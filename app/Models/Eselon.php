<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Eselon extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['nama_eselon', 'urutan'];

    /**
     * Relasi one-to-many: Satu eselon bisa dimiliki oleh banyak pegawai.
     */
    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}
