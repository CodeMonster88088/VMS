<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
        'checkin_time',
        'checkout_time',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'birth_date' => 'date',
        'card_expiry_date' => 'date',
        'checkin_time' => 'datetime',
        'checkout_time' => 'datetime',
    ];

    /**
     * Updates the visitor data from a given form input.
     *
     * @param array $data
     * @return void
     */
    public function updateFromFormData(array $data)
    {
        $this->update([
            'id_number' => $data['id_number'] ?? $this->id_number,
            'photo' => $data['photo'] ?? $this->photo,
            'address_arabic' => $data['address_arabic'] ?? $this->address_arabic,
            'address_english' => $data['address_english'] ?? $this->address_english,
            'arabic_full_name' => $data['arabic_full_name'] ?? $this->arabic_full_name,
            'birth_date' => $data['birth_date'] ?? $this->birth_date,
            'card_country' => $data['card_country'] ?? $this->card_country,
            'card_expiry_date' => $data['card_expiry_date'] ?? $this->card_expiry_date,
            'card_serial_number' => $data['card_serial_number'] ?? $this->card_serial_number,
            'gender' => $data['gender'] ?? $this->gender,
            'nationality_code' => $data['nationality_code'] ?? $this->nationality_code,
            'passport_number' => $data['passport_number'] ?? $this->passport_number,
        ]);
    }
}
