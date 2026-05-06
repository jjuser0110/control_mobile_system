<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class App extends Model
{
    protected $fillable = [
        'user_id',
        'device_id',
        'app_icon_id',
        'app_name',
        'package_name',
        'app_type',
        'is_active',
        'installed_at',
        'last_seen_at',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'installed_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function appIcon()
    {
        return $this->belongsTo(AppIcon::class, 'app_icon_id');
    }
}