<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\CustomResetPasswordMail;

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

    // Show Password Reset Request Form
    public function showPasswordResetRequestForm()
    {
        return view('auth.employer-password-request');
    }

    // Send Password Reset Link
    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:employers,email',
        ]);

        $employer = Employer::where('email', $request->email)->first();
        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert([
            'email' => $request->email,
            'guard' => 'employer',
        ], [
            'token' => $token,
            'created_at' => now(),
        ]);

        // Send the password reset link via email
        Mail::to($employer->email)->send(new CustomResetPasswordMail($token, 'employer', $request->email));

        return back()->with('status', 'We have emailed your password reset link!');
    }

    // Show Password Reset Form
    public function showPasswordResetForm(Request $request, $token)
    {
        return view('auth.employer-password-reset', [
            'token' => $token,
            'email' => $request->email,  // Pass the email to the view
        ]);
    }


    // Handle Password Reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:employers,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $passwordReset = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token,
            'guard' => 'employer',
        ])->first();

        if (!$passwordReset) {
            return back()->withErrors(['token' => 'This password reset token is invalid.']);
        }

        $employer = Employer::where('email', $request->email)->first();
        $employer->password = Hash::make($request->password);
        $employer->save();

        DB::table('password_resets')->where([
            'email' => $request->email,
            'guard' => 'employer',
        ])->delete();

        return redirect('/employer/login')->with('status', 'Password has been reset successfully!');
    }
}
