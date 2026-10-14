<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#1b2d4a">
<title><?php echo $__env->yieldContent('title','Dashboard'); ?> - Datanet</title>
<link rel="manifest" href="<?php echo e(asset('manifest.json')); ?>">
<link rel="icon" href="<?php echo e(asset('logo.png')); ?>" type="image/png">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>*{font-family:Inter,system-ui,sans-serif} @media print{.no-print{display:none!important} body{background:#fff}} ::-webkit-scrollbar{width:5px;height:5px} ::-webkit-scrollbar-thumb{background:rgba(255,255,255,.18);border-radius:999px} ::-webkit-scrollbar-track{background:transparent}</style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">
<div class="min-h-screen flex">
  <div id="sidebarOverlay" class="no-print fixed inset-0 bg-black/40 z-30 hidden lg:hidden"></div>
  <aside id="sidebar" class="no-print fixed lg:sticky top-0 inset-y-0 left-0 z-40 w-[285px] lg:w-[270px] bg-[#1b2d4a] text-white flex flex-col h-screen lg:h-screen -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-2xl lg:shadow-none shrink-0">
    <div class="px-5 py-5 flex items-center gap-3 border-b border-white/10 shrink-0">
      <img src="<?php echo e(isset($company) && $company ? $company->logoUrl() : asset('logo.png')); ?>" alt="<?php echo e(isset($company) && $company ? $company->name : 'Datanet'); ?>" class="w-9 h-9 object-contain bg-white rounded-xl p-1.5 border border-white/20">
      <div class="leading-tight">
        <div class="font-bold tracking-tight text-[17px]">Data<span class="text-[#f68b1e]">net</span></div>
        <div class="text-[11px] text-white/60 -mt-0.5">Payroll & Voucher</div>
      </div>
      <button id="closeSidebar" class="lg:hidden ml-auto w-8 h-8 grid place-items-center rounded-lg bg-white/10 hover:bg-white/20"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-6">
      <?php $is = fn($p) => request()->routeIs($p) ? true : false; $act = 'bg-white text-[#1b2d4a] font-semibold shadow-sm'; $idle = 'text-white/75 hover:bg-white/10 hover:text-white'; ?>
      <div>
        <p class="px-3 mb-2 text-[10px] font-semibold tracking-[0.14em] text-white/40">UTAMA</p>
        <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition <?php echo e($is('dashboard') ? $act : $idle); ?>"><i class="fa-solid fa-chart-pie w-5 text-center"></i> Dashboard</a>
      </div>
      <div>
        <p class="px-3 mb-2 text-[10px] font-semibold tracking-[0.14em] text-white/40">TRANSAKSI</p>
        <div class="space-y-1">
          <a href="<?php echo e(route('manual-notas.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition <?php echo e($is('manual-notas.*') ? $act : $idle); ?>"><i class="fa-solid fa-receipt w-5 text-center"></i> Nota Barang & Jasa</a>
          <a href="<?php echo e(route('transactions.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition <?php echo e($is('transactions.index') || $is('transactions.create') || $is('transactions.edit') || $is('transactions.nota') ? $act : $idle); ?>"><i class="fa-solid fa-ticket w-5 text-center"></i> Voucher</a>
          <a href="<?php echo e(route('transactions.rekap')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition <?php echo e($is('transactions.rekap') ? $act : $idle); ?>"><i class="fa-solid fa-chart-pie w-5 text-center"></i> Rekap per Reseller</a>
          <a href="<?php echo e(route('resellers.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition <?php echo e($is('resellers.*') ? $act : $idle); ?>"><i class="fa-solid fa-store w-5 text-center"></i> Reseller</a>
          <a href="<?php echo e(route('acquisitions.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition <?php echo e($is('acquisitions.*') ? $act : $idle); ?>"><i class="fa-solid fa-user-plus w-5 text-center"></i> Klien Baru</a>
        </div>
      </div>
      <div>
        <p class="px-3 mb-2 text-[10px] font-semibold tracking-[0.14em] text-white/40">SDM & PAYROLL</p>
        <div class="space-y-1">
          <a href="<?php echo e(route('employees.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition <?php echo e($is('employees.*') ? $act : $idle); ?>"><i class="fa-solid fa-users w-5 text-center"></i> Karyawan</a>
          <a href="<?php echo e(route('presences.calendar')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition <?php echo e($is('presences.*') ? $act : $idle); ?>"><i class="fa-solid fa-calendar-check w-5 text-center"></i> Presensi</a>
          <a href="<?php echo e(route('payrolls.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition <?php echo e($is('payrolls.*') ? $act : $idle); ?>"><i class="fa-solid fa-money-bill-wave w-5 text-center"></i> Payroll</a>
          <a href="<?php echo e(route('deductions.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition <?php echo e($is('deductions.*') ? $act : $idle); ?>"><i class="fa-solid fa-hand-holding-dollar w-5 text-center"></i> Kasbon</a>
        </div>
      </div>
        <div>
          <p class="px-3 mb-2 text-[10px] font-semibold tracking-[0.14em] text-white/40">PENGATURAN</p>
          <div class="space-y-1">
            <a href="<?php echo e(route('settings.company.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition <?php echo e($is('settings.company.*') ? $act : $idle); ?>"><i class="fa-solid fa-building w-5 text-center"></i> Data Perusahaan</a>
          </div>
        </div>
      <div>
        <p class="px-3 mb-2 text-[10px] font-semibold tracking-[0.14em] text-white/40">AKUN</p>
        <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition <?php echo e($is('profile.*') ? $act : $idle); ?>"><i class="fa-solid fa-id-badge w-5 text-center"></i> Profil <i class="fa-solid fa-chevron-right ml-auto text-[10px] opacity-40"></i></a>
      </div>
    </div>
    <?php if(auth()->guard()->check()): ?>
    <div class="shrink-0 border-t border-white/10 p-4 bg-[#16233a]">
      <div class="flex items-center gap-3">
        <a href="<?php echo e(route('profile.edit')); ?>" class="w-9 h-9 rounded-xl bg-[#f68b1e] text-white grid place-items-center font-bold text-xs shrink-0 hover:brightness-110 transition"><?php echo e(strtoupper(substr(Auth::user()->name,0,2))); ?></a>
        <div class="min-w-0 flex-1">
          <a href="<?php echo e(route('profile.edit')); ?>" class="block text-sm font-semibold leading-tight truncate hover:underline"><?php echo e(Auth::user()->name); ?></a>
          <div class="text-[11px] text-white/60 truncate"><?php echo e(Auth::user()->email); ?></div>
        </div>
        <form method="POST" action="<?php echo e(route('logout')); ?>" class="shrink-0"><?php echo csrf_field(); ?><button type="submit" class="w-8 h-8 grid place-items-center rounded-lg bg-white/10 hover:bg-red-500 hover:text-white transition" title="Keluar"><i class="fa-solid fa-right-from-bracket text-xs"></i></button></form>
      </div>
    </div>
    <?php endif; ?>
  </aside>
  <div class="flex-1 min-w-0 flex flex-col min-h-screen">
    <header class="no-print sticky top-0 z-20 bg-white/90 backdrop-blur border-b flex items-center justify-between gap-3 px-3 md:px-6 py-3">
      <div class="flex items-center gap-3">
        <button id="openSidebar" class="lg:hidden w-9 h-9 grid place-items-center rounded-xl border bg-white hover:bg-slate-50"><i class="fa-solid fa-bars text-slate-700"></i></button>
        <div class="hidden lg:block">
          <h1 class="font-semibold text-slate-800 text-sm leading-tight"><?php echo $__env->yieldContent('title','Dashboard'); ?></h1>
          <p class="text-[11px] text-slate-500 hidden xl:block"><?php echo e(now()->translatedFormat('l, d F Y')); ?></p>
        </div>
        <div class="lg:hidden flex items-center gap-2 font-bold text-[#1b2d4a]"><img src="<?php echo e(asset('logo.png')); ?>" class="w-8 h-8 object-contain bg-white rounded-lg border p-1"> Data<span class="text-[#f68b1e]">net</span></div>
      </div>
      <div class="flex items-center gap-2">
        <span class="hidden md:inline text-xs bg-slate-100 px-2.5 py-1.5 rounded-full border"><?php echo e(now()->translatedFormat('l, d F Y')); ?></span>
        <?php if(auth()->guard()->check()): ?><span class="hidden lg:inline text-xs text-slate-500">Halo, <b class="text-slate-800"><?php echo e(Auth::user()->name); ?></b></span><?php endif; ?>
      </div>
    </header>
    <div class="max-w-7xl w-full mx-auto px-3 md:px-6">
      <?php if(session('ok')): ?><div class="no-print mt-4 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm"><i class="fa-solid fa-circle-check mr-1"></i> <?php echo e(session('ok')); ?></div><?php endif; ?>
      <?php if($errors->any()): ?><div class="no-print mt-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm"><ul class="list-disc pl-5"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div><?php endif; ?>
    </div>
    <main class="flex-1 max-w-7xl w-full mx-auto px-3 md:px-6 py-4 md:py-6">
      <?php echo $__env->yieldContent('content'); ?>
    </main>
    <footer class="no-print border-t bg-white/60 px-3 md:px-6 py-3 text-[11px] text-slate-400 text-center lg:text-left">&copy; <?php echo e(date('Y')); ?> Datanet &mdash; Payroll & Voucher &middot; <span class="text-[#1b2d4a] font-medium">data-payroll</span></footer>
  </div>
</div>
<script>(function(){const sb=document.getElementById('sidebar');const ov=document.getElementById('sidebarOverlay');const o=document.getElementById('openSidebar');const c=document.getElementById('closeSidebar');function open(){sb.classList.remove('-translate-x-full');ov.classList.remove('hidden');document.body.style.overflow='hidden';}function close(){sb.classList.add('-translate-x-full');ov.classList.add('hidden');document.body.style.overflow='';}if(o)o.addEventListener('click',open);if(c)c.addEventListener('click',close);if(ov)ov.addEventListener('click',close);window.addEventListener('resize',()=>{if(window.innerWidth>=1024){ov.classList.add('hidden');document.body.style.overflow='';sb.classList.remove('-translate-x-full');}else{sb.classList.add('-translate-x-full');}});})();</script>
<?php echo $__env->yieldPushContent('js'); ?>
</body>
</html><?php /**PATH C:\laragon\www\data-payroll\resources\views/layouts/app.blade.php ENDPATH**/ ?>