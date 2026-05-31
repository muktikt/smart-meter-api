@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Tambah Informasi Gangguan Air
        </h1>

        <p class="text-gray-500 mt-2">
            Informasi gangguan ini akan tampil di aplikasi pelanggan PDAM
        </p>

    </div>

    <a
        href="/gangguan"
        class="bg-gray-200 hover:bg-gray-300 transition-all duration-300 text-gray-700 px-6 py-3 rounded-2xl font-semibold"
    >
        ← Kembali
    </a>

</div>

<!-- FORM -->
<div class="bg-white rounded-3xl shadow p-8">

    <form
        action="/gangguan/store"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-8"
    >

        @csrf

        <!-- JUDUL -->
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Judul Gangguan
            </label>

            <input
                type="text"
                name="judul"
                value="{{ old('judul') }}"
                placeholder="Contoh: Perbaikan Pipa Distribusi Utama"
                class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                required
            >

        </div>

        <!-- DESKRIPSI -->
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Deskripsi Gangguan
            </label>

            <textarea
                name="deskripsi"
                rows="6"
                placeholder="Masukkan informasi gangguan air..."
                class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                required
            >{{ old('deskripsi') }}</textarea>

        </div>

        <!-- GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- KECAMATAN -->
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kecamatan
                </label>

                <select
                    name="kecamatan"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    required
                >

                    <option value="">Pilih Kecamatan</option>

                    <option value="Indramayu">Indramayu</option>
                    <option value="Jatibarang">Jatibarang</option>
                    <option value="Losarang">Losarang</option>
                    <option value="Karangampel">Karangampel</option>
                    <option value="Arahan">Arahan</option>

                </select>

            </div>

            <!-- STATUS -->
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Status Gangguan
                </label>

                <select
                    name="status"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    required
                >

                    <option value="aktif">Aktif</option>
                    <option value="proses">Proses</option>
                    <option value="selesai">Selesai</option>

                </select>

            </div>

        </div>

        <!-- TANGGAL -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Tanggal Mulai Gangguan
                </label>

                <input
                    type="datetime-local"
                    name="tanggal_mulai"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    required
                >

            </div>

            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Estimasi Selesai
                </label>

                <input
                    type="datetime-local"
                    name="estimasi_selesai"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                >

            </div>

        </div>

        <!-- FOTO -->
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-4">
                Upload Foto / Poster Gangguan
            </label>

            <div class="border-2 border-dashed border-gray-300 rounded-3xl p-10 text-center">

                <div class="text-6xl mb-5">
                    📤
                </div>

                <h3 class="text-xl font-bold text-gray-700 mb-3">
                    Upload Foto Gangguan
                </h3>

                <p class="text-gray-400 mb-6">
                    JPG, PNG maksimal 5MB
                </p>

                <input
                    type="file"
                    name="foto"
                    class="block mx-auto"
                >

            </div>

        </div>

        <!-- BUTTON -->
        <div class="flex items-center gap-4 pt-4">

            <button
                type="submit"
                class="bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white px-8 py-3 rounded-2xl font-semibold shadow-lg"
            >
                Simpan Informasi
            </button>

            <a
                href="/gangguan"
                class="bg-gray-200 hover:bg-gray-300 transition-all duration-300 text-gray-700 px-8 py-3 rounded-2xl font-semibold"
            >
                Batal
            </a>

        </div>

    </form>

</div>

@endsection