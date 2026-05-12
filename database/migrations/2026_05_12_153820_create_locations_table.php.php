<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->decimal('latitude',  10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('address')->nullable();
            $table->float('accuracy_meters')->nullable();
            $table->float('altitude')->nullable();
            $table->float('speed')->nullable();
            $table->timestamp('recorded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};