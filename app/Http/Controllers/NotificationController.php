<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Contact;
use App\Models\CallLog;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class NotificationController extends Controller
{
    public function index()
    {
        $notification = Notification::all();
        return view('notification.index', compact('notification'));
    }
}