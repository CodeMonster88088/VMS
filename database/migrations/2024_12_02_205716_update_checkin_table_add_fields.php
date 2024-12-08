<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('checkin', function (Blueprint $table) {
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
            $table->text('photo')->nullable(); // To store base64 encoded photo
        });
    }

    public function down()
    {
        Schema::table('checkin', function (Blueprint $table) {
            $table->dropColumn([
                'address_arabic',
                'address_english',
                'arabic_full_name',
                'birth_date',
                'card_country',
                'card_expiry_date',
                'card_serial_number',
                'gender',
                'nationality_code',
                'passport_number',
                'photo',
            ]);
        });
    }
};
