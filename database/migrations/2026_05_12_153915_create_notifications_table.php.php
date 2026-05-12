<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->string('app_name');
            $table->string('app_package')->nullable();      // com.whatsapp | com.instagram.android
            $table->string('app_icon')->nullable();         // fa-whatsapp (FontAwesome class)
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->string('priority')->default('Normal'); // High | Normal | Low
            $table->timestamp('received_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};