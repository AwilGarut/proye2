<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index()
    {
        $users = User::all(); // Ambil semua data pengguna dari database
        return view('users.index', compact('users')); // Kirim data ke view
    }

    /**
     * Menampilkan formulir edit user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); // Cari user berdasarkan ID
        return view('users.edit', compact('user')); // Kirim data user ke view
    }

    /**
     * Memperbarui data user di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);

        // Update data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}