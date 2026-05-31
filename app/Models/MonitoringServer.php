<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringServer extends Model
{
    protected $table = 'monitoring_server';

    protected $fillable = [
        'cpu_usage',
        'ram_usage',
        'storage_usage',
        'status',
        'keterangan',
    ];
}