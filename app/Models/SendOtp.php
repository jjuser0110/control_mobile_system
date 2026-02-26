<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SendOtp extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'contact_no',
        'otp_receive',
    ];
}
