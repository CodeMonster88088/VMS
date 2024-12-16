<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class LogUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        // Continue the request
        $response = $next($request);

        // Skip logging for unauthenticated users
        if (auth()->check()) {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => $this->determineAction($request),
                'module' => $this->determineModule($request),
                'details' => json_encode($request->all()), // Store request data
                'ip_address' => $request->ip(),
            ]);
        }

        return $response;
    }

    private function determineAction(Request $request)
    {
        if ($request->isMethod('get')) {
            return 'View';
        } elseif ($request->isMethod('post')) {
            return 'Create';
        } elseif ($request->isMethod('put') || $request->isMethod('patch')) {
            return 'Update';
        } elseif ($request->isMethod('delete')) {
            return 'Delete';
        }

        return 'Unknown';
    }

    private function determineModule(Request $request)
    {
        return $request->segment(1); // Use the first URI segment as the module
    }
}
