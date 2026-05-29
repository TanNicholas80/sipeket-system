<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelatih;
use App\Models\User;
use Illuminate\Http\Request;

class PelatihController extends Controller
{
    public function index()
    {
        $pelatihs = User::where('role', 'pelatih')->with('pelatihProfile')->get();
        return view('admin.pelatih.index', compact('pelatihs'));
    }

    public function create()
    {
        return view('admin.pelatih.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'username' => strtolower(str_replace(' ', '', $data['name'])) . rand(100, 999),
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'pelatih',
            'status' => 'aktif',
        ]);

        $user->pelatihProfile()->create([
            'nama_lengkap' => $data['name'],
            'no_hp' => '+62' . $data['no_hp'],
            'alamat' => $data['alamat'],
        ]);

        return redirect()->route('admin.pelatih.index')->with('success', 'Pelatih berhasil ditambahkan.');
    }

    public function show(User $pelatih)
    {
        // Ensure this is a pelatih user
        if ($pelatih->role !== 'pelatih') {
            abort(404);
        }

        $pelatih->load('pelatihProfile');
        return view('admin.pelatih.show', compact('pelatih'));
    }

    public function edit(User $pelatih)
    {
        // Ensure this is a pelatih user
        if ($pelatih->role !== 'pelatih') {
            abort(404);
        }

        $pelatih->load('pelatihProfile');
        return view('admin.pelatih.edit', compact('pelatih'));
    }

    public function update(Request $request, User $pelatih)
    {
        // Ensure this is a pelatih user
        if ($pelatih->role !== 'pelatih') {
            abort(404);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pelatih->id,
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $pelatih->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $pelatih->pelatihProfile()->updateOrCreate(
            ['user_id' => $pelatih->id],
            [
                'nama_lengkap' => $data['name'],
                'no_hp' => '+62' . $data['no_hp'],
                'alamat' => $data['alamat'],
            ]
        );

        return redirect()->route('admin.pelatih.index')->with('success', 'Pelatih berhasil diperbarui.');
    }

    public function destroy(User $pelatih)
    {
        // Ensure this is a pelatih user
        if ($pelatih->role !== 'pelatih') {
            abort(404);
        }

        if ($pelatih->pelatihProfile) {
            $pelatih->pelatihProfile->delete();
        }

        $pelatih->delete();

        return redirect()->route('admin.pelatih.index')->with('success', 'Pelatih berhasil dihapus.');
    }
}