<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ActivityLog; // Include the ActivityLog model
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showUsersPage()
    {
        // Ensure only admin can access this page
        if (!Auth::check() || !Auth::user()->isAdmin) {
            abort(403, 'Unauthorized access');
        }

        // Fetch users
        $users = \App\Models\User::all();

        // Fetch activity logs, paginated
        $logs = ActivityLog::with('user') // Eager load the related user
        ->orderBy('created_at', 'desc') // Sort logs by latest
        ->paginate(10); // Paginate logs

        // Pass both users and logs to the view
        return view('users', compact('users', 'logs'));
    }


    public function deleteUser($id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Log the deletion action
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Delete',
            'module' => 'Users',
            'details' => 'Deleted user with ID ' . $id,
            'ip_address' => request()->ip(),
        ]);

        // Delete the user
        $user->delete();

        return redirect()->route('users.manage')->with('success', 'User deleted successfully.');
    }

    public function editUser($id)
    {
        $user = \App\Models\User::findOrFail($id); // Retrieve the user by ID or fail if not found

        // Log the edit action
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Edit',
            'module' => 'Users',
            'details' => 'Accessed edit page for user with ID ' . $id,
            'ip_address' => request()->ip(),
        ]);

        return view('edit-user', compact('user')); // Pass the user data to the edit view
    }

    public function registerUser(Request $request)
    {
        // Validation and user creation logic
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'user', // Hard-code role as 'user'
        ]);

        // Log the registration action
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Create',
            'module' => 'Users',
            'details' => 'Registered a new user with ID ' . $user->id,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('users.manage')->with('success', 'User registered successfully.');
    }

    public function updateUser(Request $request, $id)
    {
        // Validate the request inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed', // Validate password only if provided
        ]);

        // Find the user by ID
        $user = \App\Models\User::findOrFail($id);

        // Update the user's name and email
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // If a password is provided, update it
        if ($request->filled('password')) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        // Log the update action
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update',
            'module' => 'Users',
            'details' => 'Updated user with ID ' . $id,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('users.manage')->with('success', 'User updated successfully.');
    }
}
