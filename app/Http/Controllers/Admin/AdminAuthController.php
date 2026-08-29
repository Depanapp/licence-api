<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $donnees = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($donnees, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Identifiants incorrects.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Affiche le formulaire d'inscription admin.
     * Protégé par une clé de configuration (ADMIN_SETUP_KEY) pour éviter
     * que n'importe qui puisse créer un compte admin en production.
     */
    public function showRegister(Request $request)
    {
        $this->verifierCleSetup($request);

        return view('admin.register');
    }

    public function register(Request $request)
    {
        $this->verifierCleSetup($request);

        $donnees = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $donnees['name'],
            'email' => $donnees['email'],
            'password' => Hash::make($donnees['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    /**
     * Bloque l'accès à l'inscription si la clé de setup ne correspond pas.
     * Définis ADMIN_SETUP_KEY dans .env / Render (chaîne longue et secrète).
     */
    private function verifierCleSetup(Request $request): void
    {
        $cleAttendue = env('ADMIN_SETUP_KEY');

        if (empty($cleAttendue) || $request->query('key') !== $cleAttendue) {
            abort(403, 'Accès non autorisé.');
        }
    }
}