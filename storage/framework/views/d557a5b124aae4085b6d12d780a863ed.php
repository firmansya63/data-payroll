<?php $__env->startSection('title','Kalender Presensi'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-center justify-between gap-2 mb-3">
  <h1 class="text-lg font-bold"><i class="fa-solid fa-calendar-days text-sky-600 mr-2"></i>Kalender Presensi</h1>
  <div class="flex gap-2">
    <a href="<?php echo e(route('presences.bulk')); ?>" class="bg-indigo-600 text-white px-3 py-2 rounded-xl text-sm font-semibold"><i class="fa-solid fa-list-check mr-1"></i> Bulk Harian</a>
    
  </div>
</div>

<div class="bg-white p-3 rounded-2xl shadow-sm border mb-3">
<form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-2">
  <label class="text-xs font-semibold text-slate-600">Karyawan <span class="font-normal text-slate-400">kosong = rekap semua</span>
    <select name="employee_id" class="mt-1 w-full border rounded-xl px-3 py-2 text-sm bg-white">
      <option value="">-- Semua Karyawan (Rekap) --</option>
      <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($e->id); ?>" <?php echo e((string)$employeeId === (string)$e->id ? 'selected' : ''); ?>><?php echo e($e->nama); ?> - <?php echo e($e->jabatan); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
  </label>
  <label class="text-xs font-semibold text-slate-600">Bulan
    <select name="bulan" class="mt-1 w-full border rounded-xl px-3 py-2 text-sm"><?php for($m=1;$m<=12;$m++): ?><option value="<?php echo e($m); ?>" <?php echo e($bulan==$m?'selected':''); ?>><?php echo e(DateTime::createFromFormat('!m',$m)->format('F')); ?></option><?php endfor; ?></select>
  </label>
  <label class="text-xs font-semibold text-slate-600">Tahun
    <select name="tahun" class="mt-1 w-full border rounded-xl px-3 py-2 text-sm"><?php for($y=now()->year-1;$y<=now()->year+1;$y++): ?><option value="<?php echo e($y); ?>" <?php echo e($tahun==$y?'selected':''); ?>><?php echo e($y); ?></option><?php endfor; ?></select>
  </label>
  <div class="flex items-end gap-2">
    <button class="flex-1 bg-[#1b2d4a] text-white rounded-xl px-4 py-2.5 text-sm font-semibold"><i class="fa-solid fa-eye mr-1"></i> Tampilkan</button>
    <?php if($selectedEmployee): ?>
      <a href="<?php echo e(route('presences.calendar', ['bulan'=>$bulan,'tahun'=>$tahun])); ?>" class="px-4 py-2.5 border rounded-xl text-sm">Reset</a>
    <?php endif; ?>
  </div>
</form>
<p class="text-[11px] text-slate-400 mt-2"><i class="fa-solid fa-circle-info mr-1"></i> Kosongkan karyawan untuk <b>rekap semua</b> periode ini; pilih satu untuk kalender per orang. Klik tanggal &rarr; Bulk Harian.</p>
</div>
<?php if(!$selectedEmployee): ?>
  <div class="bg-white rounded-2xl border p-3 md:p-4">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
      <h3 class="font-bold text-slate-800"><i class="fa-solid fa-users text-sky-600 mr-2"></i>Rekap <?php echo e(\Carbon\Carbon::create($tahun,$bulan,1)->translatedFormat('F Y')); ?> &mdash; Semua Karyawan</h3>
      <span class="text-[11px] text-slate-500">klik kartu/nama &rarr; kalender per orang</span>
    </div>
    <?php if(isset($rekapSemua) && $rekapSemua->count()): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
      <?php $__currentLoopData = $rekapSemua; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $e=$row['employee']; $tot=$row['hadir']+$row['izin']+$row['sakit']+$row['alpha']; ?>
        <a href="<?php echo e(route('presences.calendar', ['employee_id'=>$e->id,'bulan'=>$bulan,'tahun'=>$tahun])); ?>" class="bg-white border rounded-2xl p-3 hover:border-sky-300 hover:shadow-sm transition text-left group">
          <div class="font-semibold text-sm truncate group-hover:text-sky-700"><?php echo e($e->nama); ?></div>
          <div class="text-xs text-slate-500 truncate"><?php echo e($e->jabatan); ?></div>
          <div class="mt-2 grid grid-cols-4 gap-1 text-center">
            <div><div class="text-sm font-bold text-emerald-600"><?php echo e($row['hadir']); ?></div><div class="text-[10px] text-slate-400">Hadir</div></div>
            <div><div class="text-sm font-bold text-amber-600"><?php echo e($row['izin']); ?></div><div class="text-[10px] text-slate-400">Izin</div></div>
            <div><div class="text-sm font-bold text-sky-600"><?php echo e($row['sakit']); ?></div><div class="text-[10px] text-slate-400">Sakit</div></div>
            <div><div class="text-sm font-bold text-red-600"><?php echo e($row['alpha']); ?></div><div class="text-[10px] text-slate-400">Alpha</div></div>
          </div>
          <div class="mt-2 text-[11px] text-slate-400">Terisi: <b class="text-slate-700"><?php echo e($tot); ?></b> / <?php echo e($daysInMonth); ?> hari &middot; <span class="text-sky-600">lihat kalender &rarr;</span></div>
        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
      <p class="text-sm text-slate-500 text-center py-6">Belum ada karyawan aktif.</p>
    <?php endif; ?>
    <?php if($employees->count()): ?>
    <div class="mt-3 flex flex-wrap justify-center gap-2 border-t pt-3">
      <?php $__currentLoopData = $employees->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('presences.calendar', ['employee_id'=>$e->id,'bulan'=>$bulan,'tahun'=>$tahun])); ?>" class="px-3 py-1.5 bg-slate-50 border rounded-full text-xs font-medium hover:bg-[#1b2d4a] hover:text-white transition"><?php echo e($e->nama); ?></a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
    <p class="text-[11px] text-slate-400 text-center mt-3"><i class="fa-solid fa-circle-info mr-1"></i> Rekap hanya di Kalender (tabel tanpa rekap). Klik kartu/nama untuk kalender per orang &mdash; Sab/Ming = LIBUR, klik tanggal &rarr; Bulk.</p>
  </div>
<?php else: ?>
  <div class="mb-2"><a href="<?php echo e(route('presences.calendar', ['bulan'=>$bulan,'tahun'=>$tahun])); ?>" class="inline-flex items-center gap-1 text-xs font-semibold text-sky-600 hover:underline"><i class="fa-solid fa-arrow-left"></i> Rekap Semua</a> <span class="text-slate-300 mx-1">&middot;</span> <span class="text-xs text-slate-500"><?php echo e($selectedEmployee->nama); ?> &mdash; <?php echo e($selectedEmployee->jabatan); ?></span></div>
  <?php
    $monthLabel = $first->translatedFormat('F Y');
    $todayStr = now()->format('Y-m-d');
    $cfg = [
      'hadir'=>['label'=>'HADIR','bg'=>'bg-emerald-50','bd'=>'border-emerald-200','badge'=>'bg-emerald-500 text-white'],
      'izin'=> ['label'=>'IZIN','bg'=>'bg-amber-50','bd'=>'border-amber-200','badge'=>'bg-amber-500 text-white'],
      'sakit'=>['label'=>'SAKIT','bg'=>'bg-sky-50','bd'=>'border-sky-200','badge'=>'bg-sky-500 text-white'],
      'alpha'=>['label'=>'ALPHA','bg'=>'bg-red-50','bd'=>'border-red-200','badge'=>'bg-red-500 text-white'],
    ];
  ?>
  <div class="flex items-center justify-between gap-2 mb-3">
    <a href="<?php echo e(route('presences.calendar', ['employee_id'=>$selectedEmployee->id,'bulan'=>$prev->month,'tahun'=>$prev->year])); ?>" class="w-9 h-9 grid place-items-center bg-white border rounded-xl hover:bg-slate-50"><i class="fa-solid fa-chevron-left text-xs"></i></a>
    <div class="inline-flex items-center gap-2 bg-white border rounded-xl px-4 py-2">
      <span class="w-8 h-8 grid place-items-center rounded-lg bg-[#1b2d4a] text-white text-xs"><i class="fa-solid fa-calendar-days"></i></span>
      <div class="text-left">
        <div class="text-sm font-bold leading-none"><?php echo e($monthLabel); ?></div>
        <div class="text-[11px] text-slate-500 leading-none mt-1"><?php echo e($selectedEmployee->nama); ?> - <?php echo e($selectedEmployee->jabatan); ?></div>
      </div>
    </div>
    <a href="<?php echo e(route('presences.calendar', ['employee_id'=>$selectedEmployee->id,'bulan'=>$next->month,'tahun'=>$next->year])); ?>" class="w-9 h-9 grid place-items-center bg-white border rounded-xl hover:bg-slate-50"><i class="fa-solid fa-chevron-right text-xs"></i></a>
  </div>
  <div class="grid grid-cols-2 md:grid-cols-5 gap-2 mb-3">
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-3 text-center"><div class="text-[11px] font-bold text-emerald-700">HADIR</div><div class="text-2xl font-extrabold text-emerald-600"><?php echo e($rekap['hadir']); ?></div><div class="text-[11px] text-emerald-700/60">hari</div></div>
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-3 text-center"><div class="text-[11px] font-bold text-amber-700">IZIN</div><div class="text-2xl font-extrabold text-amber-600"><?php echo e($rekap['izin']); ?></div><div class="text-[11px] text-amber-700/60">hari</div></div>
    <div class="bg-sky-50 border border-sky-200 rounded-2xl p-3 text-center"><div class="text-[11px] font-bold text-sky-700">SAKIT</div><div class="text-2xl font-extrabold text-sky-600"><?php echo e($rekap['sakit']); ?></div><div class="text-[11px] text-sky-700/60">hari</div></div>
    <div class="bg-red-50 border border-red-200 rounded-2xl p-3 text-center"><div class="text-[11px] font-bold text-red-700">ALPHA</div><div class="text-2xl font-extrabold text-red-600"><?php echo e($rekap['alpha']); ?></div><div class="text-[11px] text-red-700/60">hari</div></div>
    <div class="col-span-2 md:col-span-1 bg-slate-50 border rounded-2xl p-3 text-center"><div class="text-[11px] font-bold text-slate-600">BELUM INPUT</div><div class="text-2xl font-extrabold text-slate-600"><?php echo e($rekap['kosong']); ?></div><div class="text-[11px] text-slate-500">dari <?php echo e($daysInMonth); ?> hari</div></div>
  </div>
  <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
    <div class="grid grid-cols-7 bg-slate-50 border-b text-[11px] font-bold tracking-wide text-slate-500">
      <div class="py-1.5 text-center text-xs">Sen</div><div class="py-1.5 text-center text-xs">Sel</div><div class="py-1.5 text-center text-xs">Rab</div><div class="py-1.5 text-center text-xs">Kam</div><div class="py-1.5 text-center text-xs">Jum</div><div class="py-1.5 text-center text-xs text-slate-400">Sab</div><div class="py-1.5 text-center text-xs text-red-400">Min</div>
    </div>
    <div class="grid grid-cols-7 gap-px bg-slate-200">
      <?php for($i=0;$i<$offset;$i++): ?><div class="bg-slate-50 min-h-[48px] md:min-h-[52px]"></div><?php endfor; ?>
      <?php for($d=1;$d<=$daysInMonth;$d++): ?>
        <?php
          $date = \Carbon\Carbon::create($tahun,$bulan,$d);
          $key = $date->format('Y-m-d');
          $pres = $grouped->get($key);
          $status = $pres->status ?? null;
          $isToday = $key === $todayStr;
          $isWeekend = $date->isWeekend();
          $isSunday = $date->isSunday();
          $bulkUrl = route('presences.bulk', ['tanggal'=>$key]);
          $c = $status ? ($cfg[$status] ?? null) : null;
        ?>
        <a href="<?php echo e($bulkUrl); ?>" class="relative bg-white min-h-[48px] md:min-h-[52px] p-1.5 flex flex-col group hover:brightness-[0.98] transition text-left <?php echo e($isWeekend && !$status ? ($isSunday ? 'bg-red-50/70' : 'bg-slate-50') : ''); ?> <?php echo e($c ? $c['bg'].' '.$c['bd'].' border' : 'border border-transparent'); ?> <?php echo e($isToday ? 'ring-2 ring-sky-400 ring-inset z-10' : ''); ?>" title="Bulk <?php echo e($date->translatedFormat('l, d F Y')); ?>">
          <div class="flex items-center justify-between">
            <span class="w-5 h-5 grid place-items-center rounded-lg text-[10px] font-bold <?php echo e($isToday ? 'bg-sky-600 text-white' : ''); ?> <?php echo e(!$isToday && $isSunday ? 'text-red-600 bg-red-100' : ''); ?> <?php echo e(!$isToday && !$isSunday && $isWeekend ? 'text-slate-500 bg-slate-100' : ''); ?> <?php echo e(!$isToday && !$isWeekend ? 'text-slate-700 bg-slate-100 group-hover:bg-white' : ''); ?>"><?php echo e($d); ?></span>
            <?php if($isToday): ?><span class="text-[9px] font-bold text-sky-600 hidden md:inline">HARI INI</span><?php endif; ?>
          </div>
          <div class="mt-0.5 flex-1 flex flex-col items-center justify-center gap-0.5">
            <?php if($status): ?>
              <span class="inline-flex items-center gap-1 px-1 py-0.5 rounded-full text-[8px] font-extrabold tracking-wide <?php echo e($c['badge']); ?>"><span class="w-1 h-1 rounded-full bg-white/90"></span> <?php echo e($c['label']); ?></span>
              <?php if($isWeekend): ?><span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-white/80 border <?php echo e($isSunday ? 'text-red-600 border-red-200' : 'text-slate-500 border-slate-200'); ?>">LIBUR</span><?php endif; ?>
            <?php else: ?>
              <?php if($isWeekend): ?>
                <span class="text-[10px] font-bold px-2 py-1 rounded-full border <?php echo e($isSunday ? 'bg-red-100 text-red-600 border-red-200' : 'bg-slate-100 text-slate-500 border-slate-200'); ?>"><i class="fa-solid fa-umbrella-beach mr-1"></i>LIBUR</span>
                <span class="text-[9px] text-slate-400">tanpa presensi</span>
              <?php else: ?>
                <span class="text-[10px] text-slate-300 font-medium">-</span><span class="text-[9px] text-slate-400 hidden md:inline">belum input</span>
              <?php endif; ?>
            <?php endif; ?>
          </div>
          <span class="absolute bottom-0.5 right-0.5 w-4 h-4 hidden md:grid place-items-center rounded-lg bg-slate-900 text-white text-[10px] opacity-0 group-hover:opacity-100 transition"><i class="fa-solid fa-pen"></i></span>
        </a>
      <?php endfor; ?>
      <?php $totalCells = $offset + $daysInMonth; $remain = (7 - ($totalCells % 7)) % 7; ?>
      <?php for($i=0;$i<$remain;$i++): ?><div class="bg-slate-50 min-h-[48px] md:min-h-[52px]"></div><?php endfor; ?>
    </div>
    <div class="p-3 bg-slate-50 border-t flex flex-wrap items-center gap-3 text-xs">
      <span class="font-semibold text-slate-600">Keterangan:</span>
      <span class="inline-flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Hadir</span>
      <span class="inline-flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Izin</span>
      <span class="inline-flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span> Sakit</span>
      <span class="inline-flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Alpha</span>
      <span class="inline-flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded bg-slate-100 border"></span> Sabtu</span>
      <span class="inline-flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded bg-red-50 border border-red-200"></span> Minggu LIBUR</span>
      <span class="ml-auto text-[11px] text-slate-500"><i class="fa-solid fa-hand-pointer mr-1"></i> Klik tanggal - Bulk (prefill tanggal)</span>
    </div>
  </div>
  <div class="mt-3 flex flex-wrap gap-2">
    <a href="<?php echo e(route('presences.bulk', ['tanggal'=>now()->format('Y-m-d')])); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-semibold"><i class="fa-solid fa-list-check mr-1"></i> Bulk Hari Ini (<?php echo e(now()->translatedFormat('d M')); ?>)</a>
    
  </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\data-payroll\resources\views/presences/calendar.blade.php ENDPATH**/ ?>