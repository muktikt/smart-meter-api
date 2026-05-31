@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Laporan Smart Water Meter
        </h1>

        <p class="text-gray-500 mt-2">
            Monitoring laporan penggunaan air dan operasional PDAM
        </p>
    </div>

    <div class="flex gap-3">
        <a href="/laporan/export-excel?bulan={{ request('bulan') }}&tahun={{ request('tahun') }}"
           class="bg-green-500 hover:bg-green-600 transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
            Export Excel
        </a>

        <a href="/laporan/export-pdf?bulan={{ request('bulan') }}&tahun={{ request('tahun') }}"
           class="bg-red-500 hover:bg-red-600 transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
            Export PDF
        </a>
    </div>

</div>

<!-- FILTER -->
<div class="bg-white rounded-3xl shadow p-6 mb-8">

    <form action="/laporan" method="GET">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <select
                name="kecamatan"
                class="border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
            >
                <option value="">Semua Kecamatan</option>
                <option value="Indramayu" {{ request('kecamatan') == 'Indramayu' ? 'selected' : '' }}>Indramayu</option>
                <option value="Jatibarang" {{ request('kecamatan') == 'Jatibarang' ? 'selected' : '' }}>Jatibarang</option>
                <option value="Losarang" {{ request('kecamatan') == 'Losarang' ? 'selected' : '' }}>Losarang</option>
                <option value="Arahan" {{ request('kecamatan') == 'Arahan' ? 'selected' : '' }}>Arahan</option>
                <option value="Karangampel" {{ request('kecamatan') == 'Karangampel' ? 'selected' : '' }}>Karangampel</option>
            </select>

            <select
                name="bulan"
                class="border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
            >
                <option value="">Semua Bulan</option>
                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                    <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                        {{ $b }}
                    </option>
                @endforeach
            </select>

            <select
                name="tahun"
                class="border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
            >
                <option value="">Semua Tahun</option>
                <option value="2026" {{ request('tahun') == '2026' ? 'selected' : '' }}>2026</option>
                <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025</option>
            </select>

            <button
                type="submit"
                class="bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white rounded-2xl font-semibold">
                Tampilkan Laporan
            </button>

        </div>

    </form>

</div>

<!-- STATISTIK -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-3xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                👥
            </div>
        </div>

        <p class="text-gray-400 text-sm">
            Total Pelanggan
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ number_format($totalPelanggan ?? 0) }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                💧
            </div>
        </div>

        <p class="text-gray-400 text-sm">
            Total Pemakaian
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ number_format($totalPemakaian ?? 0) }} m³
        </h2>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl">
                💳
            </div>
        </div>

        <p class="text-gray-400 text-sm">
            Total Pendapatan
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-2xl">
                ⚠️
            </div>
        </div>

        <p class="text-gray-400 text-sm">
            Anomali
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ number_format($anomali ?? 0) }}
        </h2>
    </div>

</div>

<!-- TABLE -->
<div class="bg-white rounded-3xl shadow overflow-hidden">

    <div class="p-6 border-b border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800">
            Data Laporan Pemakaian Air
        </h2>
    </div>

    <div class="overflow-x-auto">

        <table class="w-full datatable">

            <thead class="bg-[#2191d1] text-white">
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Kecamatan</th>
                    <th class="px-6 py-4 text-left">Pelanggan</th>
                    <th class="px-6 py-4 text-left">Pemakaian</th>
                    <th class="px-6 py-4 text-left">Tagihan</th>
                    <th class="px-6 py-4 text-left">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($laporanKecamatan as $index => $item)

                    @if(!request('kecamatan') || request('kecamatan') == $item['kecamatan'])

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-5">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-6 py-5 font-semibold text-gray-700">
                                {{ $item['kecamatan'] }}
                            </td>

                            <td class="px-6 py-5">
                                {{ number_format($item['pelanggan']) }}
                            </td>

                            <td class="px-6 py-5">
                                {{ number_format($item['pemakaian']) }} m³
                            </td>

                            <td class="px-6 py-5">
                                Rp {{ number_format($item['tagihan'], 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-5">
                                @if($item['status'] == 'Anomali')
                                    <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-sm font-semibold">
                                        Anomali
                                    </span>
                                @else
                                    <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                                        Stabil
                                    </span>
                                @endif
                            </td>

                        </tr>

                    @endif

                @empty

                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-400">
                            Data laporan tidak ada
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection