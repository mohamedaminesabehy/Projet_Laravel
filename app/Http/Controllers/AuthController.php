<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showSignupForm()
    {
        return view('pages.signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'signupEmail' => 'required|string|email|max:255|unique:users,email',
            'signupPassword' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->signupEmail,
            'password' => Hash::make($request->signupPassword),
            'role' => User::ROLE_USER,
        ]);

        return redirect()->route('signin')->with('success', 'Account created successfully! Please sign in.');
    }

    public function showSigninForm()
    {
        return view('pages.signin');
    }

    public function signin(Request $request)
    {
        $credentials = $request->validate([
            'signinEmail' => 'required|string|email',
            'signinPassword' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $credentials['signinEmail'], 'password' => $credentials['signinPassword']])) {
            $request->session()->regenerate();

            if (Auth::user()->role === User::ROLE_ADMIN) {
                return redirect('/admin/dashboard');
            }

            return redirect('/'); // Redirect to home page
        }

        return back()->withErrors([
            'signinEmail' => 'The provided credentials do not match our records.',
        ])->onlyInput('signinEmail');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}