<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\MeterReading;

class LaporanController extends Controller
{
    private function pelangganQuery()
    {
        return User::where(function ($q) {
                $q->whereNull('role_id')
                  ->orWhere('role_id', '!=', 1);
            })
            ->where('no_pelanggan', '!=', '000000');
    }

    public function index(Request $request)
    {
        $kecamatan = $request->kecamatan;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $pelangganIds = $this->pelangganQuery()
            ->when($kecamatan, fn($q) => $q->where('kecamatan', $kecamatan))
            ->pluck('id');

        $meterData = MeterReading::whereIn('user_id', $pelangganIds)
            ->when($bulan, fn($q) => $q->where('bulan', $bulan))
            ->when($tahun, fn($q) => $q->where('tahun', $tahun))
            ->get();

        $tagihanData = Tagihan::whereIn('user_id', $pelangganIds)
            ->when($bulan, fn($q) => $q->where('bulan', $bulan))
            ->when($tahun, fn($q) => $q->where('tahun', $tahun))
            ->get();

        $totalPelanggan = $pelangganIds->count();
        $totalPemakaian = $meterData->sum('pemakaian');
        $totalPendapatan = $tagihanData->where('status', 'lunas')->sum('total_tagihan');
        $anomali = $meterData->where('pemakaian', '>', 100)->count();

        $laporanKecamatan = $this->pelangganQuery()
            ->when($kecamatan, fn($q) => $q->where('kecamatan', $kecamatan))
            ->whereNotNull('kecamatan')
            ->select('kecamatan')
            ->groupBy('kecamatan')
            ->get()
            ->map(function ($item) use ($bulan, $tahun) {
                $users = $this->pelangganQuery()
                    ->where('kecamatan', $item->kecamatan)
                    ->pluck('id');

                $meter = MeterReading::whereIn('user_id', $users)
                    ->when($bulan, fn($q) => $q->where('bulan', $bulan))
                    ->when($tahun, fn($q) => $q->where('tahun', $tahun));

                $tagihan = Tagihan::whereIn('user_id', $users)
                    ->when($bulan, fn($q) => $q->where('bulan', $bulan))
                    ->when($tahun, fn($q) => $q->where('tahun', $tahun));

                $totalPemakaian = $meter->sum('pemakaian');
                $totalTagihan = $tagihan->sum('total_tagihan');

                $totalAnomali = MeterReading::whereIn('user_id', $users)
                    ->when($bulan, fn($q) => $q->where('bulan', $bulan))
                    ->when($tahun, fn($q) => $q->where('tahun', $tahun))
                    ->where('pemakaian', '>', 100)
                    ->count();

                return [
                    'kecamatan' => $item->kecamatan,
                    'pelanggan' => $users->count(),
                    'pemakaian' => $totalPemakaian,
                    'tagihan' => $totalTagihan,
                    'status' => $totalAnomali > 0 ? 'Anomali' : 'Stabil',
                ];
            });

        return view('laporan.index', compact(
            'bulan',
            'tahun',
            'totalPelanggan',
            'totalPemakaian',
            'totalPendapatan',
            'anomali',
            'laporanKecamatan'
        ));
    }

    public function exportExcel(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $users = $this->pelangganQuery()
            ->whereNotNull('kecamatan')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan_smart_meter.csv"',
        ];

        $callback = function () use ($users, $bulan, $tahun) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'No',
                'Nama Pelanggan',
                'No Pelanggan',
                'Kecamatan',
                'Bulan',
                'Tahun',
                'Pemakaian',
                'Total Tagihan',
                'Status'
            ]);

            foreach ($users as $index => $user) {
                $meter = MeterReading::where('user_id', $user->id)
                    ->when($bulan, fn($q) => $q->where('bulan', $bulan))
                    ->when($tahun, fn($q) => $q->where('tahun', $tahun))
                    ->latest()
                    ->first();

                $tagihan = Tagihan::where('user_id', $user->id)
                    ->when($bulan, fn($q) => $q->where('bulan', $bulan))
                    ->when($tahun, fn($q) => $q->where('tahun', $tahun))
                    ->latest()
                    ->first();

                fputcsv($file, [
                    $index + 1,
                    $user->nama ?? '-',
                    $user->no_pelanggan ?? '-',
                    $user->kecamatan ?? '-',
                    $meter->bulan ?? $bulan ?? '-',
                    $meter->tahun ?? $tahun ?? '-',
                    $meter->pemakaian ?? 0,
                    $tagihan->total_tagihan ?? 0,
                    $tagihan->status ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        return back()->with('success', 'Export PDF belum diaktifkan');
    }
}