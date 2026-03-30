<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    //@desc Show login form
    //@route GET /login
    public function login():View
    {
        return view('auth.login');
    }

    //@desc Handle login form submission
    //@route POST /login
    public function authenticate(Request $request):RedirectResponse {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        //attempt to authenticate the user
        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'Login successful.');
        }

        // Authentication failed
        return redirect()->back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
    }
}
