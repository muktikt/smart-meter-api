@extends('layouts.app')

@section('content')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">Edit Petugas</h1>
        <p class="text-gray-500 mt-2">Perbarui data akun petugas PDAM</p>
    </div>

    <a href="/petugas" class="bg-gray-200 hover:bg-gray-300 transition-all duration-300 text-gray-700 px-6 py-3 rounded-2xl font-semibold">
        ← Kembali
    </a>

</div>

<div class="bg-white rounded-3xl shadow p-8">

    <form action="/petugas/update/{{ $petugas->id }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Petugas</label>
                    <input
                        type="text"
                        name="kode_petugas"
                        value="{{ old('kode_petugas', $petugas->kode_petugas) }}"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Petugas</label>
                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama', $petugas->nama) }}"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $petugas->email) }}"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP</label>
                    <input
                        type="text"
                        name="no_hp"
                        value="{{ old('no_hp', $petugas->no_hp) }}"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan / Cabang</label>
                    <select
                        name="kecamatan"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >
                        <option value="Indramayu" {{ old('kecamatan', $petugas->kecamatan) == 'Indramayu' ? 'selected' : '' }}>Indramayu</option>
                        <option value="Jatibarang" {{ old('kecamatan', $petugas->kecamatan) == 'Jatibarang' ? 'selected' : '' }}>Jatibarang</option>
                        <option value="Losarang" {{ old('kecamatan', $petugas->kecamatan) == 'Losarang' ? 'selected' : '' }}>Losarang</option>
                        <option value="Arahan" {{ old('kecamatan', $petugas->kecamatan) == 'Arahan' ? 'selected' : '' }}>Arahan</option>
                        <option value="Karangampel" {{ old('kecamatan', $petugas->kecamatan) == 'Karangampel' ? 'selected' : '' }}>Karangampel</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Role Petugas</label>
                    <select
                        name="role"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >
                        <option value="lapangan" {{ in_array(old('role', $petugas->role), ['lapangan', 'Petugas Lapangan']) ? 'selected' : '' }}>Petugas Lapangan</option>
                        <option value="customer_service" {{ in_array(old('role', $petugas->role), ['customer_service', 'Customer Service', 'Petugas Pengaduan']) ? 'selected' : '' }}>Petugas Pengaduan</option>
                        <option value="supervisor" {{ in_array(old('role', $petugas->role), ['supervisor', 'Supervisor Cabang']) ? 'selected' : '' }}>Supervisor Cabang</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Akun</label>
                    <select
                        name="status"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >
                        <option value="aktif" {{ in_array(old('status', $petugas->status), ['aktif', 'Aktif']) ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ in_array(old('status', $petugas->status), ['nonaktif', 'Nonaktif']) ? 'selected' : '' }}>Nonaktif</option>
                        <option value="blocked" {{ in_array(old('status', $petugas->status), ['blocked', 'Blocked']) ? 'selected' : '' }}>Blocked</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Kosongkan jika tidak diubah"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                    >
                </div>
            </div>

        </div>

        <div class="flex gap-4 mt-10">
            <button type="submit" class="bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white px-8 py-4 rounded-2xl font-semibold shadow-lg">
                Simpan Perubahan
            </button>

            <a href="/petugas" class="bg-red-500 hover:bg-red-600 transition-all duration-300 text-white px-8 py-4 rounded-2xl font-semibold shadow-lg">
                Batal
            </a>
        </div>

    </form>

</div>

@endsection
