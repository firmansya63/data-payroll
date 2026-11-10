@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- 1. HERO HEADER GREETING -->
    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Selamat Pagi, {{ auth()->user()->name ?? 'User' }} 👋</h2>
            <p class="text-sm text-slate-500 mt-1">
                Ringkasan operasional tim hari ini: <span class="font-semibold text-slate-700">{{ $attendanceRatio }}%</span> karyawan hadir tepat waktu & target penjualan ritel berjalan optimal.
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
                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $hadirHariIni > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-600' }}">
                    {{ $hadirHariIni }} Hadir
                </span>
            </div>
            <p class="text-xs font-medium text-slate-500">Karyawan Hadir Hari Ini</p>
            <h3 class="text-xl font-extrabold text-slate-900 mt-1">{{ $hadirHariIni }} <span class="text-xs font-normal text-slate-400">/ {{ $karyawanAktif }} Staf</span></h3>
            <p class="text-[11px] text-emerald-600 font-medium mt-1">{{ $attendanceRatio }}% rasio kehadiran tim</p>
        </div>

        <!-- Card 2: Penjualan Hari Ini -->
        <div class="bg-white p-5 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    💳
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">Hari Ini</span>
            </div>
            <p class="text-xs font-medium text-slate-500">Penjualan Hari Ini</p>
            <h3 class="text-xl font-extrabold text-slate-900 mt-1">{{ \App\Helpers\FormatHelper::rupiahSingkat($penjualanHariIni) }}</h3>
            <p class="text-[11px] text-slate-400 font-medium mt-1">Total lunas: <span class="text-slate-700 font-semibold">{{ \App\Helpers\FormatHelper::rupiahSingkat($totalLunas) }}</span></p>
        </div>

        <!-- Card 3: Estimasi Payroll -->
        <div class="bg-white p-5 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    💼
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600">Bulan Ini</span>
            </div>
            <p class="text-xs font-medium text-slate-500">Estimasi Payroll {{ now()->translatedFormat('M') }}</p>
            <h3 class="text-xl font-extrabold text-slate-900 mt-1">{{ \App\Helpers\FormatHelper::rupiahSingkat($estimasiPayrollBulanIni) }}</h3>
            <p class="text-[11px] text-slate-400 font-medium mt-1">🛡️ {{ $karyawanAktif }} Staf aktif terdaftar</p>
        </div>

        <!-- Card 4: Status Piutang -->
        <div class="bg-white p-5 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold">
                    ⏱️
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $totalPiutang > 0 ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }}">
                    {{ $totalPiutang > 0 ? 'Perlu Follow Up' : 'Aman' }}
                </span>
            </div>
            <p class="text-xs font-medium text-slate-500">Total Piutang Belum Lunas</p>
            <h3 class="text-xl font-extrabold text-slate-900 mt-1">{{ \App\Helpers\FormatHelper::rupiahSingkat($totalPiutang) }}</h3>
            <p class="text-[11px] text-slate-400 font-medium mt-1">🕒 {{ $transaksiBulanIni }} transaksi bulan ini</p>
        </div>
    </div>

    <!-- 3. MAIN DASHBOARD CONTENT (KONTEN UTAMA + SIDEBAR KANAN) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- AREA KIRI / TENGAH (8 KOLOM) -->
        <div class="lg:col-span-8 space-y-6">
            <!-- TABEL MONITORING KARYAWAN & PENJUALAN -->
            <div class="bg-white p-6 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]" x-data="{ search: '', filterJabatan: 'all' }">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Monitoring Karyawan & Penjualan</h3>
                        <p class="text-xs text-slate-500">Status absensi hari ini & capaian insentif klien baru per karyawan aktif</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="text" x-model="search" placeholder="Cari nama karyawan..." class="px-3.5 py-1.5 rounded-full bg-slate-50 border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Tabs Filter -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <button type="button" @click="filterJabatan = 'all'" :class="filterJabatan === 'all' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-4 py-1.5 rounded-full text-xs font-semibold transition">
                        Semua Tim ({{ $monitoringEmployees->count() }})
                    </button>
                    <button type="button" @click="filterJabatan = 'marketing'" :class="filterJabatan === 'marketing' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-4 py-1.5 rounded-full text-xs font-medium transition">
                        Marketing ({{ $monitoringEmployees->where('jabatan', 'marketing')->count() }})
                    </button>
                    <button type="button" @click="filterJabatan = 'teknisi'" :class="filterJabatan === 'teknisi' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-4 py-1.5 rounded-full text-xs font-medium transition">
                        Teknisi ({{ $monitoringEmployees->where('jabatan', 'teknisi')->count() }})
                    </button>
                    <button type="button" @click="filterJabatan = 'admin'" :class="filterJabatan === 'admin' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-4 py-1.5 rounded-full text-xs font-medium transition">
                        Admin ({{ $monitoringEmployees->where('jabatan', 'admin')->count() }})
                    </button>
                    @if($monitoringEmployees->where('jabatan', 'lainnya')->count() > 0)
                    <button type="button" @click="filterJabatan = 'lainnya'" :class="filterJabatan === 'lainnya' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-4 py-1.5 rounded-full text-xs font-medium transition">
                        Lainnya ({{ $monitoringEmployees->where('jabatan', 'lainnya')->count() }})
                    </button>
                    @endif
                </div>

                <!-- Data Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="text-slate-400 font-semibold border-b border-slate-100">
                            <tr>
                                <th class="pb-3">KARYAWAN</th>
                                <th class="pb-3 text-center">JAM MASUK</th>
                                <th class="pb-3 text-center">STATUS ABSEN</th>
                                <th class="pb-3">INSENTIF KLIEN (BLN INI)</th>
                                <th class="pb-3 text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($monitoringEmployees as $emp)
                            <tr class="hover:bg-blue-50/30 transition"
                                x-show="(filterJabatan === 'all' || filterJabatan === '{{ $emp->jabatan }}') && ('{{ strtolower($emp->nama) }}'.includes(search.toLowerCase()) || search === '')">
                                <td class="py-3.5 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                        {{ strtoupper(substr($emp->nama, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $emp->nama }}</p>
                                        <p class="text-[11px] text-slate-400 uppercase font-medium">{{ ucfirst($emp->jabatan) }} {{ $emp->no_hp ? '• ' . $emp->no_hp : '' }}</p>
                                    </div>
                                </td>
                                <td class="py-3.5 text-center font-medium text-slate-700">
                                    {{ $emp->jam_masuk }}
                                </td>
                                <td class="py-3.5 text-center">
                                    @if($emp->status_absen === 'hadir')
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700">● Hadir</span>
                                    @elseif($emp->status_absen === 'izin')
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-100 text-blue-700">● Izin</span>
                                    @elseif($emp->status_absen === 'sakit')
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-700">● Sakit</span>
                                    @elseif($emp->status_absen === 'alpha')
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-700">● Alpha</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-500">○ Belum Absen</span>
                                    @endif
                                </td>
                                <td class="py-3.5">
                                    <div class="flex items-center justify-between text-xs font-semibold mb-1">
                                        <span>{{ \App\Helpers\FormatHelper::rupiahSingkat($emp->insentif_bulan_ini) }}</span>
                                        <span class="text-blue-600 font-bold">{{ $emp->klien_bulan_ini }} Klien</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-blue-600 h-full rounded-full" style="width: {{ min(100, $emp->klien_bulan_ini * 10) }}%"></div>
                                    </div>
                                </td>
                                <td class="py-3.5 text-right font-medium">
                                    <a href="{{ route('presences.calendar', ['employee_id' => $emp->id]) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 text-xs font-semibold hover:underline" title="Lihat Riwayat Presensi">
                                        Absensi →
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    Belum ada data karyawan aktif. <a href="{{ route('employees.create') }}" class="text-blue-600 underline font-semibold">Tambah karyawan baru</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Info -->
                <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-xs text-slate-500">
                    <span>Menampilkan {{ $monitoringEmployees->count() }} karyawan aktif terdaftar</span>
                    <a href="{{ route('employees.index') }}" class="text-blue-600 font-semibold hover:underline">Kelola Karyawan →</a>
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
                        <a href="{{ route('presences.calendar') }}" class="text-xs text-blue-600 font-semibold hover:underline">Kalender</a>
                    </div>
                    <div class="flex flex-col items-center justify-center py-3">
                        <div class="relative w-36 h-36 flex items-center justify-center">
                            <!-- Visual Ring SVG -->
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="15.9155" fill="transparent" stroke="#F1F5F9" stroke-width="3"></circle>
                                <circle cx="18" cy="18" r="15.9155" fill="transparent" stroke="#10B981" stroke-width="3.5" stroke-dasharray="{{ $attendanceRatio }}, 100" stroke-linecap="round"></circle>
                            </svg>
                            <div class="absolute text-center">
                                <span class="text-2xl font-extrabold text-slate-900">{{ $karyawanAktif }}</span>
                                <p class="text-[10px] text-slate-400 uppercase font-semibold">TOTAL STAF</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-1.5 text-xs pt-2">
                        <div class="flex justify-between items-center">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Hadir</span>
                            <span class="font-semibold text-slate-700">{{ $hadirHariIni }} ({{ $attendanceRatio }}%)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span> Cuti / Izin / Sakit</span>
                            <span class="font-semibold text-slate-700">{{ $izinHariIni }} ({{ $karyawanAktif > 0 ? round(($izinHariIni / $karyawanAktif) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Alpha</span>
                            <span class="font-semibold text-slate-700">{{ $alphaHariIni }} ({{ $karyawanAktif > 0 ? round(($alphaHariIni / $karyawanAktif) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-slate-300"></span> Belum Absen</span>
                            <span class="font-semibold text-slate-700">{{ $belumAbsenHariIni }} ({{ $karyawanAktif > 0 ? round(($belumAbsenHariIni / $karyawanAktif) * 100, 1) : 0 }}%)</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Log Aktivitas Terkini -->
                <div class="bg-white p-6 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="font-bold text-slate-900">Aktivitas Terkini</h4>
                            <p class="text-xs text-slate-400">Transaksi voucher terbaru</p>
                        </div>
                        <a href="{{ route('transactions.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">Lihat Semua</a>
                    </div>
                    <div class="space-y-3.5 text-xs">
                        @forelse($lunasTerbaru->take(3) as $tx)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">🧾</div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-slate-800 truncate">{{ $tx->reseller->nama ?? 'Reseller' }}</span>
                                    <span class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($tx->tanggal)->diffForHumans() }}</span>
                                </div>
                                <p class="text-[11px] text-slate-500">Penjualan lunas • {{ \App\Helpers\FormatHelper::rupiahSingkat($tx->nominal) }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-6 text-slate-400">
                            Belum ada transaksi lunas tercatat.
                        </div>
                        @endforelse
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-center gap-1.5 text-[11px] text-slate-400">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Sistem & Database Aktif
                    </div>
                </div>
            </div>
        </div>

        <!-- AREA KANAN (4 KOLOM) -->
        <div class="lg:col-span-4 space-y-6">
            <!-- GRAFIK PENJUALAN 6 BULAN TERAKHIR -->
            <div class="bg-white p-6 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="font-bold text-slate-900">Tren Penjualan 6 Bulan</h4>
                        <p class="text-xs text-slate-400">Total voucher terdistribusi</p>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600">Bulanan</span>
                </div>
                <div class="space-y-2 text-xs">
                    @php
                        $maxTotal = max(1, $chartTotals->max());
                    @endphp
                    @foreach($chart as $item)
                        @php
                            $pct = round(($item['total'] / $maxTotal) * 100);
                        @endphp
                        <div>
                            <div class="flex justify-between items-center text-[11px] mb-1">
                                <span class="font-medium text-slate-600">{{ $item['label'] }}</span>
                                <span class="font-bold text-slate-900">{{ \App\Helpers\FormatHelper::rupiahSingkat($item['total']) }}</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-blue-600 h-full rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- TOP KARYAWAN BERDASARKAN CAPAIAN INSENTIF / KLIEN -->
            <div class="bg-white p-6 rounded-3xl border border-blue-50/80 shadow-[0_10px_25px_-5px_rgba(203,219,245,0.45)]">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-bold text-slate-900">Top Performa Tim</h4>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">Bulan Ini</span>
                </div>
                <div class="space-y-3 text-xs">
                    @forelse($topEmployees->take(3) as $index => $topEmp)
                    <div class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-50/80">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-6 h-6 rounded-full {{ $index === 0 ? 'bg-amber-100 text-amber-700' : ($index === 1 ? 'bg-blue-100 text-blue-700' : 'bg-slate-200 text-slate-700') }} font-extrabold flex items-center justify-center text-xs shrink-0">
                                {{ $index + 1 }}
                            </span>
                            <div class="min-w-0">
                                <p class="font-bold text-slate-900 truncate">{{ $topEmp->nama }}</p>
                                <p class="text-[10px] text-blue-600 font-semibold">{{ $topEmp->klien_bulan_ini }} Klien Baru • {{ ucfirst($topEmp->jabatan) }}</p>
                            </div>
                        </div>
                        <span class="font-extrabold text-slate-900 shrink-0 ml-2">{{ \App\Helpers\FormatHelper::rupiahSingkat($topEmp->insentif_bulan_ini) }}</span>
                    </div>
                    @empty
                    <div class="text-center py-4 text-slate-400">
                        Belum ada data capaian klien baru bulan ini.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
