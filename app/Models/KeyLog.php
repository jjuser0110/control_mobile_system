<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeyLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'keylogs';
    
    protected $fillable = [
        'user_id',
        'device_id',
        'app_icon_id',
        'app_name',
        'package_name',
        'typed_text',
        'captured_at',
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
        return $this->belongsTo(AppIcon::class);
    }
}