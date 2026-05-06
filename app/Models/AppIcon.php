<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppIcon extends Model
{
    protected $fillable = [
        'device_id',
        'package_name',
        'app_icon_url',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function apps()
    {
        return $this->hasMany(UserApp::class, 'app_icon_id');
    }
}