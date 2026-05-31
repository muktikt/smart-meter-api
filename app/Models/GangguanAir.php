<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GangguanAir extends Model
{
    protected $table = 'gangguan_air';

    protected $fillable = [
        'judul',
        'deskripsi',
        'foto',
        'kecamatan',
        'tanggal_mulai',
        'estimasi_selesai',
        'status'
    ];
}