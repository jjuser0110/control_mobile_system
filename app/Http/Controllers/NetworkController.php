<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Network;
use App\Models\Contact;
use App\Models\CallLog;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class NetworkController extends Controller
{
    public function index()
    {
        $network = Network::all();
        return view('network.index', compact('network'));
    }
}