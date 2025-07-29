<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatJabatan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_jabatans'; // Pastikan nama tabel benar
    protected $fillable = [
        'pegawai_id',
        'nama_jabatan',
        'eselon_id',
        'unit_kerja_id',
        'tmt_jabatan',
        'nomor_sk',
        'tanggal_sk',
        'keterangan',
    ];

    protected $casts = [
        'tmt_jabatan' => 'date',
        'tanggal_sk' => 'date',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function eselon()
    {
        return $this->belongsTo(Eselon::class);
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }
}
