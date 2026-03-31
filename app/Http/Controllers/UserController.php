<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\CallLog;
use App\Models\UserImage;
use Bouncer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Exports\UsersExport;
use App\Exports\UserContactsExport;
use App\Exports\UserCallLogsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all(); // or paginate

        return view('user.index', compact('user'));
    }

    public function pending(Request $request)
    {
        $user = User::where('role_id',3)->where('user_status','pending verified')->get();
        // dd($user);
        return view('user.index')->with('user',$user);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        
        $request->merge(['password' => Hash::make($request->password),'role_id'=>3]);
        $user = User::create($request->all());

        return redirect()->route('user.index')->withSuccess('Data saved');
    }

    public function edit(User $user)
    {
        return view('user.create')->with('user',$user);
    }

    public function update(Request $request, User $user)
    {
        if($request->password !=null){
            $request->merge(['password' => Hash::make($request->password)]);
        }else{
            $request->request->remove('password');
        }
        
        $data = $request->except(['front_ic', 'back_ic', 'bill_tnb', 'bill_air', 'slip_gaji']);

        $folderPath = 'uploads/' . $user->id;

        // File fields to check
        $fileFields = ['front_ic', 'back_ic', 'bill_tnb', 'bill_air', 'slip_gaji'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store($folderPath, 'public');
            }
        }

        $user->update($data);

        return redirect()->route('user.index')->withSuccess('Data updated');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->withSuccess('Data deleted');
    }

    public function view($id)
    {
        $user = User::with(['contacts', 'callLogs'])->findOrFail($id);

        return view('user.view', compact('user'));
    }

    public function verify(User $user)
    {
        $user->update(['user_status'=>'verified']);

        return redirect()->back()->withSuccess('user verified');
    }

    public function unverify(User $user)
    {
        $user->update(['user_status'=>'unverified']);

        return redirect()->back()->withSuccess('user not verified');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    // public function exportContacts(User $user)
    // {
    //     return Excel::download(
    //         new UserContactsExport($user->id), 
    //         'user_' . $user->id . '_contacts_' . date('Y-m-d_H-i-s') . '.xlsx'
    //     );
    // }

    // public function exportCallLogs(User $user)
    // {
    //     return Excel::download(
    //         new UserCallLogsExport($user->id), 
    //         'user_' . $user->id . '_call_logs_' . date('Y-m-d_H-i-s') . '.xlsx'
    //     );
    // }

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
                return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
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

    if ($request->filled('contacts')) {
        foreach ($request->contacts as $contact) {

            $name = trim(
                $contact['name'] ??
                $contact['displayName'] ??
                $contact['givenName'] ??
                $contact['familyName'] ??
                ''
            );

            Contact::create([
                'user_id' => $userId,
                'name' => $contact['name'] ?? null,
                'phoneNumbers' => $contact['phoneNumbers'] ?? null,
            ]);
        }
    }

    /* =========================
       CALL LOGS
    ========================== */
    if ($request->filled('call_logs')) {
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
}
