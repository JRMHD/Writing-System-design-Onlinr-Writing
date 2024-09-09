<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmployerAuthController;
use App\Http\Controllers\Auth\WriterAuthController;
use App\Http\Controllers\Employer\AssignmentController;
use App\Http\Controllers\WriterDashboardController;
use App\Http\Controllers\BidController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WriterProfileController;
use App\Http\Controllers\MessageController;

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
    });

    Route::get('employer/assignments/{assignmentId}/bids', [BidController::class, 'index'])->name('employer.assignments.bids.index');
    Route::patch('employer/bids/{id}/select', [BidController::class, 'selectWriter'])->name('employer.bids.select');
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
});

require __DIR__ . '/auth.php';

Route::patch('/employer/bids/{id}/status/{status}', [BidController::class, 'updateStatus'])->name('employer.bids.updateStatus');
Route::patch('/employer/bids/mark-taken/{bid}', [BidController::class, 'markAsTaken'])->name('employer.bids.markTaken');
Route::patch('/employer/bids/mark-completed/{bid}', [BidController::class, 'markAsCompleted'])->name('employer.bids.markCompleted');
Route::patch('/employer/bids/mark-available/{bid}', [BidController::class, 'markAsAvailable'])->name('employer.bids.markAvailable');
