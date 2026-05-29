<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tingkat;
use Illuminate\Http\Request;

class TingkatController extends Controller
{
    public function index()
    {
        $tingkats = Tingkat::orderBy('urutan')->get();
        return view('admin.tingkat.index', compact('tingkats'));
    }

    public function create()
    {
        return view('admin.tingkat.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_tingkat' => 'required|string|max:255',
            'jenis_penilaian' => 'required|in:harian,ujian',
            'kkm' => 'required|integer|min:0|max:100',
            'urutan' => 'required|integer|min:1',
        ]);

        Tingkat::create($data);

        return redirect()->route('admin.tingkat.index')->with('success', 'Tingkat berhasil ditambahkan.');
    }

    public function show(Tingkat $tingkat)
    {
        return view('admin.tingkat.show', compact('tingkat'));
    }

    public function edit(Tingkat $tingkat)
    {
        return view('admin.tingkat.edit', compact('tingkat'));
    }

    public function update(Request $request, Tingkat $tingkat)
    {
        $data = $request->validate([
            'nama_tingkat' => 'required|string|max:255',
            'jenis_penilaian' => 'required|in:harian,ujian',
            'kkm' => 'required|integer|min:0|max:100',
            'urutan' => 'required|integer|min:1',
        ]);

        $tingkat->update($data);

        return redirect()->route('admin.tingkat.index')->with('success', 'Tingkat berhasil diperbarui.');
    }

    public function destroy(Tingkat $tingkat)
    {
        $tingkat->delete();

        return redirect()->route('admin.tingkat.index')->with('success', 'Tingkat berhasil dihapus.');
    }
}