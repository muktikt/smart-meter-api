<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';

    protected $fillable = [
        'user_id',
        'meter_id',
        'bulan',
        'tahun',
        'periode',
        'pemakaian',
        'total_tagihan',
        'tarif_per_m3',
        'invoice_number',
        'metode_bayar',
        'tanggal_bayar',
        'status',
        'jatuh_tempo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function meter()
    {
        return $this->belongsTo(MeterReading::class, 'meter_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'tagihan_id');
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class, 'tagihan_id')->latestOfMany();
    }
}