<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPendidikan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pendidikans'; // Pastikan nama tabel benar
    protected $fillable = [
        'pegawai_id',
        'pendidikan_id',
        'nama_institusi',
        'jurusan',
        'tahun_lulus',
        'nomor_ijazah',
        'tgl_ijazah',
        'keterangan',
    ];

    protected $casts = [
        'tgl_ijazah' => 'date',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class);
    }
}
