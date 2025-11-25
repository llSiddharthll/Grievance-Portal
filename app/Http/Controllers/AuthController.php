<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.index');
    }

    public function showLogin()
    {
        return view('auth.index');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|max:255|unique:users,email',
            'phone' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                'unique:users,phone'
            ],
            'password' => 'required|min:6',
        ]);


        $user = User::create([
            'full_name' => $request->full_name,
            'username'  => $request->email,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'phone'     => $request->phone
        ]);

        $user->assignRole('citizen');

        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password
        ];

        Auth::attempt($credentials, $remember = true);

        return redirect()->route('dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone'    => 'required|digits:10',
            'password' => 'required'
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'phone' => 'Invalid phone number or password.'
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
