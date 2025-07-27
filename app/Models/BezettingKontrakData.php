<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BezettingKontrakData extends Model
{
    use HasFactory;

    protected $table = 'bezetting_kontrak_data';

    protected $fillable = [
        'unit_kerja_id',
        'pendidikan_id',
        'eselon_category',
        'golongan_category',
        'jumlah_pegawai',
        'bulan',
        'tahun',
    ];

    /**
     * Relasi many-to-one: Data ini terkait dengan satu unit kerja.
     */
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    /**
     * Relasi many-to-one: Data ini terkait dengan satu jenis pendidikan.
     */
    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class);
    }
}
