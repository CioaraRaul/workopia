<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{

    //@desc Show registration form
    //@route GET /register
    public function register():View
    {
        return view('auth.register');
    }

    //@desc Handle registration form submission
    //@route POST /register

    public function store(Request $request):RedirectResponse
    {
       $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // hash the password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Create the user
        $user = User::create($validatedData);

        // Redirect to the home page
        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }
}
