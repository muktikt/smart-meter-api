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

    // =========================
    // EXPORT EXCEL
    // =========================
    public function exportExcel()
    {
        $tagihan = Tagihan::with('user')->latest()->get();

        return view('tagihan.export', compact('tagihan'));
    }
}