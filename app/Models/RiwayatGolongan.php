<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatGolongan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_golongans'; // Pastikan nama tabel benar
    protected $fillable = [
        'pegawai_id',
        'golongan_id',
        'tmt_golongan',
        'nomor_sk',
        'tanggal_sk',
        'keterangan',
    ];

    protected $casts = [
        'tmt_golongan' => 'date',
        'tanggal_sk' => 'date',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }
}
