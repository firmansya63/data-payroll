@php
    /**
     * Sidebar Datanet — menu dikelompokkan per kategori.
     * Sumber menu hanya array $menu di bawah ini (dulu ada array $nav yang tidak pernah dirender).
     */

    // Ikon inline SVG (layout hanya memuat Tailwind CDN, jadi tidak pakai FontAwesome/Alpine).
    $icons = [
        'grid'     => ['M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
        'nota'     => ['M6 3h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2zm3 4h6M7 11h10M7 15h6'],
        'voucher'  => ['M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
        'store'    => ['M3 21h18M5 21V8l7-5 7 5v13M9 21v-7h6v7M8 10h.01M12 10h.01M16 10h.01'],
        'userplus' => ['M18 20a6 6 0 00-12 0m6-10a4 4 0 100-8 4 4 0 000 8zm7-3v6m3-3h-6'],
        'chart'    => ['M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
        'clock'    => ['M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        'users'    => ['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
        'wallet'   => ['M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
        'cash'     => ['M2 7a2 2 0 012-2h16a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V7z', 'M12 15a3 3 0 100-6 3 3 0 000 6z'],
        'cog'      => ['M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
    ];

    // Penanda halaman aktif. 'except' dipakai untuk menu yang nama route-nya bertumpuk
    // (Voucher = transactions.* KECUALI transactions.rekap*).
    $isActive = function (array $patterns, array $except = []): bool {
        foreach ($except as $p) {
            if (request()->routeIs($p)) {
                return false;
            }
        }
        foreach ($patterns as $p) {
            if (request()->routeIs($p)) {
                return true;
            }
        }

        return false;
    };

    $menu = [
        [
            'label' => 'Umum',
            'items' => [
                ['label' => 'Dashboard', 'icon' => 'grid', 'route' => 'dashboard', 'active' => ['dashboard']],
            ],
        ],
        [
            'label' => 'Transaksi',
            'items' => [
                ['label' => 'Nota Barang & Jasa', 'icon' => 'nota',     'route' => 'manual-notas.index', 'active' => ['manual-notas.*']],
                ['label' => 'Voucher',            'icon' => 'voucher',  'route' => 'transactions.index',  'active' => ['transactions', 'transactions.*'], 'except' => ['transactions.rekap', 'transactions.rekap.nota']],
                ['label' => 'Reseller',           'icon' => 'store',    'route' => 'resellers.index',     'active' => ['resellers.*']],
                ['label' => 'Klien Baru',         'icon' => 'userplus', 'route' => 'acquisitions.index',  'active' => ['acquisitions.*']],
                ['label' => 'Rekap Reseller',     'icon' => 'chart',    'route' => 'transactions.rekap',  'active' => ['transactions.rekap', 'transactions.rekap.nota']],
            ],
        ],
        [
            'label' => 'Karyawan',
            'items' => [
                ['label' => 'Absensi',        'icon' => 'clock',  'route' => 'presences.calendar', 'active' => ['presences.*']],
                ['label' => 'Data Karyawan',  'icon' => 'users',  'route' => 'employees.index',    'active' => ['employees.*']],
                ['label' => 'Payroll & Gaji', 'icon' => 'wallet', 'route' => 'payrolls.index',     'active' => ['payrolls.*', 'signature.*']],
                ['label' => 'Kasbon',         'icon' => 'cash',   'route' => 'deductions.index',   'active' => ['deductions.*']],
            ],
        ],
        [
            'label' => 'Pengaturan',
            'items' => [
                ['label' => 'Profil Perusahaan', 'icon' => 'cog', 'route' => 'settings.company.index', 'active' => ['settings.*']],
                ['label' => 'Manajemen User', 'icon' => 'users', 'route' => 'users.index', 'active' => ['users.*']],
            ],
        ],
    ];

    $user = auth()->user();
    $initials = collect(preg_split('/\s+/', trim((string) ($user?->name ?? 'Tamu'))))
        ->filter()->take(2)
        ->map(fn (string $w): string => mb_strtoupper(mb_substr($w, 0, 1)))
        ->implode('') ?: 'U';
@endphp
<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex h-screen w-64 shrink-0 flex-col justify-between overflow-y-auto border-r border-slate-100 bg-white p-5 lg:w-72 lg:p-6 -translate-x-full lg:translate-x-0 lg:sticky transition-transform duration-300 shadow-2xl lg:shadow-none">
    <div>
        <!-- Logo Brand & Mobile Close -->
        <div class="mb-8 flex items-center justify-between gap-3 px-2 py-1">
            <div class="flex items-center gap-3 min-w-0">
                <img src="{{ asset('logo-datanet.png') }}" alt="Logo Datanet" class="h-11 w-11 rounded-xl bg-white object-contain shadow-md shadow-blue-500/10 shrink-0">
                <div class="min-w-0">
                    <h1 class="truncate font-bold leading-tight text-slate-900">DATANET</h1>
                    <p class="truncate text-[11px] font-semibold uppercase tracking-wider text-slate-400">HR &amp; Retail Core</p>
                </div>
            </div>
            <button type="button" id="closeSidebar" class="lg:hidden grid h-9 w-9 shrink-0 place-items-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition" aria-label="Tutup Menu">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <!-- Menu Navigasi (dikelompokkan per kategori) -->
        <nav class="space-y-6">
            @foreach ($menu as $group)
                @php
                    $groupActive = collect($group['items'])
                        ->contains(fn (array $i): bool => $isActive($i['active'], $i['except'] ?? []));
                @endphp

                <div>
                    <p class="mb-2 ml-4 text-[11px] font-bold uppercase tracking-[0.14em] {{ $groupActive ? 'text-blue-600' : 'text-slate-400' }}">
                        {{ $group['label'] }}
                    </p>

                    <ul class="ml-3 space-y-1 border-l border-slate-100 pl-2.5">
                        @foreach ($group['items'] as $item)
                            @php $active = $isActive($item['active'], $item['except'] ?? []); @endphp
                            <li>
                                <a href="{{ route($item['route']) }}"
                                   @if ($active) aria-current="page" @endif
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ $active ? 'bg-blue-600 text-white shadow-md shadow-blue-600/25' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <svg class="h-5 w-5 shrink-0 {{ $active ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @foreach ($icons[$item['icon']] as $d)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $d }}" />
                                        @endforeach
                                    </svg>
                                    <span class="truncate">{{ $item['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </nav>
    </div>

    <!-- Bagian Bawah: Widget Payroll & Akun -->
    <div class="space-y-4 pt-6 border-t border-slate-100">
        <!-- Card Mini Siklus Penggajian -->
        <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-100/70">
            <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                <span>Siklus Penggajian</span>
                <span class="text-slate-400">📅</span>
            </div>
            <div class="flex items-center justify-between">
                <a href="{{ route('payrolls.index') }}" class="text-sm font-bold text-slate-800 hover:text-blue-600 transition">Jadwal Payroll</a>
                <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">{{ now()->endOfMonth()->format('d M') }}</span>
            </div>
            <div class="w-full bg-blue-200/50 h-1.5 rounded-full mt-2.5 overflow-hidden">
                <div class="bg-blue-600 h-full rounded-full" style="width: {{ min(100, max(4, (int) round(now()->day / (int) now()->format('t') * 100))) }}%"></div>
            </div>
        </div>

        <!-- Akun Pengguna -->
        <div class="flex items-center gap-2 p-2 rounded-xl border border-slate-100 bg-slate-50/70">
            <div class="flex min-w-0 flex-1 items-center gap-3">
                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-blue-600 text-[11px] font-bold uppercase tracking-wide text-white">{{ $initials }}</span>
                <div class="min-w-0">
                    <h4 class="truncate text-xs font-bold text-slate-800">{{ $user?->name ?? 'Tamu' }}</h4>
                    <p class="truncate text-[10px] text-slate-500">{{ $user?->email }}</p>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" title="Profil saya"
               class="grid h-8 w-8 shrink-0 place-items-center rounded-lg text-slate-500 transition hover:bg-white hover:text-blue-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                @csrf
                <button type="submit" title="Keluar"
                        class="grid h-8 w-8 place-items-center rounded-lg text-slate-500 transition hover:bg-white hover:text-rose-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
