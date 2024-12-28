<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckMFA
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->mfa_token) {
            return redirect()->route('mfa.prompt');
        }

        return $next($request);
    }
}
