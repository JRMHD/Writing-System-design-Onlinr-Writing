<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmployerAuthController;
use App\Http\Controllers\Auth\WriterAuthController;
use App\Http\Controllers\Employer\AssignmentController;
use App\Http\Controllers\WriterDashboardController;
use App\Http\Controllers\BidController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\MessageController;
// Import the controllers with their full namespaces
use App\Http\Controllers\Writer\WithdrawalController;
use App\Http\Controllers\Writer\WriterPaymentController;
use App\Http\Controllers\Employer\EmployerWalletController;
use App\Http\Controllers\Employer\DepositController;
use App\Http\Controllers\EmployerProfileController;
use App\Http\Controllers\WriterProfileController;
use App\Http\Controllers\EmployerSubscriptionController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SubscriptionController;

use App\Http\Controllers\Employer\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Employer Authentication Routes
Route::get('employer/login', [EmployerAuthController::class, 'showLoginForm'])->name('employer.login');
Route::post('employer/login', [EmployerAuthController::class, 'login']);
Route::get('employer/register', [EmployerAuthController::class, 'showRegistrationForm'])->name('employer.register');
Route::post('employer/register', [EmployerAuthController::class, 'register']);
Route::post('employer/logout', [EmployerAuthController::class, 'logout'])->name('employer.logout');

// Writer Authentication Routes
Route::get('writer/login', [WriterAuthController::class, 'showLoginForm'])->name('writer.login');
Route::post('writer/login', [WriterAuthController::class, 'login']);
Route::get('writer/register', [WriterAuthController::class, 'showRegistrationForm'])->name('writer.register');
Route::post('writer/register', [WriterAuthController::class, 'register']);
Route::post('writer/logout', [WriterAuthController::class, 'logout'])->name('writer.logout');

// Middleware for authenticated employers
Route::middleware(['auth:employer'])->group(function () {
    Route::get('employer/dashboard', function () {
        $assignments = \App\Models\Assignment::where('employer_id', Auth::id())->get();
        return view('employer.assignments.dashboard', compact('assignments'));
    })->name('employer.dashboard');

    Route::prefix('employer')->name('employer.')->group(function () {
        Route::resource('assignments', AssignmentController::class);
        Route::resource('assignments', AssignmentController::class);
        Route::get('/assignments-with-bids', [AssignmentController::class, 'bidOnAssignments'])->name('assignments.bid-on');
        Route::get('/given-out-assignments', [AssignmentController::class, 'givenOutAssignments'])->name('assignments.given-out');
    });
    Route::patch('/employer/assignments/{assignment}/mark-as-completed', [AssignmentController::class, 'markAsCompleted'])
        ->name('employer.assignments.markAsCompleted');
    Route::get('employer/assignments/{assignmentId}/bids', [BidController::class, 'index'])->name('employer.assignments.bids.index');
    Route::patch('employer/bids/{id}/select', [BidController::class, 'selectWriter'])->name('employer.bids.select');


    Route::get('/wallet', [EmployerWalletController::class, 'showWallet'])->name('wallet.index');
    Route::post('/wallet/deposit', [EmployerWalletController::class, 'deposit'])->name('wallet.deposit');
    Route::get('/wallet', [EmployerWalletController::class, 'showWallet'])->name('wallet.show');
    Route::post('/wallet/deposit', [DepositController::class, 'store'])->name('wallet.deposit'); // Define this controller and method
    Route::get('/wallet', [EmployerWalletController::class, 'showWallet'])->name('employer.wallet.show');
    Route::post('/wallet/deposit', [DepositController::class, 'store'])->name('wallet.deposit');

    Route::get('/employer/profile', [EmployerProfileController::class, 'show'])->name('employer.profile');
    Route::post('/employer/profile/update', [EmployerProfileController::class, 'update'])->name('employer.profile.update');
});

// Middleware for authenticated writers
Route::middleware(['auth:writer'])->group(function () {
    Route::get('writer/dashboard', [WriterDashboardController::class, 'index'])->name('writer.dashboard');

    Route::get('writer/assignments', [BidController::class, 'listAvailableAssignments'])->name('writer.assignments.index');
    Route::get('writer/assignments/{id}', [BidController::class, 'showAssignmentDetails'])->name('writer.assignments.show');
    Route::get('writer/assignments/{id}/bid', [BidController::class, 'create'])->name('writer.bids.create');

    Route::get('writer/bids', [BidController::class, 'writerIndex'])->name('writer.bids.index');
    Route::post('writer/bids', [BidController::class, 'store'])->name('writer.bids.store');

    // Display all active bids for a writer
    Route::get('/writer/bids/active', [BidController::class, 'activeBids'])->name('writer.bids.active');

    // Display other views information (rejected, in-progress, completed)
    Route::get('/writer/bids/other-views', [BidController::class, 'otherViews'])->name('writer.bids.other-views');

    // Cancel a bid
    Route::post('/writer/bids/cancel/{id}', [BidController::class, 'cancelBid'])->name('writer.bids.cancel');

    // Routes for writer's bids
    Route::get('/writer/bids/active', [BidController::class, 'activeBids'])->name('writer.bids.active');
    Route::get('/writer/bids/other', [BidController::class, 'otherViews'])->name('writer.bids.other_views');
    Route::delete('/writer/bids/{id}/cancel', [BidController::class, 'cancelBid'])->name('writer.bids.cancel');
    // Route for viewing bid details
    Route::get('/writer/bids/{id}', [BidController::class, 'show'])->name('writer.bids.show');

    Route::get('payments/history', [WriterPaymentController::class, 'paymentHistory'])->name('writer.payments.history');
    Route::get('withdrawals/request', [WithdrawalController::class, 'showForm'])->name('writer.withdrawals.request');
    Route::post('withdrawals/request', [WithdrawalController::class, 'requestWithdrawal'])->name('writer.withdrawals.submit');
    Route::get('/balance', [WriterPaymentController::class, 'showBalance'])->name('writer.balance');
    Route::get('withdrawals/history', [WithdrawalController::class, 'history'])->name('writer.withdrawals.history');
    Route::get('/writer/balance', [App\Http\Controllers\Writer\WriterPaymentController::class, 'showBalance'])->name('writer.balance');
    Route::get('/balance', [WithdrawalController::class, 'showBalance'])->name('writer.balance');
    Route::post('/withdraw', [WithdrawalController::class, 'requestWithdrawal'])->name('writer.withdraw');
    Route::post('/withdraw/update/{id}', [WithdrawalController::class, 'updateWithdrawal'])->name('writer.withdraw.update');

    Route::get('/writer/profile', [WriterProfileController::class, 'show'])->name('writer.profile');
    Route::post('/writer/profile/update', [WriterProfileController::class, 'update'])->name('writer.profile.update');
    Route::post('/writer-logout', [WriterAuthController::class, 'logout'])->name('writer.logout');

    Route::get('/subscriptions/plans', [SubscriptionController::class, 'showPlans'])->name('subscriptions.plans');
    Route::post('/subscriptions/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscriptions.subscribe');
    Route::get('/subscriptions/active', [SubscriptionController::class, 'activeSubscriptions'])->name('subscriptions.active');
});

require __DIR__ . '/auth.php';

Route::patch('/employer/bids/{id}/status/{status}', [BidController::class, 'updateStatus'])->name('employer.bids.updateStatus');
Route::patch('/employer/bids/mark-taken/{bid}', [BidController::class, 'markAsTaken'])->name('employer.bids.markTaken');
Route::patch('/employer/bids/mark-completed/{bid}', [BidController::class, 'markAsCompleted'])->name('employer.bids.markCompleted');
Route::patch('/employer/bids/mark-available/{bid}', [BidController::class, 'markAsAvailable'])->name('employer.bids.markAvailable');


// Password Reset Routes for Writers
Route::get('writer/password/reset', [WriterAuthController::class, 'showPasswordResetRequestForm'])->name('writer.password.request');
Route::post('writer/password/reset', [WriterAuthController::class, 'sendPasswordResetLink'])->name('writer.password.email');
Route::get('writer/password/reset/{token}', [WriterAuthController::class, 'showPasswordResetForm'])->name('writer.password.reset');
Route::post('writer/password/reset/{token}', [WriterAuthController::class, 'resetPassword'])->name('writer.password.update');


// Route to show the password reset request form
Route::get('employer/password/reset', [EmployerAuthController::class, 'showPasswordResetRequestForm'])
    ->name('employer.password.request');

// Route to handle the password reset request
Route::post('employer/password/email', [EmployerAuthController::class, 'sendPasswordResetLink'])
    ->name('employer.password.email');

// Route to show the password reset form
Route::get('employer/password/reset/{token}', [EmployerAuthController::class, 'showPasswordResetForm'])
    ->name('employer.password.reset');

// Route to handle password reset
Route::post('employer/password/reset', [EmployerAuthController::class, 'resetPassword'])
    ->name('employer.password.update');

// Public profile route for writer
Route::get('/writer/profile/{id}', function ($id) {
    $writer = App\Models\Writer::findOrFail($id);
    return view('public.writer-profile', compact('writer'));
})->name('public.writer.profile');

// Public profile route for employer
Route::get('/employer/profile/{id}', function ($id) {
    $employer = App\Models\Employer::findOrFail($id);
    return view('public.employer-profile', compact('employer'));
})->name('public.employer.profile');

Route::get('/writer/profile/public/{id}', [WriterProfileController::class, 'viewPublic'])->name('writer.profile.public');


Route::get('/employer/profile', [EmployerProfileController::class, 'show'])->name('employer.profile');
Route::post('/employer/profile', [EmployerProfileController::class, 'update'])->name('employer.profile.update');
Route::get('/employer/profile/public/{id}', [EmployerProfileController::class, 'viewPublic'])->name('employer.profile.public');




Route::get('ratings/{writerId}/create', [RatingController::class, 'create'])->name('ratings.create');
Route::post('ratings/{writerId}', [RatingController::class, 'store'])->name('ratings.store');

Route::prefix('employer')->name('employer.')->middleware('auth:employer')->group(function () {
    Route::get('/wallet', [EmployerWalletController::class, 'showWallet'])->name('wallet.show');
    Route::post('/wallet/deposit', [DepositController::class, 'store'])->name('wallet.deposit');
});

Route::prefix('writer')->name('writer.')->middleware('auth:writer')->group(function () {
    Route::get('/balance', [WriterPaymentController::class, 'showBalance'])->name('balance.show');
    Route::post('/withdraw', [WithdrawalController::class, 'requestWithdrawal'])->name('withdraw');
});


Route::middleware(['auth:employer'])->group(function () {
    // Existing routes
    Route::get('/employer/assignments', [AssignmentController::class, 'index'])->name('employer.assignments.index');

    // New route for displaying available writers
    Route::get('/employer/writers', [AssignmentController::class, 'showWriters'])->name('employer.writers.index');
});




Route::middleware(['auth:employer'])->group(function () {
    Route::get('employer/subscriptions/plans', [EmployerSubscriptionController::class, 'showPlans'])->name('employer.subscriptions.plans');
    Route::post('employer/subscriptions/subscribe', [EmployerSubscriptionController::class, 'subscribe'])->name('employer.subscriptions.subscribe');
    Route::get('employer/subscriptions/active', [EmployerSubscriptionController::class, 'activeSubscriptions'])->name('employer.subscriptions.active');
});


// Registration Routes
Route::get('/writer/register', [WriterAuthController::class, 'showRegistrationForm'])->name('writer.register.form');
Route::post('/writer/register', [WriterAuthController::class, 'register'])->name('writer.register');

// Verification Routes
Route::get('/writer/register/verification-sent', [WriterAuthController::class, 'verificationSent'])->name('writer.register.verification-sent');
Route::get('/writer/verify/{token}', [WriterAuthController::class, 'verify'])->name('writer.verify');
Route::post('/writer/process-payment', [WriterAuthController::class, 'processPayment'])->name('writer.process-payment');

// Employer Verification Routes
Route::get('/employer/register/verification-sent', [EmployerAuthController::class, 'verificationSent'])->name('employer.register.verification-sent');
Route::get('/employer/verify/{token}', [EmployerAuthController::class, 'verify'])->name('employer.verify');
Route::post('/employer/process-payment', [EmployerAuthController::class, 'processPayment'])->name('employer.process-payment');

// routes/web.php
Route::middleware(['auth:employer'])->group(function () {
    Route::get('/employer/dashboard', [DashboardController::class, 'index'])->name('employer.dashboard');
});

// For Employers
Route::middleware(['auth:employer'])->group(function () {
    Route::get('/employer/chats', [MessageController::class, 'indexForEmployer'])->name('employer.chat.index');
    Route::post('/employer/chats/start', [MessageController::class, 'startChatForEmployer'])->name('employer.chat.start');
    Route::get('/employer/chats/{conversation}', [MessageController::class, 'showForEmployer'])->name('employer.chat.show');
    Route::post('/employer/chats/{conversation}/send', [MessageController::class, 'sendForEmployer'])->name('employer.chat.send');
});

// For Writers
Route::middleware(['auth:writer'])->group(function () {
    Route::get('/writer/chats', [MessageController::class, 'indexForWriter'])->name('writer.chat.index');
    Route::post('/writer/chats/start', [MessageController::class, 'startChatForWriter'])->name('writer.chat.start');
    Route::get('/writer/chats/{conversation}', [MessageController::class, 'showForWriter'])->name('writer.chat.show');
    Route::post('/writer/chats/{conversation}/send', [MessageController::class, 'sendForWriter'])->name('writer.chat.send');
});
