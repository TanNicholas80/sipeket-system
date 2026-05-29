<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profil()
    {
        return view('profil.index', [
            'user' => auth()->user(),
        ]);
    }

    public function updatePassword(Request $request)
    {
        // Placeholder logic untuk update password.
        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function updatePhoto(Request $request)
    {
        // Placeholder logic untuk update foto profil.
        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}
