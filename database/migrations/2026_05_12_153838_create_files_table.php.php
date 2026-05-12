<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_type');                    // image | video | audio | pdf | text | file
            $table->bigInteger('size_bytes')->default(0);
            $table->string('folder_path')->nullable();
            $table->string('full_path')->nullable();
            $table->string('mime_type')->nullable();
            $table->boolean('is_downloaded')->default(false);
            $table->timestamp('modified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};