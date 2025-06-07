<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuperAdmin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SuperAdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek sebagai SuperAdmin
        if (Auth::guard('superadmin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        // Cek sebagai Admin
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        // Cek apakah username sudah ada di SuperAdmin
        $usernameExistsInSuper = \App\Models\SuperAdmin::where('username', $request->username)->exists();

        // Cek apakah username sudah ada di Admin
        $usernameExistsInAdmin = \App\Models\Admin::where('username', $request->username)->exists();

        if ($usernameExistsInSuper || $usernameExistsInAdmin) {
            throw ValidationException::withMessages([
                'username' => 'Username sudah digunakan oleh pengguna lain.',
            ]);
        }

        $superadmin = SuperAdmin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        session(['superadmin' => $superadmin->id]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('superadmin')->check()) {
            Auth::guard('superadmin')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }


}
