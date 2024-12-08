<?php

namespace App\Http\Controllers;
use App\Models\Checkin;
use App\Models\Checkout;
use Illuminate\Http\Request;

class SmartcardController extends Controller
{
    public function showForm()
    {
        return view('smartcard.read');  // Adjust the view name if necessary
    }

    public function readSmartcardData(Request $request)
    {
        // Example: Retrieve data from the request (you can adjust based on how you're sending it)
        $data = $request->validate([
            'ReadCardInfo' => 'boolean',
            'ReadPersonalInfo' => 'boolean',
            'ReadAddressDetails' => 'boolean',
            'ReadBiometrics' => 'boolean',
            'ReadEmploymentInfo' => 'boolean',
            'ReadImmigrationDetails' => 'boolean',
            'ReadTrafficDetails' => 'boolean',
            'SilentReading' => 'boolean',
            'ReaderIndex' => 'integer',
            'ReaderName' => 'string',
            'OutputFormat' => 'string',
            'ValidateCard' => 'boolean',
        ]);

        // Here, we assume you are calling some service to read the smartcard.
        // You would replace this with your own logic to read the smartcard data.
        $smartcardData = $this->getSmartcardData($data);

        // Returning the response in JSON format
        return response()->json($smartcardData);
    }
    public function saveCheckin(Request $request)
    {
        $validatedData = $request->validate([
            'card_number' => 'required|string',
            'name' => 'required|string',
            'nationality' => 'required|string',
            'checkin_time' => 'required|date',
            'address_arabic' => 'nullable|string',
            'address_english' => 'nullable|string',
            'arabic_full_name' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'card_country' => 'nullable|string',
            'card_expiry_date' => 'nullable|date',
            'card_serial_number' => 'nullable|string',
            'gender' => 'nullable|string',
            'nationality_code' => 'nullable|string',
            'passport_number' => 'nullable|string',
            'photo' => 'nullable|string', // base64 string for photo
        ]);

        $checkin = Checkin::create($validatedData);

        return response()->json(['message' => 'Checkin saved successfully', 'checkin' => $checkin]);
    }
    public function saveCheckout(Request $request)
    {
        $validatedData = $request->validate([
            'card_number' => 'required|string',
            'name' => 'required|string',
            'nationality' => 'required|string',
            'checkout_time' => 'required|date',
            'address_arabic' => 'nullable|string',
            'address_english' => 'nullable|string',
            'arabic_full_name' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'card_country' => 'nullable|string',
            'card_expiry_date' => 'nullable|date',
            'card_serial_number' => 'nullable|string',
            'gender' => 'nullable|string',
            'nationality_code' => 'nullable|string',
            'passport_number' => 'nullable|string',
            'photo' => 'nullable|string', // base64 string for photo
        ]);

        $checkout = Checkout::create($validatedData);

        return response()->json(['message' => 'Checkout saved successfully', 'checkout' => $checkout]);
    }


    protected function getSmartcardData($params)
    {
        // Example response - replace with your actual smartcard reading logic
        return [
            'AddressArabic' => 'Arabic Address Example',
            'AddressEnglish' => 'English Address Example',
            'ArabicFirstName' => 'Ali',
            'ArabicFullName' => 'Ali Al-Dosari',
            'BirthDate' => '1990-01-01',
            'CardCountry' => 'Bahrain',
            'CardExpiryDate' => '2025-12-31',
            'IdNumber' => '1234567890',
            'CardSerialNumber' => 'ABC123456',
            'Gender' => 'Male',
            'NationalityCode' => 'BHR',
            'IsoNationalityCode' => 'BHR',
            'PassportNumber' => 'P1234567',
            'Photo' => base64_encode(file_get_contents('path_to_image/photo.png')), // Example base64 encoding of an image
        ];
    }
}
