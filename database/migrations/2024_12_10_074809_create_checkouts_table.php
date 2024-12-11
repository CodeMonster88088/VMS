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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->string('arabic_full_name');
            $table->string('address_arabic')->nullable();
            $table->string('address_english')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('card_country')->nullable();
            $table->date('card_expiry_date')->nullable();
            $table->string('card_serial_number')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality_code')->nullable();
            $table->string('passport_number')->nullable();
            $table->longText('photo')->nullable();
            $table->timestamp('checkout_time')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checkouts');
    }

};
