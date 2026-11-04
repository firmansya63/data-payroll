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
  <div class="bg-white p-3 rounded-2xl border"><div class="text-xs text-slate-500">Lembur</div><div class="font-bold text-blue-600">Rp {{ number_format($summary['total_lembur'],0,',','.') }}</div></div>
  <div class="bg-white p-3 rounded-2xl border"><div class="text-xs text-slate-500">Potongan</div><div class="font-bold text-red-600">Rp {{ number_format($summary['total_potongan'],0,',','.') }}</div></div>
</div>
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-3 py-2 text-left">Karyawan</th><th class="px-3 py-2 text-right">Pokok</th><th class="px-3 py-2 text-right">Bonus</th><th class="px-3 py-2 text-right">Insentif</th><th class="px-3 py-2 text-right">Lembur</th><th class="px-3 py-2 text-right">Potongan</th><th class="px-3 py-2 text-right">Terima</th><th class="px-3 py-2">Aksi</th></tr></thead>
<tbody>
@forelse($payrolls as $p)
<tr class="border-t">
  <td class="px-3 py-2.5"><div class="font-semibold">{{ $p->employee->nama }}</div><div class="text-xs text-slate-500">{{ $p->employee->jabatan }} - {{ $p->jml_hadir }} hadir @if($p->jam_lembur>0) | {{ rtrim(rtrim(number_format($p->jam_lembur,2,',','.'),'0'),',') }} jam lembur @endif</div>@if($p->catatan_lembur)<div class="text-[11px] text-blue-600">{{ $p->catatan_lembur }}</div>@endif</td>
  <td class="px-3 py-2 text-right">Rp {{ number_format($p->gaji_pokok,0,',','.') }}</td>
  <td class="px-3 py-2 text-right text-emerald-600">+Rp {{ number_format($p->bonus_kehadiran,0,',','.') }}</td>
  <td class="px-3 py-2 text-right text-sky-600">+Rp {{ number_format($p->total_insentif,0,',','.') }}</td>
  <td class="px-3 py-2 text-right text-blue-600">+Rp {{ number_format($p->total_lembur,0,',','.') }}</td>
  <td class="px-3 py-2 text-right text-red-600">-Rp {{ number_format($p->total_potongan,0,',','.') }}</td>
  <td class="px-3 py-2 text-right font-bold text-slate-800">Rp {{ number_format($p->total_terima,0,',','.') }}</td>
  <td class="px-3 py-2">
    <div class="flex items-center justify-center gap-1.5">
      <a href="{{ route('payrolls.show',$p) }}" title="Lihat Detail Payroll" aria-label="Lihat Detail Payroll" class="grid h-8 w-8 place-items-center rounded-lg bg-white text-slate-600 ring-1 ring-slate-200 transition hover:bg-slate-50 hover:text-slate-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-1"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg></a>
      <a href="{{ route('payrolls.slip',$p) }}" target="_blank" rel="noopener" title="Cetak Slip Gaji" aria-label="Cetak Slip Gaji" class="inline-flex h-8 items-center gap-1.5 rounded-lg bg-blue-600 px-2.5 text-xs font-semibold text-white shadow-sm shadow-blue-600/30 transition hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-1"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9V4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v5"/><path d="M6 18H4a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="7" rx="1"/></svg> Slip</a>
      <form method="POST" action="{{ route('payrolls.destroy',$p) }}" onsubmit="return confirm('Hapus slip ini? Kasbon akan dikembalikan.')">@csrf @method('DELETE')<button type="submit" title="Hapus Slip Payroll" aria-label="Hapus Slip Payroll" class="grid h-8 w-8 place-items-center rounded-lg bg-rose-50 text-rose-600 ring-1 ring-rose-100 transition hover:bg-rose-100 hover:text-rose-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500 focus-visible:ring-offset-1"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg></button></form>
    </div>
  </td>
</tr>
@empty<tr><td colspan="8" class="px-3 py-8 text-center text-slate-400">Belum ada payroll periode {{ str_pad($bulan,2,'0',STR_PAD_LEFT) }}/{{ $tahun }}. Klik Generate Gaji.</td></tr>@endforelse
</tbody>
</table>
</div>
<div class="p-3 border-t">{{ $payrolls->links() }}</div>
</div>
<div class="mt-3 bg-sky-50 border border-sky-200 p-3 rounded-2xl text-xs text-sky-800">
  <strong>Rumus:</strong> Total Terima = Gaji Pokok + (Jml Hadir x Bonus/Hadir) + Total Insentif Klien Baru + Lembur - Potongan/Kasbon. Insentif hanya dari modul Klien Baru, bukan dari penjualan voucher. <span class="text-blue-600">Lembur diinput manual per periode.</span>
</div>
<div class="mt-2 bg-amber-50 border border-amber-200 p-3 rounded-2xl text-xs text-amber-800">
  <i class="fa-solid fa-rotate mr-1"></i> Periode bisa digenerate ulang kapan saja untuk sinkron data presensi/insentif/kasbon & koreksi lembur terbaru &mdash; data akan diupdate, bukan duplikat.
</div>
@endsection
