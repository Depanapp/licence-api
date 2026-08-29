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

Route::get('/clear-cache-xyz123', function () {
    if (request('key') !== env('SEED_SECRET_KEY')) {
        abort(403);
    }
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return 'Cache vidé avec succès.';
});

Route::get('/debug-auth-attempt-xyz123', function () {
    if (request('key') !== env('SEED_SECRET_KEY')) {
        abort(403);
    }

    $result = \Illuminate\Support\Facades\Auth::attempt([
        'email' => 'admin@licence.com',
        'password' => 'Passer123',
    ]);

    return [
        'auth_attempt_result' => $result,
        'session_driver' => config('session.driver'),
        'auth_guard' => config('auth.defaults.guard'),
    ];
});

Route::get('/debug-write-test-xyz123', function () {
    if (request('key') !== env('SEED_SECRET_KEY')) {
        abort(403);
    }

    $result = [];

    $logPath = storage_path('logs');
    $result['storage_logs_dir_exists'] = is_dir($logPath);
    $result['storage_logs_writable'] = is_writable($logPath);

    try {
        \Illuminate\Support\Facades\Log::error('TEST DIRECT LOG WRITE');
        $result['log_facade_call'] = 'no exception thrown';
    } catch (\Throwable $e) {
        $result['log_facade_call'] = 'EXCEPTION: ' . $e->getMessage();
    }

    try {
        file_put_contents(storage_path('logs/test-manuel.log'), 'test ' . now());
        $result['manual_write'] = 'success';
    } catch (\Throwable $e) {
        $result['manual_write'] = 'EXCEPTION: ' . $e->getMessage();
    }

    $result['files_in_logs_dir'] = is_dir($logPath) ? scandir($logPath) : 'dir does not exist';

    return $result;
});


Route::get('/debug-read-log-xyz123', function () {
    if (request('key') !== env('SEED_SECRET_KEY')) {
        abort(403);
    }

    $path = storage_path('logs/laravel.log');

    if (!file_exists($path)) {
        return 'Aucun fichier de log trouvé.';
    }

    // Lit les 5000 derniers caractères pour ne pas surcharger l'affichage
    $contenu = file_get_contents($path);
    $dernierMorceau = substr($contenu, -5000);

    return '<pre>' . htmlspecialchars($dernierMorceau) . '</pre>';
});