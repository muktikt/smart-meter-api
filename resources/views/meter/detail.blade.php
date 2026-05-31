@extends('layouts.app')

@section('content')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Detail Meter Air
        </h1>

        <p class="text-gray-500 mt-2">
            Detail upload meter pelanggan dan hasil pembacaan OCR
        </p>
    </div>

    <a href="/meter"
       class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-2xl font-semibold">
        ← Kembali
    </a>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

    <div class="xl:col-span-2">
        <div class="bg-white rounded-3xl shadow overflow-hidden">

            <div class="relative">
                @if($meter->foto_meter)
                    <img src="{{ asset('storage/' . $meter->foto_meter) }}"
                         class="w-full h-80 object-cover">
                @else
                    <div class="w-full h-80 bg-gray-100 flex items-center justify-center text-gray-400">
                        Foto meter belum tersedia
                    </div>
                @endif

                <div class="absolute top-5 right-5">
                    <span class="bg-[#2191d1] text-white px-5 py-2 rounded-full text-sm font-semibold shadow-lg">
                        OCR {{ ucfirst($meter->ocr_status ?? 'pending') }}
                    </span>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="bg-[#f5f7fb] rounded-2xl p-5">
                        <p class="text-sm text-gray-400 mb-2">Angka OCR / Meter Baru</p>
                        <h2 class="text-4xl font-bold text-[#2191d1]">
                            {{ $meter->meter_baru ?? 0 }}
                        </h2>
                    </div>

                    <div class="bg-[#f5f7fb] rounded-2xl p-5">
                        <p class="text-sm text-gray-400 mb-2">Meter Sebelumnya</p>
                        <h2 class="text-4xl font-bold text-gray-700">
                            {{ $meter->meter_lama ?? 0 }}
                        </h2>
                    </div>

                    <div class="bg-[#f5f7fb] rounded-2xl p-5">
                        <p class="text-sm text-gray-400 mb-2">Pemakaian</p>
                        <h2 class="text-4xl font-bold {{ ($meter->pemakaian ?? 0) > 100 ? 'text-red-500' : 'text-green-500' }}">
                            {{ $meter->pemakaian ?? 0 }}
                        </h2>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="space-y-6">

        <div class="bg-white rounded-3xl shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Data Pelanggan
            </h2>

            <div class="space-y-5">
                <div>
                    <p class="text-sm text-gray-400 mb-1">Nama Pelanggan</p>
                    <h3 class="font-semibold text-gray-700">
                        {{ $meter->user->nama ?? '-' }}
                    </h3>
                </div>

                <div>
                    <p class="text-sm text-gray-400 mb-1">Nomor Pelanggan</p>
                    <h3 class="font-semibold text-gray-700">
                        {{ $meter->user->no_pelanggan ?? '-' }}
                    </h3>
                </div>

                <div>
                    <p class="text-sm text-gray-400 mb-1">Kecamatan</p>
                    <h3 class="font-semibold text-gray-700">
                        {{ $meter->user->kecamatan ?? '-' }}
                    </h3>
                </div>

                <div>
                    <p class="text-sm text-gray-400 mb-1">Upload Pada</p>
                    <h3 class="font-semibold text-gray-700">
                        {{ $meter->created_at ? $meter->created_at->format('d F Y - H:i') . ' WIB' : '-' }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Status Verifikasi
            </h2>

            <div class="space-y-5">
                @if($meter->status == 'valid')
                    <div class="bg-green-100 text-green-700 p-5 rounded-2xl">
                        <h3 class="font-bold mb-2">✔ Valid</h3>
                        <p class="text-sm">Data meter sudah valid.</p>
                    </div>
                @elseif($meter->status_anomali == 'anomali')
                    <div class="bg-red-100 text-red-700 p-5 rounded-2xl">
                        <h3 class="font-bold mb-2">⚠ Anomali</h3>
                        <p class="text-sm">Data meter terdeteksi tidak normal.</p>
                    </div>
                @else
                    <div class="bg-yellow-100 text-yellow-700 p-5 rounded-2xl">
                        <h3 class="font-bold mb-2">⚠ Menunggu Verifikasi</h3>
                        <p class="text-sm">Data meter sedang menunggu verifikasi petugas.</p>
                    </div>
                @endif

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500">Akurasi OCR</span>
                        <span class="font-semibold text-gray-700">
                            {{ $meter->ocr_persen ?? 0 }}%
                        </span>
                    </div>

                    <div class="w-full h-4 bg-gray-200 rounded-full overflow-hidden">
                        <div class="bg-[#2191d1] h-full rounded-full"
                             style="width: {{ $meter->ocr_persen ?? 0 }}%">
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500">Validasi Petugas</span>
                        <span class="font-semibold text-gray-700">
                            {{ ucfirst($meter->validasi_petugas ?? 'pending') }}
                        </span>
                    </div>

                    <div class="w-full h-4 bg-gray-200 rounded-full overflow-hidden">
                        <div class="bg-green-500 h-full rounded-full"
                             style="width: {{ ($meter->validasi_petugas ?? '') == 'valid' ? '100%' : '30%' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Deteksi Anomali
            </h2>

            @if($meter->status_anomali == 'anomali' || ($meter->pemakaian ?? 0) > 100)
                <div class="bg-red-100 text-red-600 p-5 rounded-2xl">
                    <h3 class="font-bold mb-2">⚠ Pemakaian Tidak Normal</h3>
                    <p class="text-sm leading-relaxed">
                        {{ $meter->catatan_anomali ?? 'Sistem mendeteksi pemakaian air yang cukup tinggi dibanding batas normal.' }}
                    </p>
                </div>
            @else
                <div class="bg-green-100 text-green-600 p-5 rounded-2xl">
                    <h3 class="font-bold mb-2">✔ Normal</h3>
                    <p class="text-sm leading-relaxed">
                        Pemakaian air masih dalam batas normal.
                    </p>
                </div>
            @endif
        </div>

    </div>

</div>

@endsection