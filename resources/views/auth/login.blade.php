<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#4f46e5">
<title>Masuk - Datanet</title>
<link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
<link rel="manifest" href="{{ asset('manifest.json') }}">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  *{font-family:Inter,system-ui,-apple-system,sans-serif}
  ::selection{background:rgba(124,58,237,.18)}
  @keyframes loginIn{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
  .login-in{animation:loginIn .6s cubic-bezier(.22,1,.36,1) both}
  .grid-mask{background-image:linear-gradient(rgba(255,255,255,.07) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.07) 1px,transparent 1px);background-size:34px 34px}
  @media (prefers-reduced-motion:reduce){.login-in{animation:none!important}*{transition:none!important}}
</style>
</head>
<body class="min-h-screen bg-[#f7f6ff] text-slate-800 antialiased">
<div class="min-h-screen lg:flex">

  {{-- Panel brand (desktop) --}}
  <aside class="relative overflow-hidden bg-gradient-to-br from-[#1e1b4b] via-[#312e81] to-[#4c1d95] px-6 pb-24 pt-8 text-white lg:flex lg:w-[46%] lg:flex-col lg:justify-between lg:px-11 lg:py-10">
    <div class="pointer-events-none absolute inset-0 grid-mask opacity-60" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -right-20 -top-24 h-72 w-72 rounded-full bg-fuchsia-500/25 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -left-16 bottom-0 h-64 w-64 rounded-full bg-indigo-400/25 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute bottom-16 right-6 h-40 w-40 rounded-full bg-violet-400/20 blur-2xl" aria-hidden="true"></div>

    <div class="relative login-in">
      <div class="flex items-center gap-3">
        <img src="{{ asset('logo.png') }}" alt="Datanet" class="h-11 w-11 rounded-2xl bg-white/95 object-contain p-1.5 ring-1 ring-white/25 shadow-lg shadow-fuchsia-900/30">
        <div class="leading-tight">
          <p class="text-lg font-extrabold tracking-tight">Data<span class="bg-gradient-to-r from-fuchsia-400 via-violet-300 to-amber-300 bg-clip-text text-transparent">net</span></p>
          <p class="-mt-0.5 text-[11px] text-white/50">Payroll &amp; Voucher</p>
        </div>
        <span class="ml-auto hidden rounded-full bg-white/10 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-white/70 ring-1 ring-white/15 lg:inline-flex">Internal</span>
      </div>

      {{-- Headline desktop --}}
      <div class="mt-12 hidden max-w-md lg:block">
        <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-white/50">Selamat datang kembali</p>
        <h1 class="mt-3 text-[30px] font-extrabold leading-[1.15] tracking-tight">Kelola voucher &amp; gaji karyawan
          <span class="bg-gradient-to-r from-fuchsia-400 to-amber-300 bg-clip-text text-transparent">dalam satu tempat.</span>
        </h1>
        <p class="mt-3.5 text-[13px] leading-relaxed text-white/60">Rekap piutang reseller, presensi, insentif klien baru, kasbon, dan payroll otomatis lengkap dengan slip siap cetak.</p>

        <div class="mt-7 grid grid-cols-3 gap-2.5 text-[11px] font-medium leading-snug">
          <div class="rounded-2xl bg-white/10 p-3 ring-1 ring-white/15 backdrop-blur">
            <span class="mb-2 grid h-8 w-8 place-items-center rounded-xl bg-gradient-to-br from-fuchsia-500 to-violet-600 text-white shadow-lg shadow-fuchsia-900/40"><i class="fa-solid fa-ticket text-[13px]" aria-hidden="true"></i></span>
            Voucher &amp; Piutang
          </div>
          <div class="rounded-2xl bg-white/10 p-3 ring-1 ring-white/15 backdrop-blur">
            <span class="mb-2 grid h-8 w-8 place-items-center rounded-xl bg-gradient-to-br from-indigo-500 to-sky-500 text-white shadow-lg shadow-indigo-900/40"><i class="fa-solid fa-calendar-check text-[13px]" aria-hidden="true"></i></span>
            Presensi
          </div>
          <div class="rounded-2xl bg-white/10 p-3 ring-1 ring-white/15 backdrop-blur">
            <span class="mb-2 grid h-8 w-8 place-items-center rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-lg shadow-amber-900/40"><i class="fa-solid fa-money-bill-wave text-[13px]" aria-hidden="true"></i></span>
            Payroll
          </div>
        </div>
      </div>

      {{-- Headline mobile --}}
      <div class="mt-8 lg:hidden">
        <h1 class="text-[26px] font-extrabold leading-tight tracking-tight">Masuk ke
          <span class="bg-gradient-to-r from-fuchsia-300 to-amber-300 bg-clip-text text-transparent">Datanet</span>
        </h1>
        <p class="mt-2 max-w-xs text-xs leading-relaxed text-white/60">Payroll &amp; voucher dalam satu tempat.</p>
      </div>
    </div>

    <div class="relative mt-10 hidden items-center justify-between text-[11px] text-white/40 lg:flex">
      <span>&copy; {{ date('Y') }} Datanet</span>
      <span>Sistem Manajemen Voucher &amp; Payroll</span>
    </div>
  </aside>

  {{-- Panel form --}}
  <main class="relative flex flex-1 items-start justify-center px-4 pb-12 lg:items-center lg:px-8 lg:py-12">
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
      <div class="absolute -left-12 top-8 h-64 w-64 rounded-full bg-indigo-200/40 blur-3xl"></div>
      <div class="absolute -right-16 bottom-0 h-72 w-72 rounded-full bg-fuchsia-200/35 blur-3xl"></div>
    </div>

    <div class="relative z-10 -mt-16 w-full max-w-[430px] lg:mt-0">
      <div class="login-in rounded-[26px] bg-white/90 p-6 ring-1 ring-white/70 shadow-[0_25px_60px_-25px_rgba(99,102,241,.55)] backdrop-blur-xl md:p-8">
        <div class="flex items-center gap-3">
          <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-indigo-600 via-violet-600 to-fuchsia-500 text-white shadow-lg shadow-violet-500/30">
            <i class="fa-solid fa-shield-halved text-[15px]" aria-hidden="true"></i>
          </span>
          <div class="min-w-0">
            <h2 class="text-xl font-extrabold tracking-tight text-slate-900 md:text-[22px]">Masuk ke Datanet</h2>
            <p class="mt-0.5 text-xs text-slate-500">Gunakan akun admin untuk mengelola data.</p>
          </div>
        </div>

        @if(session('ok'))
          <div role="status" class="mt-5 flex items-start gap-2.5 rounded-2xl bg-emerald-50 px-3.5 py-3 text-[12.5px] leading-relaxed text-emerald-800 ring-1 ring-emerald-200/80">
            <i class="fa-solid fa-circle-check mt-0.5 text-emerald-500" aria-hidden="true"></i>
            <span>{{ session('ok') }}</span>
          </div>
        @endif

        @if($errors->any())
          <div role="alert" aria-live="polite" class="mt-5 flex items-start gap-2.5 rounded-2xl bg-rose-50 px-3.5 py-3 text-[12.5px] leading-relaxed text-rose-700 ring-1 ring-rose-200/80">
            <i class="fa-solid fa-circle-exclamation mt-0.5 text-rose-500" aria-hidden="true"></i>
            <ul class="list-disc space-y-0.5 pl-3.5">
              @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}" id="loginForm" class="mt-6 space-y-4">
          @csrf
          <div>
            <label for="email" class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[0.1em] text-slate-500">Email</label>
            <div class="relative">
              <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[13px] text-slate-400" aria-hidden="true"><i class="fa-regular fa-envelope"></i></span>
              <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                     class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50/80 pl-10 pr-3.5 text-sm text-slate-800 placeholder:text-slate-400 shadow-sm transition hover:border-slate-300 focus:border-violet-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-violet-500/15">
            </div>
          </div>
          <div>
            <label for="password" class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[0.1em] text-slate-500">Password</label>
            <div class="relative">
              <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[13px] text-slate-400" aria-hidden="true"><i class="fa-solid fa-lock"></i></span>
              <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                     class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50/80 pl-10 pr-12 text-sm text-slate-800 placeholder:text-slate-400 shadow-sm transition hover:border-slate-300 focus:border-violet-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-violet-500/15">
              <button type="button" id="togglePassword" aria-label="Tampilkan password" aria-pressed="false"
                      class="absolute right-1.5 top-1/2 grid h-9 w-9 -translate-y-1/2 place-items-center rounded-xl text-[13px] text-slate-400 transition hover:bg-slate-100 hover:text-violet-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-400">
                <i class="fa-solid fa-eye" data-eye aria-hidden="true"></i>
              </button>
            </div>
          </div>

          <div class="flex items-center justify-between gap-3 pt-0.5">
            <label for="remember" class="flex cursor-pointer select-none items-center gap-2.5 text-[12.5px] font-medium text-slate-600">
              <input id="remember" type="checkbox" name="remember" value="1" class="peer sr-only">
              <span aria-hidden="true" class="relative h-6 w-11 shrink-0 rounded-full bg-slate-200 ring-1 ring-inset ring-slate-300/70 transition after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:content-[''] after:transition-transform peer-checked:bg-gradient-to-r peer-checked:from-indigo-500 peer-checked:to-fuchsia-500 peer-checked:ring-transparent peer-checked:after:translate-x-5 peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-violet-400"></span>
              Ingat saya
            </label>
            <span class="inline-flex items-center gap-1.5 text-[10.5px] text-slate-400">
              <i class="fa-solid fa-lock text-[9px]" aria-hidden="true"></i> Sesi aman
            </span>
          </div>

          <button type="submit" id="submitBtn"
                  class="group inline-flex h-12 w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-500 px-4 text-sm font-semibold text-white shadow-[0_16px_30px_-14px_rgba(124,58,237,.9)] transition hover:-translate-y-0.5 hover:shadow-[0_20px_36px_-14px_rgba(124,58,237,1)] active:translate-y-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-400">
            <i class="fa-solid fa-arrow-right-to-bracket text-[13px] transition group-hover:translate-x-0.5" aria-hidden="true"></i>
            <span id="submitLabel">Masuk</span>
          </button>
        </form>
      </div>

      <p class="mt-4 px-6 text-center text-[11px] leading-relaxed text-slate-400">Dengan masuk, Anda menyetujui penggunaan sistem internal Datanet.</p>
    </div>
  </main>
</div>

<script>
(function () {
  var toggle = document.getElementById('togglePassword');
  var password = document.getElementById('password');

  if (toggle && password) {
    toggle.addEventListener('click', function () {
      var show = password.type === 'password';
      password.type = show ? 'text' : 'password';
      toggle.setAttribute('aria-pressed', show ? 'true' : 'false');
      toggle.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');

      var icon = toggle.querySelector('[data-eye]');
      if (icon) {
        icon.classList.toggle('fa-eye', !show);
        icon.classList.toggle('fa-eye-slash', show);
      }
    });
  }

  var form = document.getElementById('loginForm');
  var button = document.getElementById('submitBtn');
  var label = document.getElementById('submitLabel');

  if (form && button && label) {
    form.addEventListener('submit', function () {
      if (button.getAttribute('aria-busy') === 'true') {
        return;
      }

      button.setAttribute('aria-busy', 'true');
      button.classList.add('pointer-events-none', 'opacity-70');
      label.textContent = 'Memproses\u2026';
    });
  }
})();
</script>
</body>
</html>
