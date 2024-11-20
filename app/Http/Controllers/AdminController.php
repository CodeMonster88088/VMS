<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function showHomePage()
    {
        // Retrieve all users from the database
        $users = User::all();

        // Pass data to the home view
        return view('home', [
            'greeting' => 'Hello',
            'name' => 'Ali',
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
            'role' => 'required|string',
        ]);

        $user = \App\Models\User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('home')->with('success', 'User updated successfully.');
    }

}


