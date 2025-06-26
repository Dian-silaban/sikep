<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPegawai extends Model
{
    use HasFactory;

    protected $table = 'dokumen_pegawai';
    protected $fillable = [
        'pegawai_id', 'jenis_dokumen_id', 'nama_file_asli',
        'nama_file_tersimpan', 'path_file', 'tanggal_upload',
        'versi_dokumen', 'status_dokumen', 'keterangan'
    ];

    protected $casts = [
        'tanggal_upload' => 'datetime', // Otomatis casting ke Carbon instance
    ];

    /**
     * Relasi many-to-one: Dokumen ini milik satu pegawai.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    /**
     * Relasi many-to-one: Dokumen ini memiliki satu jenis dokumen.
     */
    public function jenis_dokumen()
    {
        return $this->belongsTo(JenisDokumen::class);
    }
}