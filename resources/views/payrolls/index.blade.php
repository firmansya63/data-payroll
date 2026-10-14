@extends('layouts.app')
@section('title','Payroll')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-2 mb-3">
  <h1 class="text-lg font-bold"><i class="fa-solid fa-money-bill-wave text-sky-600 mr-2"></i>Payroll / Gaji</h1>
  <a href="{{ route('payrolls.create',['bulan'=>$bulan,'tahun'=>$tahun]) }}" class="bg-sky-600 text-white px-4 py-2 rounded-xl text-sm font-semibold"><i class="fa-solid fa-plus mr-1"></i> Generate Gaji</a>
</div>
<form method="GET" class="bg-white p-3 rounded-2xl shadow-sm border mb-3 flex flex-wrap gap-2 items-end">
  <label class="text-sm">Bulan<select name="bulan" class="ml-1 border rounded-xl px-2 py-2 text-sm">@for($m=1;$m<=12;$m++)<option value="{{ $m }}" {{ $bulan==$m?'selected':'' }}>{{ DateTime::createFromFormat('!m',$m)->format('F') }}</option>@endfor</select></label>
  <label class="text-sm">Tahun<select name="tahun" class="ml-1 border rounded-xl px-2 py-2 text-sm">@for($y=now()->year-1;$y<=now()->year+1;$y++)<option value="{{ $y }}" {{ $tahun==$y?'selected':'' }}>{{ $y }}</option>@endfor</select></label>
  <input name="q" value="{{ request('q') }}" placeholder="Cari karyawan..." class="border rounded-xl px-3 py-2 text-sm">
  <button class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm">Tampil</button>
  <span class="text-xs text-slate-500">Periode: {{ str_pad($bulan,2,'0',STR_PAD_LEFT) }}/{{ $tahun }}</span>
</form>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-2 mb-3">
  <div class="bg-white p-3 rounded-2xl border"><div class="text-xs text-slate-500">Total Gaji Dibayar</div><div class="font-bold text-sky-700">Rp {{ number_format($summary['total_gaji'],0,',','.') }}</div></div>
  <div class="bg-white p-3 rounded-2xl border"><div class="text-xs text-slate-500">Gaji Pokok</div><div class="font-bold">Rp {{ number_format($summary['total_pokok'],0,',','.') }}</div></div>
  <div class="bg-white p-3 rounded-2xl border"><div class="text-xs text-slate-500">Bonus Hadir</div><div class="font-bold text-emerald-600">Rp {{ number_format($summary['total_bonus'],0,',','.') }}</div></div>
  <div class="bg-white p-3 rounded-2xl border"><div class="text-xs text-slate-500">Insentif Klien</div><div class="font-bold text-sky-600">Rp {{ number_format($summary['total_insentif'],0,',','.') }}</div></div>
  <div class="bg-white p-3 rounded-2xl border"><div class="text-xs text-slate-500">Lembur</div><div class="font-bold text-violet-600">Rp {{ number_format($summary['total_lembur'],0,',','.') }}</div></div>
  <div class="bg-white p-3 rounded-2xl border"><div class="text-xs text-slate-500">Potongan</div><div class="font-bold text-red-600">Rp {{ number_format($summary['total_potongan'],0,',','.') }}</div></div>
</div>
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-3 py-2 text-left">Karyawan</th><th class="px-3 py-2 text-right">Pokok</th><th class="px-3 py-2 text-right">Bonus</th><th class="px-3 py-2 text-right">Insentif</th><th class="px-3 py-2 text-right">Lembur</th><th class="px-3 py-2 text-right">Potongan</th><th class="px-3 py-2 text-right">Terima</th><th class="px-3 py-2">Aksi</th></tr></thead>
<tbody>
@forelse($payrolls as $p)
<tr class="border-t">
  <td class="px-3 py-2.5"><div class="font-semibold">{{ $p->employee->nama }}</div><div class="text-xs text-slate-500">{{ $p->employee->jabatan }} - {{ $p->jml_hadir }} hadir @if($p->jam_lembur>0) | {{ rtrim(rtrim(number_format($p->jam_lembur,2,',','.'),'0'),',') }} jam lembur @endif</div>@if($p->catatan_lembur)<div class="text-[11px] text-violet-600">{{ $p->catatan_lembur }}</div>@endif</td>
  <td class="px-3 py-2 text-right">Rp {{ number_format($p->gaji_pokok,0,',','.') }}</td>
  <td class="px-3 py-2 text-right text-emerald-600">+Rp {{ number_format($p->bonus_kehadiran,0,',','.') }}</td>
  <td class="px-3 py-2 text-right text-sky-600">+Rp {{ number_format($p->total_insentif,0,',','.') }}</td>
  <td class="px-3 py-2 text-right text-violet-600">+Rp {{ number_format($p->total_lembur,0,',','.') }}</td>
  <td class="px-3 py-2 text-right text-red-600">-Rp {{ number_format($p->total_potongan,0,',','.') }}</td>
  <td class="px-3 py-2 text-right font-bold text-slate-800">Rp {{ number_format($p->total_terima,0,',','.') }}</td>
  <td class="px-3 py-2 flex gap-1 justify-center">
    <a href="{{ route('payrolls.show',$p) }}" class="w-7 h-7 grid place-items-center bg-slate-100 rounded-lg"><i class="fa-solid fa-eye text-xs"></i></a>
    <a href="{{ route('payrolls.slip',$p) }}" target="_blank" class="bg-slate-800 text-white px-2 py-1 rounded-lg text-xs"><i class="fa-solid fa-print"></i> Slip</a>
    <form method="POST" action="{{ route('payrolls.destroy',$p) }}" onsubmit="return confirm('Hapus slip ini? Kasbon akan dikembalikan.')">@csrf @method('DELETE')<button class="w-7 h-7 grid place-items-center bg-red-100 text-red-600 rounded-lg"><i class="fa-solid fa-trash text-xs"></i></button></form>
  </td>
</tr>
@empty<tr><td colspan="8" class="px-3 py-8 text-center text-slate-400">Belum ada payroll periode {{ str_pad($bulan,2,'0',STR_PAD_LEFT) }}/{{ $tahun }}. Klik Generate Gaji.</td></tr>@endforelse
</tbody>
</table>
</div>
<div class="p-3 border-t">{{ $payrolls->links() }}</div>
</div>
<div class="mt-3 bg-sky-50 border border-sky-200 p-3 rounded-2xl text-xs text-sky-800">
  <strong>Rumus:</strong> Total Terima = Gaji Pokok + (Jml Hadir x Bonus/Hadir) + Total Insentif Klien Baru + Lembur - Potongan/Kasbon. Insentif hanya dari modul Klien Baru, bukan dari penjualan voucher. <span class="text-violet-700">Lembur diinput manual per periode.</span>
</div>
<div class="mt-2 bg-amber-50 border border-amber-200 p-3 rounded-2xl text-xs text-amber-800">
  <i class="fa-solid fa-rotate mr-1"></i> Periode bisa digenerate ulang kapan saja untuk sinkron data presensi/insentif/kasbon & koreksi lembur terbaru &mdash; data akan diupdate, bukan duplikat.
</div>
@endsection
