<?php

use Illuminate\Support\Facades\Route;

// ---------- Ajoute ce bloc dans routes/web.php ----------
// (avec les imports en haut du fichier, à côté des autres `use`)
//
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminEntrepriseController;
use App\Http\Controllers\Admin\AdminLicenceController;

Route::get('/', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/entreprises/create', [AdminEntrepriseController::class, 'create'])->name('entreprises.create');
    Route::post('/entreprises', [AdminEntrepriseController::class, 'store'])->name('entreprises.store');

    Route::get('/licences/create', [AdminLicenceController::class, 'create'])->name('licences.create');
    Route::post('/licences', [AdminLicenceController::class, 'store'])->name('licences.store');
    Route::get('/licences/{licence}', [AdminLicenceController::class, 'show'])->name('licences.show');
    Route::post('/licences/{licence}/toggle', [AdminLicenceController::class, 'toggleStatut'])->name('licences.toggle');
    Route::delete('/appareils/{appareil}', [AdminLicenceController::class, 'revoquerAppareil'])->name('appareils.revoquer');
    Route::delete('/licences/{licence}', [AdminLicenceController::class, 'destroy'])->name('licences.destroy');
});