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
        'tmt',
        'jenis_kelamin',
        'alamat',
        'email',
        'nomor_telepon',
        'unit_kerja_id',
        'status_pegawai',
        'tmt_status',
        'tgl_usulan_berkala_awal', // BARU
        'tgl_usulan_kp_awal',      // BARU
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
        'tmt_status' => 'date',
        'tgl_usulan_berkala_awal' => 'date', // BARU
        'tgl_usulan_kp_awal' => 'date',      // BARU
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

    // Relasi one-to-many untuk Riwayat
    public function riwayatGolongan()
    {
        return $this->hasMany(RiwayatGolongan::class);
    }

    public function riwayatJabatan()
    {
        return $this->hasMany(RiwayatJabatan::class);
    }

    public function riwayatPendidikan()
    {
        return $this->hasMany(RiwayatPendidikan::class);
    }
}
