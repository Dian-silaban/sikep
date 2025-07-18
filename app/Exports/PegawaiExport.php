<?php

namespace App\Exports;

use App\Models\Pegawai; // Pastikan ini di-use
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // Tambahkan ini jika ingin header kolom
use Maatwebsite\Excel\Concerns\WithMapping; // Tambahkan ini jika ingin memformat kolom

class PegawaiExport implements FromCollection, WithHeadings, WithMapping // Implement WithHeadings & WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Mengambil semua data pegawai dari database
        // Anda bisa menambahkan filter atau search di sini jika diperlukan
        return Pegawai::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Mendefinisikan nama-nama header kolom di Excel
        return [
            'ID',
            'NIP',
            'Nama Lengkap',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat',
            'Email',
            'Nomor Telepon',
            'Jabatan',
            'ID Unit Kerja', // Ini akan menjadi ID
            'Status Pegawai',
            'Tanggal Bergabung',
            'Foto Profil Path',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * @param mixed $pegawai
     * @return array
     */
    public function map($pegawai): array
    {
     
        return [
            $pegawai->id,
            ' ' . $pegawai->nip,
            $pegawai->nama_lengkap,
            \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d-m-Y'), // Format tanggal
            $pegawai->jenis_kelamin,
            $pegawai->alamat,
            $pegawai->email,
            $pegawai->nomor_telepon,
            $pegawai->jabatan,
            $pegawai->unit_kerja_id,  
            $pegawai->status_pegawai,
            \Carbon\Carbon::parse($pegawai->tanggal_bergabung)->format('d-m-Y'), // Format tanggal
            $pegawai->foto_profil_path,
            $pegawai->created_at ? $pegawai->created_at->format('d-m-Y H:i:s') : '-',
            $pegawai->updated_at ? $pegawai->updated_at->format('d-m-Y H:i:s') : '-',
        ];
    }
}