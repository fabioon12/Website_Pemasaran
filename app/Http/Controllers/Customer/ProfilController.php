<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function index()
    {
        return view('frontend.user.profil.index');
    }

    /**
     * Menampilkan halaman form edit profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('frontend.user.profil.edit', compact('user'));
    }

    /**
     * Memproses pembaruan data profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'whatsapp'  => 'required|string|max:20',
            'instansi'  => 'required|string|max:255',
            'pekerjaan' => 'required|string',
            'avatar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password'  => 'nullable|string|min:8|confirmed', // Password opsional saat edit
        ]);

        // Update data dasar
        $user->name = $request->name;
        $user->email = $request->email;
        $user->whatsapp = $request->whatsapp;
        $user->instansi = $request->instansi;
        $user->pekerjaan = $request->pekerjaan;

        // Handle Update Password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle Update Avatar
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada di storage
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan avatar baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return redirect()->route('customer.profil.index')->with([
            'success' => 'Profile updated successfully.'
        ]);
    }
}