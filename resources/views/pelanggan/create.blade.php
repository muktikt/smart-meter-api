@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Tambah Pelanggan
        </h1>

        <p class="text-gray-500 mt-2">
            Tambahkan data pelanggan baru PDAM
        </p>

    </div>

    <a href="/pelanggan"
       class="bg-gray-200 hover:bg-gray-300 transition-all duration-300 text-gray-700 px-6 py-3 rounded-2xl font-semibold">
        ← Kembali
    </a>

</div>

<!-- FORM -->
<div class="bg-white rounded-3xl shadow p-8">

    <form action="/pelanggan/store" method="POST">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- LEFT -->
            <div class="space-y-6">

                <!-- NOMOR PELANGGAN -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nomor Pelanggan
                    </label>

                    <input
                        type="text"
                        name="no_pelanggan"
                        placeholder="120000000001"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >

                </div>

                <!-- NAMA -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Pelanggan
                    </label>

                    <input
                        type="text"
                        name="nama"
                        placeholder="Masukkan nama pelanggan"
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
                        placeholder="email@gmail.com"
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

                <!-- ALAMAT -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Alamat
                    </label>

                    <textarea
                        name="alamat"
                        rows="5"
                        placeholder="Masukkan alamat pelanggan"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    ></textarea>

                </div>

                <!-- STATUS -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Status Akun
                    </label>

                    <select
                        name="status_akun"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >

                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>

                    </select>

                </div>

                <!-- DEVICE -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Status Device
                    </label>

                    <div class="bg-[#f5f7fb] rounded-2xl p-5">

                        <div class="flex items-center gap-3">

                            <div class="w-4 h-4 rounded-full bg-green-500"></div>

                            <p class="text-gray-700 font-semibold">
                                Belum terhubung ke device
                            </p>

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
                Simpan Pelanggan
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