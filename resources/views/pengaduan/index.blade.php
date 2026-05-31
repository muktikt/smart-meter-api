@extends('layouts.app')

@section('content')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Monitoring Pengaduan</h1>
        <p class="text-gray-500 mt-2">Monitoring pengaduan pelanggan PDAM secara realtime</p>
    </div>

    <div class="flex gap-3">
        <a href="/pengaduan" class="bg-[#2191d1] hover:bg-[#1977ad] text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
            Refresh Data
        </a>

        <a href="/pengaduan/export-excel" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
            Export Excel
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white rounded-3xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">📢</div>
            <span class="text-[#2191d1] text-sm font-semibold">Total</span>
        </div>
        <p class="text-gray-400 text-sm">Total Pengaduan</p>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalPengaduan ?? 0 }}</h2>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl">⏳</div>
            <span class="text-yellow-500 text-sm font-semibold">Proses</span>
        </div>
        <p class="text-gray-400 text-sm">Sedang Diproses</p>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $proses ?? 0 }}</h2>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">✔</div>
            <span class="text-green-500 text-sm font-semibold">Selesai</span>
        </div>
        <p class="text-gray-400 text-sm">Pengaduan Selesai</p>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $selesai ?? 0 }}</h2>
    </div>

</div>

<div class="bg-white rounded-3xl shadow p-6 mb-8">
    <form action="/pengaduan" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengaduan..."
                   class="border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20">

            <select name="kecamatan" class="border border-gray-300 rounded-2xl px-4 py-3">
                <option value="">Semua Kecamatan</option>
                <option value="Indramayu" {{ request('kecamatan') == 'Indramayu' ? 'selected' : '' }}>Indramayu</option>
                <option value="Jatibarang" {{ request('kecamatan') == 'Jatibarang' ? 'selected' : '' }}>Jatibarang</option>
                <option value="Losarang" {{ request('kecamatan') == 'Losarang' ? 'selected' : '' }}>Losarang</option>
                <option value="Arahan" {{ request('kecamatan') == 'Arahan' ? 'selected' : '' }}>Arahan</option>
                <option value="Karangampel" {{ request('kecamatan') == 'Karangampel' ? 'selected' : '' }}>Karangampel</option>
            </select>

            <select name="status" class="border border-gray-300 rounded-2xl px-4 py-3">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>

            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                   class="border border-gray-300 rounded-2xl px-4 py-3">

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-[#2191d1] hover:bg-[#1977ad] text-white rounded-2xl font-semibold px-4 py-3">
                    Filter
                </button>

                <a href="/pengaduan" class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-2xl font-semibold px-4 py-3">
                    Reset
                </a>
            </div>

        </div>
    </form>
</div>

<div class="bg-white rounded-3xl shadow overflow-hidden">

    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Data Pengaduan Pelanggan</h2>

        <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-sm font-semibold">
            {{ $pengaduan->where('status', '!=', 'selesai')->count() }} Belum Selesai
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#2191d1] text-white">
                <tr>
                    <th class="px-6 py-4 text-left">Pelanggan</th>
                    <th class="px-6 py-4 text-left">Kecamatan</th>
                    <th class="px-6 py-4 text-left">Kategori</th>
                    <th class="px-6 py-4 text-left">Tanggal</th>
                    <th class="px-6 py-4 text-left">Petugas</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($pengaduan as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-5">
                            <h3 class="font-semibold text-gray-800">{{ $item->user->nama ?? '-' }}</h3>
                            <p class="text-sm text-gray-400">{{ $item->user->no_pelanggan ?? '-' }}</p>
                        </td>

                        <td class="px-6 py-5">{{ $item->user->kecamatan ?? '-' }}</td>

                        <td class="px-6 py-5">
                            <span class="bg-blue-100 text-[#2191d1] px-4 py-2 rounded-full text-sm font-semibold">
                                {{ $item->kategori ?? '-' }}
                            </span>
                        </td>

                        <td class="px-6 py-5">
                            {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y') : '-' }}
                        </td>

                        <td class="px-6 py-5">
                            {{ $item->petugas->kode_petugas ?? '-' }}
                        </td>

                        <td class="px-6 py-5">
                            @if($item->status == 'selesai')
                                <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">Selesai</span>
                            @elseif($item->status == 'proses')
                                <span class="bg-yellow-100 text-yellow-600 px-4 py-2 rounded-full text-sm font-semibold">Proses</span>
                            @else
                                <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-sm font-semibold">Pending</span>
                            @endif
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex gap-2">
                                <a href="/pengaduan/detail/{{ $item->id }}"
                                   class="bg-[#2191d1] hover:bg-[#1977ad] text-white px-4 py-2 rounded-xl text-sm font-semibold">
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-gray-400">
                            Data pengaduan tidak ada
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection