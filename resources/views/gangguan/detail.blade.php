@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Detail Gangguan Air
        </h1>

        <p class="text-gray-500 mt-2">
            Informasi detail gangguan layanan air PDAM
        </p>
    </div>

    <a href="/gangguan"
       class="bg-gray-200 hover:bg-gray-300 transition-all duration-300 px-5 py-3 rounded-2xl font-semibold text-gray-700">
        ← Kembali
    </a>

</div>

<!-- CARD -->
<div class="bg-white rounded-3xl shadow overflow-hidden">

    <!-- IMAGE -->
    <div class="relative">

        @if($gangguan->foto)
            <img src="{{ asset('storage/' . $gangguan->foto) }}"
                 class="w-full h-96 object-cover">
        @else
            <div class="w-full h-96 bg-blue-100 flex items-center justify-center text-7xl">
                🚧
            </div>
        @endif

        <div class="absolute top-6 right-6">

            @if($gangguan->status == 'aktif')
                <span class="bg-red-500 text-white px-5 py-2 rounded-full font-semibold shadow-lg">
                    Aktif
                </span>
            @elseif($gangguan->status == 'proses')
                <span class="bg-yellow-500 text-white px-5 py-2 rounded-full font-semibold shadow-lg">
                    Proses
                </span>
            @else
                <span class="bg-green-500 text-white px-5 py-2 rounded-full font-semibold shadow-lg">
                    Selesai
                </span>
            @endif

        </div>

    </div>

    <!-- CONTENT -->
    <div class="p-8">

        <div class="mb-8">

            <h1 class="text-4xl font-bold text-gray-800 mb-4">
                {{ $gangguan->judul ?? '-' }}
            </h1>

            <p class="text-lg text-gray-500 leading-relaxed">
                {{ $gangguan->deskripsi ?? '-' }}
            </p>

        </div>

        <!-- INFO GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

            <div class="bg-[#f5f7fb] rounded-2xl p-5">
                <p class="text-gray-400 text-sm mb-2">Kecamatan</p>
                <h3 class="font-bold text-gray-800 text-lg">
                    {{ $gangguan->kecamatan ?? '-' }}
                </h3>
            </div>

            <div class="bg-[#f5f7fb] rounded-2xl p-5">
                <p class="text-gray-400 text-sm mb-2">Tanggal Mulai</p>
                <h3 class="font-bold text-gray-800 text-lg">
                    {{ $gangguan->tanggal_mulai ? \Carbon\Carbon::parse($gangguan->tanggal_mulai)->format('d M Y H:i') : '-' }}
                </h3>
            </div>

            <div class="bg-[#f5f7fb] rounded-2xl p-5">
                <p class="text-gray-400 text-sm mb-2">Estimasi Selesai</p>
                <h3 class="font-bold text-gray-800 text-lg">
                    {{ $gangguan->estimasi_selesai ? \Carbon\Carbon::parse($gangguan->estimasi_selesai)->format('d M Y H:i') : '-' }}
                </h3>
            </div>

            <div class="bg-[#f5f7fb] rounded-2xl p-5">
                <p class="text-gray-400 text-sm mb-2">Status</p>

                @if($gangguan->status == 'aktif')
                    <h3 class="font-bold text-red-500 text-lg">Aktif</h3>
                @elseif($gangguan->status == 'proses')
                    <h3 class="font-bold text-yellow-500 text-lg">Proses</h3>
                @else
                    <h3 class="font-bold text-green-500 text-lg">Selesai</h3>
                @endif
            </div>

        </div>

        <!-- DETAIL -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

            <div class="xl:col-span-2">
                <div class="bg-[#f5f7fb] rounded-3xl p-6">

                    <h3 class="text-2xl font-bold text-gray-800 mb-5">
                        Detail Informasi
                    </h3>

                    <p class="text-gray-600 leading-relaxed">
                        {{ $gangguan->deskripsi ?? '-' }}
                    </p>

                </div>
            </div>

            <div>
                <div class="bg-[#f5f7fb] rounded-3xl p-6">

                    <h3 class="text-2xl font-bold text-gray-800 mb-5">
                        Monitoring
                    </h3>

                    @php
                        $progress = 0;

                        if($gangguan->status == 'aktif') {
                            $progress = 30;
                        } elseif($gangguan->status == 'proses') {
                            $progress = 70;
                        } elseif($gangguan->status == 'selesai') {
                            $progress = 100;
                        }
                    @endphp

                    <div class="space-y-5">

                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-500">Progress</span>
                                <span class="font-semibold text-gray-700">
                                    {{ $progress }}%
                                </span>
                            </div>

                            <div class="w-full h-4 bg-gray-200 rounded-full overflow-hidden">
                                <div class="bg-[#2191d1] h-full rounded-full"
                                     style="width: {{ $progress }}%">
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-100 text-blue-700 p-4 rounded-2xl">
                            <h4 class="font-bold mb-2">
                                📍 Lokasi
                            </h4>

                            <p class="text-sm">
                                Kecamatan {{ $gangguan->kecamatan ?? '-' }}
                            </p>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        <!-- BUTTON -->
        <div class="flex items-center gap-4 mt-10">

            @if($gangguan->status != 'selesai')
                <a href="/gangguan/selesai/{{ $gangguan->id }}"
                   class="bg-green-500 hover:bg-green-600 transition-all duration-300 text-white px-8 py-3 rounded-2xl font-semibold shadow-lg">
                    Tandai Selesai
                </a>
            @endif

            <a href="/gangguan"
               class="bg-gray-200 hover:bg-gray-300 transition-all duration-300 text-gray-700 px-8 py-3 rounded-2xl font-semibold">
                Kembali
            </a>

        </div>

    </div>

</div>

@endsection