@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Tambah Petugas
        </h1>

        <p class="text-gray-500 mt-2">
            Tambahkan akun petugas PDAM berdasarkan cabang/kecamatan
        </p>

    </div>

    <a href="/petugas"
       class="bg-gray-200 hover:bg-gray-300 transition-all duration-300 text-gray-700 px-6 py-3 rounded-2xl font-semibold">
        ← Kembali
    </a>

</div>

<!-- FORM -->
<div class="bg-white rounded-3xl shadow p-8">

    <form action="/petugas/store" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- LEFT -->
            <div class="space-y-6">

                <!-- KODE PETUGAS -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kode Petugas
                    </label>

                    <input
                        type="text"
                        name="kode_petugas"
                        placeholder="IND001"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >

                    <p class="text-sm text-gray-400 mt-2">
                        Contoh: IND001, JTB001, LOS001
                    </p>

                </div>

                <!-- NAMA -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Petugas
                    </label>

                    <input
                        type="text"
                        name="nama"
                        placeholder="Masukkan nama petugas"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >

                </div>

                <!-- EMAIL -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        placeholder="petugas@gmail.com"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >

                </div>

                <!-- NO HP -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nomor HP
                    </label>

                    <input
                        type="text"
                        name="no_hp"
                        placeholder="08xxxxxxxxxx"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >

                </div>

                <!-- PASSWORD -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >

                </div>

            </div>

            <!-- RIGHT -->
            <div class="space-y-6">

                <!-- KECAMATAN -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kecamatan / Cabang
                    </label>

                    <select
                        name="kecamatan"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >

                        <option>Pilih Kecamatan</option>
                        <option>Indramayu</option>
                        <option>Jatibarang</option>
                        <option>Losarang</option>
                        <option>Arahan</option>
                        <option>Karangampel</option>

                    </select>

                </div>

                <!-- ROLE -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Role Petugas
                    </label>

                    <select
                        name="role"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >

                        <option value="lapangan">Petugas Lapangan</option>
                        <option value="customer_service">Petugas Pengaduan</option>
                        <option value="supervisor">Supervisor Cabang</option>

                    </select>

                </div>

                <!-- STATUS -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Status Akun
                    </label>

                    <select
                        name="status"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >

                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>

                    </select>

                </div>

                <!-- DEVICE -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Device Login
                    </label>

                    <div class="bg-[#f5f7fb] rounded-2xl p-5">

                        <div class="flex items-center gap-3">

                            <div class="w-4 h-4 rounded-full bg-yellow-500"></div>

                            <p class="text-gray-700 font-semibold">
                                Belum terhubung ke device
                            </p>

                        </div>

                    </div>

                </div>

                <!-- SECURITY -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Keamanan Akun
                    </label>

                    <div class="bg-[#f5f7fb] rounded-2xl p-5 space-y-4">

                        <div class="flex items-center justify-between">

                            <span class="text-gray-700">
                                Batasi 1 Device
                            </span>

                            <input type="checkbox" checked class="w-5 h-5">

                        </div>

                        <div class="flex items-center justify-between">

                            <span class="text-gray-700">
                                Login Verification
                            </span>

                            <input type="checkbox" checked class="w-5 h-5">

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- BUTTON -->
        <div class="flex gap-4 mt-10">

            <button
                type="submit"
                class="bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white px-8 py-4 rounded-2xl font-semibold shadow-lg"
            >
                Simpan Petugas
            </button>

            <button
                type="reset"
                class="bg-red-500 hover:bg-red-600 transition-all duration-300 text-white px-8 py-4 rounded-2xl font-semibold shadow-lg"
            >
                Reset Form
            </button>

        </div>

    </form>

</div>

@endsection
