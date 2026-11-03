@php
    $nav = [
        ['label' => 'Dashboard', 'icon' => 'fa-grid-2', 'active' => 'dashboard', 'url' => 'dashboard'],
        ['label' => 'Absensi & Presensi', 'icon' => 'fa-calendar-check', 'active' => 'presences.*', 'url' => 'presences.calendar'],
        ['label' => 'Data Karyawan', 'icon' => 'fa-users', 'active' => 'employees.*', 'url' => 'employees.index'],
        ['label' => 'Payroll & Gaji', 'icon' => 'fa-wallet', 'active' => 'payrolls.*', 'url' => 'payrolls.index'],
        ['label' => 'Penjualan & Kasir', 'icon' => 'fa-cash-register', 'active' => 'transactions.*', 'url' => 'transactions.index'],
        ['label' => 'Laporan', 'icon' => 'fa-chart-simple', 'active' => 'transactions.rekap', 'url' => 'transactions.rekap'],
        ['label' => 'Pengaturan', 'icon' => 'fa-sliders', 'active' => 'settings.*', 'url' => 'settings.company.index'],
    ];
@endphp
<div class="flex h-full min-h-screen flex-col justify-between overflow-y-auto bg-white p-6">
    <div>
        <!-- Logo Brand -->
        <div class="mb-8 flex items-center gap-3 px-2 py-3">
            <img src="{{ asset('logo-datanet.png') }}" alt="Logo Datanet" class="h-11 w-11 rounded-xl bg-white object-contain shadow-md shadow-blue-500/10">
            <div>
                <h1 class="font-bold leading-tight text-slate-900">DATANET</h1>
                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">HR &amp; Retail Core</p>
            </div>
        </div>

        <!-- Menu Navigasi -->
        <nav class="space-y-1.5">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600 text-white font-medium shadow-md shadow-blue-600/25 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('presences.calendar') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Absensi & Presensi</span>
            </a>

            <a href="{{ route('employees.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>Data Karyawan</span>
            </a>

            <a href="{{ route('payrolls.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>Payroll & Gaji</span>
            </a>

            <a href="{{ route('manual-notas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 3h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2zm3 4h6M7 11h10M7 15h6"/></svg>
                <span>Nota Barang &amp; Jasa</span>
            </a>

            <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>Voucher</span>
            </a>

            <a href="{{ route('resellers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-7h6v7M8 10h.01M12 10h.01M16 10h.01"/></svg>
                <span>Reseller</span>
            </a>

            <a href="{{ route('acquisitions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 20a6 6 0 00-12 0m6-10a4 4 0 100-8 4 4 0 000 8zm7-3v6m3-3h-6"/></svg>
                <span>Klien Baru</span>
            </a>

            <a href="{{ route('deductions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a2 2 0 012 2v1.1a7 7 0 014.9 4.9H20a2 2 0 110 4h-1.1a7 7 0 01-4.9 4.9V20a2 2 0 11-4 0v-1.1A7 7 0 014.1 14H3a2 2 0 110-4h1.1A7 7 0 019 5.1V4a2 2 0 012-2z"/></svg>
                <span>Kasbon / Potongan</span>
            </a>

            <a href="{{ route('transactions.rekap') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>Rekap per Reseller</span>
            </a>

            <a href="{{ route('settings.company.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Pengaturan</span>
            </a>
        </nav>
    </div>

    <!-- Bagian Bawah: Widget Payroll & Profil -->
    <div class="space-y-4 pt-6 border-t border-slate-100">
        <!-- Card Mini Siklus Penggajian -->
        <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-100/70">
            <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                <span>Siklus Penggajian</span>
                <span class="text-slate-400">📅</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm font-bold text-slate-800">Jadwal Payroll</span>
                <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">28 Feb</span>
            </div>
            <div class="w-full bg-blue-200/50 h-1.5 rounded-full mt-2.5 overflow-hidden">
                <div class="bg-blue-600 h-full rounded-full" style="width: 78%"></div>
            </div>
        </div>

        <!-- Akun Pengguna -->
        <div class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition cursor-pointer">
            <div class="flex items-center gap-3">
                <img class="w-9 h-9 rounded-full object-cover ring-2 ring-blue-100" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80" alt="Sarah Khan">
                <div>
                    <h4 class="text-xs font-bold text-slate-800">Sarah Khan</h4>
                    <p class="text-[10px] text-slate-500">HR & Operations Lead</p>
                </div>
            </div>
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/></svg>
        </div>
    </div>
</div>