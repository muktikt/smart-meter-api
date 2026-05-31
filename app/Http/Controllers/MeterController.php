<?php

namespace App\Http\Controllers;

use App\Models\MeterReading;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MeterController extends Controller
{
    public function ocr(Request $request)
    {
        $request->validate([
            'foto_meter' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $fotoPath = $request->file('foto_meter')->store('meter_ocr', 'public');

        // SEMENTARA: OCR simulasi dulu.
        // Nanti bisa diganti dengan OCR asli.
        $hasilOcr = $request->hasil_ocr ?? null;

        return response()->json([
            'status' => true,
            'message' => 'OCR berhasil diproses',
            'data' => [
                'foto_meter' => $fotoPath,
                'hasil_ocr' => $hasilOcr,
                'ocr_persen' => 90
            ]
        ]);
    }
    public function upload(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'foto_meter' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'meter_baru' => 'required|numeric',
            'hasil_ocr' => 'nullable|numeric',
            'ocr_persen' => 'nullable|numeric',
        ]);

        $bulan = Carbon::now()->locale('id')->translatedFormat('F');
        $tahun = Carbon::now()->year;

        $cek = MeterReading::where('user_id', $request->user_id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        if ($cek) {
            return response()->json([
                'status' => false,
                'message' => 'Meter bulan ini sudah diupload'
            ], 400);
        }

        $fotoPath = $request->file('foto_meter')->store('meter', 'public');

        $lastMeter = MeterReading::where('user_id', $request->user_id)
            ->latest()
            ->first();

        $meter_lama = $lastMeter ? $lastMeter->meter_baru : 0;

        if ($lastMeter && $request->meter_baru < $meter_lama) {
            return response()->json([
                'status' => false,
                'message' => 'Meter baru tidak boleh lebih kecil dari meter lama'
            ], 400);
        }

        $pemakaian = $request->meter_baru - $meter_lama;
        $statusAnomali = $pemakaian > 100 ? 'anomali' : 'normal';

        $meter = MeterReading::create([
            'user_id' => $request->user_id,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'meter_lama' => $meter_lama,
            'meter_baru' => $request->meter_baru,
            'pemakaian' => $pemakaian,
            'foto_meter' => $fotoPath,
            'hasil_ocr' => $request->hasil_ocr ?? $request->meter_baru,
            'status' => 'pending',
            'status_anomali' => $statusAnomali,
            'ocr_persen' => $request->ocr_persen ?? 0,
            'ocr_status' => 'berhasil',
            'validasi_petugas' => 'pending',
        ]);

        $bulanAngka = [
            'Januari' => 1,
            'Februari' => 2,
            'Maret' => 3,
            'April' => 4,
            'Mei' => 5,
            'Juni' => 6,
            'Juli' => 7,
            'Agustus' => 8,
            'September' => 9,
            'Oktober' => 10,
            'November' => 11,
            'Desember' => 12,
        ];

        $jatuhTempo = Carbon::create(
            $tahun,
            $bulanAngka[$bulan],
            20
        )->addMonth();

        $tagihan = Tagihan::create([
            'user_id' => $request->user_id,
            'meter_id' => $meter->id,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'periode' => $bulan . ' ' . $tahun,
            'pemakaian' => $pemakaian,
            'total_tagihan' => $pemakaian * 4000,
            'tarif_per_m3' => 4000,
            'invoice_number' => 'INV-' . date('YmdHis') . '-' . $request->user_id,
            'status' => 'belum_bayar',
            'jatuh_tempo' => $jatuhTempo
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Upload meter berhasil',
            'data' => [
                'meter' => $meter,
                'tagihan' => $tagihan
            ]
        ]);
    }

    public function index(Request $request)
    {
        $query = MeterReading::with('user')->latest();

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('no_pelanggan', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kecamatan')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('kecamatan', $request->kecamatan);
            });
        }

        if ($request->filled('status')) {
            if ($request->status == 'valid') {
                $query->where('status', 'valid');
            }

            if ($request->status == 'pending') {
                $query->where('status', 'pending');
            }

            if ($request->status == 'anomali') {
                $query->where('status_anomali', 'anomali');
            }
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $meter = $query->get();

        $totalMeter = MeterReading::count();

        $ocrBerhasil = MeterReading::where('ocr_status', 'berhasil')->count();

        $pending = MeterReading::where('status', 'pending')->count();

        $anomali = MeterReading::where('pemakaian', '>', 100)->count();

        return view('meter.index', compact(
            'meter',
            'totalMeter',
            'ocrBerhasil',
            'pending',
            'anomali'
        ));
    }

    public function detail($id)
    {
        $meter = MeterReading::with('user')->findOrFail($id);

        return view('meter.detail', compact('meter'));
    }

    public function anomaliView(Request $request)
    {
        $query = MeterReading::with('user')
            ->where('pemakaian', '>', 100)
            ->latest();

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('no_pelanggan', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kecamatan')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('kecamatan', $request->kecamatan);
            });
        }

        if ($request->filled('status')) {
            $query->where('validasi_petugas', $request->status);
        }

        $anomali = $query->get();

        $totalAnomali = MeterReading::where('pemakaian', '>', 100)->count();

        $pendingAnomali = MeterReading::where('pemakaian', '>', 100)
            ->where('validasi_petugas', 'pending')
            ->count();

        $validAnomali = MeterReading::where('pemakaian', '>', 100)
            ->where('validasi_petugas', 'valid')
            ->count();

        $kecamatanTertinggi = MeterReading::with('user')
            ->where('pemakaian', '>', 100)
            ->get()
            ->groupBy(fn ($item) => $item->user->kecamatan ?? '-')
            ->sortByDesc(fn ($items) => $items->count())
            ->keys()
            ->first();

        return view('meter.anomali', compact(
            'anomali',
            'totalAnomali',
            'pendingAnomali',
            'validAnomali',
            'kecamatanTertinggi'
        ));
    }

    public function validasi($id)
    {
        $meter = MeterReading::findOrFail($id);

        $meter->update([
            'status' => 'valid',
            'validasi_petugas' => 'valid',
            'status_anomali' => 'normal',
        ]);

        return back()->with('success', 'Meter berhasil divalidasi');
    }

    public function warning($id)
    {
        $meter = MeterReading::findOrFail($id);

        $meter->update([
            'status' => 'pending',
            'status_anomali' => 'anomali',
            'validasi_petugas' => 'warning',
            'catatan_anomali' => 'Pemakaian tidak normal',
        ]);

        return back()->with('success', 'Meter ditandai sebagai warning');
    }

    public function exportExcel()
    {
        $meter = MeterReading::with('user')->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="meter_reading.csv"',
        ];

        $callback = function () use ($meter) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'ID',
                'Pelanggan',
                'No Pelanggan',
                'Kecamatan',
                'Bulan',
                'Tahun',
                'Meter Lama',
                'Meter Baru',
                'Pemakaian',
                'OCR',
                'Status',
                'Status Anomali',
                'Tanggal'
            ]);

            foreach ($meter as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->user->nama ?? '-',
                    $item->user->no_pelanggan ?? '-',
                    $item->user->kecamatan ?? '-',
                    $item->bulan,
                    $item->tahun,
                    $item->meter_lama,
                    $item->meter_baru,
                    $item->pemakaian,
                    ($item->ocr_persen ?? 0) . '%',
                    $item->status,
                    $item->status_anomali,
                    $item->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function history($user_id)
    {
        $meter = MeterReading::where('user_id', $user_id)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Riwayat meter berhasil diambil',
            'data' => $meter
        ]);
    }
}