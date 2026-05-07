<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('nama_lengkap')->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'username'     => ['required', 'string', 'max:50', 'unique:users,username'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
            'role'         => ['required', 'in:admin_tu,kepala_sekolah'],
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(int $id): View
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'username'     => ['required', 'string', 'max:50', "unique:users,username,{$id},id_user"],
            'role'         => ['required', 'in:admin_tu,kepala_sekolah'],
            'password'     => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        if (auth()->user()->id_user === $id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
