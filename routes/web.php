<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminComplaintController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDepartmentController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminUserController;

// Officer controllers
use App\Http\Controllers\Officer\OfficerAuthController;

// Normal controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Officer\OfficerComplaintController;
use App\Http\Controllers\Officer\OfficerDashboardController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'hi'])) {
        session(['locale' => $locale]);
    }
    return back();
});

// Public complaint tracking routes
Route::get('/track-complaint', [TrackingController::class, 'showTrackingForm'])->name('tracking.form');
Route::post('/track-complaint', [TrackingController::class, 'trackComplaint'])->name('tracking.submit');
Route::get('/track-complaint/{tracking_id}', [TrackingController::class, 'trackComplaintPublic'])->name('tracking.public');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');

    // Complaint Routes
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
    Route::get('/complaints/thanks/{trackingId}', [ComplaintController::class, 'thanks'])->name('complaints.thanks');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin authentication routes
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Admin protected routes
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Admin Complaint Routes
        Route::get('/complaints', [AdminComplaintController::class, 'index'])->name('complaints.index');
        Route::get('/complaints/{complaint}', [AdminComplaintController::class, 'show'])->name('complaints.show');
        Route::post('/complaints/{complaint}/status', [AdminComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');
        Route::post('/complaints/{complaint}/assign', [AdminComplaintController::class, 'assignOfficer'])->name('complaints.assignOfficer');
        Route::post('/complaints/{complaint}/unassign', [AdminComplaintController::class, 'unassignOfficer'])->name('complaints.unassignOfficer');
        Route::put('/complaints/{complaint}/department', [AdminComplaintController::class, 'updateDepartment'])->name('complaints.updateDepartment');
        Route::get('/departments/{department}/officers', [AdminComplaintController::class, 'getOfficersByDepartment'])->name('complaints.getOfficers');


        // Admin User Routes
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        Route::patch('/users/{user}/status', [AdminUserController::class, 'updateStatus'])->name('users.updateStatus');

        // Admin Department Routes
        Route::get('/departments', [AdminDepartmentController::class, 'index'])->name('departments.index');

        // Admin Reports
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    });
});

// Officer routes
Route::prefix('officer')->name('officer.')->group(function () {
    // Officer authentication routes
    Route::get('/login', [OfficerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [OfficerAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [OfficerAuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'role:officer'])->group(function () {
        Route::get('/dashboard', [OfficerDashboardController::class, 'index'])->name('dashboard');

        // Officer Complaint Routes
        Route::get('/complaints', [OfficerComplaintController::class, 'index'])->name('complaints.index');
        Route::get('/complaints/{complaint}', [OfficerComplaintController::class, 'show'])->name('complaints.show');
        Route::put('/complaints/{complaint}/status', [OfficerComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');
        Route::post('/complaints/{complaint}/resolve', [OfficerComplaintController::class, 'markAsResolved'])->name('complaints.markResolved');
    });
});


// Feedback routes for all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/create/{complaint}', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback/store/{complaint}', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/{feedback}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::put('/feedback/{feedback}/status', [FeedbackController::class, 'updateStatus'])->name('feedback.updateStatus');
});