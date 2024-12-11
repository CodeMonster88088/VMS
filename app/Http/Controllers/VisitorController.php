<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use App\Models\Checkin;

class VisitorController extends Controller
{
    /**
     * Display the visitor log.
     */
    public function visitorLog()
    {
        $checkins = Checkin::select(
            'photo',
            'id',
            'id_number',
            'arabic_full_name',
            'address_arabic',
            'created_at as checkin_time'
        )
            ->orderBy('created_at', 'desc')
            ->get();

        $checkouts = Checkout::select(
            'id',
            'id_number',
            'arabic_full_name',
            'address_arabic',
            'created_at as checkout_time'
        )
            ->orderBy('created_at', 'desc')
            ->get();

        // Combine the data into a single collection
        $visitors = $checkins->merge($checkouts)->sortByDesc(function ($visitor) {
            return $visitor->checkin_time ?? $visitor->checkout_time;
        });

        return view('home', compact('visitors'));
    }


    /**
     * Show details of a single visitor.
     */
    public function show($id)
    {
        $visitor = Checkin::findOrFail($id);

        return view('visitors.details', compact('visitor'));
    }
}
