<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DisasterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TipController;
use Illuminate\Support\Facades\Route;

// ── Public ────────────────────────────────────────────────────────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');



// ── Auth ──────────────────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile',  [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile',  [AuthController::class, 'updateProfile'])->name('profile.update');
});

// ── Disasters ─────────────────────────────────────────────────────────────────

// Public routes (index, show)
Route::resource('disasters', DisasterController::class)->only(['index', 'show'])->parameters([
    'disasters' => 'disaster:slug',
]);

// Auth + admin routes (create, store, edit, update, destroy)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('disasters', DisasterController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->parameters(['disasters' => 'disaster:slug']);
});

// ── Contacts ──────────────────────────────────────────────────────────────────

Route::prefix('contacts')->name('contacts.')->group(function () {
    Route::get('/',     [ContactController::class, 'index'])->name('index');
    Route::get('/{contact}', [ContactController::class, 'show'])->name('show');
});

// ── Checklists ────────────────────────────────────────────────────────────────

Route::middleware('auth')->prefix('checklists')->name('checklists.')->group(function () {
    Route::get('/',                         [ChecklistController::class, 'index'])->name('index');
    Route::get('/create',                   [ChecklistController::class, 'create'])->name('create');
    Route::post('/',                        [ChecklistController::class, 'store'])->name('store');
    Route::get('/{checklist}',              [ChecklistController::class, 'show'])->name('show');
    Route::patch('/{checklist}/toggle/{index}', [ChecklistController::class, 'toggle'])->name('toggle');
    Route::delete('/{checklist}',           [ChecklistController::class, 'destroy'])->name('destroy');
});

// ── Tips / Community ──────────────────────────────────────────────────────────

Route::prefix('tips')->name('tips.')->group(function () {
    Route::get('/',           [TipController::class, 'index'])->name('index');
    Route::get('/create',     [TipController::class, 'create'])->name('create')->middleware('auth');
    Route::post('/',          [TipController::class, 'store'])->name('store')->middleware('auth');
    Route::get('/{tip}',      [TipController::class, 'show'])->name('show');
    Route::delete('/{tip}',   [TipController::class, 'destroy'])->name('destroy')->middleware('auth');
    Route::patch('/{tip}/approve', [TipController::class, 'approve'])->name('approve')->middleware(['auth', 'admin']);
});

// ── Fallback ──────────────────────────────────────────────────────────────────

Route::fallback(fn() => view('errors.404'));
