<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTP;
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
            $user = Auth::user();

            // Generate a 6-digit OTP for MFA
            $otp = rand(100000, 999999);
            $user->update([
                'mfa_token' => $otp,
                'mfa_expires_at' => now()->addMinutes(10), // OTP valid for 10 minutes
            ]);

            // Send the OTP to the user's email
            Mail::to($user->email)->send(new SendOTP($otp));

            // Log the login attempt (without MFA success yet)
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'Login',
                'module' => 'Authentication',
                'details' => "User logged in. Awaiting MFA verification.",
                'ip_address' => $request->ip(),
            ]);

            // Redirect to MFA verification page
            return redirect()->route('mfa.prompt')->with('success', 'OTP sent to your email for verification.');
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
