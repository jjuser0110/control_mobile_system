<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->string('os_name')->nullable();          // Android 14 | iOS 17.4
            $table->string('os_version')->nullable();
            $table->string('model_number')->nullable();     // SM-S911B
            $table->string('brand')->nullable();            // Samsung | Apple | Xiaomi
            $table->string('imei')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('cpu_model')->nullable();        // Snapdragon 8 Gen 2
            $table->tinyInteger('cpu_usage')->default(0);  // 0–100
            $table->float('ram_used_gb')->default(0);
            $table->float('ram_total_gb')->default(0);
            $table->float('storage_used_gb')->default(0);
            $table->float('storage_total_gb')->default(0);
            $table->unsignedBigInteger('uptime_seconds')->default(0);
            $table->string('status')->default('Offline');  // Online | Offline
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_infos');
    }
};