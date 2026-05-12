<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'app_name',
        'app_package',  // com.whatsapp | com.instagram.android
        'app_icon',     // fa-whatsapp (FontAwesome class)
        'title',
        'body',
        'priority',     // High | Normal | Low
        'received_at',
    ];
}