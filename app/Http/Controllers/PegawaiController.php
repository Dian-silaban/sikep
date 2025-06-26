<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\JenisDokumen;
use App\Models\UnitKerja; // Penting: Tambahkan ini untuk Opsi A
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua data pegawai, dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        // Memulai query untuk model Pegawai dengan eager loading relasi unit_kerja
        // Eager loading (with('unit_kerja')) akan mencegah N+1 query problem
        $query = Pegawai::with('unit_kerja')->orderBy('nama_lengkap');

        // Logic Pencarian
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_lengkap', 'like', '%' . $searchTerm . '%')
                  ->orWhere('nip', 'like', '%' . $searchTerm . '%')
                  ->orWhere('jabatan', 'like', '%' . $searchTerm . '%');

                
                $q->orWhereHas('unit_kerja', function($q_unit) use ($searchTerm) {
                    $q_unit->where('nama_unit', 'like', '%' . $searchTerm . '%');
                });
            });
        }

        $pegawai = $query->paginate(10); // Paginasi tetap diterapkan

        // Kirim searchTerm kembali ke view agar input pencarian tidak kosong
        return view('pegawai.index', compact('pegawai'))->with('searchTerm', $request->search);
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan formulir untuk menambah data pegawai baru.
     * Mengirimkan daftar unit kerja ke view.
     */
    public function create()
    {
        // Ambil semua data unit kerja untuk dropdown (Opsi A)
        $unit_kerja = UnitKerja::orderBy('nama_unit')->get();
        return view('pegawai.create', compact('unit_kerja'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:pegawai|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'email' => 'nullable|unique:pegawai|email|max:255',
            'nomor_telepon' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:255',
            'unit_kerja_id' => 'nullable|exists:unit_kerja,id', // Validasi untuk Opsi A
            'status_pegawai' => 'nullable|string|max:50',
            'tanggal_bergabung' => 'nullable|date',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        $data = $request->except('foto_profil');
        $data['nip'] = strtoupper($data['nip']); // Pastikan NIP uppercase

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $ekstensi = $file->getClientOriginalExtension();
            $namaFileTersimpan = $data['nip'] . '_foto_profil_' . Str::uuid() . '.' . $ekstensi;

            $path = $file->storeAs('public/foto_profil', $namaFileTersimpan);
            $data['foto_profil_path'] = Storage::url($path);
        }

        Pegawai::create($data);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail data pegawai beserta daftar dokumen aktifnya.
     * Mengirimkan daftar unit kerja ke view untuk form upload dokumen.
     */
    public function show(Pegawai $pegawai)
    {
        // PENTING: Menambahkan filter whereNotIn untuk status_dokumen = 'Dihapus'
        $all_dokumen = $pegawai->dokumen()
                               ->whereNotIn('status_dokumen', ['Dihapus']) // Hanya tampilkan Aktif dan Revisi
                               ->orderBy('jenis_dokumen_id')
                               ->orderBy('versi_dokumen', 'desc')
                               ->get();

        $jenis_dokumen = JenisDokumen::all();
        $unit_kerja = UnitKerja::orderBy('nama_unit')->get();

        return view('pegawai.show', compact('pegawai', 'all_dokumen', 'jenis_dokumen', 'unit_kerja'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan formulir untuk mengedit data pegawai.
     * Mengirimkan daftar unit kerja ke view.
     */
    public function edit(Pegawai $pegawai)
    {
        // Ambil semua data unit kerja untuk dropdown (Opsi A)
        $unit_kerja = UnitKerja::orderBy('nama_unit')->get();
        return view('pegawai.edit', compact('pegawai', 'unit_kerja'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data pegawai di database.
     * Validasi disesuaikan untuk unit_kerja_id.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nip' => 'required|string|max:255|unique:pegawai,nip,' . $pegawai->id,
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email|max:255|unique:pegawai,email,' . $pegawai->id,
            'nomor_telepon' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:255',
            'unit_kerja_id' => 'nullable|exists:unit_kerja,id',
            'status_pegawai' => 'nullable|string|max:50',
            'tanggal_bergabung' => 'nullable|date',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('foto_profil');
        $data['nip'] = strtoupper($data['nip']);

        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada dan bukan default image
            if ($pegawai->foto_profil_path && !Str::contains($pegawai->foto_profil_path, 'default_profile.png')) { // Sesuaikan nama default image jika berbeda
                $oldPath = str_replace('/storage/', 'public/', $pegawai->foto_profil_path);
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }

            $file = $request->file('foto_profil');
            $ekstensi = $file->getClientOriginalExtension();
            $namaFileTersimpan = $data['nip'] . '_foto_profil_' . Str::uuid() . '.' . $ekstensi;
            $path = $file->storeAs('public/foto_profil', $namaFileTersimpan);
            $data['foto_profil_path'] = Storage::url($path);
        } else {
            // Jika tidak ada file baru dan ada permintaan untuk menghapus foto lama
            // (misal, ada checkbox di view untuk menghapus foto)
            if ($request->input('hapus_foto_profil') == '1') {
                 if ($pegawai->foto_profil_path && !Str::contains($pegawai->foto_profil_path, 'default_profile.png')) {
                    $oldPath = str_replace('/storage/', 'public/', $pegawai->foto_profil_path);
                    if (Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }
                }
                $data['foto_profil_path'] = null; // Set path menjadi null
            }
        }

        $pegawai->update($data);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus data pegawai dari database.
     */
    public function destroy(Pegawai $pegawai)
    {
        // Hapus foto profil jika ada
        if ($pegawai->foto_profil_path) {
            $filePath = str_replace('/storage/', 'public/', $pegawai->foto_profil_path);
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }
        // Dokumen terkait pegawai akan otomatis terhapus karena onDelete('cascade') di migrasi dokumen_pegawai
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }
}