<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#1b2d4a">
<title>Masuk - Datanet</title>
<link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
<link rel="manifest" href="{{ asset('manifest.json') }}">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>*{font-family:Inter,system-ui,sans-serif}</style>
</head>
<body class="min-h-screen bg-slate-50 flex flex-col">
<div class="flex-1 flex">
  <!-- Left brand panel (desktop) -->
  <div class="hidden lg:flex w-[46%] bg-[#1b2d4a] text-white flex-col justify-between p-10 relative overflow-hidden">
    <div class="absolute -right-24 -top-24 w-[520px] h-[520px] bg-white/5 rounded-full"></div>
    <div class="absolute -right-10 bottom-10 w-72 h-72 bg-[#f68b1e]/10 rounded-full blur-2xl"></div>
    <div class="relative">
      <div class="flex items-center gap-3">
        <img src="{{ asset('logo.png') }}" alt="Datanet" class="w-11 h-11 bg-white rounded-2xl p-1.5 object-contain shadow">
        <span class="text-xl font-bold tracking-tight">Data<span class="text-[#f68b1e]">net</span></span>
      </div>
      <div class="mt-16 max-w-md">
        <h1 class="text-3xl font-bold leading-tight">Kelola voucher &amp;<br>gaji karyawan<br><span class="text-[#f68b1e]">dalam satu tempat.</span></h1>
        <p class="text-sm text-slate-300 mt-4 leading-relaxed">Rekap piutang reseller (lunas/belum lunas + nota), presensi, insentif klien baru, kasbon & payroll otomatis dengan slip cetak.</p>
        <div class="mt-8 grid grid-cols-3 gap-3 text-xs">
          <div class="bg-white/10 rounded-2xl p-3 border border-white/10"><i class="fa-solid fa-ticket text-[#f68b1e] block text-lg mb-1"></i>Voucher & Piutang</div>
          <div class="bg-white/10 rounded-2xl p-3 border border-white/10"><i class="fa-solid fa-calendar-check text-[#f68b1e] block text-lg mb-1"></i>Presensi</div>
          <div class="bg-white/10 rounded-2xl p-3 border border-white/10"><i class="fa-solid fa-money-bill-wave text-[#f68b1e] block text-lg mb-1"></i>Payroll</div>
        </div>
      </div>
    </div>
    <div class="relative text-xs text-slate-400">&copy; {{ date('Y') }} Datanet &middot; Sistem Manajemen Voucher & Payroll</div>
  </div>
  <!-- Right form -->
  <div class="flex-1 flex items-center justify-center p-4 md:p-6 bg-slate-50">
    <div class="w-full max-w-[420px]">
      <div class="lg:hidden flex items-center justify-center gap-2 mb-6">
        <img src="{{ asset('logo.png') }}" alt="Datanet" class="w-10 h-10 object-contain bg-white rounded-xl border border-slate-200 p-1.5 shadow-sm">
        <span class="font-bold text-lg tracking-tight text-[#1b2d4a]">Data<span class="text-[#f68b1e]">net</span></span>
      </div>
      <div class="bg-white rounded-[24px] shadow-sm border p-6 md:p-8">
        <h2 class="text-xl font-bold text-slate-800">Masuk ke Datanet</h2>
        <p class="text-sm text-slate-500 mt-1">Gunakan akun admin untuk mengelola data.</p>
        @if(session('ok'))<div class="mt-4 bg-emerald-50 border border-emerald-200 text-emerald-800 px-3 py-2.5 rounded-xl text-sm"><i class="fa-solid fa-circle-check mr-1"></i> {{ session('ok') }}</div>@endif
        @if($errors->any())<div class="mt-4 bg-red-50 border border-red-200 text-red-800 px-3 py-2.5 rounded-xl text-sm"><ul class="list-disc pl-5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('login.attempt') }}" class="mt-6 space-y-4">
          @csrf
          <div>
            <label class="text-xs font-semibold text-slate-600">Email</label>
            <div class="mt-1 relative">
              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"><i class="fa-solid fa-envelope"></i></span>
              <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@datanet.net" class="w-full pl-9 pr-3 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#1b2d4a] focus:ring-2 focus:ring-[#1b2d4a]/10 outline-none text-sm">
            </div>
          </div>
          <div>
            <label class="text-xs font-semibold text-slate-600">Password</label>
            <div class="mt-1 relative">
              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"><i class="fa-solid fa-lock"></i></span>
              <input id="pw" type="password" name="password" required placeholder="••••••••" class="w-full pl-9 pr-10 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#1b2d4a] focus:ring-2 focus:ring-[#1b2d4a]/10 outline-none text-sm">
              <button type="button" onclick="const i=document.getElementById('pw');i.type=i.type==='password'?'text':'password';this.innerHTML=i.type==='password'?'<i class=\'fa-solid fa-eye\'></i>':'<i class=\'fa-solid fa-eye-slash\'></i>'" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"><i class="fa-solid fa-eye"></i></button>
            </div>
          </div>
          <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer select-none">
            <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-[#1b2d4a] focus:ring-[#1b2d4a]"> Ingat saya
          </label>
          <button type="submit" class="w-full bg-[#1b2d4a] hover:bg-[#16233a] text-white font-semibold py-3 rounded-xl transition shadow-sm"><i class="fa-solid fa-right-to-bracket mr-1"></i> Masuk</button>
        </form>
        <div class="mt-5 bg-amber-50 border border-amber-200 rounded-xl p-3 flex gap-2 text-xs text-amber-800">
          <i class="fa-solid fa-circle-info mt-0.5"></i>
          <div><span class="font-semibold">Demo:</span> <span class="font-mono">admin@datanet.net</span> / <span class="font-mono">password</span><br><span class="text-amber-700/80">Ganti di reset password / seeder setelah login.</span></div>
        </div>
      </div>
      <p class="text-center text-[11px] text-slate-400 mt-4">Dengan masuk, Anda menyetujui penggunaan sistem internal Datanet.</p>
    </div>
  </div>
</div>
</body>
</html>
