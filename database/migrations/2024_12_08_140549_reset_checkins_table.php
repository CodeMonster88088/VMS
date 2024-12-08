<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ResetCheckinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop the 'checkins' table if it exists
        Schema::dropIfExists('checkin');

        // Create a new 'checkins' table
        Schema::create('checkins', function (Blueprint $table) {
            $table->id(); // Primary key (auto-incrementing)
            $table->string('photo')->nullable();
            $table->string('id_number')->nullable();
            $table->string('address_arabic')->nullable();
            $table->string('address_english')->nullable();
            $table->string('arabic_full_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('card_country')->nullable();
            $table->date('card_expiry_date')->nullable();
            $table->string('card_serial_number')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality_code')->nullable();
            $table->string('passport_number')->nullable();
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the 'checkins' table
        Schema::dropIfExists('checkins');
    }
}
