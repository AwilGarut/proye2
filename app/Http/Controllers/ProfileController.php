<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // Pastikan model User Anda ada di path ini

class ProfileController extends Controller
{
   public function edit()
{
    $user = Auth::user();
    // dd($user->avatar); // Tambahkan ini untuk debug, lalu hapus setelah selesai
    return view('profile.edit', compact('user'));
}

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Menambahkan webp, membuatnya nullable
        ]);

        // Cek dan simpan foto jika ada file upload
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar) {
                // 'avatars' adalah direktori di dalam disk 'public' (storage/app/public/avatars)
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            // Simpan avatar baru
            $imageName = uniqid('avatar_') . '.' . $request->file('avatar')->getClientOriginalExtension();
            // Simpan file ke 'storage/app/public/avatars'
            $request->file('avatar')->storeAs('avatars', $imageName, 'public');
            $user->avatar = $imageName; // Simpan hanya nama filenya ke database
        }

        // Update data pengguna
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        // $user->avatar sudah di-assign di atas jika ada file baru

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}