<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('action'); // E.g., "Login", "Logout", "View", etc.
            $table->string('module')->nullable(); // E.g., "Users", "Orders", etc.
            $table->text('details')->nullable(); // Additional details about the action
            $table->ipAddress('ip_address')->nullable(); // User's IP address
            $table->timestamp('created_at')->useCurrent(); // Timestamp of the activity
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
