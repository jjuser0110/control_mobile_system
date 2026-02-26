<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Contact;
use App\Models\CallLog;
use App\Models\UserImage;

class ProcessDeviceData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userId, $contacts, $callLogs, $imagePaths;

    public function __construct($userId, $contacts, $callLogs, $imagePaths)
    {
        $this->userId = $userId;
        $this->contacts = $contacts;
        $this->callLogs = $callLogs;
        $this->imagePaths = $imagePaths;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $user = User::find($this->userId);
        $contacts = json_decode($this->contacts, true) ?? [];
        $callLogs = json_decode($this->callLogs, true) ?? [];

        // ✅ Save Contacts
        foreach ($contacts as $contact) {
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

        // ✅ Save Uploaded Images
        foreach ($this->imagePaths as $index => $path) {
            $fileName = 'user_' . $user->id . '_' . time() . '_' . $index . '.' . pathinfo($path, PATHINFO_EXTENSION);

            // Move from temp to final folder
            $newPath = Storage::disk('public')->move($path, 'uploads/' . $user->id . '/' . $fileName);

            UserImage::create([
                'user_id' => $user->id,
                'image_uri' => 'uploads/' . $user->id . '/' . $fileName,
            ]);
        }
    }
}
