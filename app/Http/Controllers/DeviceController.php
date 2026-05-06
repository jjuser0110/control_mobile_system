<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Device;
use App\Models\Contact;
use App\Models\CallLog;
use App\Models\App;
use App\Models\AppIcon;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        return view('device.index', compact('devices'));
    }

    public function app($id)
    {
        $device = Device::findOrFail($id);

        $apps = App::with(['appIcon'])
            ->where('device_id', $id)
            ->orderBy('last_seen_at', 'desc')
            ->get();

        return view('user.app', compact('device', 'apps'));
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('device.index')->withSuccess('Data deleted');
    }
}