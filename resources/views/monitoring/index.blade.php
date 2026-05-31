@extends('layouts.app')

@section('content')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Monitoring Realtime</h1>
        <p class="text-gray-500 mt-2">Monitoring aktivitas Smart Water Meter seluruh kecamatan</p>
    </div>

    <a href="/monitoring"
       class="bg-[#2191d1] hover:bg-[#1977ad] text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
        Refresh Data
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-3xl shadow p-6">
        <p class="text-gray-400 text-sm">Sistem Aktif</p>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ $totalKecamatan ?? 0 }} Kecamatan
        </h2>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <p class="text-gray-400 text-sm">Upload Meter Hari Ini</p>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ number_format($meterHariIni ?? 0) }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <p class="text-gray-400 text-sm">Tagihan Belum Bayar</p>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ number_format($tagihanBelumBayar ?? 0) }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <p class="text-gray-400 text-sm">Deteksi Anomali</p>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ number_format($anomaliCount ?? 0) }}
        </h2>
    </div>

</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">

    <div class="xl:col-span-2 bg-white rounded-3xl shadow p-6">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Monitoring Kecamatan</h2>
            <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">Realtime</span>
        </div>

        @php
            $kecamatanData = collect($meterTerbaru ?? [])
                ->groupBy(fn($item) => $item->user->kecamatan ?? 'Tidak diketahui');
        @endphp

        <div class="space-y-6">
            @forelse($kecamatanData as $kecamatan => $items)
                @php
                    $jumlah = $items->count();
                    $persen = min(100, $jumlah * 20);
                @endphp

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h3 class="font-semibold text-gray-700">
                                Kecamatan {{ $kecamatan }}
                            </h3>
                            <p class="text-sm text-gray-400">
                                {{ $jumlah }} upload meter terbaru
                            </p>
                        </div>

                        <span class="text-green-500 font-bold">
                            {{ $persen }}%
                        </span>
                    </div>

                    <div class="w-full h-4 bg-gray-200 rounded-full overflow-hidden">
                        <div class="bg-[#2191d1] h-full rounded-full"
                             style="width: {{ $persen }}%">
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-center py-8">
                    Belum ada data monitoring kecamatan
                </p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Ringkasan Layanan</h2>
            <span class="bg-blue-100 text-[#2191d1] px-4 py-2 rounded-full text-sm font-semibold">PDAM</span>
        </div>

        <div class="space-y-5">
            <div class="flex items-center justify-between bg-red-50 rounded-2xl p-4">
                <span class="font-semibold text-gray-700">Tagihan Belum Bayar</span>
                <span class="font-bold text-red-500">{{ $tagihanBelumBayar ?? 0 }}</span>
            </div>

            <div class="flex items-center justify-between bg-yellow-50 rounded-2xl p-4">
                <span class="font-semibold text-gray-700">Pengaduan Pending</span>
                <span class="font-bold text-yellow-500">{{ $pengaduanPending ?? 0 }}</span>
            </div>

            <div class="flex items-center justify-between bg-blue-50 rounded-2xl p-4">
                <span class="font-semibold text-gray-700">Gangguan Aktif</span>
                <span class="font-bold text-[#2191d1]">{{ $gangguanAktif ?? 0 }}</span>
            </div>
        </div>
    </div>

</div>

<div class="bg-white rounded-3xl shadow overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800">Aktivitas Sistem Terbaru</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#2191d1] text-white">
                <tr>
                    <th class="px-6 py-4 text-left">Waktu</th>
                    <th class="px-6 py-4 text-left">Aktivitas</th>
                    <th class="px-6 py-4 text-left">Kecamatan</th>
                    <th class="px-6 py-4 text-left">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($meterTerbaru as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-5">
                            {{ $item->created_at ? $item->created_at->format('H:i') . ' WIB' : '-' }}
                        </td>

                        <td class="px-6 py-5">
                            Upload meter pelanggan {{ $item->user->nama ?? '-' }}
                        </td>

                        <td class="px-6 py-5">
                            {{ $item->user->kecamatan ?? '-' }}
                        </td>

                        <td class="px-6 py-5">
                            @if(($item->pemakaian ?? 0) > 100)
                                <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-sm font-semibold">
                                    Anomali
                                </span>
                            @else
                                <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                                    Berhasil
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-10 text-gray-400">
                            Belum ada aktivitas sistem
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

@endsection