<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#312e81">
<title>@yield('title','Dashboard') - Datanet</title>
<link rel="manifest" href="{{ asset('manifest.json') }}">
<link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>*{font-family:Inter,system-ui,sans-serif}html,body{max-width:100%;overflow-x:hidden}img,svg,video,canvas{max-width:100%;height:auto}input,select,textarea{max-width:100%}button,a,input,select,textarea{touch-action:manipulation}table{max-width:100%}@media (max-width:767px){main{overflow-x:hidden}.break-mobile,.prose,.whitespace-pre-wrap{overflow-wrap:anywhere}.overflow-x-auto{-webkit-overflow-scrolling:touch;scrollbar-width:thin}.overflow-x-auto table{min-width:max-content}.overflow-x-auto th,.overflow-x-auto td{white-space:nowrap}.overflow-x-auto td:first-child,.overflow-x-auto th:first-child{white-space:normal}.grid,.flex,form{min-width:0}button,a{max-width:100%}} @keyframes vchFadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}} .vch-in{animation:vchFadeUp .55s cubic-bezier(.22,1,.36,1) both} @media (prefers-reduced-motion:reduce){.vch-in{animation:none!important;transition:none!important}} @media print{.no-print{display:none!important} body{background:#fff}} ::-webkit-scrollbar{width:5px;height:5px} ::-webkit-scrollbar-thumb{background:rgba(255,255,255,.18);border-radius:999px} ::-webkit-scrollbar-track{background:transparent}</style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">
<div class="min-h-screen flex">
  <div id="sidebarOverlay" class="no-print fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-30 hidden lg:hidden"></div>
  <aside id="sidebar" class="no-print fixed lg:sticky top-0 inset-y-0 left-0 z-40 w-[265px] lg:w-[250px] overflow-hidden bg-gradient-to-b from-[#1e1b4b] via-[#2e1065] to-[#4c1d95] text-white flex flex-col h-screen lg:h-screen -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-2xl lg:shadow-none border-r border-white/10 shrink-0">
    <div class="pointer-events-none absolute -right-16 -top-20 z-0 h-56 w-56 rounded-full bg-fuchsia-500/20 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -left-16 bottom-24 z-0 h-56 w-56 rounded-full bg-indigo-400/20 blur-3xl" aria-hidden="true"></div>

    <div class="relative z-10 px-5 py-5 flex items-center gap-3 border-b border-white/10 shrink-0">
      <img src="{{ isset($company) && $company ? $company->logoUrl() : asset('logo.png') }}" alt="{{ isset($company) && $company ? $company->name : 'Datanet' }}" class="w-9 h-9 object-contain bg-white/95 rounded-xl p-1.5 ring-1 ring-white/20 shadow-lg shadow-fuchsia-900/30">
      <div class="leading-tight">
        <div class="font-bold tracking-tight text-[17px]">Data<span class="bg-gradient-to-r from-fuchsia-400 via-violet-300 to-amber-300 bg-clip-text text-transparent">net</span></div>
        <div class="text-[11px] text-white/50 -mt-0.5">Payroll & Voucher</div>
      </div>
      <button id="closeSidebar" class="lg:hidden ml-auto w-9 h-9 grid place-items-center rounded-lg bg-white/10 ring-1 ring-white/10 hover:bg-white/20"><i class="fa-solid fa-xmark text-sm"></i></button>
    </div>
    <div class="relative z-10 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent" aria-hidden="true"></div>

    <div class="relative z-10 flex-1 overflow-y-auto px-3 py-4 space-y-6">
      @php $is = fn($p) => request()->routeIs($p) ? true : false; $act = 'bg-gradient-to-r from-white/20 to-white/5 text-white font-semibold ring-1 ring-white/20 shadow-[inset_3px_0_0_0_#e879f9] backdrop-blur-sm'; $idle = 'text-white/70 hover:bg-white/10 hover:text-white'; @endphp

      <div>
        <p class="px-3 mb-2 flex items-center gap-2 text-[10px] font-semibold tracking-[0.16em] text-white/45"><span class="h-px w-4 rounded-full bg-gradient-to-r from-fuchsia-400/80 to-transparent" aria-hidden="true"></span>UTAMA</p>
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('dashboard') ? $act : $idle }}"><i class="fa-solid fa-chart-pie w-6 text-center"></i> Dashboard</a>
      </div>
      <div>
        <p class="px-3 mb-2 flex items-center gap-2 text-[10px] font-semibold tracking-[0.16em] text-white/45"><span class="h-px w-4 rounded-full bg-gradient-to-r from-fuchsia-400/80 to-transparent" aria-hidden="true"></span>TRANSAKSI</p>
        <div class="space-y-1">
          <a href="{{ route('manual-notas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('manual-notas.*') ? $act : $idle }}"><i class="fa-solid fa-receipt w-6 text-center"></i> Nota Barang & Jasa</a>
          <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('transactions.index') || $is('transactions.create') || $is('transactions.edit') || $is('transactions.nota') ? $act : $idle }}"><i class="fa-solid fa-ticket w-6 text-center"></i> Voucher</a>
          <a href="{{ route('transactions.rekap') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('transactions.rekap') ? $act : $idle }}"><i class="fa-solid fa-chart-pie w-6 text-center"></i> Rekap per Reseller</a>
          <a href="{{ route('resellers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('resellers.*') ? $act : $idle }}"><i class="fa-solid fa-store w-6 text-center"></i> Reseller</a>
          <a href="{{ route('acquisitions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('acquisitions.*') ? $act : $idle }}"><i class="fa-solid fa-user-plus w-6 text-center"></i> Klien Baru</a>
        </div>
      </div>
      <div>
        <p class="px-3 mb-2 flex items-center gap-2 text-[10px] font-semibold tracking-[0.16em] text-white/45"><span class="h-px w-4 rounded-full bg-gradient-to-r from-fuchsia-400/80 to-transparent" aria-hidden="true"></span>SDM & PAYROLL</p>
        <div class="space-y-1">
          <a href="{{ route('employees.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('employees.*') ? $act : $idle }}"><i class="fa-solid fa-users w-6 text-center"></i> Karyawan</a>
          <a href="{{ route('presences.calendar') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('presences.*') ? $act : $idle }}"><i class="fa-solid fa-calendar-check w-6 text-center"></i> Presensi</a>
          <a href="{{ route('payrolls.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('payrolls.*') ? $act : $idle }}"><i class="fa-solid fa-money-bill-wave w-6 text-center"></i> Payroll</a>
          <a href="{{ route('deductions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('deductions.*') ? $act : $idle }}"><i class="fa-solid fa-hand-holding-dollar w-6 text-center"></i> Kasbon</a>
          <a href="{{ route('signature.verify') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('signature.*') ? $act : $idle }}"><i class="fa-solid fa-qrcode w-6 text-center"></i> Verifikasi TTD</a>
        </div>
      </div>
        <div>
          <p class="px-3 mb-2 flex items-center gap-2 text-[10px] font-semibold tracking-[0.16em] text-white/45"><span class="h-px w-4 rounded-full bg-gradient-to-r from-fuchsia-400/80 to-transparent" aria-hidden="true"></span>PENGATURAN</p>
          <div class="space-y-1">
            <a href="{{ route('settings.company.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('settings.company.*') ? $act : $idle }}"><i class="fa-solid fa-building w-6 text-center"></i> Data Perusahaan</a>
          </div>
        </div>
      <div>
        <p class="px-3 mb-2 flex items-center gap-2 text-[10px] font-semibold tracking-[0.16em] text-white/45"><span class="h-px w-4 rounded-full bg-gradient-to-r from-fuchsia-400/80 to-transparent" aria-hidden="true"></span>AKUN</p>
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('profile.*') ? $act : $idle }}"><i class="fa-solid fa-id-badge w-6 text-center"></i> Profil <i class="fa-solid fa-chevron-right ml-auto text-[10px] opacity-40"></i></a>
      </div>
    </div>
    @auth
    <div class="relative z-10 shrink-0 border-t border-white/10 p-4 bg-white/5 backdrop-blur">
      <div class="flex items-center gap-3">
        <a href="{{ route('profile.edit') }}" class="w-9 h-9 rounded-xl bg-gradient-to-br from-fuchsia-500 to-indigo-500 text-white grid place-items-center font-bold text-xs shrink-0 ring-1 ring-white/25 shadow-lg shadow-fuchsia-500/25 hover:brightness-110 transition">{{ strtoupper(substr(Auth::user()->name,0,2)) }}</a>
        <div class="min-w-0 flex-1">
          <a href="{{ route('profile.edit') }}" class="block text-sm font-semibold leading-tight truncate hover:underline">{{ Auth::user()->name }}</a>
          <div class="text-[11px] text-white/60 truncate">{{ Auth::user()->email }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="shrink-0">@csrf<button type="submit" class="w-9 h-9 grid place-items-center rounded-lg bg-white/10 ring-1 ring-white/10 hover:bg-rose-500 hover:text-white transition" title="Keluar"><i class="fa-solid fa-right-from-bracket text-sm"></i></button></form>
      </div>
    </div>
    @endauth
  </aside>
  <div class="flex-1 min-w-0 flex flex-col min-h-screen">
    <header class="no-print sticky top-0 z-20 bg-white/85 backdrop-blur-xl border-b border-slate-200/70 flex items-center justify-between gap-3 px-3 md:px-6 py-3">
      <div class="flex items-center gap-3">
        <button id="openSidebar" class="lg:hidden w-10 h-10 grid place-items-center rounded-xl border border-slate-200 bg-white hover:bg-indigo-50 hover:border-indigo-200 transition"><i class="fa-solid fa-bars text-slate-700 text-base"></i></button>
        <div class="hidden lg:block">
          <h1 class="flex items-center gap-2 font-semibold text-slate-800 text-sm leading-tight"><span class="h-2 w-2 rounded-full bg-gradient-to-br from-indigo-500 to-fuchsia-500" aria-hidden="true"></span>@yield('title','Dashboard')</h1>
          <p class="text-[11px] text-slate-500 hidden xl:block">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="lg:hidden flex items-center gap-2 font-bold text-slate-800"><img src="{{ asset('logo.png') }}" class="w-8 h-8 object-contain bg-white rounded-lg border p-1"> Data<span class="bg-gradient-to-r from-indigo-600 to-fuchsia-500 bg-clip-text text-transparent">net</span></div>
      </div>
      <div class="flex items-center gap-2">
        <span class="hidden md:inline text-xs bg-indigo-50/80 text-indigo-600 px-2.5 py-1.5 rounded-full ring-1 ring-indigo-100">{{ now()->translatedFormat('l, d F Y') }}</span>
        @auth<span class="hidden lg:inline text-xs text-slate-500">Halo, <b class="text-slate-800">{{ Auth::user()->name }}</b></span>@endauth
      </div>
    </header>
    <div class="max-w-7xl w-full mx-auto px-3 md:px-6">
      @if(session('ok'))<div class="no-print mt-4 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm"><i class="fa-solid fa-circle-check mr-1"></i> {{ session('ok') }}</div>@endif
      @if($errors->any())<div class="no-print mt-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm"><ul class="list-disc pl-5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    </div>
    <main class="flex-1 max-w-7xl w-full mx-auto px-3 md:px-6 py-4 md:py-6">
      @yield('content')
    </main>
    <footer class="no-print border-t border-slate-200/70 bg-gradient-to-r from-white via-indigo-50/40 to-fuchsia-50/40 px-3 md:px-6 py-3 text-[11px] text-slate-400 text-center lg:text-left">&copy; {{ date('Y') }} Datanet &mdash; Payroll & Voucher &middot; <span class="text-indigo-700 font-medium">data-payroll</span></footer>
  </div>
</div>
<script>(function(){const sb=document.getElementById('sidebar');const ov=document.getElementById('sidebarOverlay');const o=document.getElementById('openSidebar');const c=document.getElementById('closeSidebar');function open(){sb.classList.remove('-translate-x-full');ov.classList.remove('hidden');document.body.style.overflow='hidden';}function close(){sb.classList.add('-translate-x-full');ov.classList.add('hidden');document.body.style.overflow='';}if(o)o.addEventListener('click',open);if(c)c.addEventListener('click',close);if(ov)ov.addEventListener('click',close);window.addEventListener('resize',()=>{if(window.innerWidth>=1024){ov.classList.add('hidden');document.body.style.overflow='';sb.classList.remove('-translate-x-full');}else{sb.classList.add('-translate-x-full');}});})();</script>
@stack('js')
</body>
</html>