<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_golongan', 'keterangan', 'urutan'];

    /**
     * Relasi one-to-many: Satu golongan bisa dimiliki oleh banyak pegawai.
     */
    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}
