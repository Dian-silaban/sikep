<!DOCTYPE html>
<html>
<head>
    <title>Daftar Jaga Usulan Kenaikan Pangkat</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: sans-serif;
            font-size: 10pt;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .header-title {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }
        .sub-header {
            font-size: 12pt;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header-title">DAFTAR JAGA USULAN KENAIKAN PANGKAT</div>
    <div class="sub-header">BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH KOTA METRO</div>
    <div class="sub-header">PERIODE: {{ $month ? \Carbon\Carbon::createFromDate(null, $month, 1)->translatedFormat('F') : 'Semua Bulan' }} {{ $year }}</div>
    <div class="sub-header">UNIT KERJA: {{ $unitKerjaName }}</div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">NAMA/NIP</th>
                <th rowspan="2">PANGKAT/GOLONGAN</th>
                <th rowspan="2">TMT</th>
                <th colspan="{{ count($proyeksiYears) }}">TAHUN</th>
                <th rowspan="2">KET</th>
            </tr>
            <tr>
                @foreach ($proyeksiYears as $y)
                    <th>{{ $y }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($usulanKenaikanPangkatData as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">
                        {{ $data['pegawai']->nama_lengkap }}<br>
                        {{ $data['pegawai']->nip }}
                    </td>
                    <td>{{ $data['pegawai']->golongan->nama_golongan ?? '-' }}</td>
                    <td>{{ $data['pegawai']->tgl_usulan_kp_awal ? \Carbon\Carbon::parse($data['pegawai']->tgl_usulan_kp_awal)->format('d-m-Y') : '-' }}</td>
                    @foreach ($proyeksiYears as $y)
                        <td>{{ $data['proyeksi'][$y] ?? '-' }}</td>
                    @endforeach
                    <td>-</td> {{-- Kolom Keterangan --}}
                </tr>
            @empty
                <tr>
                    <td colspan="{{ 4 + count($proyeksiYears) + 1 }}">Tidak ada data usulan kenaikan pangkat untuk filter ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
