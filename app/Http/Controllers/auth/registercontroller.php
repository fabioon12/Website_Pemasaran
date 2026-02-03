<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class registercontroller extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
   public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'whatsapp'  => 'required|string|max:20', 
            'instansi'  => 'required|string|max:255',
            'pekerjaan' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'whatsapp'  => $request->whatsapp,  
            'instansi'  => $request->instansi,  
            'pekerjaan' => $request->pekerjaan, 
            'password' => Hash::make($request->password),
            'avatar'   => $avatarPath, 
        ]);

        $user->assignRole('CUSTOMER');
        Auth::login($user);

        // Redirect dengan pesan sukses
        return redirect()->route('customer.catalog.index')->with([
            'success' => 'Akun berhasil dibuat. Selamat datang, ' . $user->name . '!',
        ]);
    }
}
