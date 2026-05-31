<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Petugas;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    // =========================
    // API MOBILE - KIRIM PENGADUAN
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
        ]);

        $pengaduan = Pengaduan::create([
            'user_id' => $request->user_id,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'foto' => $request->foto,
            'status' => 'proses',
            'petugas_id' => null
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Pengaduan berhasil dikirim',
            'data' => $pengaduan
        ]);
    }

    // =========================
    // WEB ADMIN - LIST PENGADUAN
    // =========================
    public function index(Request $request)
    {
        $query = Pengaduan::with(['user', 'petugas'])->latest();

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
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $pengaduan = $query->get();

        $totalPengaduan = Pengaduan::count();
        $proses = Pengaduan::whereIn('status', ['proses', 'pending'])->count();
        $selesai = Pengaduan::where('status', 'selesai')->count();

        return view('pengaduan.index', compact(
            'pengaduan',
            'totalPengaduan',
            'proses',
            'selesai'
        ));
    }

    // =========================
    // WEB ADMIN - DETAIL
    // =========================
    public function detail($id)
    {
        $pengaduan = Pengaduan::with(['user', 'petugas'])->findOrFail($id);

        return view('pengaduan.detail', compact('pengaduan'));
    }

    // =========================
    // WEB ADMIN - PROSES
    // =========================
    public function proses($id)
    {
        $pengaduan = Pengaduan::with(['user', 'petugas'])->findOrFail($id);

        $petugas = Petugas::where('status', 'aktif')->get();

        return view('pengaduan.proses', compact('pengaduan', 'petugas'));
    }

    // =========================
    // UPDATE STATUS PROSES
    // =========================
    public function updateProses(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $pengaduan->update([
            'status' => $request->status,
            'petugas_id' => $request->petugas_id
        ]);

        return redirect('/pengaduan')->with('success', 'Status pengaduan berhasil diperbarui');
    }

    // =========================
    // EXPORT EXCEL
    // =========================
    public function exportExcel()
    {
        $pengaduan = Pengaduan::with(['user', 'petugas'])->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="pengaduan.csv"',
        ];

        $callback = function () use ($pengaduan) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'ID',
                'Pelanggan',
                'No Pelanggan',
                'Kecamatan',
                'Kategori',
                'Deskripsi',
                'Status',
                'Petugas',
                'Tanggal'
            ]);

            foreach ($pengaduan as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->user->nama ?? '-',
                    $item->user->no_pelanggan ?? '-',
                    $item->user->kecamatan ?? '-',
                    $item->kategori ?? '-',
                    $item->deskripsi ?? '-',
                    $item->status ?? '-',
                    $item->petugas->kode_petugas ?? '-',
                    $item->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function userHistory($user_id)
    {
        $pengaduan = Pengaduan::where('user_id', $user_id)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Riwayat pengaduan berhasil diambil',
            'data' => $pengaduan
        ]);
    }
}