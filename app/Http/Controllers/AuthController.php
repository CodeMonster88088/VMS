<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // Log successful login
            $user = Auth::user();
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'Login',
                'module' => 'Authentication',
                'details' => "User logged in.",
                'ip_address' => $request->ip(),
            ]);

            return redirect()->intended('/')->with('success', 'Logged in successfully.');
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        // Log the logout activity
        if ($user = Auth::user()) {
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'Logout',
                'module' => 'Authentication',
                'details' => "User logged out.",
                'ip_address' => $request->ip(),
            ]);
        }

        // Perform logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
