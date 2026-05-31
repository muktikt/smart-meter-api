@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Informasi Gangguan Air
        </h1>

        <p class="text-gray-500 mt-2">
            Monitoring informasi gangguan layanan air PDAM
        </p>
    </div>

    <a href="/gangguan/create"
       class="bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
        + Tambah Gangguan
    </a>
</div>

<!-- FILTER -->
<div class="bg-white rounded-3xl shadow p-6 mb-8">
    <form action="/gangguan" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari gangguan..."
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
                <option value="Karangampel" {{ request('kecamatan') == 'Karangampel' ? 'selected' : '' }}>Karangampel</option>
                <option value="Arahan" {{ request('kecamatan') == 'Arahan' ? 'selected' : '' }}>Arahan</option>
            </select>

            <select
                name="status"
                class="border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20"
            >
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>

            <div class="flex gap-3">
                <button
                    type="submit"
                    class="flex-1 bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white rounded-2xl font-semibold px-4 py-3">
                    Filter
                </button>

                <a href="/gangguan"
                   class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-2xl font-semibold px-4 py-3">
                    Reset
                </a>
            </div>

        </div>
    </form>
</div>

<!-- CARD GRID -->
@if($gangguan->count() > 0)

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">

        @foreach($gangguan as $item)

            <div class="bg-white rounded-3xl shadow overflow-hidden hover:shadow-2xl transition-all duration-300">

                <div class="relative">

                    @if($item->foto)
                        <img
                            src="{{ asset('storage/' . $item->foto) }}"
                            class="w-full h-56 object-cover"
                        >
                    @else
                        <div class="w-full h-56 bg-blue-100 flex items-center justify-center text-6xl">
                            🚧
                        </div>
                    @endif

                    <div class="absolute top-4 right-4">

                        @if($item->status == 'aktif')
                            <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                                Aktif
                            </span>
                        @elseif($item->status == 'proses')
                            <span class="bg-yellow-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                                Proses
                            </span>
                        @else
                            <span class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                                Selesai
                            </span>
                        @endif

                    </div>

                </div>

                <div class="p-6">

                    <div class="flex items-center justify-between mb-4">

                        <span class="bg-blue-100 text-[#2191d1] px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $item->kecamatan ?? '-' }}
                        </span>

                        <span class="text-gray-400 text-sm">
                            {{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') : '-' }}
                        </span>

                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-3">
                        {{ $item->judul ?? '-' }}
                    </h2>

                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        {{ \Illuminate\Support\Str::limit($item->deskripsi ?? '-', 120) }}
                    </p>

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <p class="text-sm text-gray-400">
                                Estimasi Selesai
                            </p>

                            <p class="font-semibold text-gray-700">
                                {{ $item->estimasi_selesai ? \Carbon\Carbon::parse($item->estimasi_selesai)->format('d M Y') : '-' }}
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <a href="/gangguan/detail/{{ $item->id }}"
                               class="bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white px-5 py-2 rounded-xl text-sm font-semibold">
                                Detail
                            </a>

                            @if($item->status != 'selesai')
                                <a href="/gangguan/selesai/{{ $item->id }}"
                                   class="bg-green-500 hover:bg-green-600 transition-all duration-300 text-white px-5 py-2 rounded-xl text-sm font-semibold">
                                    Selesai
                                </a>
                            @endif
                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

@else

    <div class="bg-white rounded-3xl shadow p-12 text-center">
        <div class="text-6xl mb-4">🚧</div>

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Data gangguan tidak ada
        </h2>

        <p class="text-gray-500">
            Belum ada informasi gangguan air yang tersimpan di database.
        </p>
    </div>

@endif

@endsection