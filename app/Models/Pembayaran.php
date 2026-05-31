<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'tagihan_id',
        'metode_pembayaran',
        'jumlah_bayar',
        'status',
        'bukti_pembayaran',
        'tanggal_pembayaran'
    ];

    // =========================
    // RELASI KE TAGIHAN
    // =========================
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id');
    }

    // =========================
    // RELASI KE USER
    // =========================
    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Tagihan::class,
            'id',
            'id',
            'tagihan_id',
            'user_id'
        );
    }
}