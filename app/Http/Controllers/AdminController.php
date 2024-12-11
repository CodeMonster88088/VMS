<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showUsersPage()
    {
        // Ensure only admin can access this page
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        // Fetch users from the database
        $users = \App\Models\User::all(); // You can add filters here if needed

        // Pass data to the users view
        return view('users', [
            'users' => $users,
        ]);
    }


    public function deleteUser($id)
    {
        \App\Models\User::findOrFail($id)->delete();
        return redirect()->route('home')->with('success', 'User deleted successfully.');
    }

    public function editUser($id)
    {
        $user = \App\Models\User::findOrFail($id); // Retrieve the user by ID or fail if not found
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

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'user', // Hard-code role as 'user'
        ]);

        return redirect()->route('home')->with('success', 'User registered successfully.');
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

        return redirect()->route('home')->with('success', 'User updated successfully.');
    }


}


