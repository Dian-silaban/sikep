<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pendidikan', 'jenjang', 'urutan'];

    /**
     * Relasi one-to-many: Satu jenis pendidikan bisa dimiliki oleh banyak pegawai.
     */
    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}
