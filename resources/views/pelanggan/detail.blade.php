@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Detail Pelanggan
        </h1>

        <p class="text-gray-500 mt-2">
            Informasi lengkap pelanggan PDAM
        </p>

    </div>

    <div class="flex gap-3">

        <a href="/pelanggan/edit/{{ $pelanggan->id }}" class="bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">Edit Data</a>

        <form action="/pelanggan/nonaktif/{{ $pelanggan->id }}" method="POST" style="display:inline">
            @csrf
            <button class="bg-red-500 hover:bg-red-600 transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">Nonaktifkan</button>
        </form>

        <form action="/pelanggan/delete/{{ $pelanggan->id }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button class="bg-gray-500 hover:bg-gray-600 transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">Hapus</button>
        </form>

    </div>

</div>

<!-- PROFILE -->
<div class="bg-white rounded-3xl shadow p-8 mb-8">

    <div class="flex flex-col lg:flex-row gap-8">

        <!-- FOTO -->
        <div class="flex flex-col items-center">

            <div class="w-36 h-36 rounded-full bg-[#2191d1] flex items-center justify-center text-white text-5xl font-bold shadow-lg">

                {{ strtoupper(substr($pelanggan->nama, 0, 1)) }}

            </div>

            @if($pelanggan->status_akun == 'aktif')
                <span class="mt-5 bg-green-100 text-green-600 px-5 py-2 rounded-full text-sm font-semibold">
                    Akun Aktif
                </span>
            @else
                <span class="mt-5 bg-red-100 text-red-600 px-5 py-2 rounded-full text-sm font-semibold">
                    Akun Nonaktif
                </span>
            @endif

        </div>

        <!-- INFO -->
        <div class="flex-1">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div>

                    <p class="text-sm text-gray-400 mb-2">
                        Nama Pelanggan
                    </p>

                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ $pelanggan->nama }}
                    </h2>

                </div>

                <div>

                    <p class="text-sm text-gray-400 mb-2">
                        Nomor Pelanggan
                    </p>

                    <h2 class="text-2xl font-bold text-[#2191d1]">
                        {{ $pelanggan->no_pelanggan }}
                    </h2>

                </div>

                <div>

                    <p class="text-sm text-gray-400 mb-2">
                        Email
                    </p>

                    <h3 class="font-semibold text-gray-700">
                        {{ $pelanggan->email }}
                    </h3>

                </div>

                <div>

                    <p class="text-sm text-gray-400 mb-2">
                        Nomor HP
                    </p>

                    <h3 class="font-semibold text-gray-700">
                        {{ $pelanggan->no_hp ?? '-' }}
                    </h3>

                </div>

                <div>

                    <p class="text-sm text-gray-400 mb-2">
                        Kecamatan
                    </p>

                    <h3 class="font-semibold text-gray-700">
                        {{ $pelanggan->kecamatan ?? '-' }}
                    </h3>

                </div>

                <div>

                    <p class="text-sm text-gray-400 mb-2">
                        Device Login
                    </p>

                    <div class="flex items-center gap-3">

                        <div class="w-3 h-3 rounded-full bg-green-500"></div>

                        <h3 class="font-semibold text-green-600">
                            Device Aktif
                        </h3>

                    </div>

                </div>

            </div>

            <!-- ALAMAT -->
            <div class="mt-8">

                <p class="text-sm text-gray-400 mb-2">
                    Alamat
                </p>

                <div class="bg-[#f5f7fb] rounded-2xl p-5">

                    <p class="text-gray-700 leading-relaxed">
                        {{ $pelanggan->alamat ?? '-' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- STATISTIK -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                💧
            </div>

            <span class="text-[#2191d1] text-sm font-semibold">
                Bulan Ini
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Pemakaian Air
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            150 m³
        </h2>

    </div>

    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                💳
            </div>

            <span class="text-green-500 text-sm font-semibold">
                Lunas
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Total Tagihan
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            Rp 600K
        </h2>

    </div>

    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl">
                📢
            </div>

            <span class="text-yellow-500 text-sm font-semibold">
                Pengaduan
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Total Pengaduan
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            2
        </h2>

    </div>

    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-2xl">
                ⚠️
            </div>

            <span class="text-red-500 text-sm font-semibold">
                Warning
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Status Pemakaian
        </p>

        <h2 class="text-2xl font-bold text-gray-800 mt-2">
            Anomali
        </h2>

    </div>

</div>

<!-- HISTORI -->
<div class="bg-white rounded-3xl shadow overflow-hidden">

    <div class="p-6 border-b border-gray-100">

        <h2 class="text-2xl font-bold text-gray-800">
            Histori Upload Meter
        </h2>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#2191d1] text-white">

                <tr>

                    <th class="px-6 py-4 text-left">Bulan</th>
                    <th class="px-6 py-4 text-left">Meter Lama</th>
                    <th class="px-6 py-4 text-left">Meter Baru</th>
                    <th class="px-6 py-4 text-left">Pemakaian</th>
                    <th class="px-6 py-4 text-left">OCR</th>
                    <th class="px-6 py-4 text-left">Status</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                <tr class="hover:bg-gray-50">

                    <td class="px-6 py-5">
                        Juni 2026
                    </td>

                    <td class="px-6 py-5">
                        1200
                    </td>

                    <td class="px-6 py-5">
                        1350
                    </td>

                    <td class="px-6 py-5 text-green-500 font-bold">
                        150 m³
                    </td>

                    <td class="px-6 py-5">

                        <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                            96%
                        </span>

                    </td>

                    <td class="px-6 py-5">

                        <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                            Valid
                        </span>

                    </td>

                </tr>

                <tr class="hover:bg-gray-50">

                    <td class="px-6 py-5">
                        Mei 2026
                    </td>

                    <td class="px-6 py-5">
                        1050
                    </td>

                    <td class="px-6 py-5">
                        1200
                    </td>

                    <td class="px-6 py-5 text-green-500 font-bold">
                        150 m³
                    </td>

                    <td class="px-6 py-5">

                        <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                            94%
                        </span>

                    </td>

                    <td class="px-6 py-5">

                        <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                            Valid
                        </span>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection
