<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'os_name',          // Android 14 | iOS 17.4
        'os_version',
        'model_number',     // SM-S911B
        'brand',            // Samsung | Apple | Xiaomi
        'imei',
        'serial_number',
        'cpu_model',        // Snapdragon 8 Gen 2
        'cpu_usage',        // 0–100
        'ram_used_gb',
        'ram_total_gb',
        'storage_used_gb',
        'storage_total_gb',
        'uptime_seconds',
        'status',           // Online | Offline
        'last_seen_at',
    ];
}