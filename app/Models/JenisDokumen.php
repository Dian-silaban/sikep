<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    use HasFactory;

    protected $table = 'jenis_dokumen';
    protected $fillable = ['nama_jenis', 'deskripsi'];

    public function dokumen_pegawai()
    {
        return $this->hasMany(DokumenPegawai::class);
    }
}