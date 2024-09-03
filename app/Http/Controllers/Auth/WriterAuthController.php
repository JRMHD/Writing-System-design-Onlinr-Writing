<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WriterAuthController extends Controller
{
    // Show Writer Login Form
    public function showLoginForm()
    {
        return view('auth.writer-login');
    }

    // Handle Writer Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('writer')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('writer.dashboard')->with('success', 'Welcome back, writer!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    // Show Writer Registration Form
    public function showRegistrationForm()
    {
        return view('auth.writer-register');
    }

    // Handle Writer Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:writers',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'required|string|max:15',
        ]);

        Writer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        Auth::guard('writer')->attempt($request->only('email', 'password'));

        return redirect()->route('writer.dashboard')->with('success', 'Registration successful! Welcome aboard.');
    }

    // Handle Writer Logout
    public function logout(Request $request)
    {
        Auth::guard('writer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}
