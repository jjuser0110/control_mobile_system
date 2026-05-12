<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Contact;
use App\Models\CallLog;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class LocationController extends Controller
{
    public function index()
    {
        $location = Location::all();
        return view('location.index', compact('location'));
    }
}