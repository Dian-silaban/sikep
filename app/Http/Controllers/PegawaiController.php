<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\JenisDokumen;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Exports\PegawaiExport;  
use Maatwebsite\Excel\Facades\Excel;



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

    $query = Pegawai::with('unit_kerja')->orderBy('nama_lengkap');

    // Filter pencarian
    if ($searchTerm) {
        $query->where(function ($q) use ($searchTerm) {
            $q->where('nama_lengkap', 'like', '%' . $searchTerm . '%')
              ->orWhere('nip', 'like', '%' . $searchTerm . '%')
              ->orWhere('jabatan', 'like', '%' . $searchTerm . '%')
              ->orWhereHas('unit_kerja', function ($q_unit) use ($searchTerm) {
                  $q_unit->where('nama_unit', 'like', '%' . $searchTerm . '%');
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

    return view('pegawai.index', compact(
        'pegawai',
        'searchTerm',
        'unitKerjaFilter',
        'statusFilter',
        'unitKerjaList',
        'totalPegawai',
        'pegawaiAktif',
        'pegawaiNonAktif',
        'pegawaiPensiun'

    ));

    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan formulir untuk menambah data pegawai baru.
     * Mengirimkan daftar unit kerja ke view.
     */
    public function create()
    {
        $unit_kerja = UnitKerja::orderBy('nama_unit')->get();
        return view('pegawai.create', compact('unit_kerja'));
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan data pegawai baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:pegawai|string|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:50',
            'alamat' => 'required|string',
            'email' => 'required|unique:pegawai|email|max:255',
            'nomor_telepon' => 'required|regex:/^\d{12}$/', // Tepat 12 digit
            'jabatan' => 'required|string|max:255',
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
            'status_pegawai' => 'required|string|max:50',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nik' => 'nullable|string|size:16|unique:pegawai,nik', // Validasi NIK
            'golongan_pangkat' => 'nullable|string|max:50', // Validasi Gol
        ]);

        $data = $request->except('foto_profil');
        $data['nip'] = strtoupper($data['nip']);  
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $ekstensi = $file->getClientOriginalExtension();
            $namaFileTersimpan = $data['nip'] . '_foto_profil_' . Str::uuid() . '.' . $ekstensi;

            $path = $file->storeAs('public/foto_profil', $namaFileTersimpan);
            $data['foto_profil_path'] = Storage::url($path);
        } else {
            // Logika untuk foto profil default berdasarkan jenis kelamin
            if ($request->input('jenis_kelamin') == 'Perempuan') {
                $data['foto_profil_path'] = asset('img/wanita.jpg');
            } else {
                $data['foto_profil_path'] = asset('img/pria.jpg');
            }
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
            'nip' => 'required|string|digits:16|unique:pegawai,nip,' . $pegawai->id,
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:50',
            'alamat' => 'required|string',
            'email' => 'required|email|max:255|unique:pegawai,email,' . $pegawai->id,
            'nomor_telepon' => 'required|regex:/^\d{12}$/', // Tepat 12 digit
            'jabatan' => 'required|string|max:255',
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
            'status_pegawai' => 'required|string|max:50',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nik' => 'nullable|string|size:16|unique:pegawai,nik,' . $pegawai->id, // Validasi NIK
            'golongan_pangkat' => 'nullable|string|max:50', // Validasi Gol
        ]);

        $data = $request->except('foto_profil', '_redirect_to', 'hapus_foto_profil');
        $data['nip'] = strtoupper($data['nip']);

        if ($request->hasFile('foto_profil')) {
            // Hapus foto profil lama jika ada dan bukan foto default
            if ($pegawai->foto_profil_path && !Str::contains($pegawai->foto_profil_path, 'pria.jpg') && !Str::contains($pegawai->foto_profil_path, 'wanita.jpg')) {
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
            // Logika penghapusan foto profil atau kembali ke default
            if ($request->input('hapus_foto_profil') == '1') {
                // Hapus foto lama jika ada dan bukan foto default
                if ($pegawai->foto_profil_path && !Str::contains($pegawai->foto_profil_path, 'pria.jpg') && !Str::contains($pegawai->foto_profil_path, 'wanita.jpg')) {
                    $oldPath = str_replace('/storage/', 'public/', $pegawai->foto_profil_path);
                    if (Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }
                }
                
                if ($pegawai->jenis_kelamin == 'Perempuan') {  
                    $data['foto_profil_path'] = asset('img/wanita.jpg');
                } else {
                    $data['foto_profil_path'] = asset('img/pria.jpg');
                }
            }
            
            else if (!$request->hasFile('foto_profil') && !isset($data['foto_profil_path'])) {
                $data['foto_profil_path'] = $pegawai->foto_profil_path;
            }
        }

        $pegawai->update($data);

        if ($request->has('_redirect_to') && URL::isValidUrl($request->_redirect_to)) {
            return redirect($request->_redirect_to)->with('success', 'Data pegawai berhasil diperbarui.');
        }

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus data pegawai dari database.
     */
    public function destroy(Pegawai $pegawai)
    {
        // 1. Hapus foto profil pegawai jika ada dan BUKAN foto default
        if ($pegawai->foto_profil_path && !Str::contains($pegawai->foto_profil_path, 'pria.jpg') && !Str::contains($pegawai->foto_profil_path, 'wanita.jpg')) {
            $filePathFoto = str_replace('/storage/', 'public/', $pegawai->foto_profil_path);
            if (Storage::exists($filePathFoto)) {
                Storage::delete($filePathFoto);
            }
        }

        // 2. Hapus semua file dokumen terkait pegawai
        foreach ($pegawai->dokumen as $dokumen) {
            $filePathDokumen = str_replace('/storage/', 'public/', $dokumen->path_file);
            if (Storage::exists($filePathDokumen)) {
                Storage::delete($filePathDokumen);
            }
        }

        // 3. Hapus folder dokumen pegawai jika ada
        $folderPath = 'public/dokumen_pegawai/' . $pegawai->nip;
        if (Storage::exists($folderPath)) {
            Storage::deleteDirectory($folderPath);
        }

        // 4. Hapus data pegawai dari database
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }


    public function exportExcel(Request $request)
    {
        // Mendefinisikan semua kolom yang mungkin bisa diekspor beserta nama tampilannya.
        // Kunci adalah nama kolom database/relasi, nilai adalah nama tampilan di Excel.
        $allExportColumns = [
            'id' => 'ID Pegawai',
            'nip' => 'NIP',
            'nama_lengkap' => 'Nama Lengkap',
            'nomor_telepon' => 'No. Telepon',
            'nik' => 'NIK', // Aktifkan jika kolom NIK ada di DB Anda
            'golongan_pangkat' => 'Pangkat',
            'unit_kerja.nama_unit' => 'Unit Kerja', // Mengakses relasi
            'jabatan' => 'Jabatan',
            'status_pegawai' => 'Status Pegawai',
            'alamat' => 'Alamat',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'email' => 'Email',
            // 'foto_profil_path' => 'Path Foto Profil',
            'created_at' => 'Tanggal Dibuat',
            'updated_at' => 'Tanggal Diperbarui',
        ];

        // Dapatkan kolom yang dipilih dari request. Jika tidak ada, ekspor semua.
        $selectedColumnsRaw = $request->input('columns', array_keys($allExportColumns));
        
        // Filter kolom yang dipilih untuk memastikan hanya kolom yang valid yang masuk
        $selectedColumns = array_filter($selectedColumnsRaw, function($col) use ($allExportColumns) {
            return array_key_exists($col, $allExportColumns);
        });

        // Dapatkan filter dari request (dari modal)
        $filters = [
            'status' => $request->input('status_filter'),
            'unit_kerja_id' => $request->input('unit_kerja_filter'),
        ];

        // Buat instance PegawaiExport dengan kolom dan filter yang dipilih
        return Excel::download(new PegawaiExport($selectedColumns, $filters, $allExportColumns), 'pegawai_data_'.date('Ymd_His').'.xlsx');
    }
}
