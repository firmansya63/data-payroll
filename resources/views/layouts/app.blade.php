<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Datanet - HR & Retail Core' }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome (dipakai 150+ ikon di halaman dalam layout ini) -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Tailwind via Vite atau CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: '#2563EB',
                        surface: '#EEF4FB',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#EEF4FB] text-slate-800 antialiased min-h-screen">
    @php($attendanceOnly = auth()->check() && auth()->user()->isAttendanceOnly())

    @if($attendanceOnly)
        <header class="flex min-h-16 items-center justify-between border-b border-emerald-100 bg-white px-4 shadow-sm">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-emerald-600">Mode Perangkat</p>
                <h1 class="text-sm font-extrabold text-slate-800">Scanner Absensi</h1>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:bg-rose-50 hover:text-rose-600">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </header>
        <main class="mx-auto w-full max-w-2xl p-4 sm:p-6">
            @yield('content')
        </main>
    @else
        <!-- Sidebar Overlay Mobile -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 hidden lg:hidden transition-opacity"></div>

        <div class="flex min-h-screen">
            <!-- Sidebar -->
            @include('layouts.partials.sidebar')

            <!-- Main Content Wrapper -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Topbar Header -->
                @include('layouts.partials.topbar')

                <!-- Main Page Content -->
                <main class="flex-1 p-3.5 sm:p-5 lg:p-8 max-w-[1600px] w-full mx-auto">
                    @yield('content')
                </main>
            </div>
        </div>
    @endif
    <script>
    (function() {
        const sb = document.getElementById('sidebar');
        const ov = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        function openSidebar() {
            if (!sb) return;
            sb.classList.remove('-translate-x-full');
            if (ov) ov.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            if (!sb) return;
            sb.classList.add('-translate-x-full');
            if (ov) ov.classList.add('hidden');
            document.body.style.overflow = '';
        }

        if (openBtn) openBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (ov) ov.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSidebar();
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });
    })();
    </script>
    @stack('js')
    @stack('scripts')
</body>
</html>