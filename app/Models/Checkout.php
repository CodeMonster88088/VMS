<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $table = 'checkout';

    protected $fillable = [
        'card_number',
        'name',
        'nationality',
        'checkout_time',
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
        'photo',  // Assuming you're storing base64 encoded photo
    ];

    // Optionally, you can add date casting for any date fields (if you store them as date objects)
    protected $dates = [
        'birth_date', 'checkout_time', 'card_expiry_date'
    ];

    // If you are storing the photo in a different format or external storage,
    // you can create a custom attribute or accessor for handling the photo field.
}
