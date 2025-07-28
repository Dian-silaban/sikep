<?php

namespace App\Http\Controllers;

use App\Models\BezettingKontrakData;
use App\Models\UnitKerja;
use App\Models\Pendidikan;
use App\Models\Eselon; // Make sure this is imported
use Illuminate\Http\Request;

class BezettingKontrakController extends Controller
{
    /**
     * Menampilkan daftar data bezetting kontrak yang sudah ada.
     */
    public function index(Request $request)
    {
        $unitKerjaList = UnitKerja::orderBy('nama_unit')->get();
        $pendidikanList = Pendidikan::orderBy('urutan')->get();
        $eselonList = Eselon::orderBy('urutan')->get(); // <--- ADD THIS LINE: Fetch Eselon data for the dropdowns

        $selectedUnitKerjaId = $request->input('unit_kerja_id');
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));

        $query = BezettingKontrakData::with(['unitKerja', 'pendidikan']);

        if ($selectedUnitKerjaId) {
            $query->where('unit_kerja_id', $selectedUnitKerjaId);
        }
        $query->where('bulan', $selectedMonth)->where('tahun', $selectedYear);

        $dataKontrak = $query->orderBy('unit_kerja_id')->orderBy('pendidikan_id')->get();

        return view('settings.bezetting_kontrak.index', compact(
            'dataKontrak',
            'unitKerjaList',
            'pendidikanList',
            'eselonList', // <--- ADD THIS LINE: Pass eselonList to the view
            'selectedUnitKerjaId',
            'selectedMonth',
            'selectedYear'
        ));
    }

    /**
     * Menampilkan form untuk menambah/mengedit data bezetting kontrak.
     *
     * IMPORTANT: With the new modal approach, this `createEdit` method might not be directly used
     * to render a separate page. The data for modals is usually passed via data-attributes
     * on the edit button, and the 'Add' modal is static.
     * However, if you *do* navigate to this route for a dedicated create/edit page,
     * it's already passing `eselonCategories`, which is good.
     * For consistency with the `index` method's `eselonList`, you might want to change this:
     */
    public function createEdit(Request $request)
    {
        $unitKerjaList = UnitKerja::orderBy('nama_unit')->get();
        $pendidikanList = Pendidikan::orderBy('urutan')->get();

        // This is good, you're already getting `nama_eselon` as an array
        $eselonCategories = Eselon::orderBy('urutan')->pluck('nama_eselon')->toArray();
        // If you want to use the same $eselonList as in index, you could do:
        // $eselonList = Eselon::orderBy('urutan')->get();

        $dataKontrak = null;
        if ($request->has('id')) {
            $dataKontrak = BezettingKontrakData::find($request->id);
        }

        return view('settings.bezetting_kontrak.create_edit', compact(
            'unitKerjaList',
            'pendidikanList',
            'eselonCategories', // Keep this name for now if create_edit.blade.php uses it
            'dataKontrak'
        ));
    }

    /**
     * Menyimpan data bezetting kontrak baru ke storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'unit_kerja_id' => 'required|exists:unit_kerja,id', // Corrected 'unit_kerja' to 'unit_kerjas' table name
            'pendidikan_id' => 'nullable|exists:pendidikans,id',
            // Validate 'eselon_category' against existing 'nama_eselon' in the 'eselons' table
            'eselon_category' => 'required|string|max:50|exists:eselons,nama_eselon',
            'jumlah_pegawai' => 'required|integer|min:0',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);

        $data = $request->only([
            'unit_kerja_id',
            'pendidikan_id',
            'eselon_category',
            'jumlah_pegawai',
            'bulan',
            'tahun'
        ]);
        $data['golongan_category'] = 'KONTRAK';

        $existingData = BezettingKontrakData::where('unit_kerja_id', $data['unit_kerja_id'])
                                            ->where('pendidikan_id', $data['pendidikan_id'])
                                            ->where('eselon_category', $data['eselon_category'])
                                            ->where('bulan', $data['bulan'])
                                            ->where('tahun', $data['tahun'])
                                            ->first();

        if ($existingData) {
            return redirect()->back()->withErrors(['duplicate' => 'Data untuk kombinasi Unit Kerja, Pendidikan, Kategori Eselon, Bulan, dan Tahun ini sudah ada. Harap edit data yang sudah ada.'])->withInput();
        }

        BezettingKontrakData::create($data);

        return redirect()->route('settings.bezetting_kontrak.index')->with('success', 'Data bezetting kontrak berhasil ditambahkan.');
    }

    /**
     * Memperbarui data bezetting kontrak yang ada di storage.
     */
    public function update(Request $request, BezettingKontrakData $bezettingKontrakData)
    {
        $request->validate([
            'unit_kerja_id' => 'required|exists:unit_kerja,id', // Corrected 'unit_kerja' to 'unit_kerjas' table name
            'pendidikan_id' => 'nullable|exists:pendidikans,id',
            'eselon_category' => 'required|string|max:50|exists:eselons,nama_eselon', // Validate against existing 'nama_eselon'
            'jumlah_pegawai' => 'required|integer|min:0',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);

        $data = $request->only([
            'unit_kerja_id',
            'pendidikan_id',
            'eselon_category',
            'jumlah_pegawai',
            'bulan',
            'tahun'
        ]);
        $data['golongan_category'] = 'KONTRAK';

        $existingData = BezettingKontrakData::where('unit_kerja_id', $data['unit_kerja_id'])
                                            ->where('pendidikan_id', $data['pendidikan_id'])
                                            ->where('eselon_category', $data['eselon_category'])
                                            ->where('bulan', $data['bulan'])
                                            ->where('tahun', $data['tahun'])
                                            ->where('id', '!=', $bezettingKontrakData->id)
                                            ->first();

        if ($existingData) {
            return redirect()->back()->withErrors(['duplicate' => 'Data untuk kombinasi Unit Kerja, Pendidikan, Kategori Eselon, Bulan, dan Tahun ini sudah ada. Harap edit data yang sudah ada.'])->withInput();
        }

        $bezettingKontrakData->update($data);

        return redirect()->route('settings.bezetting_kontrak.index')->with('success', 'Data bezetting kontrak berhasil diperbarui.');
    }

    /**
     * Menghapus data bezetting kontrak.
     */
    public function destroy(BezettingKontrakData $bezettingKontrakData)
    {
        $bezettingKontrakData->delete();
        return redirect()->route('settings.bezetting_kontrak.index')->with('success', 'Data bezetting kontrak berhasil dihapus.');
    }
}