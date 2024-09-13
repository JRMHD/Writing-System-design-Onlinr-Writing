<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\CustomResetPasswordMail;

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

    // Show Password Reset Request Form
    public function showPasswordResetRequestForm()
    {
        return view('auth.writer-password-request');
    }

    // Send Password Reset Link
    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:writers,email',
        ]);

        $writer = Writer::where('email', $request->email)->first();
        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert([
            'email' => $request->email,
            'guard' => 'writer',
        ], [
            'token' => $token,
            'created_at' => now(),
        ]);

        // Send the password reset link via email
        Mail::to($writer->email)->send(new CustomResetPasswordMail($token, 'writer', $request->email));

        return back()->with('status', 'We have emailed your password reset link!');
    }

    // Show Password Reset Form
    public function showPasswordResetForm(Request $request, $token)
    {
        return view('auth.writer-password-reset', [
            'token' => $token,
            'email' => $request->email,  // Pass the email to the view
        ]);
    }


    // Handle Password Reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:writers,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $passwordReset = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token,
            'guard' => 'writer',
        ])->first();

        if (!$passwordReset) {
            return back()->withErrors(['token' => 'This password reset token is invalid.']);
        }

        $writer = Writer::where('email', $request->email)->first();
        $writer->password = Hash::make($request->password);
        $writer->save();

        DB::table('password_resets')->where([
            'email' => $request->email,
            'guard' => 'writer',
        ])->delete();

        return redirect('/writer/login')->with('status', 'Password has been reset successfully!');
    }
}
