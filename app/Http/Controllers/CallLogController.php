<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CallLog;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class CallLogController extends Controller
{
    public function index()
    {
        $call_log = CallLog::all();
        return view('call_log.index', compact('call_log'));
    }

    public function destroy(CallLog $call_log)
    {
        $call_log->delete();
        return redirect()->route('call_log.index')->withSuccess('Data deleted');
    }

    public function view($id)
    {
        $call_log = CallLog::with(['call_logs', 'callLogs', 'images'])->findOrFail($id);
        return view('call_log.view', compact('call_log'));
    }
}