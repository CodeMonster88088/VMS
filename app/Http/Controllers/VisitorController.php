<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
//use Barryvdh\DomPDF\Facade as PDF; // Correct Facade usage
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VisitorsExport;

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

    public function edit($id)
    {
        $visitor = Visitor::findOrFail($id);
        return view('visitors.edit', compact('visitor'));
    }

    public function destroy($id)
    {
        $visitor = Visitor::findOrFail($id);
        $visitor->delete();

        return redirect()->route('visitors.index')->with('success', 'Visitor deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'id_number' => 'required|string|max:255',
            'arabic_full_name' => 'required|string|max:255',
            'address_arabic' => 'nullable|string|max:255',
            'address_english' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'card_country' => 'nullable|string|max:100',
            'card_expiry_date' => 'nullable|date',
            'card_serial_number' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:10',
            'nationality_code' => 'nullable|string|max:50',
            'passport_number' => 'nullable|string|max:255',
        ]);

        // Find the visitor and update
        $visitor = Visitor::findOrFail($id);
        $visitor->update($request->all());

        // Redirect back with a success message
        return redirect()->route('visitors.index')->with('success', 'Visitor updated successfully!');
    }

    public function visitorLog()
    {
        $visitors = Visitor::orderBy('checkin_time', 'desc')->get();
        return view('home', compact('visitors'));
    }

    public function checkIn(Request $request): \Illuminate\Http\JsonResponse
    {
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

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

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
            'checkout_time' => null,
        ]);

        return response()->json([
            'message' => 'Visitor checked in successfully!',
            'visitor' => $visitor,
        ], 201);
    }

    public function validateCheckin(Request $request)
    {
        $request->validate([
            'id_number' => 'required|string',
        ]);

        $isCheckedIn = Visitor::where('id_number', $request->id_number)
            ->whereNull('checkout_time')
            ->exists();

        return response()->json(['is_checked_in' => $isCheckedIn]);
    }

    public function checkOut(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_number' => 'required|string|exists:visitors,id_number',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Invalid checkout request.');
        }

        $visitor = Visitor::where('id', $id)
            ->whereNull('checkout_time')
            ->first();

        if (!$visitor) {
            return redirect()->back()->with('error', 'Visitor has already checked out or does not exist.');
        }

        $visitor->update(['checkout_time' => now()]);

        return redirect()->back()->with('success', 'Visitor checked out successfully!');
    }

    public function show($id)
    {
        $visitor = Visitor::findOrFail($id);

        return view('visitors.details', compact('visitor'));
    }

    public function exportPDF()
    {
        // Fetch all visitors
        $visitors = Visitor::all();

        // Load the view and pass the data
        $pdf = PDF::loadView('reports.visitors_pdf', compact('visitors'));

        // Download the generated PDF
        return $pdf->download('visitors_report.pdf');
    }
    public function exportExcel()
    {
        return Excel::download(new VisitorsExport, 'visitors_report.xlsx');
    }
}
