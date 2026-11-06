<header class="h-16 lg:h-20 bg-white/70 backdrop-blur-md border-b border-blue-50/80 px-4 lg:px-8 flex items-center justify-between gap-3 sticky top-0 z-30">
    <!-- Hamburger & Search Bar -->
    <div class="flex items-center gap-3 min-w-0">
        <button type="button" id="openSidebar" class="lg:hidden grid h-10 w-10 shrink-0 place-items-center rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition" aria-label="Buka Menu">
            <i class="fa-solid fa-bars text-base"></i>
        </button>

        <div class="relative hidden sm:block sm:w-64 md:w-80 lg:w-96">
            <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Cari karyawan, transaksi penjualan, atau slip gaji..." class="w-full pl-11 pr-4 py-2.5 rounded-full bg-slate-50 border border-slate-200/70 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
        </div>
    </div>

    <!-- Aksi Topbar -->
    <div class="flex items-center gap-2 sm:gap-3 shrink-0">
        <!-- Notifikasi -->
        <button class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-50 border border-slate-200/70 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition" aria-label="Notifikasi">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            <span class="w-2 h-2 bg-rose-500 rounded-full absolute top-2 right-2 ring-2 ring-white"></span>
        </button>

        <!-- CTA Utama -->
        <a href="{{ route('transactions.create') }}" class="flex items-center gap-1.5 sm:gap-2 px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs shadow-md shadow-blue-600/30 transition">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span class="hidden sm:inline">+ Input Penjualan</span>
            <span class="sm:hidden font-bold">Jual</span>
        </a>
    </div>
</header>