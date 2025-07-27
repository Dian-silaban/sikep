<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bezetting Pegawai</title>
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
        .total-row {
            background-color: #d0e7ff; /* Light blue */
            font-weight: bold;
        }
        .contract-row {
            background-color: #e9ecef; /* Light gray */
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header-title">BEZETTING PEGAWAI BPKAD KOTA METRO</div>
    <div class="sub-header">BULAN {{ strtoupper(\Carbon\Carbon::createFromDate(null, $month, 1)->translatedFormat('F Y')) }}</div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">GOLONGAN</th>
                <th colspan="5">ESELON</th>
                <th colspan="8">PENDIDIKAN</th>
                <th rowspan="2">JUMLAH</th>
            </tr>
            <tr>
                <th>I</th>
                <th>II</th>
                <th>III</th>
                <th>IV</th>
                <th>JFU</th>
                <th>SD</th>
                <th>SMP</th>
                <th>SMA</th>
                <th>D-I</th>
                <th>D-II</th>
                <th>D-III</th>
                <th>S-1</th>
                <th>S-2</th>
            </tr>
        </thead>
        <tbody>
            @php
                $golonganOrder = ['IV A', 'IV B', 'IV C', 'IV D', 'III A', 'III B', 'III C', 'III D', 'II A', 'II B', 'II C', 'II D', 'I A', 'I B', 'I C', 'I D'];
                $eselonColumns = ['I', 'II', 'III', 'IV', 'JFU'];
                $pendidikanColumns = ['SD', 'SMP', 'SMA', 'D-I', 'D-II', 'D-III', 'S-1', 'S-2'];
                $grandTotalEselon = array_fill_keys($eselonColumns, 0);
                $grandTotalPendidikan = array_fill_keys($pendidikanColumns, 0);
                $grandTotalJumlah = 0;
            @endphp

            @foreach ($golonganOrder as $golongan)
                @if (isset($bezettingData[$golongan]))
                    <tr>
                        <td>{{ $bezettingData[$golongan]['golongan'] }}</td>
                        @foreach ($eselonColumns as $eselon)
                            <td>{{ $bezettingData[$golongan]['eselon'][$eselon] }}</td>
                            @php $grandTotalEselon[$eselon] += $bezettingData[$golongan]['eselon'][$eselon]; @endphp
                        @endforeach
                        @foreach ($pendidikanColumns as $pendidikan)
                            <td>{{ $bezettingData[$golongan]['pendidikan'][$pendidikan] }}</td>
                            @php $grandTotalPendidikan[$pendidikan] += $bezettingData[$golongan]['pendidikan'][$pendidikan]; @endphp
                        @endforeach
                        <td>{{ $bezettingData[$golongan]['total_golongan'] }}</td>
                        @php $grandTotalJumlah += $bezettingData[$golongan]['total_golongan']; @endphp
                    </tr>
                @else
                    <tr>
                        <td>{{ $golongan }}</td>
                        @foreach ($eselonColumns as $eselon) <td>0</td> @endforeach
                        @foreach ($pendidikanColumns as $pendidikan) <td>0</td> @endforeach
                        <td>0</td>
                    </tr>
                @endif
            @endforeach

            {{-- Baris untuk Golongan IX dan V (jika ada di data Anda) --}}
            @foreach (['IX', 'V'] as $golonganKhusus)
                @if (isset($bezettingData[$golonganKhusus]))
                    <tr>
                        <td>{{ $bezettingData[$golonganKhusus]['golongan'] }}</td>
                        @foreach ($eselonColumns as $eselon)
                            <td>{{ $bezettingData[$golonganKhusus]['eselon'][$eselon] }}</td>
                            @php $grandTotalEselon[$eselon] += $bezettingData[$golonganKhusus]['eselon'][$eselon]; @endphp
                        @endforeach
                        @foreach ($pendidikanColumns as $pendidikan)
                            <td>{{ $bezettingData[$golonganKhusus]['pendidikan'][$pendidikan] }}</td>
                            @php $grandTotalPendidikan[$pendidikan] += $bezettingData[$golonganKhusus]['pendidikan'][$pendidikan]; @endphp
                        @endforeach
                        <td>{{ $bezettingData[$golonganKhusus]['total_golongan'] }}</td>
                        @php $grandTotalJumlah += $bezettingData[$golonganKhusus]['total_golongan']; @endphp
                    </tr>
                @else
                    {{-- Jika tidak ada data, tampilkan baris dengan 0 --}}
                    <tr>
                        <td>{{ $golonganKhusus }}</td>
                        @foreach ($eselonColumns as $eselon) <td>0</td> @endforeach
                        @foreach ($pendidikanColumns as $pendidikan) <td>0</td> @endforeach
                        <td>0</td>
                    </tr>
                @endif
            @endforeach

            {{-- Baris KONTRAK --}}
            @if (isset($bezettingData['KONTRAK']))
                <tr class="contract-row">
                    <td>KONTRAK</td>
                    @foreach ($eselonColumns as $eselon)
                        <td>{{ $bezettingData['KONTRAK']['eselon'][$eselon] }}</td>
                        @php $grandTotalEselon[$eselon] += $bezettingData['KONTRAK']['eselon'][$eselon]; @endphp
                    @endforeach
                    @foreach ($pendidikanColumns as $pendidikan)
                        <td>{{ $bezettingData['KONTRAK']['pendidikan'][$pendidikan] }}</td>
                        @php $grandTotalPendidikan[$pendidikan] += $bezettingData['KONTRAK']['pendidikan'][$pendidikan]; @endphp
                    @endforeach
                    <td>{{ $bezettingData['KONTRAK']['total_golongan'] }}</td>
                    @php $grandTotalJumlah += $bezettingData['KONTRAK']['total_golongan']; @endphp
                </tr>
            @else
                <tr class="contract-row">
                    <td>KONTRAK</td>
                    @foreach ($eselonColumns as $eselon) <td>0</td> @endforeach
                    @foreach ($pendidikanColumns as $pendidikan) <td>0</td> @endforeach
                    <td>0</td>
                </tr>
            @endif

            {{-- Baris TOTAL --}}
            <tr class="total-row">
                <td>TOTAL</td>
                @foreach ($eselonColumns as $eselon)
                    <td>{{ $grandTotalEselon[$eselon] }}</td>
                @endforeach
                @foreach ($pendidikanColumns as $pendidikan)
                    <td>{{ $grandTotalPendidikan[$pendidikan] }}</td>
                @endforeach
                <td>{{ $grandTotalJumlah }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
<div class="row">
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Simpan
        </button>
        <a href="{{ route('settings.bezetting_kontrak.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>