<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    // Ensure this matches your actual table name
    protected $table = 'checkouts'; // Updated from 'checkout'

    // Fillable fields that can be mass-assigned
    protected $fillable = [
        'id_number',
        'arabic_full_name',
        'address_arabic',
        'address_english',
        'birth_date',
        'card_country',
        'card_expiry_date',
        'card_serial_number',
        'gender',
        'nationality_code',
        'passport_number',
        'photo',  // Assuming you're storing base64 encoded photo
    ];

    // Specify which fields should be cast as dates
    protected $dates = [
        'birth_date',
        'card_expiry_date',
    ];
}
