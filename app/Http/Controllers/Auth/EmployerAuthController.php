<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployerAuthController extends Controller
{
    // Show Employer Login Form
    public function showLoginForm()
    {
        return view('auth.employer-login');
    }

    // Handle Employer Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('employer')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('employer.dashboard')->with('success', 'Welcome back, employer!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    // Show Employer Registration Form
    public function showRegistrationForm()
    {
        return view('auth.employer-register');
    }

    // Handle Employer Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employers',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'required|string|max:15',
        ]);

        Employer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        Auth::guard('employer')->attempt($request->only('email', 'password'));

        return redirect()->route('employer.dashboard')->with('success', 'Registration successful! Welcome aboard.');
    }

    // Handle Employer Logout
    public function logout(Request $request)
    {
        Auth::guard('employer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}
