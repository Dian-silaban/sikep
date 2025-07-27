<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $fillable = [
        'nip',
        'nama_lengkap',
        'tanggal_lahir',
        'tmt', // Ini adalah TMT umum/awal pegawai
        'jenis_kelamin',
        'alamat',
        'email',
        'nomor_telepon',
        'unit_kerja_id',
        'status_pegawai',
        'tmt_status', // BARU: Tambahkan kolom TMT Status
        'foto_profil_path',
        'nik',
        'golongan_id',
        'jabatan',
        'eselon_id',
        'pendidikan_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tmt' => 'date',
        'tmt_status' => 'date', // BARU: Cast TMT Status sebagai tanggal
    ];

    /**
     * Relasi many-to-one: Pegawai ini memiliki satu unit kerja.
     */
    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    /**
     * Relasi one-to-many: Pegawai ini memiliki banyak dokumen.
     */
    public function dokumen()
    {
        return $this->hasMany(DokumenPegawai::class);
    }

    /**
     * Relasi many-to-one: Pegawai ini memiliki satu golongan.
     */
    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    /**
     * Relasi many-to-one: Pegawai ini memiliki satu eselon.
     */
    public function eselon()
    {
        return $this->belongsTo(Eselon::class);
    }

    /**
     * Relasi many-to-one: Pegawai ini memiliki satu jenis pendidikan.
     */
    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class);
    }
}
