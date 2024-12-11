<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Save the checkout data.
     */
    public function save(Request $request): \Illuminate\Http\JsonResponse
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'id_number' => 'required|string|max:255',
            'photo' => 'nullable|string', // Assuming photo is base64 encoded or a file path
            'address_arabic' => 'nullable|string|max:255',
            'address_english' => 'nullable|string|max:255',
            'arabic_full_name' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'card_country' => 'nullable|string|max:100',
            'card_expiry_date' => 'nullable|date',
            'card_serial_number' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:10',
            'nationality_code' => 'nullable|string|max:50',
            'passport_number' => 'nullable|string|max:255',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Create the checkout record
        $checkout = Checkout::create([
            'id_number' => $request->id_number,
            'photo' => $request->photo,
            'address_arabic' => $request->address_arabic,
            'address_english' => $request->address_english,
            'arabic_full_name' => $request->arabic_full_name,
            'birth_date' => $request->birth_date,
            'card_country' => $request->card_country,
            'card_expiry_date' => $request->card_expiry_date,
            'card_serial_number' => $request->card_serial_number,
            'gender' => $request->gender,
            'nationality_code' => $request->nationality_code,
            'passport_number' => $request->passport_number,
        ]);

        // Return a success response
        return response()->json([
            'message' => 'Checkout saved successfully!',
            'checkout' => $checkout,
        ], 201);
    }
}
