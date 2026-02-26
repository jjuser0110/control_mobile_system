<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\SendOtp;
use Bouncer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserOtpController extends Controller
{
    public function index(Request $request)
    {
        $user_otp = SendOtp::all();
        return view('user_otp.index')->with('user_otp',$user_otp);
    }

}
