<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<meta name="theme-color" content="#1E3A8A">
<title>Koneksi Database Terputus - {{ $appName ?? 'Datanet' }}</title>
<link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
<link rel="manifest" href="{{ asset('manifest.json') }}">
<style>
  :root{
    --ink:#0f172a;--muted:#64748b;--line:#e2e8f0;--soft:#f8fafc;
    --brand:#2563EB;
  }
  *,*::before,*::after{box-sizing:border-box}
  html,body{height:100%}
  body{
    margin:0;padding:28px 16px;min-height:100%;
    display:flex;align-items:center;justify-content:center;
    font-family:'Inter',ui-sans-serif,system-ui,-apple-system,'Segoe UI',Roboto,Arial,sans-serif;
    color:var(--ink);background:#172554;
    background-image:
      radial-gradient(900px 520px at 10% -12%,rgba(37,99,235,.48),transparent 62%),
      radial-gradient(760px 460px at 90% -4%,rgba(37,99,235,.30),transparent 60%),
      linear-gradient(160deg,#172554 0%,#1E3A8A 46%,#1E40AF 100%);
    -webkit-font-smoothing:antialiased;
  }
  body::after{
    content:"";position:fixed;inset:0;pointer-events:none;opacity:.55;
    background-image:radial-gradient(rgba(255,255,255,.08) 1px,transparent 1px);
    background-size:22px 22px;
  }
  .card{
    position:relative;z-index:1;width:100%;max-width:640px;
    background:rgba(255,255,255,.975);border:1px solid rgba(255,255,255,.65);
    border-radius:26px;padding:24px 22px 18px;
    box-shadow:0 30px 70px -26px rgba(23,37,84,.8),inset 0 1px 0 rgba(255,255,255,.8);
    animation:rise .55s cubic-bezier(.22,1,.36,1) both;
  }
  @media(min-width:768px){.card{padding:32px 34px 22px;border-radius:28px}}
  @keyframes rise{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
  .head{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;margin-bottom:20px}
  .brand{display:flex;align-items:center;gap:9px;font-size:15px;font-weight:700;letter-spacing:-.01em;color:#172554}
  .brand img{width:30px;height:30px;object-fit:contain;border-radius:9px;background:#fff;border:1px solid var(--line);padding:3px}
  .brand b{background:var(--brand);-webkit-background-clip:text;background-clip:text;color:transparent}
  .pill{display:inline-flex;align-items:center;gap:7px;border-radius:999px;padding:6px 11px;
    font-size:10.5px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;
    color:#9a3412;background:#fff7ed;border:1px solid #fed7aa}
  .pill .dot{width:6px;height:6px;border-radius:999px;background:#f97316;box-shadow:0 0 0 3px rgba(249,115,22,.18);animation:blink 1.9s ease-in-out infinite}
  @keyframes blink{0%,100%{opacity:1}50%{opacity:.35}}
  .hero{text-align:center}
  .icon-wrap{position:relative;display:inline-grid;place-items:center;width:74px;height:74px;margin-bottom:15px;
    border-radius:22px;background:#EFF6FF;border:1px solid #DBEAFE;color:var(--brand);
    box-shadow:0 12px 26px -14px rgba(37,99,235,.75)}
  .icon-wrap svg.main{width:34px;height:34px}
  .icon-badge{position:absolute;right:-6px;bottom:-6px;width:27px;height:27px;border-radius:999px;
    background:#fff7ed;border:1px solid #fed7aa;display:grid;place-items:center;color:#ea580c;
    box-shadow:0 4px 10px -6px rgba(234,88,12,.7)}
  .icon-badge svg{width:13px;height:13px}
  h1{margin:0 0 8px;font-size:clamp(20px,4.6vw,25px);line-height:1.22;letter-spacing:-.02em;font-weight:700;color:#111827}
  .lead{margin:0 auto;max-width:46ch;font-size:13px;line-height:1.65;color:var(--muted)}
  .reason{display:flex;gap:11px;margin:19px 0 15px;padding:12px 14px;border-radius:16px;background:#fffbeb;border:1px solid #fde68a}
  .reason-ico{flex:none;width:22px;height:22px;border-radius:999px;background:#f59e0b;color:#fff;font-size:12px;font-weight:700;display:grid;place-items:center}
  .reason p{margin:0}
  .reason .t{font-size:10px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:#92400e}
  .reason .d{margin-top:3px;font-size:12.5px;line-height:1.6;color:#78350f}
  .steps{list-style:none;margin:0 0 19px;padding:0;display:grid;gap:9px}
  .steps li{display:flex;gap:10px;align-items:flex-start;font-size:12.5px;line-height:1.6;color:#475569}
  .steps .n{flex:none;margin-top:1px;width:20px;height:20px;border-radius:7px;background:#EFF6FF;color:#2563EB;
    font-size:11px;font-weight:700;display:grid;place-items:center}
  .steps p{margin:0}
  .steps b{color:#1e293b;font-weight:600}
  .actions{display:flex;flex-wrap:wrap;align-items:center;gap:10px 14px;padding-top:2px}
  .btn{display:inline-flex;align-items:center;gap:8px;border:0;cursor:pointer;font:inherit;font-size:12.5px;font-weight:600;
    padding:11px 18px;border-radius:13px;transition:transform .18s ease,box-shadow .18s ease}
  .btn svg{width:14px;height:14px}
  .btn-primary{color:#fff;background:var(--brand);
    box-shadow:0 12px 24px -13px rgba(37,99,235,.9)}
  .btn-primary:hover{transform:translateY(-1px);box-shadow:0 16px 30px -14px rgba(37,99,235,1)}
  .btn-primary:active{transform:translateY(0)}
  .countdown{margin:0;font-size:11.5px;color:#94a3b8}
  .countdown b{color:var(--brand);font-variant-numeric:tabular-nums}
  .foot{display:flex;flex-wrap:wrap;gap:5px 14px;align-items:center;justify-content:center;margin-top:17px;
    padding-top:13px;border-top:1px solid var(--line);font-size:10.5px;color:#94a3b8}
  @media(prefers-reduced-motion:reduce){.card,.pill .dot{animation:none!important}*{transition:none!important}}
</style>
</head>
<body>
<main class="card" role="alert" aria-labelledby="db-title">
  <div class="head">
    <span class="pill"><span class="dot" aria-hidden="true"></span>503 &middot; Layanan Tidak Tersedia</span>
    <div class="brand">
      <img src="{{ asset('logo.png') }}" alt="Logo {{ $appName ?? 'Datanet' }}">
      <span>Data<b>net</b></span>
    </div>
  </div>

  <div class="hero">
    <div class="icon-wrap" aria-hidden="true">
      <svg class="main" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
        <ellipse cx="12" cy="5" rx="7.5" ry="3"></ellipse>
        <path d="M4.5 5v6c0 1.66 3.36 3 7.5 3s7.5-1.34 7.5-3V5"></path>
        <path d="M4.5 11v6c0 1.66 3.36 3 7.5 3s7.5-1.34 7.5-3v-6"></path>
      </svg>
      <span class="icon-badge">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.2" stroke-linecap="round" aria-hidden="true">
          <path d="M6 6l12 12M18 6L6 18"></path>
        </svg>
      </span>
    </div>
    <h1 id="db-title">Koneksi Database Terputus</h1>
    <p class="lead">Aplikasi tidak dapat terhubung ke server database saat ini. Data Anda tetap aman &mdash;
      ini hanya gangguan koneksi sementara. Halaman akan mencoba menyambung ulang secara otomatis.</p>
  </div>

  <div class="reason">
    <span class="reason-ico" aria-hidden="true">!</span>
    <div>
      <p class="t">Kesalahan Database</p>
      <p class="d">{{ $reason }}</p>
    </div>
  </div>

  <ol class="steps">
    <li><span class="n">1</span><p>Tunggu sebentar &mdash; halaman ini akan mencoba menyambung ulang secara otomatis.</p></li>
    <li><span class="n">2</span><p>Tekan <b>Coba Lagi</b> bila Anda ingin mencoba saat ini juga.</p></li>
    <li><span class="n">3</span><p>Jika gangguan berlangsung lama, silakan hubungi admin/IT.</p></li>
  </ol>

  <div class="actions">
    <button type="button" id="retryBtn" class="btn btn-primary">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M20 11a8 8 0 1 0-2.34 5.66"></path>
        <path d="M20 4v7h-7"></path>
      </svg>
      Coba Lagi
    </button>
    <p class="countdown" id="countdown" aria-live="polite"></p>
  </div>

  <div class="foot">
    <span>&copy; {{ date('Y') }} {{ $appName ?? 'Datanet' }} &middot; Payroll &amp; Voucher</span>
  </div>
</main>
<script>
(function () {
  var remaining = {{ (int) ($retrySeconds ?? 20) }};
  var label = document.getElementById('countdown');
  var button = document.getElementById('retryBtn');

  function paint() {
    if (label) {
      label.innerHTML = 'Mencoba otomatis dalam <b>' + remaining + '</b> detik&hellip;';
    }
  }

  paint();

  var timer = setInterval(function () {
    remaining -= 1;

    if (remaining <= 0) {
      clearInterval(timer);
      if (label) { label.textContent = 'Menghubungkan ulang\u2026'; }
      window.location.reload();
      return;
    }

    paint();
  }, 1000);

  if (button) {
    button.addEventListener('click', function () {
      clearInterval(timer);
      window.location.reload();
    });
  }

  window.addEventListener('online', function () {
    window.location.reload();
  });
})();
</script>
</body>
</html>

