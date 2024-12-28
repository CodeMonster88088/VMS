<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Visitor;
//use Barryvdh\DomPDF\Facade as PDF; // Correct Facade usage
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VisitorsExport;
use Illuminate\Support\Facades\Auth;


class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'checkin_desc'); // Default to check-in time ascending
        $search = $request->input('search'); // Get the search input
        $query = Visitor::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id_number', 'like', "%{$search}%")
                    ->orWhere('arabic_full_name', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        switch ($sort) {
            case 'checkin_asc':
                $query->orderBy('checkin_time', 'asc');
                break;
            case 'checkin_desc':
                $query->orderBy('checkin_time', 'desc');
                break;
            case 'checkout_asc':
                $query->orderBy('checkout_time', 'asc');
                break;
            case 'checkout_desc':
                $query->orderBy('checkout_time', 'desc');
                break;
            case 'still_checked_in':
                $query->whereNull('checkout_time')->orderBy('checkin_time', 'asc');
                break;
            default:
                $query->orderBy('checkin_time', 'asc');
                break;
        }

        $visitors = $query->paginate(10)->appends($request->except('page')); // Maintain query string during pagination

        return view('visitors.index', compact('visitors'));
    }





    public function edit($id, Request $request)
    {
        $visitor = Visitor::findOrFail($id);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Logout',
            'module' => 'Authentication',
            'details' => "visitor edited.",
            'ip_address' => $request->ip(),
        ]);

        return view('visitors.edit', compact('visitor'));
    }

    public function destroy($id, Request $request)
    {
        $visitor = Visitor::findOrFail($id);
        $visitor->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Delete',
            'module' => 'Visitors',
            'details' => "Visitor with ID {$id} deleted.",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', 'Visitor deleted successfully.');
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


        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'module' => 'Visitors',
            'details' => "Visitor updated.",
            'ip_address' => $request->ip(),
        ]);

        // Redirect back with a success message
        return redirect()->route('home')->with('success', 'Visitor updated successfully!');
    }

    public function visitorLog(Request $request)
    {
        // Default sorting by check-in time descending
        $sort = $request->input('sort', 'checkin_desc');
        $search = $request->input('search'); // Handle search queries
        $query = Visitor::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id_number', 'like', "%{$search}%")
                    ->orWhere('arabic_full_name', 'like', "%{$search}%");
            });
        }

        // Apply sorting logic
        switch ($sort) {
            case 'checkin_asc':
                $query->orderBy('checkin_time', 'asc');
                break;
            case 'checkin_desc':
                $query->orderBy('checkin_time', 'desc');
                break;
            case 'checkout_asc':
                $query->orderBy('checkout_time', 'asc');
                break;
            case 'checkout_desc':
                $query->orderBy('checkout_time', 'desc');
                break;
            case 'still_checked_in':
                $query->whereNull('checkout_time')->orderBy('checkin_time', 'desc');
                break;
            default:
                $query->orderBy('checkin_time', 'desc'); // Default sorting
                break;
        }

        // Paginate visitors and maintain query string during pagination
        $visitors = $query->paginate(10)->appends($request->except('page'));

        return view('home', compact('visitors'));
    }


    public function checkIn(Request $request)
    {
        // Combine all validation into one step
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
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

        // Create the visitor record
        $visitor = Visitor::create([
            'user_id' => $validatedData['user_id'],
            'id_number' => $validatedData['id_number'],
            'photo' => $validatedData['photo'] ?? null,
            'address_arabic' => $validatedData['address_arabic'] ?? null,
            'address_english' => $validatedData['address_english'] ?? null,
            'arabic_full_name' => $validatedData['arabic_full_name'] ?? null,
            'birth_date' => $validatedData['birth_date'] ?? null,
            'card_country' => $validatedData['card_country'] ?? null,
            'card_expiry_date' => $validatedData['card_expiry_date'] ?? null,
            'card_serial_number' => $validatedData['card_serial_number'] ?? null,
            'gender' => $validatedData['gender'] ?? null,
            'nationality_code' => $validatedData['nationality_code'] ?? null,
            'passport_number' => $validatedData['passport_number'] ?? null,
            'checkin_time' => now(),
            'checkout_time' => null,
        ]);

        // Log the check-in action
        ActivityLog::create([
            'user_id' => $validatedData['user_id'],
            'action' => 'Check-in',
            'module' => 'Visitors',
            'details' => "Checked in visitor with ID {$visitor->id}.",
            'ip_address' => $request->ip(),
        ]);

        // Return a success response
        return response()->json(['message' => 'Visitor checked in successfully!', 'visitor' => $visitor], 201);
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

        ActivityLog::create([
            'user_id' => Auth::id(), // Use the authenticated user's ID
            'action' => 'Check-out',
            'module' => 'Visitors',
            'details' => "Checked out visitor with ID {$id}.",
            'ip_address' => request()->ip(),
        ]);

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
