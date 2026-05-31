<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringKecamatan extends Model
{
    protected $table = 'monitoring_kecamatan';

    protected $fillable = [
        'kecamatan',
        'total_pelanggan',
        'meter_hari_ini',
        'pengaduan_aktif',
        'gangguan_aktif',
        'anomali',
        'persentase_aktif',
        'status',
    ];
}