<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisitorController extends Controller
{

    public function index(Request $request)
    {
        $query = Visitor::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('id_number', 'like', "%$search%")
                ->orWhere('arabic_full_name', 'like', "%$search%");
        }

        $visitors = $query->orderBy('checkin_time', 'desc')->get();

        return view('visitors.index', compact('visitors'));
    }

    /**
     * Display the visitor log.
     */
    public function visitorLog()
    {
        $visitors = Visitor::orderBy('checkin_time', 'desc')->get();
        return view('home', compact('visitors'));
    }

    /**
     * Save a check-in record.
     */
    public function checkIn(Request $request): \Illuminate\Http\JsonResponse
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'id_number' => 'required|string|max:255',
            'photo' => 'nullable|string',
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

        // Create a new visitor record for this visit
        $visitor = Visitor::create([
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
            'checkin_time' => now(),
            'checkout_time' => null, // Initialize checkout time as null
        ]);

        // Return a success response
        return response()->json([
            'message' => 'Visitor checked in successfully!',
            'visitor' => $visitor,
        ], 201);
    }
    public function validateCheckin(Request $request)
    {
        $request->validate([
            'id_number' => 'required|string'
        ]);

        $isCheckedIn = Visitor::where('id_number', $request->id_number)
            ->whereNull('checkout_time') // Check if there is an active check-in
            ->exists();

        return response()->json(['is_checked_in' => $isCheckedIn]);
    }


    /**
     * Save a check-out record.
     */
    public function checkOut(Request $request, $id)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'id_number' => 'required|string|exists:visitors,id_number',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Invalid checkout request.');
        }

        // Find the existing visitor record
        $visitor = Visitor::where('id', $id)
            ->whereNull('checkout_time')
            ->first();

        if (!$visitor) {
            return redirect()->back()->with('error', 'Visitor has already checked out or does not exist.');
        }

        // Update the check-out time
        $visitor->update(['checkout_time' => now()]);

        return redirect()->back()->with('success', 'Visitor checked out successfully!');
    }




    /**
     * Show details of a single visitor.
     */
    public function show($id)
    {
        $visitor = Visitor::findOrFail($id);

        return view('visitors.details', compact('visitor'));
    }
}
