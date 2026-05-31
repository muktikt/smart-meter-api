<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'no_pelanggan',
        'nama',
        'email',
        'password',
        'role_id',
        'no_hp',
        'alamat',
        'kecamatan',
        'latitude',
        'longitude',
        'status_akun'
    ];

    protected $hidden = [
        'password'
    ];

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function meter()
    {
        return $this->hasMany(MeterReading::class);
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
