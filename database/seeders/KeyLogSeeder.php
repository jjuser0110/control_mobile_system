<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Device;
use App\Models\KeyLog;
use Carbon\Carbon;

class KeyLogSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Please seed users first.');
            return;
        }

        $keylogSamples = [
            ['app_name' => 'WhatsApp',      'package_name' => 'com.whatsapp',                  'typed_text' => 'mypassword123'],
            ['app_name' => 'Facebook',      'package_name' => 'com.facebook.katana',            'typed_text' => 'john.doe@gmail.com'],
            ['app_name' => 'Instagram',     'package_name' => 'com.instagram.android',          'typed_text' => 'instagram@pass456'],
            ['app_name' => 'TikTok',        'package_name' => 'com.zhiliaoapp.musically',       'typed_text' => 'tiktok_secret!'],
            ['app_name' => 'Telegram',      'package_name' => 'org.telegram.messenger',         'typed_text' => 'telegram2024#'],
            ['app_name' => 'Google Chrome', 'package_name' => 'com.android.chrome',             'typed_text' => 'google@secure99'],
            ['app_name' => 'YouTube',       'package_name' => 'com.google.android.youtube',     'typed_text' => 'youtube_pass!'],
            ['app_name' => 'Gmail',         'package_name' => 'com.google.android.gm',          'typed_text' => 'gmail.secret@2024'],
        ];

        foreach ($users as $user) {

            $device = Device::where('user_id', $user->id)->first();

            if (!$device) {
                $this->command->info("⏭️  No device for: {$user->name} — skipping");
                continue;
            }

            $selectedSamples = collect($keylogSamples)->shuffle()->take(rand(3, 6));

            foreach ($selectedSamples as $sample) {

                // Skip if exact same user + device + package already exists
                $exists = KeyLog::where('user_id', $user->id)
                    ->where('device_id', $device->id)
                    ->where('package_name', $sample['package_name'])
                    ->exists();

                if (!$exists) {
                    KeyLog::create([
                        'user_id'      => $user->id,
                        'device_id'    => $device->id,
                        'app_icon_id'  => null,
                        'app_name'     => $sample['app_name'],
                        'package_name' => $sample['package_name'],
                        'typed_text'   => $sample['typed_text'],
                        'captured_at'  => Carbon::now()->subMinutes(rand(1, 10000)),
                    ]);
                    $this->command->info("   ✅ Added keylog: {$sample['app_name']} for {$user->name}");
                } else {
                    $this->command->info("   ⏭️  Keylog exists: {$sample['app_name']} for {$user->name} — skipping");
                }
            }
        }

        $this->command->info('');
        $this->command->info('🎉 KeyLogSeeder completed!');
    }
}