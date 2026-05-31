@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Monitoring Tagihan
        </h1>

        <p class="text-gray-500 mt-2">
            Monitoring pembayaran dan tagihan pelanggan PDAM
        </p>

    </div>

    <div class="flex gap-3">

        <a href="/tagihan/export-excel"
           class="bg-green-500 hover:bg-green-600 transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
            Export Excel
        </a>

    </div>

</div>

<!-- STATISTIK -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <!-- TOTAL -->
    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                💳
            </div>

            <span class="text-[#2191d1] text-sm font-semibold">
                Total
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Total Tagihan
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            Rp {{ number_format($totalTagihan ?? 0, 0, ',', '.') }}
        </h2>

    </div>

    <!-- LUNAS -->
    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                ✔
            </div>

            <span class="text-green-500 text-sm font-semibold">
                Lunas
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Pembayaran Masuk
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            Rp {{ number_format($sudahBayar ?? 0, 0, ',', '.') }}
        </h2>

    </div>

    <!-- BELUM -->
    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-2xl">
                ⚠️
            </div>

            <span class="text-red-500 text-sm font-semibold">
                Pending
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Belum Dibayar
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            Rp {{ number_format($belumBayar ?? 0, 0, ',', '.') }}
        </h2>

    </div>

    <!-- PELANGGAN -->
    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl">
                👥
            </div>

            <span class="text-yellow-500 text-sm font-semibold">
                Aktif
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Pelanggan Ditagih
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ number_format($totalPelanggan ?? 0) }}
        </h2>

    </div>

</div>

<!-- FILTER -->
<div class="bg-white rounded-3xl shadow p-6 mb-8">

    <form action="/tagihan" method="GET">

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-4">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari pelanggan..."
                class="border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
            >

            <select name="kecamatan" class="border border-gray-300 rounded-2xl px-4 py-3">
                <option value="">Semua Kecamatan</option>
                <option value="Indramayu" {{ request('kecamatan') == 'Indramayu' ? 'selected' : '' }}>Indramayu</option>
                <option value="Jatibarang" {{ request('kecamatan') == 'Jatibarang' ? 'selected' : '' }}>Jatibarang</option>
                <option value="Losarang" {{ request('kecamatan') == 'Losarang' ? 'selected' : '' }}>Losarang</option>
                <option value="Arahan" {{ request('kecamatan') == 'Arahan' ? 'selected' : '' }}>Arahan</option>
            </select>

            <select name="status" class="border border-gray-300 rounded-2xl px-4 py-3">
                <option value="">Semua Status</option>
                <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="belum_bayar" {{ request('status') == 'belum_bayar' ? 'selected' : '' }}>Belum Lunas</option>
            </select>

            <select name="bulan" class="border border-gray-300 rounded-2xl px-4 py-3">
                <option value="">Semua Bulan</option>
                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                    <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>
                        {{ $bulan }}
                    </option>
                @endforeach
            </select>

            <select name="tahun" class="border border-gray-300 rounded-2xl px-4 py-3">
                <option value="">Semua Tahun</option>
                @for($tahun = date('Y'); $tahun >= 2024; $tahun--)
                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                @endfor
            </select>

            <div class="flex gap-3">
                <button type="submit"
                        class="flex-1 bg-[#2191d1] hover:bg-[#1977ad] text-white rounded-2xl font-semibold px-4 py-3">
                    Filter
                </button>

                <a href="/tagihan"
                   class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-2xl font-semibold px-4 py-3">
                    Reset
                </a>
            </div>

        </div>

    </form>

</div>

<!-- TABLE -->
<div class="bg-white rounded-3xl shadow overflow-hidden">

    <div class="p-6 border-b border-gray-100 flex items-center justify-between">

        <h2 class="text-2xl font-bold text-gray-800">
            Data Tagihan Pelanggan
        </h2>

        <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-sm font-semibold">
            {{ $tagihan->where('status', '!=', 'lunas')->count() }} Belum Lunas
        </span>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#2191d1] text-white">

                <tr>

                    <th class="px-6 py-4 text-left">Pelanggan</th>
                    <th class="px-6 py-4 text-left">Kecamatan</th>
                    <th class="px-6 py-4 text-left">Pemakaian</th>
                    <th class="px-6 py-4 text-left">Tagihan</th>
                    <th class="px-6 py-4 text-left">Jatuh Tempo</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Aksi</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($tagihan as $item)

                <tr class="hover:bg-gray-50">

                    <td class="px-6 py-5">

                        <div>

                            <h3 class="font-semibold text-gray-800">
                                {{ $item->user->nama ?? '-' }}
                            </h3>

                            <p class="text-sm text-gray-400">
                                {{ $item->user->no_pelanggan ?? '-' }}
                            </p>

                        </div>

                    </td>

                    <td class="px-6 py-5">
                        {{ $item->user->kecamatan ?? '-' }}
                    </td>

                    <td class="px-6 py-5 {{ ($item->pemakaian ?? 0) > 100 ? 'text-red-500' : 'text-green-500' }} font-bold">
                        {{ $item->pemakaian ?? 0 }} m³
                    </td>

                    <td class="px-6 py-5 font-semibold text-gray-800">
                        Rp {{ number_format($item->total_tagihan ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="px-6 py-5">
                        {{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d M Y') }}
                    </td>

                    <td class="px-6 py-5">

                        @if(strtolower($item->status) == 'lunas')

                            <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                                Lunas
                            </span>

                        @else

                            <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-sm font-semibold">
                                Belum Lunas
                            </span>

                        @endif

                    </td>

                    <td class="px-6 py-5">

                        <a href="/tagihan/detail/{{ $item->id }}"
                           class="bg-[#2191d1] hover:bg-[#1977ad] text-white px-4 py-2 rounded-xl text-sm font-semibold">
                            Detail
                        </a>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="7" class="text-center py-10 text-gray-400">
                        Tidak ada data tagihan
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection