@extends('layouts.app')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Profile Admin</h1>
    <p class="text-gray-500 mt-2">Pengaturan akun dan keamanan dashboard PDAM</p>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

    <div class="xl:col-span-2 space-y-8">

        <div class="bg-white rounded-3xl shadow p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Informasi Profile</h2>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="flex flex-col items-center">
                    @if($admin && $admin->foto)
                        <img src="{{ asset('profile/' . $admin->foto) }}"
                             class="w-36 h-36 rounded-full object-cover shadow-lg">
                    @else
                        <div class="w-36 h-36 rounded-full bg-[#2191d1] flex items-center justify-center text-white text-5xl font-bold shadow-lg">
                            {{ strtoupper(substr($admin->nama ?? 'A', 0, 1)) }}
                        </div>
                    @endif

                    <form action="/admin-profile/upload-foto" method="POST" enctype="multipart/form-data" class="mt-6 w-full">
                        @csrf

                        <input type="file" name="foto"
                               class="w-full border border-gray-300 rounded-2xl px-4 py-3 text-sm mb-3">

                        <button type="submit"
                            class="w-full bg-[#2191d1] hover:bg-[#1977ad] text-white px-5 py-3 rounded-2xl font-semibold">
                            Upload Foto
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-2">
                    <form action="/admin-profile/update" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Admin</label>
                                <input type="text" name="nama"
                                       value="{{ old('nama', $admin->nama ?? 'Admin PDAM') }}"
                                       class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                <input type="email" name="email"
                                       value="{{ old('email', $admin->email ?? 'admin@pdam.com') }}"
                                       class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP</label>
                                <input type="text" name="no_hp"
                                       value="{{ old('no_hp', $admin->no_hp ?? '') }}"
                                       class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                                <input type="text" value="Administrator" readonly
                                       class="w-full bg-[#f5f7fb] border border-gray-300 rounded-2xl px-4 py-3">
                            </div>
                        </div>

                        <button type="submit"
                            class="mt-6 bg-[#2191d1] hover:bg-[#1977ad] text-white px-8 py-3 rounded-2xl font-semibold shadow-lg">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <div class="bg-white rounded-3xl shadow p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Ubah Password</h2>

            <form action="/admin-profile/update-password" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password Lama</label>
                        <input type="password" name="password_lama"
                               class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                        <input type="password" name="password_baru"
                               class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi</label>
                        <input type="password" name="konfirmasi_password"
                               class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
                               required>
                    </div>
                </div>

                <button type="submit"
                    class="mt-6 bg-[#2191d1] hover:bg-[#1977ad] text-white px-8 py-3 rounded-2xl font-semibold shadow-lg">
                    Update Password
                </button>
            </form>
        </div>

    </div>

    <div class="space-y-8">

        <div class="bg-white rounded-3xl shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Status Akun</h2>

            <div class="space-y-5">
                <div class="flex items-center justify-between">
                    <span class="text-gray-700">Status</span>
                    <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">Aktif</span>
                </div>

                <div>
                    <p class="text-gray-400 text-sm">Email</p>
                    <p class="font-semibold text-gray-700 break-all">
                        {{ $admin->email ?? 'admin@pdam.com' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-400 text-sm">No HP</p>
                    <p class="font-semibold text-gray-700">
                        {{ $admin->no_hp ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Keamanan</h2>

            <div class="bg-green-100 text-green-700 p-5 rounded-2xl mb-5">
                <h3 class="font-bold mb-2">✔ Sistem Aman</h3>
                <p class="text-sm">Tidak ada aktivitas login mencurigakan.</p>
            </div>

            <form action="/admin-profile/logout-all" method="POST">
                @csrf

                <input type="password" name="password"
                    placeholder="Password admin"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3 mb-3 focus:outline-none focus:ring-4 focus:ring-red-500/20"
                    required>

                <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white py-4 rounded-2xl font-semibold shadow-lg">
                    Logout Semua Device
                </button>
            </form>
        </div>

    </div>

</div>

@endsection