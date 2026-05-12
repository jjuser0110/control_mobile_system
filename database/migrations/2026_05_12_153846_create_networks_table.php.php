<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->string('connection_type');              // WiFi | 4G LTE | 5G | 3G
            $table->string('ssid')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            $table->tinyInteger('signal_strength')->default(0); // 0–100
            $table->bigInteger('data_up_bytes')->default(0);
            $table->bigInteger('data_down_bytes')->default(0);
            $table->string('status')->default('Connected'); // Connected | Disconnected | Weak Signal
            $table->timestamp('recorded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('networks');
    }
};