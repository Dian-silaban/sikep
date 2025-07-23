<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = [
        'nip', 'nama_lengkap', 'tanggal_lahir', 'jenis_kelamin', 'alamat',
        'email', 'nomor_telepon', 'jabatan', 'unit_kerja_id', 'status_pegawai',
        'tanggal_bergabung', 'foto_profil_path'
    ];

    // Supaya kolom tanggal otomatis jadi Carbon (DateTime)
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_bergabung' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function dokumen()
    {
        return $this->hasMany(DokumenPegawai::class);
    }

    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }
}
