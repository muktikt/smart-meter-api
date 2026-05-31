<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\Pengaduan;
use App\Models\MeterReading;
use App\Models\GangguanAir;

class MonitoringController extends Controller
{
    public function index()
    {
        $totalPelanggan = User::count();

        $totalKecamatan = User::whereNotNull('kecamatan')
            ->distinct('kecamatan')
            ->count('kecamatan');

        $meterHariIni = MeterReading::whereDate('created_at', today())->count();

        $tagihanBelumBayar = Tagihan::where('status', 'belum_bayar')->count();

        $pengaduanPending = Pengaduan::whereIn('status', ['pending', 'proses'])->count();

        $gangguanAktif = GangguanAir::whereIn('status', ['aktif', 'proses'])->count();

        $anomaliCount = MeterReading::where('pemakaian', '>', 100)->count();

        $anomaliMeter = MeterReading::with('user')
            ->where('pemakaian', '>', 100)
            ->latest()
            ->take(10)
            ->get();

        $meterTerbaru = MeterReading::with('user')
            ->latest()
            ->take(10)
            ->get();

        $pengaduanTerbaru = Pengaduan::with('user')
            ->latest()
            ->take(10)
            ->get();

        $tagihanTerbaru = Tagihan::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('monitoring.index', compact(
            'totalPelanggan',
            'totalKecamatan',
            'meterHariIni',
            'tagihanBelumBayar',
            'pengaduanPending',
            'gangguanAktif',
            'anomaliCount',
            'anomaliMeter',
            'meterTerbaru',
            'pengaduanTerbaru',
            'tagihanTerbaru'
        ));
    }

    public function realtime()
    {
        $meter = MeterReading::with('user')
            ->latest()
            ->take(20)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $meter
        ]);
    }

    public function anomali()
    {
        $anomali = MeterReading::with('user')
            ->where('pemakaian', '>', 100)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $anomali
        ]);
    }
}