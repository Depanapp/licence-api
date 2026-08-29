<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

       Log::error('LOGIN ATTEMPT DEBUG', [
            'email_raw' => $donnees['email'],
            'email_length' => strlen($donnees['email']),
            'password_length' => strlen($donnees['password']),
            'session_id' => $request->session()->getId(),
            'csrf_token_request' => $request->input('_token'),
            'csrf_token_session' => $request->session()->token(),
        ]);

        $attemptResult = Auth::attempt($donnees, $request->boolean('remember'));

        Log::error('AUTH ATTEMPT RESULT', ['result' => $attemptResult]);

        if (! $attemptResult) {
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
}