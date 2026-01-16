<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        // Hanya tampilkan user dengan role karyawan
        $users = User::where('role', 'karyawan')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'karyawan',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun karyawan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        
        // Pastikan hanya karyawan yang bisa dilihat
        if ($user->role !== 'karyawan') {
            abort(403, 'Unauthorized access');
        }
        
        return view('admin.users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        
        // Pastikan hanya karyawan yang bisa diedit
        if ($user->role !== 'karyawan') {
            abort(403, 'Unauthorized access');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        // Pastikan hanya karyawan yang bisa diupdate
        if ($user->role !== 'karyawan') {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Akun karyawan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Pastikan hanya karyawan yang bisa dihapus
        if ($user->role !== 'karyawan') {
            abort(403, 'Unauthorized access');
        }

        // Jangan izinkan menghapus diri sendiri jika admin secara tidak sengaja mengakses
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun karyawan berhasil dihapus');
    }
}

