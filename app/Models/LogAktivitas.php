<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id',
        'petugas_id',
        'aktivitas',
        'keterangan',
        'ip_address',
        'device',
    ];

    // =========================
    // RELASI USER
    // =========================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // =========================
    // RELASI PETUGAS
    // =========================
    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}