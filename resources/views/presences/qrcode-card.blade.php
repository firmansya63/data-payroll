@extends('layouts.app')
@section('title', 'QR Code Karyawan - '.$employee->nama)
@section('content')
<div class="relative min-h-[80vh] flex flex-col items-center justify-center py-6">
    <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
        <div class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-blue-300/40 blur-3xl"></div>
        <div class="absolute -right-10 top-10 h-80 w-80 rounded-full bg-blue-300/30 blur-3xl"></div>
    </div>

    <div class="relative z-10 w-full max-w-sm">
        <div id="print-area" class="bg-white p-6 rounded-3xl shadow-2xl ring-1 ring-slate-200 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-blue-600 text-white font-bold text-xl mb-3 shadow-lg shadow-blue-600/30">
                {{ substr($employee->nama, 0, 1) }}
            </div>
            <h2 class="text-xl font-extrabold text-slate-900">{{ $employee->nama }}</h2>
            <p class="text-xs text-blue-600 font-semibold uppercase tracking-wider mt-0.5">{{ $employee->jabatan }}</p>
            <p class="text-xs text-slate-400 mt-1">ID Karyawan: #{{ $employee->id }}</p>

            <div class="my-6 p-4 bg-slate-50 rounded-2xl border border-slate-100 flex justify-center">
                <img src="{{ $qrImage }}" alt="QR Code {{ $employee->nama }}" class="w-48 h-48 rounded-xl">
            </div>

            <p class="text-[11px] text-slate-500 font-medium">Scan QR Code ini pada menu <span class="text-blue-600 font-bold">Scan QR Absen</span> di perangkat standby kantor.</p>
        </div>

        <div class="mt-6 flex gap-3">
            <a href="{{ route('employees.index') }}" class="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-slate-100 text-slate-600 font-semibold hover:bg-slate-200 transition text-xs">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-600/20 text-xs">
                <i class="fa-solid fa-print"></i> Cetak Kartu
            </button>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #print-area, #print-area * {
        visibility: visible;
    }
    #print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
        border: none !important;
    }
}
</style>
@endsection
