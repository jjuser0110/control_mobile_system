```php id="3q3ye1"
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('device_name')->nullable();
            $table->string('device_id')->nullable();
            $table->string('platform')->nullable();
            $table->string('ip_address')->nullable();
            $table->enum('status', ['Online', 'Offline'])->default('Offline');
            $table->timestamp('last_seen')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};