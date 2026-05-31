@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Proses Pengaduan
        </h1>

        <p class="text-gray-500 mt-2">
            Penanganan dan monitoring proses pengaduan pelanggan
        </p>

    </div>

    <a href="/pengaduan"
       class="bg-gray-200 hover:bg-gray-300 transition-all duration-300 text-gray-700 px-6 py-3 rounded-2xl font-semibold">
        ← Kembali
    </a>

</div>

<!-- GRID -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

    <!-- LEFT -->
    <div class="xl:col-span-2 space-y-8">

        <!-- FOTO PENGADUAN -->
        <div class="bg-white rounded-3xl shadow overflow-hidden">

            <img
                src="https://images.unsplash.com/photo-1521207418485-99c705420785?q=80&w=1200&auto=format&fit=crop"
                class="w-full h-105 object-cover"
            >

        </div>

        <!-- FORM PROSES -->
        <div class="bg-white rounded-3xl shadow p-8">

            <h2 class="text-2xl font-bold text-gray-800 mb-8">
                Form Penanganan Pengaduan
            </h2>

            <form action="/pengaduan/update-proses/{{ $pengaduan->id }}" method="POST">

                @csrf

                <div class="space-y-6">

                    <!-- STATUS -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Status Pengaduan
                        </label>

                        <select
                            name="status"
                            class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                        >
                            <option value="proses" {{ $pengaduan->status == 'proses' ? 'selected' : '' }}>
                                Proses
                            </option>

                            <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>

                    </div>

                    <!-- PETUGAS -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Petugas Penanganan
                        </label>

                        <input
                            type="text"
                            value="IND001 - Petugas Indramayu"
                            readonly
                            class="w-full bg-[#f5f7fb] border border-gray-300 rounded-2xl px-4 py-3"
                        >

                    </div>

                    <!-- KETERANGAN -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Keterangan Penanganan
                        </label>

                        <textarea
                            rows="6"
                            placeholder="Masukkan proses penanganan pengaduan..."
                            class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                        ></textarea>

                    </div>

                    <!-- UPLOAD -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-4">
                            Upload Bukti Penyelesaian
                        </label>

                        <div class="border-2 border-dashed border-gray-300 rounded-3xl p-10 text-center">

                            <div class="text-6xl mb-5">
                                📤
                            </div>

                            <h3 class="text-xl font-bold text-gray-700 mb-3">
                                Upload Foto Perbaikan
                            </h3>

                            <p class="text-gray-400 mb-6">
                                Upload hasil pengerjaan petugas lapangan
                            </p>

                            <input
                                type="file"
                                class="block mx-auto"
                            >

                        </div>

                    </div>

                    <!-- BUTTON -->
                    <div class="flex gap-4 pt-4">

                        <button
                            type="submit"
                            class="bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white px-8 py-4 rounded-2xl font-semibold shadow-lg"
                        >
                            Simpan
                        </button>

                        <a
                            href="/pengaduan"
                            class="bg-gray-200 hover:bg-gray-300 transition-all duration-300 text-gray-700 px-8 py-4 rounded-2xl font-semibold shadow-lg text-center"
                        >
                            Kembali
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- RIGHT -->
    <div class="space-y-8">

        <!-- DATA PELANGGAN -->
        <div class="bg-white rounded-3xl shadow p-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Data Pelanggan
            </h2>

            <div class="space-y-5">

                <div>

                    <p class="text-sm text-gray-400 mb-1">
                        Nama Pelanggan
                    </p>

                    <h3 class="font-semibold text-gray-700">
                        Mukti Rahayu
                    </h3>

                </div>

                <div>

                    <p class="text-sm text-gray-400 mb-1">
                        Nomor Pelanggan
                    </p>

                    <h3 class="font-semibold text-[#2191d1]">
                        120000000001
                    </h3>

                </div>

                <div>

                    <p class="text-sm text-gray-400 mb-1">
                        Kecamatan
                    </p>

                    <h3 class="font-semibold text-gray-700">
                        Indramayu
                    </h3>

                </div>

                <div>

                    <p class="text-sm text-gray-400 mb-1">
                        Nomor HP
                    </p>

                    <h3 class="font-semibold text-gray-700">
                        081234567890
                    </h3>

                </div>

            </div>

        </div>

        <!-- STATUS -->
        <div class="bg-white rounded-3xl shadow p-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Status Penanganan
            </h2>

            <div class="space-y-5">

                <div class="bg-yellow-100 text-yellow-700 p-5 rounded-2xl">

                    <h3 class="font-bold mb-2">
                        ⏳ Sedang Diproses
                    </h3>

                    <p class="text-sm">
                        Petugas sedang melakukan pengecekan lapangan.
                    </p>

                </div>

                <div>

                    <div class="flex justify-between mb-2">

                        <span class="text-gray-500">
                            Progress
                        </span>

                        <span class="font-semibold text-gray-700">
                            70%
                        </span>

                    </div>

                    <div class="w-full h-4 bg-gray-200 rounded-full overflow-hidden">

                        <div class="bg-[#2191d1] h-full rounded-full w-[70%]"></div>

                    </div>

                </div>

            </div>

        </div>

        <!-- PETUGAS -->
        <div class="bg-white rounded-3xl shadow p-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Petugas Aktif
            </h2>

            <div class="flex items-center gap-4">

                <div class="w-16 h-16 rounded-2xl bg-[#2191d1] flex items-center justify-center text-white text-2xl font-bold">

                    P

                </div>

                <div>

                    <h3 class="font-bold text-gray-800">
                        IND001
                    </h3>

                    <p class="text-gray-400 text-sm">
                        Petugas Indramayu
                    </p>

                </div>

            </div>

            <div class="mt-6 space-y-4">

                <div class="bg-[#f5f7fb] rounded-2xl p-4">

                    <p class="text-sm text-gray-400 mb-1">
                        Device
                    </p>

                    <h4 class="font-semibold text-green-600">
                        Samsung Galaxy A24
                    </h4>

                </div>

                <div class="bg-[#f5f7fb] rounded-2xl p-4">

                    <p class="text-sm text-gray-400 mb-1">
                        Login Terakhir
                    </p>

                    <h4 class="font-semibold text-gray-700">
                        15 Juni 2026 - 09:10 WIB
                    </h4>

                </div>

            </div>

        </div>

        <!-- TIMELINE -->
        <div class="bg-white rounded-3xl shadow p-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Timeline Penanganan
            </h2>

            <div class="space-y-6">

                <div class="flex gap-4">

                    <div class="w-4 h-4 rounded-full bg-green-500 mt-1"></div>

                    <div>

                        <h4 class="font-semibold text-gray-700">
                            Pengaduan Dibuat
                        </h4>

                        <p class="text-sm text-gray-400">
                            15 Juni 2026 - 07:10 WIB
                        </p>

                    </div>

                </div>

                <div class="flex gap-4">

                    <div class="w-4 h-4 rounded-full bg-yellow-500 mt-1"></div>

                    <div>

                        <h4 class="font-semibold text-gray-700">
                            Diproses Petugas
                        </h4>

                        <p class="text-sm text-gray-400">
                            15 Juni 2026 - 08:30 WIB
                        </p>

                    </div>

                </div>

                <div class="flex gap-4">

                    <div class="w-4 h-4 rounded-full bg-gray-300 mt-1"></div>

                    <div>

                        <h4 class="font-semibold text-gray-400">
                            Menunggu Penyelesaian
                        </h4>

                        <p class="text-sm text-gray-300">
                            Pending
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection