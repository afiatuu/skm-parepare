<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    // Tampilkan halaman profil
    public function index()
    {
        $user = Auth::user();
        return view('admin.profil', compact('user'));
    }

    // Update profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,'.$user->id],
            'password' => ['nullable','string','min:8','confirmed'],
        ]);

        // Jika password diisi, hash; kalau kosong jangan diubah
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}