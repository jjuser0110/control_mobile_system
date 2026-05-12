<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'latitude',
        'longitude',
        'address',
        'accuracy_meters',
        'altitude',
        'speed',
        'recorded_at',
    ];
}