<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeterReading extends Model
{
    protected $table = 'meter_reading';

    protected $fillable = [
        'user_id',
        'petugas_id',
        'bulan',
        'tahun',
        'meter_lama',
        'meter_baru',
        'pemakaian',
        'foto_meter',
        'hasil_ocr',
        'status',
        'status_anomali',
        'catatan_anomali',
        'ocr_persen',
        'ocr_status',
        'validasi_petugas',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'petugas_id');
    }
}