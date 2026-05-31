@extends('layouts.app')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">
        Deteksi Anomali Pemakaian
    </h1>

    <p class="text-gray-500 mt-2">
        Monitoring pemakaian air yang terdeteksi tidak normal
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-3xl shadow p-6">
        <p class="text-gray-400 text-sm">Total Anomali</p>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ number_format($totalAnomali ?? 0) }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <p class="text-gray-400 text-sm">Menunggu Verifikasi</p>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ number_format($pendingAnomali ?? 0) }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <p class="text-gray-400 text-sm">Sudah Diverifikasi</p>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ number_format($validAnomali ?? 0) }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <p class="text-gray-400 text-sm">Kecamatan Tertinggi</p>
        <h2 class="text-2xl font-bold text-gray-800 mt-2">
            {{ $kecamatanTertinggi ?? '-' }}
        </h2>
    </div>

</div>

<div class="bg-white rounded-3xl shadow p-6 mb-8">

    <form action="/meter/anomali" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari pelanggan..."
            class="border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
        >

        <select
            name="kecamatan"
            class="border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
        >
            <option value="">Semua Kecamatan</option>
            <option value="Indramayu" {{ request('kecamatan') == 'Indramayu' ? 'selected' : '' }}>Indramayu</option>
            <option value="Jatibarang" {{ request('kecamatan') == 'Jatibarang' ? 'selected' : '' }}>Jatibarang</option>
            <option value="Losarang" {{ request('kecamatan') == 'Losarang' ? 'selected' : '' }}>Losarang</option>
            <option value="Arahan" {{ request('kecamatan') == 'Arahan' ? 'selected' : '' }}>Arahan</option>
            <option value="Karangampel" {{ request('kecamatan') == 'Karangampel' ? 'selected' : '' }}>Karangampel</option>
        </select>

        <select
            name="status"
            class="border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
        >
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="valid" {{ request('status') == 'valid' ? 'selected' : '' }}>Valid</option>
            <option value="warning" {{ request('status') == 'warning' ? 'selected' : '' }}>Warning</option>
        </select>

        <div class="flex gap-3">
            <button
                type="submit"
                class="flex-1 bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white rounded-2xl font-semibold"
            >
                Filter Data
            </button>

            <a
                href="/meter/anomali"
                class="flex-1 text-center bg-gray-200 hover:bg-gray-300 transition-all duration-300 text-gray-700 rounded-2xl font-semibold px-4 py-3"
            >
                Reset
            </a>
        </div>

    </form>

</div>

<div class="bg-white rounded-3xl shadow overflow-hidden">

    <div class="p-6 border-b border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800">
            Data Anomali Pemakaian Air
        </h2>
    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#2191d1] text-white">
                <tr>
                    <th class="px-6 py-4 text-left">Pelanggan</th>
                    <th class="px-6 py-4 text-left">Kecamatan</th>
                    <th class="px-6 py-4 text-left">Meter Lama</th>
                    <th class="px-6 py-4 text-left">Meter Baru</th>
                    <th class="px-6 py-4 text-left">Pemakaian</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

            @forelse($anomali as $item)

                <tr class="hover:bg-gray-50">

                    <td class="px-6 py-5">
                        <h3 class="font-semibold text-gray-800">
                            {{ $item->user->nama ?? 'Pelanggan tidak ditemukan' }}
                        </h3>

                        <p class="text-sm text-gray-400">
                            {{ $item->user->no_pelanggan ?? '-' }}
                        </p>
                    </td>

                    <td class="px-6 py-5">
                        {{ $item->user->kecamatan ?? '-' }}
                    </td>

                    <td class="px-6 py-5">
                        {{ $item->meter_lama ?? 0 }} m³
                    </td>

                    <td class="px-6 py-5">
                        {{ $item->meter_baru ?? 0 }} m³
                    </td>

                    <td class="px-6 py-5 font-bold text-red-500">
                        {{ $item->pemakaian ?? 0 }} m³
                    </td>

                    <td class="px-6 py-5">
                        @if($item->validasi_petugas == 'valid')
                            <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                                Valid
                            </span>
                        @elseif($item->validasi_petugas == 'warning')
                            <span class="bg-yellow-100 text-yellow-600 px-4 py-2 rounded-full text-sm font-semibold">
                                Warning
                            </span>
                        @else
                            <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-sm font-semibold">
                                Anomali
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-5">
                        <div class="flex gap-2">
                            <a href="/meter/detail/{{ $item->id }}"
                               class="bg-[#2191d1] hover:bg-[#1977ad] text-white px-4 py-2 rounded-xl text-sm font-semibold">
                                Detail
                            </a>

                            <a href="/meter/validasi/{{ $item->id }}"
                               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-semibold">
                                Valid
                            </a>

                            <a href="/meter/warning/{{ $item->id }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-xl text-sm font-semibold">
                                Warning
                            </a>
                        </div>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center py-10 text-gray-400">
                        Tidak ada data anomali
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection