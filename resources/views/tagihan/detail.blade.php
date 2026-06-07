@extends('layouts.app')

@section('content')

<!-- PRINT HEADER -->
<div class="print-header">

    <h1 style="font-size:32px; font-weight:bold;">
        PDAM Tirta Dharma Ayu
    </h1>

    <p>
        Smart Water Meter System
    </p>

    <hr style="margin-top:20px;">

</div>

<!-- HEADER -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8 no-print">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Detail Tagihan
        </h1>

        <p class="text-gray-500 mt-2">
            Informasi detail tagihan dan pemakaian air pelanggan
        </p>
    </div>

    <div class="flex gap-3">

        <a href="/tagihan"
           class="bg-gray-200 hover:bg-gray-300 transition-all duration-300 text-gray-700 px-6 py-3 rounded-2xl font-semibold">
            ← Kembali
        </a>

        <button onclick="window.print()"
                class="bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
            🖨 Cetak Tagihan
        </button>

        @if($tagihan->status != 'lunas' && $tagihan->user && $tagihan->user->no_hp)

            <button id="btnReminder"
                    onclick="sendReminder({{ $tagihan->id }})"
                    class="bg-green-500 hover:bg-green-600 transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
                📩 Kirim Reminder
            </button>

        @endif

    </div>

</div>

<!-- PROFILE -->
<div class="bg-white rounded-3xl shadow p-8 mb-8">

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">

        <div>
            <p class="text-sm text-gray-400 mb-2">Nama Pelanggan</p>
            <h2 class="text-2xl font-bold text-gray-800">
                {{ $tagihan->user->nama ?? '-' }}
            </h2>
        </div>

        <div>
            <p class="text-sm text-gray-400 mb-2">Nomor Pelanggan</p>
            <h2 class="text-2xl font-bold text-[#2191d1]">
                {{ $tagihan->user->no_pelanggan ?? '-' }}
            </h2>
        </div>

        <div>
            <p class="text-sm text-gray-400 mb-2">Kecamatan</p>
            <h3 class="font-semibold text-gray-700">
                {{ $tagihan->user->kecamatan ?? '-' }}
            </h3>
        </div>

        <div>
            <p class="text-sm text-gray-400 mb-2">Status</p>

            @if($tagihan->status == 'lunas')
                <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                    Lunas
                </span>
            @else
                <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-sm font-semibold">
                    Belum Lunas
                </span>
            @endif
        </div>

    </div>

</div>

<!-- STATISTIK -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-3xl shadow p-6">
        <p class="text-gray-400 text-sm">Jatuh Tempo</p>
        <h2 class="text-2xl font-bold text-gray-800 mt-2">
            @if($tagihan->jatuh_tempo)
                {{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d M Y') }}
            @else
                -
            @endif
        </h2>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <p class="text-gray-400 text-sm">Total Pemakaian</p>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ $tagihan->pemakaian ?? 0 }} m³
        </h2>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <p class="text-gray-400 text-sm">Tarif Per m³</p>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            Rp {{ number_format($tagihan->tarif_per_m3 ?? 0, 0, ',', '.') }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <p class="text-gray-400 text-sm">Jatuh Tempo</p>
        <h2 class="text-2xl font-bold text-gray-800 mt-2">
            {{ $tagihan->jatuh_tempo ?? '-' }}
        </h2>
    </div>

</div>

<!-- GRID -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

    <!-- LEFT -->
    <div class="xl:col-span-2 space-y-8">

        <!-- RINCIAN -->
        <div class="bg-white rounded-3xl shadow overflow-hidden">

            <div class="p-6 border-b border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800">
                    Rincian Tagihan
                </h2>
            </div>

            <div class="p-6">

                <div class="space-y-5">

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">
                            Pemakaian Air ({{ $tagihan->pemakaian ?? 0 }} m³)
                        </span>

                        <span class="font-semibold text-gray-800">
                            Rp {{ number_format(($tagihan->pemakaian ?? 0) * ($tagihan->tarif_per_m3 ?? 0), 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">
                            Tarif Per m³
                        </span>

                        <span class="font-semibold text-gray-800">
                            Rp {{ number_format($tagihan->tarif_per_m3 ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="border-t pt-5 flex items-center justify-between">
                        <span class="text-xl font-bold text-gray-800">
                            Total Pembayaran
                        </span>

                        <span class="text-2xl font-bold text-[#2191d1]">
                            Rp {{ number_format($tagihan->total_tagihan ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                </div>

            </div>

        </div>

        <!-- HISTORI -->
        <div class="bg-white rounded-3xl shadow overflow-hidden">

            <div class="p-6 border-b border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800">
                    Histori Tagihan
                </h2>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-[#2191d1] text-white">

                        <tr>
                            <th class="px-6 py-4 text-left">Bulan</th>
                            <th class="px-6 py-4 text-left">Pemakaian</th>
                            <th class="px-6 py-4 text-left">Tagihan</th>
                            <th class="px-6 py-4 text-left">Status</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($histori ?? [] as $item)

                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-5">
                                    {{ $item->bulan ?? '-' }} {{ $item->tahun ?? '' }}
                                </td>

                                <td class="px-6 py-5">
                                    {{ $item->pemakaian ?? 0 }} m³
                                </td>

                                <td class="px-6 py-5">
                                    Rp {{ number_format($item->total_tagihan ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-5">
                                    @if($item->status == 'lunas')
                                        <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                                            Lunas
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-sm font-semibold">
                                            Belum Lunas
                                        </span>
                                    @endif
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center py-8 text-gray-400">
                                    Belum ada histori tagihan
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- RIGHT -->
    <div class="space-y-8">

        <!-- DATA METER -->
        <div class="bg-white rounded-3xl shadow p-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Data Meter
            </h2>

            <div class="space-y-5">

                <div>
                    <p class="text-sm text-gray-400 mb-1">Meter Sebelumnya</p>
                    <h3 class="font-semibold text-gray-700">
                        {{ $tagihan->meter->meter_lama ?? '-' }}
                    </h3>
                </div>

                <div>
                    <p class="text-sm text-gray-400 mb-1">Meter Sekarang</p>
                    <h3 class="font-semibold text-gray-700">
                        {{ $tagihan->meter->meter_baru ?? '-' }}
                    </h3>
                </div>

                <div>
                    <p class="text-sm text-gray-400 mb-1">OCR Accuracy</p>
                    <h3 class="font-semibold text-green-600">
                        {{ $tagihan->meter->ocr_persen ?? 0 }}%
                    </h3>
                </div>

            </div>

        </div>

        <!-- STATUS PEMBAYARAN -->
        <div class="bg-white rounded-3xl shadow p-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Status Pembayaran
            </h2>

            @php
                $payment = $tagihan->latestPayment;
            @endphp

            @if($tagihan->status == 'lunas')
                <div class="bg-green-100 text-green-700 p-5 rounded-2xl mb-5">
                    <h3 class="font-bold mb-2">✔ Sudah Dibayar</h3>
                    <p class="text-sm">Tagihan sudah lunas.</p>
                </div>
            @else
                <div class="bg-red-100 text-red-700 p-5 rounded-2xl mb-5">
                    <h3 class="font-bold mb-2">⚠ Belum Dibayar</h3>
                    <p class="text-sm">Tagihan belum dibayarkan oleh pelanggan.</p>
                </div>
            @endif

            <div class="space-y-4">

                <div>
                    <p class="text-sm text-gray-400 mb-1">Metode Pembayaran</p>
                    <h3 class="font-semibold text-gray-700">
                        {{ $tagihan->metode_bayar ?? $payment->metode_pembayaran ?? '-' }}
                    </h3>
                </div>

                <div>
                    <p class="text-sm text-gray-400 mb-1">Invoice Payment</p>
                    <h3 class="font-semibold text-gray-700 break-all">
                        {{ $payment->invoice_id ?? $tagihan->invoice_number ?? '-' }}
                    </h3>
                </div>

                <div>
                    <p class="text-sm text-gray-400 mb-1">Status Payment Gateway</p>

                    @if($payment && $payment->status == 'paid')
                        <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">
                            Paid
                        </span>
                    @elseif($payment && $payment->status == 'pending')
                        <span class="bg-yellow-100 text-yellow-600 px-4 py-2 rounded-full text-sm font-semibold">
                            Pending
                        </span>
                    @elseif($payment)
                        <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-sm font-semibold">
                            {{ ucfirst($payment->status) }}
                        </span>
                    @else
                        <span class="bg-gray-100 text-gray-600 px-4 py-2 rounded-full text-sm font-semibold">
                            Belum Ada Payment
                        </span>
                    @endif
                </div>

                <div>
                    <p class="text-sm text-gray-400 mb-1">Tanggal Bayar</p>
                    <h3 class="font-semibold text-gray-700">
                        @if($tagihan->tanggal_bayar)
                            {{ \Carbon\Carbon::parse($tagihan->tanggal_bayar)->format('d M Y H:i') }}
                        @elseif($payment && $payment->paid_at)
                            {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y H:i') }}
                        @else
                            -
                        @endif
                    </h3>
                </div>

                @if($payment && $payment->payment_url && $payment->status == 'pending')
                    <a href="{{ $payment->payment_url }}"
                    target="_blank"
                    class="block text-center bg-[#2191d1] hover:bg-[#1977ad] text-white px-6 py-3 rounded-2xl font-semibold shadow-lg mt-4">
                        Buka Link Pembayaran
                    </a>
                @endif

            </div>

        </div>

    </div>

</div>

<style>
    @media print {
        .no-print,
        aside,
        header,
        nav {
            display: none !important;
        }

        body {
            background: white !important;
        }

        main {
            margin: 0 !important;
            padding: 0 !important;
        }

        .shadow {
            box-shadow: none !important;
        }
    }
</style>

<style>

    @media print {

        body {
            background: white !important;
        }

        aside,
        nav,
        .no-print {
            display: none !important;
        }

        main {
            padding: 0 !important;
            margin: 0 !important;
        }

        .shadow,
        .shadow-lg,
        .shadow-xl,
        .rounded-3xl {
            box-shadow: none !important;
        }

        .grid {
            display: block !important;
        }

        .bg-white {
            background: white !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #d1d5db;
            padding: 10px;
        }

        h1, h2, h3 {
            color: black !important;
        }

        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 30px;
        }

    }

    .print-header {
        display: none;
    }

</style>

@endsection

@section('scripts')
<script>
    function sendReminder(tagihanId) {
        const btn = document.getElementById('btnReminder');
        const originalText = btn.innerHTML;
        btn.innerHTML = '⏳ Mengirim...';
        btn.disabled = true;

        fetch('/tagihan/reminder/' + tagihanId, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === true) {
                // Buka WhatsApp di tab baru
                if (data.wa_url) {
                    window.open(data.wa_url, '_blank');
                }

                showToast('✅ ' + data.message, 'success');
            } else {
                showToast('❌ ' + (data.message || 'Gagal mengirim reminder'), 'error');
            }
        })
        .catch(err => {
            console.error(err);
            showToast('❌ Terjadi kesalahan koneksi', 'error');
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }

    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `fixed top-6 right-6 z-50 px-6 py-4 rounded-2xl shadow-2xl text-white font-semibold transition-all duration-500 transform translate-x-full`;
        toast.style.minWidth = '320px';

        if (type === 'success') {
            toast.classList.add('bg-green-500');
        } else {
            toast.classList.add('bg-red-500');
        }

        toast.textContent = message;
        document.body.appendChild(toast);

        // Animate in
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-full');
            toast.classList.add('translate-x-0');
        });

        // Auto dismiss after 4s
        setTimeout(() => {
            toast.classList.remove('translate-x-0');
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 500);
        }, 4000);
    }
</script>
@endsection