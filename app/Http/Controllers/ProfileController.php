<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit(Request $r)
    {
        return view('profile.edit', ['user' => $r->user()]);
    }

    public function update(Request $r)
    {
        $user = $r->user();
        $r->validate([
            'name'  => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
        ]);

        $user->fill($r->only('name','email'));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return back()->with('ok', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $r)
    {
        $r->validate([
            'current_password' => ['required','string'],
            'password' => ['required','string','min:8','confirmed'],
        ]);

        $user = $r->user();

        if (! Hash::check($r->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->password = $r->password; // cast hashed
        $user->save();

        return back()->with('ok', 'Password berhasil diubah. Gunakan password baru saat login berikutnya.');
    }
}
