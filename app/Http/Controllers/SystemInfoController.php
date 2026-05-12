<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemInfo;
use App\Models\Contact;
use App\Models\CallLog;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class SystemInfoController extends Controller
{
    public function index()
    {
        $system_info = SystemInfo::all();
        return view('system_info.index', compact('system_info'));
    }
}