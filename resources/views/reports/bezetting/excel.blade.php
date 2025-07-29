<table>
{{-- Judul --}}
<tr>
    <td colspan="15" style="text-align: center; font-weight: bold; font-size: 16px;">BEZETTING PEGAWAI BPKAD KOTA METRO</td>
</tr>
<tr>
    <td colspan="15" style="text-align: center; font-weight: bold; font-size: 14px;">BULAN {{ strtoupper(\Carbon\Carbon::createFromDate(null, $month, 1)->translatedFormat('F')) }} {{ $year }}</td>
</tr>
<tr>
    <td colspan="15"></td>
</tr>

{{-- Header Row 1 --}}
<tr>
    <td style="text-align: center; font-weight: bold;">GOLONGAN</td>
    <td style="text-align: center; font-weight: bold;">ESELON</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="text-align: center; font-weight: bold;">PENDIDIKAN</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="text-align: center; font-weight: bold;">JUMLAH</td>
</tr>

{{-- Header Row 2 --}}
<tr>
    <td style="text-align: center; font-weight: bold;"></td>
    <td style="text-align: center; font-weight: bold;">I</td>
    <td style="text-align: center; font-weight: bold;">II</td>
    <td style="text-align: center; font-weight: bold;">III</td>
    <td style="text-align: center; font-weight: bold;">IV</td>
    <td style="text-align: center; font-weight: bold;">JFU</td>
    <td style="text-align: center; font-weight: bold;">SD</td>
    <td style="text-align: center; font-weight: bold;">SMP</td>
    <td style="text-align: center; font-weight: bold;">SMA</td>
    <td style="text-align: center; font-weight: bold;">D-I</td>
    <td style="text-align: center; font-weight: bold;">D-II</td>
    <td style="text-align: center; font-weight: bold;">D-III</td>
    <td style="text-align: center; font-weight: bold;">S-1</td>
    <td style="text-align: center; font-weight: bold;">S-2</td>
    <td style="text-align: center; font-weight: bold;"></td>
</tr>

{{-- Data PNS --}}
@php
    $golonganOrder = ['IV A','IV B','IV C','IV D','III A','III B','III C','III D','II A','II B','II C','II D','I A','I B','I C','I D'];
    $eselonColumns = ['I','II','III','IV','JFU'];
    $pendidikanColumns = ['SD','SMP','SMA','D-I','D-II','D-III','S-1','S-2'];
@endphp

@foreach ($golonganOrder as $golongan)
<tr>
    <td style="text-align: center;">{{ $golongan }}</td>
    @foreach ($eselonColumns as $eselon)
        <td style="text-align: center;">{{ $bezettingData[$golongan]['eselon'][$eselon] ?? 0 }}</td>
    @endforeach
    @foreach ($pendidikanColumns as $pendidikan)
        <td style="text-align: center;">{{ $bezettingData[$golongan]['pendidikan'][$pendidikan] ?? 0 }}</td>
    @endforeach
    <td style="text-align: center;">{{ $bezettingData[$golongan]['total_golongan'] ?? 0 }}</td>
</tr>
@endforeach

{{-- Baris KONTRAK --}}
<tr>
    <td style="text-align: center; font-weight: bold;">KONTRAK</td>
    @foreach ($eselonColumns as $eselon)
        <td style="text-align: center; font-weight: bold;">{{ $bezettingData['KONTRAK']['eselon'][$eselon] ?? 0 }}</td>
    @endforeach
    @foreach ($pendidikanColumns as $pendidikan)
        <td style="text-align: center; font-weight: bold;">{{ $bezettingData['KONTRAK']['pendidikan'][$pendidikan] ?? 0 }}</td>
    @endforeach
    <td style="text-align: center; font-weight: bold;">{{ $bezettingData['KONTRAK']['total_golongan'] ?? 0 }}</td>
</tr>

{{-- Baris TOTAL --}}
<tr>
    <td style="text-align: center; font-weight: bold;">TOTAL</td>
    @foreach ($eselonColumns as $eselon)
        <td style="text-align: center; font-weight: bold;">{{ $grandTotalEselon[$eselon] }}</td>
    @endforeach
    @foreach ($pendidikanColumns as $pendidikan)
        <td style="text-align: center; font-weight: bold;">{{ $grandTotalPendidikan[$pendidikan] }}</td>
    @endforeach
    <td style="text-align: center; font-weight: bold;">{{ $grandTotalJumlah }}</td>
</tr>
</table>