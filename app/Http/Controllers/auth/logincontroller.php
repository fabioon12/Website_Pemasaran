<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class logincontroller extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput();
        }

        Auth::login($user);

        // Redirect & Kirim pesan sukses yang akan dibaca SweetAlert
        if ($user->hasRole('ADMINISTRATOR')) {
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
        }
        
        // Sesuaikan dengan role yang Anda gunakan (CUSTOMER atau STUDENT)
        if ($user->hasRole('CUSTOMER') || $user->hasRole('STUDENT')) {
            return redirect()->route('customer.catalog.index')->with('success', 'Senang melihatmu kembali, ' . $user->name . '!');
        } 

        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Role tidak dikenali.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Kamu telah berhasil keluar.');
    }
}
