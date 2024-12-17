<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MFAController extends Controller
{
    public function showPrompt()
    {
        return view('auth.prompt');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = Auth::user();

        // Check if OTP is valid
        if ($user->mfa_token == $request->otp && $user->mfa_expires_at > now()) {
            // Clear MFA token after successful verification
            $user->update(['mfa_token' => null, 'mfa_expires_at' => null]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Login',
                'module' => 'Authentication',
                'details' => "User logged in. MFA Verified",
                'ip_address' => $request->ip(),
            ]);

            return redirect()->intended('/')->with('success', 'MFA verified successfully!');
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Login',
            'module' => 'Authentication',
            'details' => "User Failed to login. MFA verification failed",
            'ip_address' => $request->ip(),
        ]);

        return back()->withErrors(['mfa.prompt' => 'Invalid or expired OTP.']);
    }
}
