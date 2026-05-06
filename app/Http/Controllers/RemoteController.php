<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Remote;
use App\Models\Contact;
use App\Models\CallLog;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class RemoteController extends Controller
{
    public function index()
    {
        $remote = Remote::all();
        return view('remote.index', compact('remote'));
    }
}