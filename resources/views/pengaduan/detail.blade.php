@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Detail Pengaduan
        </h1>

        <p class="text-gray-500 mt-2">
            Informasi lengkap pengaduan pelanggan PDAM
        </p>

    </div>

    <div class="flex gap-3">

        @if($pengaduan->status != 'selesai')
            <a href="/pengaduan/proses/{{ $pengaduan->id }}"
            class="bg-yellow-500 hover:bg-yellow-600 transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
                ✔ Proses
            </a>
        @endif

        <a href="/pengaduan"
        class="bg-gray-200 hover:bg-gray-300 transition-all duration-300 text-gray-700 px-6 py-3 rounded-2xl font-semibold shadow-lg">
            ← Kembali
        </a>

    </div>

</div>

<!-- GRID -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

    <!-- LEFT -->
    <div class="xl:col-span-2 space-y-8">

        <!-- FOTO -->
        <div class="bg-white rounded-3xl shadow overflow-hidden">

            @if($pengaduan->foto)
                <img
                    src="{{ asset('storage/' . $pengaduan->foto) }}"
                    class="w-full h-80 object-cover"
                    alt="Foto pengaduan"
                >
            @else
                <div class="w-full h-80 bg-gray-100 flex flex-col items-center justify-center text-gray-400 gap-3">
                    <span class="text-5xl">📷</span>
                    <p>Tidak ada foto pengaduan</p>
                </div>
            @endif

        </div>

        <!-- DESKRIPSI -->
        <div class="bg-white rounded-3xl shadow p-8">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Deskripsi Pengaduan
            </h2>

            <div class="bg-[#f5f7fb] rounded-2xl p-6">

                <p class="text-gray-700 leading-relaxed">
                    {{ $pengaduan->deskripsi ?? '-' }}
                </p>

            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="bg-[#f5f7fb] rounded-2xl p-4">
                    <p class="text-sm text-gray-400 mb-1">Kategori</p>
                    <h4 class="font-semibold text-gray-700">
                        {{ $pengaduan->kategori ?? '-' }}
                    </h4>
                </div>

                <div class="bg-[#f5f7fb] rounded-2xl p-4">
                    <p class="text-sm text-gray-400 mb-1">Tanggal Masuk</p>
                    <h4 class="font-semibold text-gray-700">
                        {{ $pengaduan->created_at ? \Carbon\Carbon::parse($pengaduan->created_at)->format('d M Y - H:i') . ' WIB' : '-' }}
                    </h4>
                </div>

            </div>

        </div>

        <!-- BUKTI PENYELESAIAN -->
        <div class="bg-white rounded-3xl shadow p-8">

            <div class="flex items-center justify-between mb-6">

                <h2 class="text-2xl font-bold text-gray-800">
                    Bukti Penyelesaian
                </h2>

                <span class="{{ $pengaduan->status == 'selesai' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }} px-4 py-2 rounded-full text-sm font-semibold">
                    {{ $pengaduan->status == 'selesai' ? 'Sudah Selesai' : 'Belum Upload' }}
                </span>

            </div>

            @if($pengaduan->status != 'selesai')

                <!-- UPLOAD -->
                <div class="border-2 border-dashed border-gray-300 rounded-3xl p-10 text-center">

                    <div class="text-6xl mb-5">
                        📤
                    </div>

                    <h3 class="text-xl font-bold text-gray-700 mb-3">
                        Upload Bukti Penyelesaian
                    </h3>

                    <p class="text-gray-400 mb-6">
                        Upload foto hasil perbaikan oleh petugas
                    </p>

                    <a href="/pengaduan/proses/{{ $pengaduan->id }}"
                       class="inline-block bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
                        Proses Pengaduan
                    </a>

                </div>

            @else

                <div class="bg-green-50 rounded-2xl p-6 text-center">
                    <div class="text-5xl mb-3">✅</div>
                    <p class="text-green-700 font-semibold">Pengaduan telah diselesaikan</p>
                    @if($pengaduan->updated_at)
                        <p class="text-green-500 text-sm mt-1">
                            {{ \Carbon\Carbon::parse($pengaduan->updated_at)->format('d M Y - H:i') }} WIB
                        </p>
                    @endif
                </div>

            @endif

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
                        {{ $pengaduan->user->nama ?? '-' }}
                    </h3>
                </div>

                <div>
                    <p class="text-sm text-gray-400 mb-1">
                        Nomor Pelanggan
                    </p>
                    <h3 class="font-semibold text-[#2191d1]">
                        {{ $pengaduan->user->no_pelanggan ?? '-' }}
                    </h3>
                </div>

                <div>
                    <p class="text-sm text-gray-400 mb-1">
                        Kecamatan
                    </p>
                    <h3 class="font-semibold text-gray-700">
                        {{ $pengaduan->user->kecamatan ?? '-' }}
                    </h3>
                </div>

                <div>
                    <p class="text-sm text-gray-400 mb-1">
                        Nomor HP
                    </p>
                    <h3 class="font-semibold text-gray-700">
                        {{ $pengaduan->user->no_hp ?? '-' }}
                    </h3>
                </div>

                @if($pengaduan->user && $pengaduan->user->no_hp)
                    @php
                        $noHp = preg_replace('/[^0-9]/', '', $pengaduan->user->no_hp);
                        if (substr($noHp, 0, 1) == '0') {
                            $noHp = '62' . substr($noHp, 1);
                        }
                        $pesan = 'Halo ' . ($pengaduan->user->nama ?? 'Pelanggan') .
                            ', pengaduan Anda dengan kategori "' . ($pengaduan->kategori ?? '-') .
                            '" sedang kami proses. Mohon tunggu informasi selanjutnya dari PDAM.';
                    @endphp
                    <a href="https://wa.me/{{ $noHp }}?text={{ urlencode($pesan) }}"
                       target="_blank"
                       class="flex items-center gap-2 bg-green-500 hover:bg-green-600 transition text-white px-4 py-3 rounded-2xl text-sm font-semibold">
                        <span>📩</span> Hubungi via WhatsApp
                    </a>
                @endif

            </div>

        </div>

        <!-- STATUS -->
        <div class="bg-white rounded-3xl shadow p-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Status Pengaduan
            </h2>

            <div class="space-y-5">

                @if($pengaduan->status == 'selesai')
                    <div class="bg-green-100 text-green-700 p-5 rounded-2xl">
                        <h3 class="font-bold mb-2">✅ Selesai</h3>
                        <p class="text-sm">Pengaduan telah ditangani dan diselesaikan.</p>
                    </div>
                    @php $progress = 100; @endphp
                @elseif($pengaduan->status == 'proses')
                    <div class="bg-yellow-100 text-yellow-700 p-5 rounded-2xl">
                        <h3 class="font-bold mb-2">⏳ Sedang Diproses</h3>
                        <p class="text-sm">Pengaduan sedang ditangani oleh petugas lapangan.</p>
                    </div>
                    @php $progress = 60; @endphp
                @else
                    <div class="bg-red-100 text-red-700 p-5 rounded-2xl">
                        <h3 class="font-bold mb-2">🕐 Menunggu Diproses</h3>
                        <p class="text-sm">Pengaduan telah diterima dan menunggu penugasan petugas.</p>
                    </div>
                    @php $progress = 20; @endphp
                @endif

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500">Progress Penanganan</span>
                        <span class="font-semibold text-gray-700">{{ $progress }}%</span>
                    </div>

                    <div class="w-full h-4 bg-gray-200 rounded-full overflow-hidden">
                        <div class="bg-[#2191d1] h-full rounded-full"
                             style="width: {{ $progress }}%">
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- PETUGAS -->
        <div class="bg-white rounded-3xl shadow p-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Petugas Penanganan
            </h2>

            @if($pengaduan->petugas)

                <div class="flex items-center gap-4 mb-6">

                    <div class="w-16 h-16 rounded-2xl bg-[#2191d1] flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($pengaduan->petugas->nama ?? 'P', 0, 1)) }}
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800">
                            {{ $pengaduan->petugas->nama ?? '-' }}
                        </h3>
                        <p class="text-gray-400 text-sm">
                            {{ $pengaduan->petugas->kode_petugas ?? '-' }}
                        </p>
                    </div>

                </div>

                <div class="space-y-4">

                    <div class="bg-[#f5f7fb] rounded-2xl p-4">
                        <p class="text-sm text-gray-400 mb-1">Kecamatan Tugas</p>
                        <h4 class="font-semibold text-gray-700">
                            {{ $pengaduan->petugas->kecamatan ?? '-' }}
                        </h4>
                    </div>

                    <div class="bg-[#f5f7fb] rounded-2xl p-4">
                        <p class="text-sm text-gray-400 mb-1">Device Aktif</p>
                        <h4 class="font-semibold {{ $pengaduan->petugas->device_name ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $pengaduan->petugas->device_name ?? 'Belum terhubung' }}
                        </h4>
                    </div>

                    <div class="bg-[#f5f7fb] rounded-2xl p-4">
                        <p class="text-sm text-gray-400 mb-1">Status Petugas</p>
                        <span class="{{ $pengaduan->petugas->status == 'aktif' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} px-3 py-1 rounded-full text-sm font-semibold">
                            {{ ucfirst($pengaduan->petugas->status ?? '-') }}
                        </span>
                    </div>

                </div>

            @else

                <div class="bg-gray-50 rounded-2xl p-6 text-center text-gray-400">
                    <div class="text-4xl mb-3">👷</div>
                    <p class="font-semibold">Belum ada petugas yang ditugaskan</p>
                    <p class="text-sm mt-1">Klik tombol "Proses" untuk menugaskan petugas</p>
                </div>

            @endif

        </div>

        <!-- TIMELINE -->
        <div class="bg-white rounded-3xl shadow p-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Timeline
            </h2>

            <div class="space-y-6">

                <!-- Dibuat -->
                <div class="flex gap-4">
                    <div class="w-4 h-4 rounded-full bg-green-500 mt-1 shrink-0"></div>
                    <div>
                        <h4 class="font-semibold text-gray-700">Pengaduan Dibuat</h4>
                        <p class="text-sm text-gray-400">
                            {{ $pengaduan->created_at ? \Carbon\Carbon::parse($pengaduan->created_at)->format('d M Y - H:i') . ' WIB' : '-' }}
                        </p>
                    </div>
                </div>

                <!-- Diproses -->
                <div class="flex gap-4">
                    <div class="w-4 h-4 rounded-full {{ in_array($pengaduan->status, ['proses', 'selesai']) ? 'bg-yellow-500' : 'bg-gray-300' }} mt-1 shrink-0"></div>
                    <div>
                        <h4 class="font-semibold {{ in_array($pengaduan->status, ['proses', 'selesai']) ? 'text-gray-700' : 'text-gray-400' }}">
                            Diproses Petugas
                        </h4>
                        <p class="text-sm {{ in_array($pengaduan->status, ['proses', 'selesai']) ? 'text-gray-400' : 'text-gray-300' }}">
                            @if(in_array($pengaduan->status, ['proses', 'selesai']) && $pengaduan->updated_at)
                                {{ \Carbon\Carbon::parse($pengaduan->updated_at)->format('d M Y - H:i') }} WIB
                            @else
                                Menunggu
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Selesai -->
                <div class="flex gap-4">
                    <div class="w-4 h-4 rounded-full {{ $pengaduan->status == 'selesai' ? 'bg-green-500' : 'bg-gray-300' }} mt-1 shrink-0"></div>
                    <div>
                        <h4 class="font-semibold {{ $pengaduan->status == 'selesai' ? 'text-gray-700' : 'text-gray-400' }}">
                            Selesai
                        </h4>
                        <p class="text-sm {{ $pengaduan->status == 'selesai' ? 'text-gray-400' : 'text-gray-300' }}">
                            @if($pengaduan->status == 'selesai' && $pengaduan->updated_at)
                                {{ \Carbon\Carbon::parse($pengaduan->updated_at)->format('d M Y - H:i') }} WIB
                            @else
                                Menunggu Penyelesaian
                            @endif
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection