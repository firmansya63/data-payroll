@extends('layouts.app')
@section('title','Detail Payroll')
@section('content')
<h1 class="text-lg font-bold mb-3">Detail Gaji - {{ $payroll->employee->nama }} ({{ str_pad($payroll->periode_bulan,2,'0',STR_PAD_LEFT) }}/{{ $payroll->periode_tahun }})</h1>
<div class="grid md:grid-cols-2 gap-4">
<div class="bg-white p-4 rounded-2xl shadow-sm border">
  <h3 class="font-semibold mb-2">Rincian Gaji</h3>
  <table class="w-full text-sm">
    <tr class="border-b"><td class="py-2 text-slate-500">Gaji Pokok</td><td class="py-2 text-right font-semibold">Rp {{ number_format($payroll->gaji_pokok,0,',','.') }}</td></tr>
    <tr class="border-b"><td class="py-2 text-slate-500">Kehadiran</td><td class="py-2 text-right">{{ $payroll->jml_hadir }} hadir x Rp {{ number_format($payroll->employee->bonus_per_hadir,0,',','.') }} = <span class="font-semibold text-emerald-600">Rp {{ number_format($payroll->bonus_kehadiran,0,',','.') }}</span></td></tr>
    <tr class="border-b"><td class="py-2 text-slate-500">Insentif Klien Baru ({{ $insentifList->count() }} klien)</td><td class="py-2 text-right font-semibold text-sky-600">Rp {{ number_format($payroll->total_insentif,0,',','.') }}</td></tr>
    <tr class="border-b bg-blue-50/60"><td class="py-2 text-blue-600">Lembur @if($payroll->jam_lembur>0) ({{ rtrim(rtrim(number_format($payroll->jam_lembur,2,',','.'),'0'),',') }} jam) @endif @if($payroll->catatan_lembur)<span class="text-xs text-slate-500">&mdash; {{ $payroll->catatan_lembur }}</span>@endif</td><td class="py-2 text-right font-semibold text-blue-600">+Rp {{ number_format($payroll->total_lembur,0,',','.') }}</td></tr>
    <tr class="border-b"><td class="py-2 text-slate-500">Potongan / Kasbon</td><td class="py-2 text-right font-semibold text-red-600">-Rp {{ number_format($payroll->total_potongan,0,',','.') }}</td></tr>
    <tr class="bg-slate-50 font-bold text-base"><td class="py-3 px-2 rounded-l-xl">Total Terima</td><td class="py-3 px-2 text-right rounded-r-xl text-sky-700">Rp {{ number_format($payroll->total_terima,0,',','.') }}</td></tr>
  </table>
  <p class="text-[11px] text-slate-400 mt-2">Rumus: Pokok + Bonus Hadir + Insentif + Lembur - Potongan. Lembur diinput manual per periode.</p>
  <div class="mt-3 flex gap-2">
    <a href="{{ route('payrolls.slip',$payroll) }}" target="_blank" class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm"><i class="fa-solid fa-print mr-1"></i> Cetak Slip</a>
    <a href="{{ route('payrolls.index',['bulan'=>$payroll->periode_bulan,'tahun'=>$payroll->periode_tahun]) }}" class="border px-4 py-2 rounded-xl text-sm">Kembali</a>
    <a href="{{ route('payrolls.create',['bulan'=>$payroll->periode_bulan,'tahun'=>$payroll->periode_tahun]) }}" class="border px-4 py-2 rounded-xl text-sm bg-amber-50 text-amber-700"><i class="fa-solid fa-rotate mr-1"></i> Koreksi / Generate Ulang</a>
  </div>
</div>
<div class="space-y-4">
  <div class="bg-white p-4 rounded-2xl shadow-sm border">
    <h3 class="font-semibold mb-2 text-emerald-700">Insentif Klien Baru Bulan Ini</h3>
    @forelse($insentifList as $it)
      <div class="flex justify-between text-sm py-1.5 border-b last:border-0"><span>{{ $it->nama_klien }} ({{ $it->tanggal->format('d/m') }})</span><span class="font-semibold">Rp {{ number_format($it->nominal_insentif,0,',','.') }}</span></div>
    @empty <p class="text-sm text-slate-400">Tidak ada insentif bulan ini</p> @endforelse
  </div>
  <div class="bg-white p-4 rounded-2xl shadow-sm border">
    <h3 class="font-semibold mb-2 text-red-700">Potongan / Kasbon</h3>
    @forelse($potonganList as $p)
      <div class="flex justify-between text-sm py-1.5 border-b last:border-0"><span>{{ $p->keterangan ?? 'Potongan' }} ({{ $p->tanggal->format('d/m') }})</span><span class="font-semibold text-red-600">Rp {{ number_format($p->nominal,0,',','.') }}</span></div>
    @empty <p class="text-sm text-slate-400">Tidak ada potongan</p> @endforelse
  </div>
  @if($payroll->total_lembur>0 || $payroll->catatan_lembur)
  <div class="bg-white p-4 rounded-2xl shadow-sm border border-blue-200">
    <h3 class="font-semibold mb-2 text-blue-600">Lembur Periode Ini</h3>
    <div class="text-sm flex justify-between"><span>{{ $payroll->jam_lembur }} jam @if($payroll->catatan_lembur) &mdash; {{ $payroll->catatan_lembur }} @endif</span><span class="font-semibold text-blue-600">Rp {{ number_format($payroll->total_lembur,0,',','.') }}</span></div>
  </div>
  @endif
</div>
</div>
@endsection
