<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'tagihan_id',
        'invoice_id',
        'payment_gateway',
        'amount',
        'metode_pembayaran',
        'status',
        'payment_url',
        'paid_at',
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id');
    }
}