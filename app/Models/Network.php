<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'connection_type',  // WiFi | 4G LTE | 5G | 3G
        'ssid',
        'ip_address',
        'mac_address',
        'signal_strength',  // 0–100
        'data_up_bytes',
        'data_down_bytes',
        'status',           // Connected | Disconnected | Weak Signal
        'recorded_at',
    ];
}