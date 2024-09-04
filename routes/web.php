<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmployerAuthController;
use App\Http\Controllers\Auth\WriterAuthController;
use App\Http\Controllers\Employer\AssignmentController;
use App\Http\Controllers\WriterDashboardController;
use App\Http\Controllers\BidController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

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
        Route::resource('assignments', AssignmentController::class)->except(['show']);
    });

    Route::get('employer/assignments/{assignmentId}/bids', [BidController::class, 'index'])->name('employer.assignments.bids.index');
    Route::post('employer/assignments/{assignmentId}/select-writer', [BidController::class, 'selectWriter'])->name('employer.assignments.selectWriter');
});

// Middleware for authenticated writers
Route::middleware(['auth:writer'])->group(function () {
    Route::get('writer/dashboard', [WriterDashboardController::class, 'index'])->name('writer.dashboard');

    Route::get('writer/bids', [BidController::class, 'writerIndex'])->name('writer.bids.index');
    Route::get('writer/bids/create', [BidController::class, 'create'])->name('writer.bids.create');
    Route::post('writer/bids', [BidController::class, 'store'])->name('writer.bids.store');
});
