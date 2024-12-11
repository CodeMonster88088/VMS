<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('id_number'); // Unique identifier for the visitor
            $table->text('photo')->nullable(); // Base64 encoded image of the visitor
            $table->string('address_arabic')->nullable();
            $table->string('address_english')->nullable();
            $table->string('arabic_full_name')->nullable();
            $table->date('birth_date')->nullable(); // Visitor's birth date
            $table->string('card_country')->nullable();
            $table->date('card_expiry_date')->nullable(); // Expiry date of the card
            $table->string('card_serial_number')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality_code')->nullable();
            $table->string('passport_number')->nullable();
            $table->timestamp('checkin_time')->nullable(); // Time of check-in
            $table->timestamp('checkout_time')->nullable(); // Time of check-out
            $table->timestamps(); // Laravel's created_at and updated_at
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitors');
    }
}
