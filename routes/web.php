<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmployerAuthController;
use App\Http\Controllers\Auth\WriterAuthController;
use App\Http\Controllers\EmployerDashboardController;
use App\Http\Controllers\WriterDashboardController;
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

// Dashboard Routes
Route::middleware(['auth:employer'])->group(function () {
    Route::get('employer/dashboard', function () {
        return view('employer.dashboard'); // Adjust this to your dashboard view
    })->name('employer.dashboard');
});

Route::middleware(['auth:writer'])->group(function () {
    Route::get('writer/dashboard', function () {
        return view('writer.dashboard'); // Adjust this to your dashboard view
    })->name('writer.dashboard');
});



// Employer Dashboard Routes
Route::group(['middleware' => ['auth:employer']], function () {
    Route::get('employer/dashboard', [EmployerDashboardController::class, 'index'])->name('employer.dashboard');
    Route::get('employer/assignment/create', [EmployerDashboardController::class, 'createAssignment'])->name('employer.assignment.create');
    Route::post('employer/assignment/store', [EmployerDashboardController::class, 'storeAssignment'])->name('employer.assignment.store');
    Route::get('employer/assignment/{assignment}', [EmployerDashboardController::class, 'showAssignment'])->name('employer.assignment.show');
});


// Writer Dashboard Routes
Route::group(['middleware' => ['auth:writer']], function () {
    Route::get('writer/dashboard', [WriterDashboardController::class, 'index'])->name('writer.dashboard');
    Route::get('writer/assignment/{assignment}', [WriterDashboardController::class, 'showAssignment'])->name('writer.assignment.show');
    Route::post('writer/assignment/{assignment}/bid', [WriterDashboardController::class, 'storeBid'])->name('writer.assignment.bid');
});