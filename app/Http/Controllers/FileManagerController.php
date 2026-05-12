<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Contact;
use App\Models\CallLog;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FileManagerController extends Controller
{
    public function index()
    {
        $file = File::all();
        return view('file.index', compact('file'));
    }
}