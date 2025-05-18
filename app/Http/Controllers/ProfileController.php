<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // ✅ Tambahkan baris ini
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var Authenticatable $user */
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar) {
                Storage::delete('public/avatars/' . $user->avatar); // 🔥 Sekarang tidak akan error
            }

            $imageName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('public/avatars', $imageName);
            $user->avatar = $imageName;
        }

        $user->username = $request->username;
        $user->email = $request->email;

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}