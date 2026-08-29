<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminEntrepriseController;
use App\Http\Controllers\Admin\AdminLicenceController;

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/entreprises/create', [AdminEntrepriseController::class, 'create'])->name('entreprises.create');
    Route::post('/entreprises', [AdminEntrepriseController::class, 'store'])->name('entreprises.store');

    Route::get('/licences/create', [AdminLicenceController::class, 'create'])->name('licences.create');
    Route::post('/licences', [AdminLicenceController::class, 'store'])->name('licences.store');
    Route::get('/licences/{licence}', [AdminLicenceController::class, 'show'])->name('licences.show');
    Route::post('/licences/{licence}/toggle', [AdminLicenceController::class, 'toggleStatut'])->name('licences.toggle');
    Route::delete('/appareils/{appareil}', [AdminLicenceController::class, 'revoquerAppareil'])->name('appareils.revoquer');
    Route::delete('/licences/{licence}', [AdminLicenceController::class, 'destroy'])->name('licences.destroy');
});
