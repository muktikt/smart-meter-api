<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tagihan;
use App\Models\Pengaduan;
use App\Models\GangguanAir;
use App\Models\MeterReading;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = User::whereNull('role_id')->count();

        $totalTagihan = Tagihan::sum('total_tagihan');

        $belumBayar = Tagihan::where('status', 'belum_bayar')->count();

        $totalPengaduan = Pengaduan::count();

        $pengaduanProses = Pengaduan::where('status', 'proses')->count();

        $gangguanAktif = GangguanAir::where('status', 'aktif')->count();

        $totalMeter = MeterReading::count();

        $tagihanTerbaru = Tagihan::latest()
                            ->take(5)
                            ->get();

        $pengaduanTerbaru = Pengaduan::latest()
                                ->take(5)
                                ->get();

        $meterTerbaru = MeterReading::latest()
                            ->take(5)
                            ->get();

        // DATA CHART PEMAKAIAN AIR PER BULAN
        $chartLabel = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ];

        $chartPemakaian = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {

            $namaBulan = $this->namaBulan($bulan);

            $totalPemakaian = MeterReading::where('bulan', $namaBulan)
                                ->sum('pemakaian');

            $chartPemakaian[] = $totalPemakaian;
        }

        return view('dashboard.index', compact(
            'totalPelanggan',
            'totalTagihan',
            'belumBayar',
            'totalPengaduan',
            'pengaduanProses',
            'gangguanAktif',
            'totalMeter',
            'tagihanTerbaru',
            'pengaduanTerbaru',
            'meterTerbaru',
            'chartLabel',
            'chartPemakaian'
        ));
    }

    private function namaBulan($bulan)
    {
        $data = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $data[$bulan];
    }
}