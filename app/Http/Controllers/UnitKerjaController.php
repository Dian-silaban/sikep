<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    /**
     * Display a listing of the resource (Unit Kerja).
     */
    public function index()
    {
        $unitKerjas = UnitKerja::orderBy('nama_unit')->get();
        // Perbaiki nama view: gunakan hyphen (-) agar konsisten
        return view('settings.unit-kerja.index', compact('unitKerjas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Perbaiki nama view: gunakan hyphen (-) agar konsisten
        return view('settings.unit-kerja.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255|unique:unit_kerja,nama_unit',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        UnitKerja::create($request->all());

        return redirect()->route('settings.unit-kerja.index')->with('success', 'Unit kerja berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitKerja $unitKerja)
    {
        // Ini sudah benar menggunakan hyphen (-)
        return view('settings.unit-kerja.edit', compact('unitKerja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitKerja $unitKerja)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255|unique:unit_kerja,nama_unit,' . $unitKerja->id,
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $unitKerja->update($request->all());

        return redirect()->route('settings.unit-kerja.index')->with('success', 'Unit kerja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitKerja $unitKerja)
    {
        // Pencegahan: Jangan biarkan unit kerja dihapus jika masih ada pegawai yang terhubung
        if ($unitKerja->pegawai()->count() > 0) {
            return redirect()->route('settings.unit-kerja.index')->with('error', 'Tidak dapat menghapus unit kerja karena masih ada pegawai yang terkait.');
        }
        
        $unitKerja->delete();

        return redirect()->route('settings.unit-kerja.index')->with('success', 'Unit kerja berhasil dihapus.');
    }
}