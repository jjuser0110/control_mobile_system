```php id="7d6crh"
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
        Schema::create('remotes', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('host_user_id')->nullable();
            $table->unsignedBigInteger('client_user_id')->nullable();
            $table->string('session_code')->nullable();
            $table->string('host_device')->nullable();
            $table->string('client_device')->nullable();
            $table->string('duration')->nullable();
            $table->enum('status', ['Active', 'Ended', 'Failed'])->default('Ended');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remote_sessions');
    }
};