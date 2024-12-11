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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        $user = \App\Models\User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('home')->with('success', 'User updated successfully.');
    }

}


