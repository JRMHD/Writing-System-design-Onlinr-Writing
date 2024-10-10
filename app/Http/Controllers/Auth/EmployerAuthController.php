<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\EmployerVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\CustomResetPasswordMail;
use App\Mail\EmployerVerificationMail;

class EmployerAuthController extends Controller
{
    /**
     * Show the Employer Login Form
     */
    public function showLoginForm()
    {
        return view('auth.employer-login');
    }

    /**
     * Handle Employer Login
     */
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

    /**
     * Show the Employer Registration Form
     */
    public function showRegistrationForm()
    {
        return view('auth.employer-register');
    }

    /**
     * Handle Employer Registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employers|unique:employer_verifications',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'required|string|max:15',
        ]);

        // Generate a unique verification token
        $token = Str::random(60);

        // Store the employer's details in the employer_verifications table
        EmployerVerification::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'token' => $token,
        ]);

        // Send the verification email
        Mail::to($request->email)->send(new EmployerVerificationMail($token));

        // Redirect to the verification sent page
        return redirect()->route('employer.register.verification-sent');
    }

    /**
     * Show Verification Sent Page
     */
    public function verificationSent()
    {
        return view('auth.employer-verification-sent');
    }

    /**
     * Handle Verification Link Click
     */
    public function verify($token)
    {
        // Find the verification record by token
        $verification = EmployerVerification::where('token', $token)->first();

        if (!$verification) {
            return redirect()->route('employer.login')->withErrors(['token' => 'Invalid verification token.']);
        }

        // Show the payment page
        return view('auth.employer-payment', ['verification' => $verification]);
    }

    /**
     * Process Payment and Finalize Registration
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'token' => 'required|exists:employer_verifications,token',
        ]);

        // Find the verification record by token
        $verification = EmployerVerification::where('token', $request->token)->first();

        if (!$verification) {
            return redirect()->route('employer.login')->withErrors(['token' => 'Invalid token.']);
        }

        // TODO: Integrate MPESA STK Push here
        // For now, simulate successful payment

        // Move the employer's data to the employers table
        Employer::create([
            'name' => $verification->name,
            'email' => $verification->email,
            'password' => $verification->password, // Already hashed
            'phone' => $verification->phone,
        ]);

        // Delete the verification record
        $verification->delete();

        // Redirect to the login page with a success message
        return redirect()->route('employer.login')->with('success', 'Your account has been activated! You can now log in.');
    }

    /**
     * Handle Employer Logout
     */
    public function logout(Request $request)
    {
        Auth::guard('employer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/employer/login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show Password Reset Request Form
     */
    public function showPasswordResetRequestForm()
    {
        return view('auth.employer-password-request');
    }

    /**
     * Send Password Reset Link
     */
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

    /**
     * Show Password Reset Form
     */
    public function showPasswordResetForm(Request $request, $token)
    {
        return view('auth.employer-password-reset', [
            'token' => $token,
            'email' => $request->email,  // Pass the email to the view
        ]);
    }

    /**
     * Handle Password Reset
     */
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
