<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'checkins';

    // Define the fillable attributes to allow mass assignment
    protected $fillable = [
        'photo',
        'id_number',
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
    ];

    // Optionally, you can specify hidden attributes (like password, if any) or cast attributes to specific types
    protected $casts = [
        'birth_date' => 'date',
        'card_expiry_date' => 'date',
    ];

    // Additional relationships, accessors, or mutators can be added here as needed
}
