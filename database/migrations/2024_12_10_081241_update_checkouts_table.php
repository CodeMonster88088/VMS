<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            if (!Schema::hasColumn('checkouts', 'id_number')) {
                $table->string('id_number', 255);
            }
            if (!Schema::hasColumn('checkouts', 'photo')) {
                $table->longText('photo')->nullable();
            }
            if (!Schema::hasColumn('checkouts', 'address_arabic')) {
                $table->string('address_arabic', 255)->nullable();
            }
            if (!Schema::hasColumn('checkouts', 'address_english')) {
                $table->string('address_english', 255)->nullable();
            }
            if (!Schema::hasColumn('checkouts', 'arabic_full_name')) {
                $table->string('arabic_full_name', 255)->nullable();
            }
            if (!Schema::hasColumn('checkouts', 'birth_date')) {
                $table->date('birth_date')->nullable();
            }
            if (!Schema::hasColumn('checkouts', 'card_country')) {
                $table->string('card_country', 100)->nullable();
            }
            if (!Schema::hasColumn('checkouts', 'card_expiry_date')) {
                $table->date('card_expiry_date')->nullable();
            }
            if (!Schema::hasColumn('checkouts', 'card_serial_number')) {
                $table->string('card_serial_number', 255)->nullable();
            }
            if (!Schema::hasColumn('checkouts', 'gender')) {
                $table->string('gender', 10)->nullable();
            }
            if (!Schema::hasColumn('checkouts', 'nationality_code')) {
                $table->string('nationality_code', 50)->nullable();
            }
            if (!Schema::hasColumn('checkouts', 'passport_number')) {
                $table->string('passport_number', 255)->nullable();
            }
            if (!Schema::hasColumn('checkouts', 'checkout_time')) {
                $table->timestamp('checkout_time')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropColumn([
                'id_number',
                'photo',
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
                'checkout_time',
            ]);
        });
    }
}
