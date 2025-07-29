<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\JenisDokumen; // Tidak digunakan di sini, bisa dihapus jika tidak ada metode lain yang menggunakannya
use App\Models\UnitKerja;
use App\Models\Golongan;
use App\Models\Pendidikan;
use App\Models\Eselon;
use App\Models\BezettingKontrakData; // Tidak digunakan di sini, bisa dihapus jika tidak ada metode lain yang menggunakannya
use Illuminate\Support\Facades\Auth; // Tidak digunakan di sini, bisa dihapus jika tidak ada metode lain yang menggunakannya
use Illuminate\Support\Facades\Gate; // Tidak digunakan di sini, bisa dihapus jika tidak ada metode lain yang menggunakannya
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL; // Sudah ada
use App\Exports\PegawaiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException; // <-- PENTING: Tambahkan ini

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua data pegawai, dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->search;
        $unitKerjaFilter = $request->unit_kerja;
        $statusFilter = $request->status_pegawai;

        // Eager load relasi unit_kerja, golongan, pendidikan, dan eselon
        $query = Pegawai::with(['unit_kerja', 'golongan', 'pendidikan', 'eselon'])->orderBy('nama_lengkap');

        // Filter pencarian
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_lengkap', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nip', 'like', '%' . $searchTerm . '%')
                    ->orWhere('jabatan', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('unit_kerja', function ($q_unit) use ($searchTerm) {
                        $q_unit->where('nama_unit', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('eselon', function ($q_eselon) use ($searchTerm) {
                        $q_eselon->where('nama_eselon', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        // Filter unit kerja
        if ($unitKerjaFilter) {
            $query->where('unit_kerja_id', $unitKerjaFilter);
        }

        // Filter status pegawai
        if ($statusFilter) {
            $query->where('status_pegawai', $statusFilter);
        }

        $pegawai = $query->paginate(10);

        $totalPegawai = Pegawai::count();
        $pegawaiAktif = Pegawai::where('status_pegawai', 'Aktif')->count();
        $pegawaiNonAktif = Pegawai::where('status_pegawai', 'Non-aktif')->count();
        $pegawaiPensiun = Pegawai::where('status_pegawai', 'Pensiun')->count();

        $unitKerjaList = UnitKerja::orderBy('nama_unit')->get();

        // Data untuk dropdown modal (add & edit)
        $golongans = Golongan::orderBy('urutan')->get();
        $pendidikans = Pendidikan::orderBy('urutan')->get();
        $eselons = Eselon::orderBy('urutan')->get();

        return view('pegawai.index', compact(
            'pegawai',
            'searchTerm',
            'unitKerjaFilter',
            'statusFilter',
            'unitKerjaList',
            'totalPegawai',
            'pegawaiAktif',
            'pegawaiNonAktif',
            'pegawaiPensiun',
            'golongans',
            'pendidikans',
            'eselons'
        ));
    }

    /**
     * Show the form for creating a new resource.
     * Metode ini tidak lagi digunakan jika Anda sepenuhnya menggunakan modal untuk tambah data.
     * Jika Anda masih memiliki route 'pegawai.create' yang mengarah ke file create.blade.php,
     * maka biarkan metode ini. Namun, disarankan untuk menghapus route dan file create.blade.php
     * jika modal sudah diimplementasikan.
     */
    public function create()
    {
        $unit_kerja = UnitKerja::orderBy('nama_unit')->get();
        $golongans = Golongan::orderBy('urutan')->get();
        $pendidikans = Pendidikan::orderBy('urutan')->get();
        $eselons = Eselon::orderBy('urutan')->get();

        return view('pegawai.create', compact('unit_kerja', 'golongans', 'pendidikans', 'eselons'));
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan data pegawai baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'nip' => 'required|string|digits:16|unique:pegawai,nip',
                'nik' => 'nullable|string|size:16|unique:pegawai,nik',
                'nama_lengkap' => 'required|string|max:255',
                'tanggal_lahir' => 'nullable|date', // Berdasarkan form Anda, ini mungkin nullable
                'tmt' => 'nullable|date',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan', // Menggunakan 'in' lebih tepat daripada string|max:50
                'alamat' => 'required|string',
                'email' => 'nullable|email|max:255|unique:pegawai,email', // Berdasarkan form Anda, ini mungkin nullable
                'nomor_telepon' => 'nullable|string|max:20', // Mengurangi kekakuan regex, ganti jika perlu regex spesifik
                'jabatan' => 'nullable|string|max:255', // Berdasarkan form Anda, ini mungkin nullable
                'unit_kerja_id' => 'nullable|exists:unit_kerja,id', // <-- PASTIKAN NAMA TABEL BENAR (unit_kerjas atau unit_kerja)
                'status_pegawai' => 'nullable|in:Aktif,Non-aktif,Pensiun', // Berdasarkan form Anda, ini mungkin nullable
                'tmt_status' => 'nullable|date',
                'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'golongan_id' => 'nullable|exists:golongans,id',
                'eselon_id' => 'nullable|exists:eselons,id',
                'pendidikan_id' => 'nullable|exists:pendidikans,id',
                'reset_foto_profil' => 'sometimes|boolean', // Untuk checkbox reset di modal tambah (jika diimplementasikan)
            ];

            $validatedData = $request->validate($rules);

            $dataToCreate = $validatedData; // Gunakan data yang sudah divalidasi

            // Konversi NIP ke uppercase
            $dataToCreate['nip'] = strtoupper($dataToCreate['nip']);

            // Hapus 'reset_foto_profil' dari data karena hanya untuk frontend
            unset($dataToCreate['reset_foto_profil']);

            // Penanganan foto profil
            if ($request->hasFile('foto_profil')) {
                $file = $request->file('foto_profil');
                $ekstensi = $file->getClientOriginalExtension();
                $namaFileTersimpan = $dataToCreate['nip'] . '_foto_profil_' . Str::uuid() . '.' . $ekstensi;
                $path = $file->storeAs('public/foto_profil', $namaFileTersimpan);
                $dataToCreate['foto_profil_path'] = Storage::url($path);
            } else {
                // Set foto profil default jika tidak ada file diunggah
                $dataToCreate['foto_profil_path'] = asset('img/' . ($dataToCreate['jenis_kelamin'] == 'Perempuan' ? 'wanita.jpg' : 'pria.jpg'));
            }

            Pegawai::create($dataToCreate);

            // Respon untuk AJAX atau non-AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Data pegawai berhasil ditambahkan!'], 201);
            }

            // Fallback untuk non-AJAX (jika tombol add bukan modal atau AJAX gagal)
            return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');

        } catch (ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail data pegawai beserta daftar dokumen aktifnya.
     */
    public function show(Pegawai $pegawai)
    {
        $pegawai->load(['unit_kerja', 'golongan', 'pendidikan', 'eselon']);

        $all_dokumen = $pegawai->dokumen()
            ->whereNotIn('status_dokumen', ['Dihapus'])
            ->orderBy('jenis_dokumen_id')
            ->orderBy('versi_dokumen', 'desc')
            ->get();

        // Pastikan Anda memuat semua data yang dibutuhkan view
        $jenis_dokumen = JenisDokumen::all(); // Pastikan model ini ada
        $unitKerjaList = UnitKerja::orderBy('nama_unit')->get();
        $golongans = Golongan::orderBy('urutan')->get();
        $pendidikans = Pendidikan::orderBy('urutan')->get();
        $eselons = Eselon::orderBy('urutan')->get();

        return view('pegawai.show', compact('pegawai', 'all_dokumen', 'jenis_dokumen', 'unitKerjaList', 'golongans', 'pendidikans', 'eselons'));
    }

    /**
     * Show the form for editing the specified resource.
     * Metode ini tidak lagi digunakan jika Anda sepenuhnya menggunakan modal untuk edit data.
     * Jika Anda masih memiliki route 'pegawai.edit' yang mengarah ke file edit.blade.php,
     * maka biarkan metode ini. Namun, disarankan untuk menghapus route dan file edit.blade.php
     * jika modal sudah diimplementasikan.
     */
    public function edit(Pegawai $pegawai)
    {
        $unit_kerja = UnitKerja::orderBy('nama_unit')->get();
        $golongans = Golongan::orderBy('urutan')->get();
        $pendidikans = Pendidikan::orderBy('urutan')->get();
        $eselons = Eselon::orderBy('urutan')->get();

        return view('pegawai.edit', compact('pegawai', 'unit_kerja', 'golongans', 'pendidikans', 'eselons'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data pegawai di database.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        try {
            $rules = [
                'nip' => [
                    'required',
                    'string',
                    'digits:16',
                    Rule::unique('pegawai')->ignore($pegawai->id),
                ],
                'nama_lengkap' => 'required|string|max:255',
                'tanggal_lahir' => 'nullable|date',
                'tmt' => 'nullable|date',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'alamat' => 'required|string',
                'email' => [
                    'nullable', // Berdasarkan form Anda, ini mungkin nullable
                    'email',
                    'max:255',
                    Rule::unique('pegawai')->ignore($pegawai->id),
                ],
                'nomor_telepon' => 'nullable|string|max:20', // Mengurangi kekakuan regex
                'jabatan' => 'nullable|string|max:255', // Berdasarkan form Anda, ini mungkin nullable
                'unit_kerja_id' => 'nullable|exists:unit_kerja,id', // <-- PASTIKAN NAMA TABEL BENAR
                'status_pegawai' => 'nullable|in:Aktif,Non-aktif,Pensiun', // Berdasarkan form Anda, ini mungkin nullable
                'tmt_status' => 'nullable|date',
                'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'nik' => [
                    'nullable',
                    'string',
                    'size:16',
                    Rule::unique('pegawai')->ignore($pegawai->id),
                ],
                'golongan_id' => 'nullable|exists:golongans,id',
                'eselon_id' => 'nullable|exists:eselons,id',
                'pendidikan_id' => 'nullable|exists:pendidikans,id',
                'hapus_foto_profil' => 'sometimes|boolean', // Menangkap checkbox "Delete Avatar"
            ];

            $validatedData = $request->validate($rules);

            $dataToUpdate = $validatedData;

            // Konversi NIP ke uppercase
            $dataToUpdate['nip'] = strtoupper($dataToUpdate['nip']);

            // Penanganan foto profil di update
            if ($request->has('hapus_foto_profil') && $request->input('hapus_foto_profil')) {
                // Jika checkbox 'Delete Avatar' dicentang
                if ($pegawai->foto_profil_path && !Str::contains($pegawai->foto_profil_path, ['pria.jpg', 'wanita.jpg'])) {
                    $oldPath = str_replace('/storage/', 'public/', $pegawai->foto_profil_path);
                    if (Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }
                }
                $dataToUpdate['foto_profil_path'] = asset('img/' . ($pegawai->jenis_kelamin == 'Perempuan' ? 'wanita.jpg' : 'pria.jpg'));
            } elseif ($request->hasFile('foto_profil')) {
                // Jika ada file foto baru diunggah
                if ($pegawai->foto_profil_path && !Str::contains($pegawai->foto_profil_path, ['pria.jpg', 'wanita.jpg'])) {
                    $oldPath = str_replace('/storage/', 'public/', $pegawai->foto_profil_path);
                    if (Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }
                }
                $file = $request->file('foto_profil');
                $ekstensi = $file->getClientOriginalExtension();
                $namaFileTersimpan = $dataToUpdate['nip'] . '_foto_profil_' . Str::uuid() . '.' . $ekstensi;
                $path = $file->storeAs('public/foto_profil', $namaFileTersimpan);
                $dataToUpdate['foto_profil_path'] = Storage::url($path);
            } else {
                // Jika tidak ada foto baru dan tidak ada permintaan hapus, pertahankan path yang sudah ada
                // Pastikan foto_profil_path tidak di unset jika tidak ada perubahan
                $dataToUpdate['foto_profil_path'] = $pegawai->foto_profil_path;
            }
            
            // Hapus 'foto_profil' dari dataToUpdate karena sudah ditangani secara terpisah
            unset($dataToUpdate['foto_profil']);


            $pegawai->update($dataToUpdate);

            // Respon untuk AJAX atau non-AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Data pegawai berhasil diperbarui!'], 200);
            }

            // Fallback untuk non-AJAX
            return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');

        } catch (ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Gagal memperbarui data pegawai: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Gagal memperbarui data pegawai: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus data pegawai dari database.
     */
    public function destroy(Pegawai $pegawai)
    {
        // Hapus foto profil jika bukan default
        if ($pegawai->foto_profil_path && !Str::contains($pegawai->foto_profil_path, ['pria.jpg', 'wanita.jpg'])) {
            $filePathFoto = str_replace('/storage/', 'public/', $pegawai->foto_profil_path);
            if (Storage::exists($filePathFoto)) {
                Storage::delete($filePathFoto);
            }
        }

        // Hapus dokumen terkait pegawai
        foreach ($pegawai->dokumen as $dokumen) {
            $filePathDokumen = str_replace('/storage/', 'public/', $dokumen->path_file);
            if (Storage::exists($filePathDokumen)) {
                Storage::delete($filePathDokumen);
            }
        }

        // Hapus folder dokumen pegawai jika ada
        $folderPath = 'public/dokumen_pegawai/' . $pegawai->nip;
        if (Storage::exists($folderPath)) {
            Storage::deleteDirectory($folderPath);
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        $allExportColumns = [
            'id' => 'ID Pegawai',
            'nip' => 'NIP',
            'nama_lengkap' => 'Nama Lengkap',
            'nomor_telepon' => 'No. Telepon',
            'nik' => 'NIK',
            'tmt' => 'TMT',
            'tmt_status' => 'TMT Status',
            'golongan.nama_golongan' => 'Pangkat',
            'unit_kerja.nama_unit' => 'Unit Kerja',
            'jabatan' => 'Jabatan',
            'status_pegawai' => 'Status Pegawai',
            'alamat' => 'Alamat',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'email' => 'Email',
            'created_at' => 'Tanggal Dibuat',
            'updated_at' => 'Tanggal Diperbarui',
            'eselon.nama_eselon' => 'Eselon',
            'pendidikan.nama_pendidikan' => 'Pendidikan',
        ];

        $selectedColumnsRaw = $request->input('columns', array_keys($allExportColumns));
        $selectedColumns = array_filter($selectedColumnsRaw, function ($col) use ($allExportColumns) {
            return array_key_exists($col, $allExportColumns);
        });

        $filters = [
            'status' => $request->input('status_filter'),
            'unit_kerja_id' => $request->input('unit_kerja_filter'),
        ];

        return Excel::download(new PegawaiExport($selectedColumns, $filters, $allExportColumns), 'pegawai_data_' . date('Ymd_His') . '.xlsx');
    }
}