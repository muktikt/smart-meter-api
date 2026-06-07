<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    // =========================
    // API MOBILE
    // =========================
    public function index($user_id)
    {
        $tagihan = Tagihan::with(['user', 'meter', 'payments'])
            ->where('user_id', $user_id)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data tagihan berhasil diambil',
            'data' => $tagihan
        ]);
    }

    // =========================
    // WEB ADMIN - LIST TAGIHAN
    // =========================
    public function webIndex(Request $request)
    {
        $query = Tagihan::with(['user', 'meter']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                ->orWhere('no_pelanggan', 'like', '%' . $search . '%');
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

        if ($request->filled('bulan')) {
            $query->whereRaw("REPLACE(LOWER(TRIM(bulan)), ' ', '') = ?", [
                strtolower(str_replace(' ', '', trim($request->bulan)))
            ]);
        }

        if ($request->filled('tahun')) {
            $query->whereRaw("TRIM(tahun) = ?", [
                trim($request->tahun)
            ]);
        }

        $tagihan = $query->latest()->get();

        $totalTagihan = Tagihan::sum('total_tagihan');

        $sudahBayar = Tagihan::where('status', 'lunas')
            ->sum('total_tagihan');

        $belumBayar = Tagihan::where('status', 'belum_bayar')
            ->sum('total_tagihan');

        $totalPelanggan = Tagihan::distinct('user_id')->count('user_id');

        return view('tagihan.index', compact(
            'tagihan',
            'totalTagihan',
            'sudahBayar',
            'belumBayar',
            'totalPelanggan'
        ));
    }

    public function detail($id)
    {
        $tagihan = Tagihan::with(['user', 'meter', 'latestPayment'])
            ->findOrFail($id);

        $histori = Tagihan::where('user_id', $tagihan->user_id)
            ->latest()
            ->get();

        return view('tagihan.detail', compact('tagihan', 'histori'));
    }

    public function sendReminder($id)
    {
        $tagihan = Tagihan::with('user')->findOrFail($id);

        if (!$tagihan->user) {
            return response()->json([
                'status' => false,
                'message' => 'Data pengguna tidak ditemukan'
            ], 404);
        }

        // 1. Simpan Notifikasi ke Database agar muncul di menu Notifikasi Mobile Pelanggan
        \App\Models\Notification::create([
            'user_id' => $tagihan->user_id,
            'judul'   => 'Reminder Tagihan Air',
            'pesan'   => 'Tagihan air PDAM Anda bulan ' . $tagihan->bulan . ' ' . $tagihan->tahun . ' sebesar Rp ' . number_format($tagihan->total_tagihan, 0, ',', '.') . ' belum lunas. Silakan lakukan pembayaran.',
            'tipe'    => 'jatuh_tempo',
            'status'  => 'unread'
        ]);

        // 2. Generate Link WhatsApp
        $noHp = preg_replace('/[^0-9]/', '', $tagihan->user->no_hp ?? '');
        if (substr($noHp, 0, 1) == '0') {
            $noHp = '62' . substr($noHp, 1);
        }

        $pesan = 'Halo ' . ($tagihan->user->nama ?? 'Pelanggan') .
            ', tagihan air PDAM Anda bulan ' . ($tagihan->bulan ?? '-') . ' ' . ($tagihan->tahun ?? '') .
            ' sebesar Rp ' . number_format($tagihan->total_tagihan ?? 0, 0, ',', '.') .
            ' belum dibayar. Mohon segera melakukan pembayaran sebelum jatuh tempo ' . ($tagihan->jatuh_tempo ?? '-') . '.';

        $waUrl = "https://wa.me/{$noHp}?text=" . urlencode($pesan);

        return response()->json([
            'status' => true,
            'message' => 'Notifikasi reminder berhasil dikirim ke aplikasi pelanggan',
            'wa_url' => $waUrl
        ]);
    }

    // =========================
    // EXPORT EXCEL
    // =========================
    public function exportExcel()
    {
        $tagihan = Tagihan::with('user')->latest()->get();

        return view('tagihan.export', compact('tagihan'));
    }
}