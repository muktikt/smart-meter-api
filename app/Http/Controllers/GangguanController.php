<?php

namespace App\Http\Controllers;

use App\Models\GangguanAir;
use Illuminate\Http\Request;

class GangguanController extends Controller
{
    public function index($kecamatan)
    {
        $gangguan = GangguanAir::where('kecamatan', $kecamatan)
            ->where('status', 'aktif')
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data gangguan berhasil diambil',
            'data' => $gangguan
        ]);
    }

    public function webIndex(Request $request)
    {
        $query = GangguanAir::latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $gangguan = $query->get();

        return view('gangguan.index', compact('gangguan'));
    }

    public function create()
    {
        return view('gangguan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'kecamatan' => 'required',
            'tanggal_mulai' => 'required|date',
            'estimasi_selesai' => 'nullable|date',
            'status' => 'required',
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('gangguan', 'public');
        }

        $gangguan = GangguanAir::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
            'kecamatan' => $request->kecamatan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'estimasi_selesai' => $request->estimasi_selesai,
            'status' => $request->status,
        ]);

        if ($request->status == 'aktif' || $request->status == 'proses') {
            \App\Models\Notification::create([
                'user_id' => null, // Broadcast to all
                'judul' => 'Info Gangguan: ' . $request->judul,
                'pesan' => 'Kecamatan ' . $request->kecamatan . ': ' . $request->deskripsi,
                'tipe' => 'gangguan_air',
                'status' => 'unread',
            ]);
        }

        return redirect('/gangguan')->with('success', 'Gangguan berhasil ditambahkan');
    }

    public function detail($id)
    {
        $gangguan = GangguanAir::findOrFail($id);

        return view('gangguan.detail', compact('gangguan'));
    }

    public function selesai($id)
    {
        $gangguan = GangguanAir::findOrFail($id);

        $gangguan->update([
            'status' => 'selesai'
        ]);

        return redirect('/gangguan')->with('success', 'Gangguan berhasil diselesaikan');
    }

    public function exportExcel()
    {
        $gangguan = GangguanAir::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="gangguan_air.csv"',
        ];

        $callback = function () use ($gangguan) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'ID',
                'Judul',
                'Deskripsi',
                'Kecamatan',
                'Tanggal Mulai',
                'Estimasi Selesai',
                'Status',
                'Created At'
            ]);

            foreach ($gangguan as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->judul,
                    $item->deskripsi,
                    $item->kecamatan,
                    $item->tanggal_mulai,
                    $item->estimasi_selesai,
                    $item->status,
                    $item->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}