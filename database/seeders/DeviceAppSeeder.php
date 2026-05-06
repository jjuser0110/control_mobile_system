<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Device;
use App\Models\App;
use Carbon\Carbon;

class DeviceAppSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Please seed users first.');
            return;
        }

        $appList = [
            ['app_name' => 'WhatsApp',          'package_name' => 'com.whatsapp',                    'app_type' => 'user'],
            ['app_name' => 'Facebook',           'package_name' => 'com.facebook.katana',             'app_type' => 'user'],
            ['app_name' => 'Instagram',          'package_name' => 'com.instagram.android',           'app_type' => 'user'],
            ['app_name' => 'TikTok',             'package_name' => 'com.zhiliaoapp.musically',        'app_type' => 'user'],
            ['app_name' => 'Telegram',           'package_name' => 'org.telegram.messenger',          'app_type' => 'user'],
            ['app_name' => 'Google Chrome',      'package_name' => 'com.android.chrome',              'app_type' => 'user'],
            ['app_name' => 'YouTube',            'package_name' => 'com.google.android.youtube',      'app_type' => 'user'],
            ['app_name' => 'Gmail',              'package_name' => 'com.google.android.gm',           'app_type' => 'user'],
            ['app_name' => 'Samsung Keyboard',   'package_name' => 'com.samsung.android.honeyboard',  'app_type' => 'system'],
            ['app_name' => 'Samsung Launcher',   'package_name' => 'com.sec.android.app.launcher',    'app_type' => 'system'],
        ];

        $platforms = ['Android', 'iOS'];
        $statuses  = ['Online', 'Offline'];

        foreach ($users as $user) {

            $device = Device::where('user_id', $user->id)->first();

            if (!$device) {
                $device = Device::create([
                    'user_id'     => $user->id,
                    'device_name' => 'Device-' . strtoupper(substr($user->name, 0, 3)) . rand(100, 999),
                    'device_id'   => 'DEV-' . strtoupper(uniqid()),
                    'platform'    => $platforms[array_rand($platforms)],
                    'ip_address'  => '192.168.1.' . rand(10, 250),
                    'status'      => $statuses[array_rand($statuses)],
                    'last_seen'   => Carbon::now()->subMinutes(rand(1, 10000)),
                ]);
                $this->command->info("✅ Created device for: {$user->name}");
            } else {
                $this->command->info("⏭️  Device exists for: {$user->name} — skipping");
            }

            $selectedApps = collect($appList)->shuffle()->take(rand(4, 8));

            foreach ($selectedApps as $app) {

                $exists = App::where('user_id', $user->id)
                             ->where('package_name', $app['package_name'])
                             ->exists();

                if (!$exists) {
                    App::create([
                        'user_id'      => $user->id,
                        'device_id'    => $device->id,
                        'app_icon_id'  => null,
                        'app_name'     => $app['app_name'],
                        'package_name' => $app['package_name'],
                        'app_type'     => $app['app_type'],
                        'is_active'    => (bool) rand(0, 1),
                        'installed_at' => Carbon::now()->subDays(rand(1, 365)),
                        'last_seen_at' => Carbon::now()->subMinutes(rand(1, 5000)),
                    ]);
                    $this->command->info("   ✅ Added app: {$app['app_name']} for {$user->name}");
                } else {
                    $this->command->info("   ⏭️  App exists: {$app['app_name']} for {$user->name} — skipping");
                }
            }
        }

        $this->command->info('');
        $this->command->info('🎉 DeviceAppSeeder completed!');
    }
}