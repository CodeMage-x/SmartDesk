<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth (guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected
Route::middleware(['auth', 'force_password_change'])->group(function () {

    // Universal Change Password
    Route::get('/password/change', [PasswordController::class, 'show'])->name('password.change');
    Route::post('/password/change', [PasswordController::class, 'update'])->name('password.update');

    // Dashboard redirect
    Route::get('/dashboard', fn () => redirect()->route('home'))->name('dashboard');

    // Admin routes
    Route::middleware('role:super_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Users
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/create-user', [AdminController::class, 'createUser'])->name('create-user');
        Route::post('/store-user', [AdminController::class, 'storeUser'])->name('store-user');
        Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('toggle-user-status');

        // Tickets
        Route::get('/tickets', [AdminController::class, 'tickets'])->name('tickets');
        Route::get('/agents-by-category/{category}', [AdminController::class, 'getAgentsByCategory'])
            ->name('agents.by-category'); // <-- name added
        Route::patch('/tickets/{ticket}/reassign', [AdminController::class, 'reassignTicket'])
            ->name('reassign-ticket');    // keep only once
    });

    // Agent routes
    Route::middleware('role:helpdesk_agent')->prefix('agent')->name('agent.')->group(function () {
        Route::get('/dashboard', [AgentController::class, 'dashboard'])->name('dashboard');
        Route::get('/tickets-pool', [AgentController::class, 'ticketsPool'])->name('tickets-pool');
        Route::patch('/tickets/{ticket}/claim', [AgentController::class, 'claimTicket'])->name('claim-ticket');
        Route::patch('/tickets/{ticket}/status', [AgentController::class, 'updateTicketStatus'])->name('update-ticket-status');
    });

    // User routes
    Route::middleware('role:end_user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/create-ticket', [UserController::class, 'createTicket'])->name('create-ticket');
        Route::post('/store-ticket', [UserController::class, 'storeTicket'])->name('store-ticket');
    });

    // Shared ticket routes
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
});