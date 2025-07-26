<?php

namespace App\Http\Controllers;

use App\Models\JenisDokumen;
use Illuminate\Http\Request;

class JenisDokumenController extends Controller
{
    /**
     * Display a listing of the resource (Jenis Dokumen).
     */
    public function index()
    {
        $jenisDokumens = JenisDokumen::orderBy('nama_jenis')->get();
        return view('settings.jenis_dokumen.index', compact('jenisDokumens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.jenis_dokumen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis_dokumen,nama_jenis',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        JenisDokumen::create($request->all());

        return redirect()->route('settings.jenis-dokumen.index')->with('success', 'Jenis dokumen berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisDokumen $jenisDokuman) // Perhatikan nama parameter harus sesuai route
    {
        return view('settings.jenis-dokumen.edit', compact('jenisDokuman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisDokumen $jenisDokuman) // Perhatikan nama parameter
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis_dokumen,nama_jenis,' . $jenisDokuman->id,
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $jenisDokuman->update($request->all());

        return redirect()->route('settings.jenis-dokumen.index')->with('success', 'Jenis dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisDokumen $jenisDokuman) // Perhatikan nama parameter
    {
        // Pencegahan: Jangan biarkan jenis dokumen dihapus jika masih ada dokumen pegawai yang terhubung
        if ($jenisDokuman->dokumen_pegawai()->count() > 0) {
            return redirect()->route('settings.jenis-dokumen.index')->with('error', 'Tidak dapat menghapus jenis dokumen karena masih ada dokumen pegawai yang terkait.');
        }

        $jenisDokuman->delete();

        return redirect()->route('settings.jenis-dokumen.index')->with('success', 'Jenis dokumen berhasil dihapus.');
    }
}