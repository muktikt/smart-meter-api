@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Detail Petugas
        </h1>

        <p class="text-gray-500 mt-2">
            Monitoring informasi dan aktivitas petugas PDAM
        </p>

    </div>

    <div class="flex gap-3">

        <a href="/petugas/edit/{{ $petugas->id }}" class="bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
            Edit Data
        </a>

        <form action="/petugas/nonaktif/{{ $petugas->id }}" method="POST" style="display:inline">
            @csrf
            <button class="bg-red-500 hover:bg-red-600 transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
                Nonaktifkan
            </button>
        </form>

        <form action="/petugas/delete/{{ $petugas->id }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button class="bg-gray-500 hover:bg-gray-600 transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
                Hapus
            </button>
        </form>

    </div>

</div>

<!-- PROFILE -->
<div class="bg-white rounded-3xl shadow p-8 mb-8">

    <div class="flex flex-col lg:flex-row gap-8">

        <!-- FOTO -->
        <div class="flex flex-col items-center">

            <div class="w-36 h-36 rounded-full bg-[#2191d1] flex items-center justify-center text-white text-5xl font-bold shadow-lg">

                {{ strtoupper(substr($petugas->nama, 0, 1)) }}

            </div>

            <span class="{{ $petugas->status == 'aktif' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} mt-5 px-5 py-2 rounded-full text-sm font-semibold">
                {{ $petugas->status == 'aktif' ? 'Petugas Aktif' : 'Petugas Nonaktif' }}
            </span>

        </div>

        <!-- INFO -->
        <div class="flex-1">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div>

                    <p class="text-sm text-gray-400 mb-2">
                        Nama Petugas
                    </p>

                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ $petugas->nama }}
                    </h2>

                </div>

                <div>

                    <p class="text-sm text-gray-400 mb-2">
                        Kode Petugas
                    </p>

                    <h2 class="text-2xl font-bold text-[#2191d1]">
                        {{ $petugas->kode_petugas }}
                    </h2>

                </div>

                <div>

                    <p class="text-sm text-gray-400 mb-2">
                        Email
                    </p>

                    <h3 class="font-semibold text-gray-700">
                        {{ $petugas->email }}
                    </h3>

                </div>

                <div>

                    <p class="text-sm text-gray-400 mb-2">
                        Nomor HP
                    </p>

                    <h3 class="font-semibold text-gray-700">
                        {{ $petugas->no_hp ?? '-' }}
                    </h3>

                </div>

                <div>

                    <p class="text-sm text-gray-400 mb-2">
                        Kecamatan
                    </p>

                    <h3 class="font-semibold text-gray-700">
                        {{ $petugas->kecamatan ?? '-' }}
                    </h3>

                </div>

                <div>

                    <p class="text-sm text-gray-400 mb-2">
                        Role
                    </p>

                    <span class="bg-blue-100 text-[#2191d1] px-4 py-2 rounded-full text-sm font-semibold">
                        {{ in_array($petugas->role, ['supervisor', 'Supervisor Cabang']) ? 'Supervisor Cabang' : (in_array($petugas->role, ['customer_service', 'Customer Service', 'Petugas Pengaduan']) ? 'Petugas Pengaduan' : 'Petugas Lapangan') }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- STATISTIK -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <!-- PENGADUAN -->
    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl">
                📢
            </div>

            <span class="text-yellow-500 text-sm font-semibold">
                Bulan Ini
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Pengaduan Diproses
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ $pengaduan->count() }}
        </h2>

    </div>

    <!-- SELESAI -->
    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                ✔
            </div>

            <span class="text-green-500 text-sm font-semibold">
                Selesai
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Pengaduan Selesai
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ $pengaduan->where('status', 'selesai')->count() }}
        </h2>

    </div>

    <!-- METER -->
    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                💧
            </div>

            <span class="text-[#2191d1] text-sm font-semibold">
                Upload
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Validasi Meter
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ $meter->count() }}
        </h2>

    </div>

    <!-- DEVICE -->
    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex items-center justify-between mb-4">

            <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-2xl">
                📱
            </div>

            <span class="text-red-500 text-sm font-semibold">
                Device
            </span>

        </div>

        <p class="text-gray-400 text-sm">
            Device Aktif
        </p>

        <h2 class="text-2xl font-bold text-gray-800 mt-2">
            {{ $petugas->device_name ?? '-' }}
        </h2>

    </div>

</div>

<!-- GRID -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

    <!-- LOGIN ACTIVITY -->
    <div class="xl:col-span-2 bg-white rounded-3xl shadow overflow-hidden">

        <div class="p-6 border-b border-gray-100">

            <h2 class="text-2xl font-bold text-gray-800">
                Aktivitas Login
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-[#2191d1] text-white">

                    <tr>

                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Waktu</th>
                        <th class="px-6 py-4 text-left">IP Address</th>
                        <th class="px-6 py-4 text-left">Device</th>
                        <th class="px-6 py-4 text-left">Status</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-5">
                            15 Juni 2026
                        </td>

                        <td class="px-6 py-5">
                            08:42 WIB
                        </td>

                        <td class="px-6 py-5">
                            192.168.1.12
                        </td>

                        <td class="px-6 py-5">
                            Samsung Galaxy A24
                        </td>

                        <td class="px-6 py-5">

                            <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                                Berhasil
                            </span>

                        </td>

                    </tr>

                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-5">
                            14 Juni 2026
                        </td>

                        <td class="px-6 py-5">
                            19:20 WIB
                        </td>

                        <td class="px-6 py-5">
                            192.168.1.12
                        </td>

                        <td class="px-6 py-5">
                            Samsung Galaxy A24
                        </td>

                        <td class="px-6 py-5">

                            <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                                Berhasil
                            </span>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <!-- SECURITY -->
    <div class="space-y-8">

        <!-- DEVICE -->
        <div class="bg-white rounded-3xl shadow p-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Keamanan Device
            </h2>

            <div class="space-y-5">

                <div class="bg-green-100 text-green-700 p-5 rounded-2xl">

                    <h3 class="font-bold mb-2">
                        ✔ Device Terverifikasi
                    </h3>

                    <p class="text-sm">
                        Akun hanya digunakan pada satu device resmi.
                    </p>

                </div>

                <div class="bg-[#f5f7fb] rounded-2xl p-4">

                    <p class="text-sm text-gray-400 mb-1">
                        Device Aktif
                    </p>

                    <h4 class="font-semibold text-gray-700">
                        Samsung Galaxy A24
                    </h4>

                </div>

                <div class="bg-[#f5f7fb] rounded-2xl p-4">

                    <p class="text-sm text-gray-400 mb-1">
                        Android Version
                    </p>

                    <h4 class="font-semibold text-gray-700">
                        Android 14
                    </h4>

                </div>

            </div>

        </div>

        <!-- STATUS -->
        <div class="bg-white rounded-3xl shadow p-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Status Akun
            </h2>

            <div class="space-y-5">

                <div class="flex items-center justify-between">

                    <span class="text-gray-700">
                        Status Akun
                    </span>

                    <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                        Aktif
                    </span>

                </div>

                <div class="flex items-center justify-between">

                    <span class="text-gray-700">
                        Login Verification
                    </span>

                    <span class="bg-blue-100 text-[#2191d1] px-4 py-2 rounded-full text-sm font-semibold">
                        Aktif
                    </span>

                </div>

                <div class="flex items-center justify-between">

                    <span class="text-gray-700">
                        Batas 1 Device
                    </span>

                    <span class="bg-yellow-100 text-yellow-600 px-4 py-2 rounded-full text-sm font-semibold">
                        Aktif
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
