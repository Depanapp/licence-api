<?php

use Illuminate\Support\Facades\Route;

// ---------- Ajoute ce bloc dans routes/web.php ----------
// (avec les imports en haut du fichier, à côté des autres `use`)
//
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminEntrepriseController;
use App\Http\Controllers\Admin\AdminLicenceController;

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

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


Route::get('/debug-admin-check-xyz123', function () {
    if (request('key') !== env('SEED_SECRET_KEY')) {
        abort(403);
    }

    $user = \App\Models\User::where('email', 'admin@licence.com')->first();

    if (!$user) {
        return 'Aucun utilisateur trouvé avec cet email.';
    }

    $passwordMatches = \Illuminate\Support\Facades\Hash::check('Passer123', $user->password);

    return [
        'user_found' => true,
        'email' => $user->email,
        'name' => $user->name,
        'password_hash' => $user->password,
        'password_matches' => $passwordMatches,
    ];
});