<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    private function headers($body = [])
    {
        $apiKey = env('DOMPETX_SECRET_KEY');

        $timestamp = time();

        $jsonBody = !empty($body)
            ? json_encode($body, JSON_UNESCAPED_SLASHES)
            : '';

        $ks = $timestamp . '.' . $jsonBody;

        $signature = hash_hmac('sha256', $ks, $apiKey);

        return [
            'Content-Type' => 'application/json',
            'X-DOMPAY-API-Key' => $apiKey,
            'X-DOMPAY-Signature' => $signature,
            'X-DOMPAY-Timestamp' => $timestamp,
        ];
    }

    public function create(Request $request)
    {
        $request->validate([
            'tagihan_id' => 'required|exists:tagihan,id',
        ]);

        $tagihan = Tagihan::with('user')->findOrFail($request->tagihan_id);

        if ($tagihan->status == 'lunas') {
            return response()->json([
                'status' => false,
                'message' => 'Tagihan sudah lunas'
            ], 400);
        }

        $reference = 'INV-' . $tagihan->id . '-' . time();

        $body = [
            'amount' => (int) $tagihan->total_tagihan,
            'currency' => 'IDR',
            'reference' => $reference,
            'metadata' => [
                'tagihan_id' => $tagihan->id,
                'user_id' => $tagihan->user_id,
                'periode' => $tagihan->periode ?? ($tagihan->bulan . ' ' . $tagihan->tahun),
            ]
        ];

        $response = Http::withHeaders($this->headers($body))
            ->post(env('DOMPETX_BASE_URL') . '/v1/payments/checkout', $body);

        if (!$response->successful()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat checkout DompetX',
                'error' => $response->json()
            ], 500);
        }

        $result = $response->json();

        $payment = Payment::create([
            'tagihan_id' => $tagihan->id,
            'invoice_id' => $result['id'] ?? null,
            'payment_gateway' => 'dompetx',
            'amount' => $tagihan->total_tagihan,
            'metode_pembayaran' => 'checkout',
            'status' => $result['status'] ?? 'pending',
            'payment_url' => $result['payment_url'] ?? null,
        ]);

        $tagihan->update([
            'invoice_number' => $reference,
            'metode_bayar' => 'dompetx'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Checkout berhasil dibuat',
            'data' => [
                'payment' => $payment,
                'payment_url' => $payment->payment_url
            ]
        ], 200, [], JSON_UNESCAPED_SLASHES);
            }

    public function status($id)
    {
        $payment = Payment::where('invoice_id', $id)->first();

        if (!$payment) {
            return response()->json([
                'status' => false,
                'message' => 'Payment tidak ditemukan di database'
            ], 404);
        }

        // Coba cek status
        $response = Http::withHeaders($this->headers())
            ->get(env('DOMPETX_BASE_URL') . '/v1/payments/checkout/check-status/' . $id);

        // Kalau check-status error, pakai detail
        if (!$response->successful()) {
            $response = Http::withHeaders($this->headers())
                ->get(env('DOMPETX_BASE_URL') . '/v1/payments/checkout/detail/' . $id);
        }

        if (!$response->successful()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil status dari DompetX',
                'error' => $response->json(),
                'http_code' => $response->status()
            ], 500);
        }

        $result = $response->json();

        $status = $result['status'] ?? null;

        if ($status === 'paid') {
            $payment->update([
                'status' => 'paid',
                'paid_at' => now()
            ]);

            $payment->tagihan->update([
                'status' => 'lunas',
                'tanggal_bayar' => now(),
                'metode_bayar' => 'dompetx'
            ]);
        }

        if (in_array($status, ['failed', 'expired', 'cancelled'])) {
            $payment->update([
                'status' => 'failed'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Status pembayaran berhasil dicek',
            'data' => [
                'local_payment' => $payment->fresh(),
                'dompetx' => $result
            ]
        ]);
    }

    public function webhook(Request $request)
    {
        $data = $request->data;

        $paymentId = $request->paymentId ?? ($data['id'] ?? null);
        $reference = $data['reference'] ?? null;
        $status = $data['status'] ?? null;

        $payment = Payment::where('invoice_id', $paymentId)
            ->orWhere('invoice_id', $reference)
            ->first();

        if (!$payment) {
            return response()->json([
                'status' => false,
                'message' => 'Payment tidak ditemukan'
            ], 404);
        }

        if ($status == 'paid') {
            $payment->update([
                'status' => 'paid',
                'paid_at' => now()
            ]);

            $payment->tagihan->update([
                'status' => 'lunas',
                'tanggal_bayar' => now(),
                'metode_bayar' => 'dompetx'
            ]);
        } elseif (in_array($status, ['failed', 'expired', 'cancelled'])) {
            $payment->update([
                'status' => 'failed'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Webhook berhasil diproses'
        ]);
    }

    public function cancel($id)
    {
        $response = Http::withHeaders($this->headers())
            ->post(env('DOMPETX_BASE_URL') . '/v1/payments/checkout/cancel/' . $id);

        return response()->json([
            'status' => $response->successful(),
            'data' => $response->json()
        ]);
    }
}