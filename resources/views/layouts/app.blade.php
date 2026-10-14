<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#1b2d4a">
<title>@yield('title','Dashboard') - Datanet</title>
<link rel="manifest" href="{{ asset('manifest.json') }}">
<link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>*{font-family:Inter,system-ui,sans-serif} @media print{.no-print{display:none!important} body{background:#fff}} ::-webkit-scrollbar{width:5px;height:5px} ::-webkit-scrollbar-thumb{background:rgba(255,255,255,.18);border-radius:999px} ::-webkit-scrollbar-track{background:transparent}</style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">
<div class="min-h-screen flex">
  <div id="sidebarOverlay" class="no-print fixed inset-0 bg-black/40 z-30 hidden lg:hidden"></div>
  <aside id="sidebar" class="no-print fixed lg:sticky top-0 inset-y-0 left-0 z-40 w-[265px] lg:w-[250px] bg-[#1b2d4a] text-white flex flex-col h-screen lg:h-screen -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-2xl lg:shadow-none shrink-0">
    <div class="px-5 py-5 flex items-center gap-3 border-b border-white/10 shrink-0">
      <img src="{{ isset($company) && $company ? $company->logoUrl() : asset('logo.png') }}" alt="{{ isset($company) && $company ? $company->name : 'Datanet' }}" class="w-9 h-9 object-contain bg-white rounded-xl p-1.5 border border-white/20">
      <div class="leading-tight">
        <div class="font-bold tracking-tight text-[17px]">Data<span class="text-[#f68b1e]">net</span></div>
        <div class="text-[11px] text-white/60 -mt-0.5">Payroll & Voucher</div>
      </div>
      <button id="closeSidebar" class="lg:hidden ml-auto w-9 h-9 grid place-items-center rounded-lg bg-white/10 hover:bg-white/20"><i class="fa-solid fa-xmark text-sm"></i></button>
    </div>
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-6">
      @php $is = fn($p) => request()->routeIs($p) ? true : false; $act = 'bg-white text-[#1b2d4a] font-semibold shadow-sm'; $idle = 'text-white/75 hover:bg-white/10 hover:text-white'; @endphp
      <div>
        <p class="px-3 mb-2 text-[10px] font-semibold tracking-[0.14em] text-white/40">UTAMA</p>
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('dashboard') ? $act : $idle }}"><i class="fa-solid fa-chart-pie w-6 text-center"></i> Dashboard</a>
      </div>
      <div>
        <p class="px-3 mb-2 text-[10px] font-semibold tracking-[0.14em] text-white/40">TRANSAKSI</p>
        <div class="space-y-1">
          <a href="{{ route('manual-notas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('manual-notas.*') ? $act : $idle }}"><i class="fa-solid fa-receipt w-6 text-center"></i> Nota Barang & Jasa</a>
          <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('transactions.index') || $is('transactions.create') || $is('transactions.edit') || $is('transactions.nota') ? $act : $idle }}"><i class="fa-solid fa-ticket w-6 text-center"></i> Voucher</a>
          <a href="{{ route('transactions.rekap') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('transactions.rekap') ? $act : $idle }}"><i class="fa-solid fa-chart-pie w-6 text-center"></i> Rekap per Reseller</a>
          <a href="{{ route('resellers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('resellers.*') ? $act : $idle }}"><i class="fa-solid fa-store w-6 text-center"></i> Reseller</a>
          <a href="{{ route('acquisitions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('acquisitions.*') ? $act : $idle }}"><i class="fa-solid fa-user-plus w-6 text-center"></i> Klien Baru</a>
        </div>
      </div>
      <div>
        <p class="px-3 mb-2 text-[10px] font-semibold tracking-[0.14em] text-white/40">SDM & PAYROLL</p>
        <div class="space-y-1">
          <a href="{{ route('employees.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('employees.*') ? $act : $idle }}"><i class="fa-solid fa-users w-6 text-center"></i> Karyawan</a>
          <a href="{{ route('presences.calendar') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('presences.*') ? $act : $idle }}"><i class="fa-solid fa-calendar-check w-6 text-center"></i> Presensi</a>
          <a href="{{ route('payrolls.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('payrolls.*') ? $act : $idle }}"><i class="fa-solid fa-money-bill-wave w-6 text-center"></i> Payroll</a>
          <a href="{{ route('deductions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('deductions.*') ? $act : $idle }}"><i class="fa-solid fa-hand-holding-dollar w-6 text-center"></i> Kasbon</a>
        </div>
      </div>
        <div>
          <p class="px-3 mb-2 text-[10px] font-semibold tracking-[0.14em] text-white/40">PENGATURAN</p>
          <div class="space-y-1">
            <a href="{{ route('settings.company.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('settings.company.*') ? $act : $idle }}"><i class="fa-solid fa-building w-6 text-center"></i> Data Perusahaan</a>
          </div>
        </div>
      <div>
        <p class="px-3 mb-2 text-[10px] font-semibold tracking-[0.14em] text-white/40">AKUN</p>
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition {{ $is('profile.*') ? $act : $idle }}"><i class="fa-solid fa-id-badge w-6 text-center"></i> Profil <i class="fa-solid fa-chevron-right ml-auto text-[10px] opacity-40"></i></a>
      </div>
    </div>
    @auth
    <div class="shrink-0 border-t border-white/10 p-4 bg-[#16233a]">
      <div class="flex items-center gap-3">
        <a href="{{ route('profile.edit') }}" class="w-9 h-9 rounded-xl bg-[#f68b1e] text-white grid place-items-center font-bold text-xs shrink-0 hover:brightness-110 transition">{{ strtoupper(substr(Auth::user()->name,0,2)) }}</a>
        <div class="min-w-0 flex-1">
          <a href="{{ route('profile.edit') }}" class="block text-sm font-semibold leading-tight truncate hover:underline">{{ Auth::user()->name }}</a>
          <div class="text-[11px] text-white/60 truncate">{{ Auth::user()->email }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="shrink-0">@csrf<button type="submit" class="w-9 h-9 grid place-items-center rounded-lg bg-white/10 hover:bg-red-500 hover:text-white transition" title="Keluar"><i class="fa-solid fa-right-from-bracket text-sm"></i></button></form>
      </div>
    </div>
    @endauth
  </aside>
  <div class="flex-1 min-w-0 flex flex-col min-h-screen">
    <header class="no-print sticky top-0 z-20 bg-white/90 backdrop-blur border-b flex items-center justify-between gap-3 px-3 md:px-6 py-3">
      <div class="flex items-center gap-3">
        <button id="openSidebar" class="lg:hidden w-10 h-10 grid place-items-center rounded-xl border bg-white hover:bg-slate-50"><i class="fa-solid fa-bars text-slate-700 text-base"></i></button>
        <div class="hidden lg:block">
          <h1 class="font-semibold text-slate-800 text-sm leading-tight">@yield('title','Dashboard')</h1>
          <p class="text-[11px] text-slate-500 hidden xl:block">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="lg:hidden flex items-center gap-2 font-bold text-[#1b2d4a]"><img src="{{ asset('logo.png') }}" class="w-8 h-8 object-contain bg-white rounded-lg border p-1"> Data<span class="text-[#f68b1e]">net</span></div>
      </div>
      <div class="flex items-center gap-2">
        <span class="hidden md:inline text-xs bg-slate-100 px-2.5 py-1.5 rounded-full border">{{ now()->translatedFormat('l, d F Y') }}</span>
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
    <footer class="no-print border-t bg-white/60 px-3 md:px-6 py-3 text-[11px] text-slate-400 text-center lg:text-left">&copy; {{ date('Y') }} Datanet &mdash; Payroll & Voucher &middot; <span class="text-[#1b2d4a] font-medium">data-payroll</span></footer>
  </div>
</div>
<script>(function(){const sb=document.getElementById('sidebar');const ov=document.getElementById('sidebarOverlay');const o=document.getElementById('openSidebar');const c=document.getElementById('closeSidebar');function open(){sb.classList.remove('-translate-x-full');ov.classList.remove('hidden');document.body.style.overflow='hidden';}function close(){sb.classList.add('-translate-x-full');ov.classList.add('hidden');document.body.style.overflow='';}if(o)o.addEventListener('click',open);if(c)c.addEventListener('click',close);if(ov)ov.addEventListener('click',close);window.addEventListener('resize',()=>{if(window.innerWidth>=1024){ov.classList.add('hidden');document.body.style.overflow='';sb.classList.remove('-translate-x-full');}else{sb.classList.add('-translate-x-full');}});})();</script>
@stack('js')
</body>
</html>