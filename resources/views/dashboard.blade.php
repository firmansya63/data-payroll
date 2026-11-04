@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- 1. HERO HEADER GREETING -->
    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wide uppercase bg-blue-100 text-blue-700">
                    JAKARTA CENTRAL STORE #01
                </span>
                <span class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Live System
                </span>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Selamat Pagi, Sarah 👋</h2>
            <p class="text-sm text-slate-500 mt-1">
                Ringkasan operasional tim hari ini: <span class="font-semibold text-slate-700">94.6%</span> karyawan hadir tepat waktu & target penjualan ritel berjalan optimal.
            </p>
        </div>

    </div>

    <!-- 2. GRID 4 KPI STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Karyawan Hadir -->
        <div class="bg-white p-5 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    👥
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">↑ +2.4%</span>
            </div>
            <p class="text-xs font-medium text-slate-500">Karyawan Hadir</p>
            <h3 class="text-2xl font-extrabold text-slate-900 mt-1">142 <span class="text-sm font-normal text-slate-400">/ 150</span></h3>
            <p class="text-[11px] text-emerald-600 font-medium mt-1">94.6% rasio kehadiran tim</p>
        </div>

        <!-- Card 2: Penjualan Hari Ini -->
        <div class="bg-white p-5 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    💳
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">↑ +14.2%</span>
            </div>
            <p class="text-xs font-medium text-slate-500">Penjualan Hari Ini</p>
            <h3 class="text-2xl font-extrabold text-slate-900 mt-1">Rp 18.45M</h3>
            <p class="text-[11px] text-slate-400 font-medium mt-1">Target hari ini: <span class="text-slate-700 font-semibold">Rp 20.00M (92%)</span></p>
        </div>

        <!-- Card 3: Estimasi Payroll -->
        <div class="bg-white p-5 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                    💼
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600">Siap Payroll</span>
            </div>
            <p class="text-xs font-medium text-slate-500">Estimasi Payroll Feb</p>
            <h3 class="text-2xl font-extrabold text-slate-900 mt-1">Rp 684.2M</h3>
            <p class="text-[11px] text-slate-400 font-medium mt-1">🛡️ 150 Slip terverifikasi BPJS</p>
        </div>

        <!-- Card 4: Rata-rata Jam Kerja -->
        <div class="bg-white p-5 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold">
                    ⏱️
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">Normal</span>
            </div>
            <p class="text-xs font-medium text-slate-500">Rata-rata Jam Kerja</p>
            <h3 class="text-2xl font-extrabold text-slate-900 mt-1">7.8 Jam</h3>
            <p class="text-[11px] text-slate-400 font-medium mt-1">🕒 14 Jam lembur tercatat</p>
        </div>
    </div>

    <!-- 3. MAIN DASHBOARD CONTENT (KONTEN UTAMA + SIDEBAR KANAN) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- AREA KIRI / TENGAH (8 KOLOM) -->
        <div class="lg:col-span-8 space-y-6">
            <!-- TABEL MONITORING KARYAWAN & PENJUALAN -->
            <div class="bg-white p-6 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Monitoring Karyawan & Penjualan</h3>
                        <p class="text-xs text-slate-500">Status absensi langsung terintegrasi dengan capaian POS per shift</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="text" placeholder="Filter nama/NIK..." class="px-3.5 py-1.5 rounded-full bg-slate-50 border border-slate-200 text-xs focus:outline-none">
                    </div>
                </div>

                <!-- Tabs Filter -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <button class="px-4 py-1.5 rounded-full bg-blue-600 text-white text-xs font-semibold">Semua Tim (150)</button>
                    <button class="px-4 py-1.5 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-medium transition">Tim Sales & Kasir (48)</button>
                    <button class="px-4 py-1.5 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-medium transition">Operasional Toko (62)</button>
                    <button class="px-4 py-1.5 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-medium transition">Back-Office (40)</button>
                </div>

                <!-- Data Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="text-slate-400 font-semibold border-b border-slate-100">
                            <tr>
                                <th class="pb-3">KARYAWAN</th>
                                <th class="pb-3 text-center">JAM MASUK</th>
                                <th class="pb-3 text-center">STATUS ABSEN</th>
                                <th class="pb-3">CAPAIAN SALES HARI INI</th>
                                <th class="pb-3 text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <!-- Row 1 -->
                            <tr class="hover:bg-blue-50/30 transition">
                                <td class="py-3.5 flex items-center gap-3">
                                    <img class="w-9 h-9 rounded-full object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80" alt="Dimas">
                                    <div>
                                        <p class="font-bold text-slate-900">Dimas Pratama</p>
                                        <p class="text-[11px] text-slate-400">NIK-8821 • Kasir Senior</p>
                                    </div>
                                </td>
                                <td class="py-3.5 text-center font-medium text-slate-700">07:48 WIB</td>
                                <td class="py-3.5 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700">● Tepat Waktu</span>
                                </td>
                                <td class="py-3.5">
                                    <div class="flex items-center justify-between text-xs font-semibold mb-1">
                                        <span>Rp 4.200.000</span>
                                        <span class="text-emerald-600">105%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-emerald-500 h-full rounded-full" style="width: 100%"></div>
                                    </div>
                                </td>
                                <td class="py-3.5 text-right text-slate-400 hover:text-slate-600 cursor-pointer font-bold">⋮</td>
                            </tr>
                            <!-- Row 2 -->
                            <tr class="hover:bg-blue-50/30 transition">
                                <td class="py-3.5 flex items-center gap-3">
                                    <img class="w-9 h-9 rounded-full object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&auto=format&fit=crop&q=80" alt="Siti">
                                    <div>
                                        <p class="font-bold text-slate-900">Siti Rahma</p>
                                        <p class="text-[11px] text-slate-400">NIK-8834 • Sales Associate</p>
                                    </div>
                                </td>
                                <td class="py-3.5 text-center font-medium text-slate-700">07:55 WIB</td>
                                <td class="py-3.5 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700">● Tepat Waktu</span>
                                </td>
                                <td class="py-3.5">
                                    <div class="flex items-center justify-between text-xs font-semibold mb-1">
                                        <span>Rp 4.800.000</span>
                                        <span class="text-blue-600">96%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-blue-600 h-full rounded-full" style="width: 96%"></div>
                                    </div>
                                </td>
                                <td class="py-3.5 text-right text-slate-400 hover:text-slate-600 cursor-pointer font-bold">⋮</td>
                            </tr>
                            <!-- Row 3 -->
                            <tr class="hover:bg-blue-50/30 transition">
                                <td class="py-3.5 flex items-center gap-3">
                                    <img class="w-9 h-9 rounded-full object-cover" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80" alt="Budi">
                                    <div>
                                        <p class="font-bold text-slate-900">Budi Santoso</p>
                                        <p class="text-[11px] text-slate-400">NIK-8790 • Inventory SPV</p>
                                    </div>
                                </td>
                                <td class="py-3.5 text-center font-bold text-rose-600">08:12 WIB</td>
                                <td class="py-3.5 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-700">● Terlambat 12m</span>
                                </td>
                                <td class="py-3.5">
                                    <div class="text-[11px] text-slate-400">Operasional Gudang • 100% Audit</div>
                                    <div class="w-full bg-purple-100 h-1.5 rounded-full mt-1 overflow-hidden">
                                        <div class="bg-purple-600 h-full rounded-full" style="width: 100%"></div>
                                    </div>
                                </td>
                                <td class="py-3.5 text-right text-slate-400 hover:text-slate-600 cursor-pointer font-bold">⋮</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination -->
                <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-xs text-slate-500">
                    <span>Menampilkan 5 dari 150 staf terdaftar</span>
                    <div class="flex gap-2">
                        <button class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 font-medium">Sebelumnya</button>
                        <button class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700">Berikutnya</button>
                    </div>
                </div>
            </div>

            <!-- ROW 2 WIDGETS (DISTRIBUSI ABSENSI + AKTIVITAS TERKINI) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Donut Chart Distribusi Absensi -->
                <div class="bg-white p-6 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="font-bold text-slate-900">Distribusi Absensi</h4>
                            <p class="text-xs text-slate-400">Sesi Kerja Hari Ini</p>
                        </div>
                        <span class="text-slate-300">🔄</span>
                    </div>
                    <div class="flex flex-col items-center justify-center py-3">
                        <div class="relative w-36 h-36 flex items-center justify-center">
                            <!-- Visual Ring SVG -->
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="15.9155" fill="transparent" stroke="#F1F5F9" stroke-width="3"></circle>
                                <circle cx="18" cy="18" r="15.9155" fill="transparent" stroke="#10B981" stroke-width="3.5" stroke-dasharray="94.6, 100" stroke-linecap="round"></circle>
                            </svg>
                            <div class="absolute text-center">
                                <span class="text-2xl font-extrabold text-slate-900">150</span>
                                <p class="text-[10px] text-slate-400 uppercase font-semibold">TOTAL STAF</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-1.5 text-xs pt-2">
                        <div class="flex justify-between items-center">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Hadir Tepat Waktu</span>
                            <span class="font-semibold text-slate-700">142 (94.6%)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> Cuti / Izin Sakit</span>
                            <span class="font-semibold text-slate-700">5 (3.4%)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Terlambat Masuk</span>
                            <span class="font-semibold text-slate-700">3 (2.0%)</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Log Aktivitas Terkini -->
                <div class="bg-white p-6 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="font-bold text-slate-900">Aktivitas Terkini</h4>
                            <p class="text-xs text-slate-400">Log real-time kasir & HR</p>
                        </div>
                        <a href="{{ route('transactions.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">Lihat Semua</a>
                    </div>
                    <div class="space-y-3.5 text-xs">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">🧾</div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <span class="font-bold text-slate-800">Siti Rahma mencat...</span>
                                    <span class="text-[10px] text-slate-400">2 mnt lalu</span>
                                </div>
                                <p class="text-[11px] text-slate-500">Struk POS #TX-8839 • Rp 450.0...</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">📍</div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <span class="font-bold text-slate-800">Budi Santoso cloc...</span>
                                    <span class="text-[10px] text-slate-400">15 mnt lalu</span>
                                </div>
                                <p class="text-[11px] text-slate-500">Outlet Jakarta Pusat • GPS Akurat</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">📝</div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <span class="font-bold text-slate-800">Lembur disetujui ...</span>
                                    <span class="text-[10px] text-slate-400">45 mnt lalu</span>
                                </div>
                                <p class="text-[11px] text-slate-500">2 Staf Shift Malam disetujui Sarah</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-center gap-1.5 text-[11px] text-slate-400">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Sinkronisasi POS & Cloud Aktif
                    </div>
                </div>
            </div>
        </div>

        <!-- AREA KANAN (4 KOLOM) -->
        <div class="lg:col-span-4 space-y-6">
            <!-- WIDGET AKSI CEPAT -->
            <div class="bg-white p-6 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-bold text-slate-900">Aksi Cepat</h4>
                    <span class="text-amber-500">⚡</span>
                </div>
                <div class="space-y-2.5">
                    <a href="{{ route('payrolls.create') }}" class="flex items-center justify-between p-3 rounded-2xl bg-blue-50/50 hover:bg-blue-100/50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center">💼</div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Proses Payroll Sekaligus</p>
                                <p class="text-[10px] text-slate-400">Kalkulasi 150 staf langsung</p>
                            </div>
                        </div>
                        <span class="text-slate-400 text-sm">›</span>
                    </a>
                    <a href="{{ route('transactions.create') }}" class="flex items-center justify-between p-3 rounded-2xl bg-emerald-50/50 hover:bg-emerald-100/50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center">🏪</div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Buka Kasir / POS Baru</p>
                                <p class="text-[10px] text-slate-400">Terminal kasir outlet</p>
                            </div>
                        </div>
                        <span class="text-slate-400 text-sm">›</span>
                    </a>
                    <a href="{{ route('presences.calendar') }}" class="flex items-center justify-between p-3 rounded-2xl bg-purple-50/50 hover:bg-purple-100/50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-purple-600 text-white flex items-center justify-center">📥</div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Ekspor Rekap Absensi</p>
                                <p class="text-[10px] text-slate-400">Format Excel (.xlsx) / PDF</p>
                            </div>
                        </div>
                        <span class="text-slate-400 text-sm">›</span>
                    </a>
                    <a href="{{ route('presences.bulk') }}" class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 hover:bg-slate-100 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-slate-700 text-white flex items-center justify-center">📑</div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Input Izin & Lembur</p>
                                <p class="text-[10px] text-slate-400">Form pengajuan manual SPV</p>
                            </div>
                        </div>
                        <span class="text-slate-400 text-sm">›</span>
                    </a>
                </div>
            </div>

            <!-- GRAFIK WAVE PERFORMA PENJUALAN -->
            <div class="bg-white p-6 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
                <div class="flex items-center justify-between mb-1">
                    <p class="text-xs text-slate-400 font-medium">Performa Penjualan</p>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">↑ +18.4%</span>
                </div>
                <h3 class="text-2xl font-extrabold text-slate-900 mb-4">Rp 128.85M</h3>
                <!-- Smooth Wave SVG Chart -->
                <div class="h-28 w-full">
                    <svg class="w-full h-full" viewBox="0 0 300 100" fill="none">
                        <path d="M0 80 Q 50 85, 100 60 T 200 40 T 300 15" stroke="#2563EB" stroke-width="3" fill="none"></path>
                        <path d="M0 80 Q 50 85, 100 60 T 200 40 T 300 15 L 300 100 L 0 100 Z" fill="url(#blueGradient)" opacity="0.15"></path>
                        <defs>
                            <linearGradient id="blueGradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#2563EB"/>
                                <stop offset="100%" stop-color="#2563EB" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <circle cx="200" cy="40" r="4" fill="#2563EB"></circle>
                        <circle cx="300" cy="15" r="4" fill="#2563EB"></circle>
                    </svg>
                </div>
                <div class="flex justify-between text-[10px] font-semibold text-slate-400 mt-2">
                    <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span class="text-blue-600 font-bold">Min</span>
                </div>
            </div>

            <!-- TOP SALES LEADERBOARD -->
            <div class="bg-white p-6 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-bold text-slate-900">Top Sales Hari Ini</h4>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">Live Ranking</span>
                </div>
                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-50/80">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-700 font-extrabold flex items-center justify-center text-xs">1</span>
                            <div>
                                <p class="font-bold text-slate-900">Annisa Putri</p>
                                <p class="text-[10px] text-emerald-600 font-semibold">128% dari target</p>
                            </div>
                        </div>
                        <span class="font-extrabold text-slate-900">Rp 6.4M</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-50/80">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 font-extrabold flex items-center justify-center text-xs">2</span>
                            <div>
                                <p class="font-bold text-slate-900">Siti Rahma</p>
                                <p class="text-[10px] text-blue-600 font-semibold">96% dari target</p>
                            </div>
                        </div>
                        <span class="font-extrabold text-slate-900">Rp 4.8M</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-50/80">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-700 font-extrabold flex items-center justify-center text-xs">3</span>
                            <div>
                                <p class="font-bold text-slate-900">Dimas Pratama</p>
                                <p class="text-[10px] text-slate-500 font-semibold">84% dari target</p>
                            </div>
                        </div>
                        <span class="font-extrabold text-slate-900">Rp 4.2M</span>
                    </div>
                </div>
            </div>

            <!-- CARD TIPS EFISIENSI HR -->
            <div class="p-6 rounded-3xl bg-blue-50/60 border border-blue-100/70">
                <div class="flex items-center gap-2 text-blue-700 font-bold text-xs mb-2">
                    <span>💡</span> Tips Efisiensi HR
                </div>
                <p class="text-xs text-slate-600 leading-relaxed mb-4">
                    Otomatisasi kalkulasi BPJS Ketenagakerjaan & tarif efektif PPh 21 TER 2025 kini aktif. Hindari rekap manual saat penutupan buku akhir bulan.
                </p>
                <button class="w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs transition">
                    Pelajari Detail Payroll
                </button>
            </div>
        </div>
    </div>
</div>
@endsection