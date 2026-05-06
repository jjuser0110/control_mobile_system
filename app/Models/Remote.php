<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Remote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'host_user_id',
        'client_user_id',
        'session_code',
        'host_device',
        'client_device',
        'duration',
        'status',
        'started_at',
        'ended_at',
    ];
}
