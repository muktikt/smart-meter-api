@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Data Pelanggan
        </h1>

        <p class="text-gray-500 mt-2">
            Monitoring data pelanggan Smart Water Meter PDAM
        </p>

    </div>

    <div class="flex gap-3">

        <a href="/pelanggan/create"
           class="bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
            + Tambah Pelanggan
        </a>

        <a href="/pelanggan/export-excel" class="bg-green-500 hover:bg-green-600 transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
            Export Excel
        </a>

    </div>

</div>

<!-- STATISTIK -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                👥
            </div>

            <span class="text-[#2191d1] text-sm font-semibold">
                Total
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Total Pelanggan
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ number_format($totalPelanggan) }}
        </h2>

    </div>

    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                ✔
            </div>

            <span class="text-green-500 text-sm font-semibold">
                Aktif
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Akun Aktif
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ number_format($pelangganAktif) }}
        </h2>

    </div>

    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl">
                📱
            </div>

            <span class="text-yellow-500 text-sm font-semibold">
                Device
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Device Terhubung
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ number_format($deviceTerhubung) }}
        </h2>

    </div>

    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-2xl">
                ⚠️
            </div>

            <span class="text-red-500 text-sm font-semibold">
                Nonaktif
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Akun tidak aktif
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ number_format($pelangganNonaktif) }}
        </h2>

    </div>

</div>

<!-- FILTER -->
<div class="bg-white rounded-3xl shadow p-6 mb-8">

    <form method="GET" action="/pelanggan" class="grid grid-cols-1 md:grid-cols-5 gap-4">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari pelanggan..."
            class="border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
        >

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
            name="status_akun"
            class="border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
        >
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status_akun') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="belum_registrasi" {{ request('status_akun') == 'belum_registrasi' ? 'selected' : '' }}>Belum Registrasi</option>
        </select>

        <select
            name="device"
            class="border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
        >
            <option value="">Semua Device</option>
            <option value="terhubung" {{ request('device') == 'terhubung' ? 'selected' : '' }}>Terhubung</option>
            <option value="belum_login" {{ request('device') == 'belum_login' ? 'selected' : '' }}>Belum Login</option>
        </select>

        <div class="flex gap-3">
            <button
                type="submit"
                class="flex-1 bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white rounded-2xl font-semibold"
            >
                Filter Data
            </button>

            <a
                href="/pelanggan"
                class="flex-1 text-center bg-gray-200 hover:bg-gray-300 transition-all duration-300 text-gray-700 rounded-2xl font-semibold px-4 py-3"
            >
                Reset
            </a>
        </div>

    </form>

</div>

<!-- TABLE -->
<div class="bg-white rounded-3xl shadow overflow-hidden">

    <div class="p-6 border-b border-gray-100 flex items-center justify-between">

        <h2 class="text-2xl font-bold text-gray-800">
            Data Pelanggan PDAM
        </h2>

        <span class="bg-blue-100 text-[#2191d1] px-4 py-2 rounded-full text-sm font-semibold">
            {{ number_format($totalPelanggan) }} Pelanggan
        </span>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full datatable">

            <thead class="bg-[#2191d1] text-white">

                <tr>

                    <th class="px-6 py-4 text-left">Pelanggan</th>
                    <th class="px-6 py-4 text-left">Kecamatan</th>
                    <th class="px-6 py-4 text-left">No HP</th>
                    <th class="px-6 py-4 text-left">Device</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Pemakaian</th>
                    <th class="px-6 py-4 text-left">Aksi</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

            @forelse($pelanggan as $item)

            <tr class="hover:bg-gray-50 transition-all duration-300">

                <!-- PELANGGAN -->
                <td class="px-6 py-5">

                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12 rounded-2xl bg-[#2191d1] flex items-center justify-center text-white font-bold uppercase">

                            {{ substr($item->nama, 0, 1) }}

                        </div>

                        <div>

                            <h3 class="font-semibold text-gray-800">
                                {{ $item->nama }}
                            </h3>

                            <p class="text-sm text-gray-400">
                                {{ $item->no_pelanggan }}
                            </p>

                        </div>

                    </div>

                </td>

                <!-- KECAMATAN -->
                <td class="px-6 py-5">
                    {{ $item->kecamatan }}
                </td>

                <!-- NO HP -->
                <td class="px-6 py-5">
                    {{ $item->no_hp ?? '-' }}
                </td>

                <!-- DEVICE -->
                <td class="px-6 py-5">

                    @if($item->device_id)

                        <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                            Terhubung
                        </span>

                    @else

                        <span class="bg-yellow-100 text-yellow-600 px-4 py-2 rounded-full text-sm font-semibold">
                            Belum Login
                        </span>

                    @endif

                </td>

                <!-- STATUS -->
                <td class="px-6 py-5">

                    @if($item->status_akun == 'aktif')

                        <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                            Aktif
                        </span>

                    @else

                        <span class="bg-yellow-100 text-yellow-600 px-4 py-2 rounded-full text-sm font-semibold">
                            Belum Registrasi
                        </span>

                    @endif

                </td>

                <!-- PEMAKAIAN -->
                <td class="px-6 py-5 font-bold text-[#2191d1]">

                    @php
                        $lastMeter = \App\Models\MeterReading::where('user_id', $item->id)
                            ->latest()
                            ->first();
                    @endphp

                    {{ $lastMeter ? $lastMeter->pemakaian . ' m³' : '-' }}

                </td>

                <!-- AKSI -->
                <td class="px-6 py-5">

                    <div class="flex gap-2">

                        <a href="/pelanggan/detail/{{ $item->id }}"
                        class="bg-[#2191d1] hover:bg-[#1977ad] transition text-white px-4 py-2 rounded-xl text-sm font-semibold">

                            Detail

                        </a>

                        <a href="/pelanggan/edit/{{ $item->id }}" class="bg-yellow-500 hover:bg-yellow-600 transition text-white px-4 py-2 rounded-xl text-sm font-semibold">Edit</a>

                    </div>

                </td>

            </tr>

            @empty
            @endforelse
            </tbody>

        </table>

        @if($pelanggan->isEmpty())
            <div class="p-6 text-center text-gray-400">
                Belum ada data pelanggan
            </div>
        @endif

    </div>

</div>

@endsection