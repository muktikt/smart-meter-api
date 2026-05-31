@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Dashboard Admin
        </h1>

        <p class="text-gray-500 mt-2">
            Monitoring Smart Water Meter PDAM realtime
        </p>

    </div>

    <div class="bg-white px-5 py-3 rounded-2xl shadow flex items-center gap-4">

        <div class="w-12 h-12 rounded-2xl bg-[#2191d1] text-white flex items-center justify-center font-bold text-xl">
            A
        </div>

        <div>

            <h3 class="font-bold text-gray-700">
                Admin PDAM
            </h3>

            <p class="text-sm text-gray-400">
                Administrator
            </p>

        </div>

    </div>

</div>

<!-- CARD -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <!-- TOTAL PELANGGAN -->
    <div class="bg-white rounded-3xl p-6 shadow card-hover">

        <div class="flex items-center justify-between mb-5">

            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                👥
            </div>

            <span class="text-green-500 text-sm font-semibold">
                LIVE
            </span>

        </div>

        <p class="text-gray-500 text-sm">
            Total Pelanggan
        </p>

        <h1 class="text-3xl font-bold text-gray-800 mt-3">
            {{ number_format($totalPelanggan) }}
        </h1>

    </div>

    <!-- TOTAL TAGIHAN -->
    <div class="bg-white rounded-3xl p-6 shadow card-hover">

        <div class="flex items-center justify-between mb-5">

            <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                💳
            </div>

            <span class="text-green-500 text-sm font-semibold">
                LIVE
            </span>

        </div>

        <p class="text-gray-500 text-sm">
            Total Tagihan
        </p>

        <h1 class="text-3xl font-bold text-gray-800 mt-3">
            Rp {{ number_format($totalTagihan) }}
        </h1>

    </div>

    <!-- PENGADUAN -->
    <div class="bg-white rounded-3xl p-6 shadow card-hover">

        <div class="flex items-center justify-between mb-5">

            <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl">
                📢
            </div>

            <span class="text-yellow-500 text-sm font-semibold">
                {{ $pengaduanProses }}
            </span>

        </div>

        <p class="text-gray-500 text-sm">
            Pengaduan Proses
        </p>

        <h1 class="text-3xl font-bold text-gray-800 mt-3">
            {{ number_format($totalPengaduan) }}
        </h1>

    </div>

    <!-- ANOMALI -->
    <div class="bg-white rounded-3xl p-6 shadow card-hover">

        <div class="flex items-center justify-between mb-5">

            <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-2xl">
                ⚠️
            </div>

            <span class="text-red-500 text-sm font-semibold">
                ALERT
            </span>

        </div>

        <p class="text-gray-500 text-sm">
            Gangguan Aktif
        </p>

        <h1 class="text-3xl font-bold text-gray-800 mt-3">
            {{ number_format($gangguanAktif) }}
        </h1>

    </div>

</div>

<!-- GRID -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    <!-- CHART -->
    <div class="xl:col-span-2 bg-white rounded-3xl p-6 shadow">

        <div class="flex items-center justify-between mb-6">

            <div>

                <h3 class="text-xl font-bold text-gray-800">
                    Statistik Pemakaian Air
                </h3>

                <p class="text-gray-400 text-sm mt-1">
                    Monitoring penggunaan air bulanan
                </p>

            </div>

            <button class="bg-[#2191d1] text-white px-4 py-2 rounded-xl text-sm">
                Realtime
            </button>

        </div>

        <canvas id="chartPemakaian" height="120"></canvas>

    </div>

    <!-- GANGGUAN -->
    <div class="bg-white rounded-3xl p-6 shadow">

        <div class="flex items-center justify-between mb-6">

            <h3 class="text-xl font-bold text-gray-800">
                Gangguan Aktif
            </h3>

            <span class="bg-red-100 text-red-500 px-3 py-1 rounded-full text-sm">
                {{ $gangguanAktif }} Aktif
            </span>

        </div>

        <div class="space-y-5">

            @forelse($pengaduanTerbaru as $item)

                <div class="border border-gray-100 rounded-2xl p-4">

                    <div class="flex items-start justify-between mb-3">

                        <h4 class="font-bold text-gray-700">
                            {{ $item->kategori }}
                        </h4>

                        <span class="bg-yellow-100 text-yellow-600 text-xs px-3 py-1 rounded-full">
                            {{ $item->status }}
                        </span>

                    </div>

                    <p class="text-sm text-gray-500">
                        {{ $item->deskripsi }}
                    </p>

                </div>

            @empty

                <div class="text-center py-10 text-gray-400">

                    Belum ada pengaduan

                </div>

            @endforelse

        </div>

    </div>

</div>

<!-- TABLE -->
<div class="bg-white rounded-3xl shadow mt-8 p-6">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h3 class="text-xl font-bold text-gray-800">
                Tagihan Terbaru
            </h3>

            <p class="text-sm text-gray-400 mt-1">
                Monitoring tagihan pelanggan terbaru
            </p>

        </div>

    </div>

    <div class="overflow-x-auto">

        <table class="datatable w-full">

            <thead>

                <tr class="text-left text-gray-500 border-b">

                    <th class="pb-4">User ID</th>
                    <th class="pb-4">Bulan</th>
                    <th class="pb-4">Pemakaian</th>
                    <th class="pb-4">Tagihan</th>
                    <th class="pb-4">Status</th>

                </tr>

            </thead>

            <tbody>

                @foreach($tagihanTerbaru as $item)

                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="py-4">
                        {{ $item->user_id }}
                    </td>

                    <td class="py-4">
                        {{ $item->bulan }} {{ $item->tahun }}
                    </td>

                    <td class="py-4">
                        {{ $item->pemakaian }} m3
                    </td>

                    <td class="py-4 font-semibold text-[#2191d1]">
                        Rp {{ number_format($item->total_tagihan) }}
                    </td>

                    <td class="py-4">

                        @if($item->status == 'lunas')

                            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs">
                                Lunas
                            </span>

                        @else

                            <span class="bg-red-100 text-red-500 px-3 py-1 rounded-full text-xs">
                                Belum Bayar
                            </span>

                        @endif

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection

@push('scripts')

<script>

const ctx = document.getElementById('chartPemakaian');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],

        datasets: [{

            label: 'Pemakaian Air',

            data: [120, 190, 300, 500, 200, 300],

            borderColor: '#2191d1',

            backgroundColor: 'rgba(33,145,209,0.1)',

            tension: 0.4,

            fill: true

        }]

    },

});

</script>

@endpush