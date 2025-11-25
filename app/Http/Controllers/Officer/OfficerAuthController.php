<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.officer.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // Check role using Spatie
            if (!$user->hasRole('officer')) {
                Auth::logout();
                return back()->withErrors(['username' => 'Unauthorized access']);
            }

            return redirect()->route('officer.dashboard');
        }

        return back()->withErrors(['username' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('officer.login');
    }
}
