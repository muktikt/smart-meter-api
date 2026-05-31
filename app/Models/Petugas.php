<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Petugas extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'petugas';

    protected $fillable = [
        'kode_petugas',
        'nama',
        'email',
        'password',
        'no_hp',
        'kecamatan',
        'role',
        'status',
        'device_id',
        'device_name',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // =========================
    // RELASI PENGADUAN
    // =========================
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }

    // =========================
    // RELASI METER
    // =========================
    public function meter()
    {
        return $this->hasMany(MeterReading::class);
    }

    // =========================
    // RELASI LOG AKTIVITAS
    // =========================
    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }
}