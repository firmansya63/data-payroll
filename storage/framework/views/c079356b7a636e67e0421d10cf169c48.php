
<?php $__env->startSection('title','Nota Barang & Jasa'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-center justify-between gap-2 mb-3">
  <h1 class="text-lg font-bold"><i class="fa-solid fa-receipt text-[#f68b1e] mr-2"></i>Nota Barang & Jasa</h1>
  <a href="<?php echo e(route('manual-notas.create')); ?>" class="bg-[#1b2d4a] hover:bg-[#16233a] text-white px-4 py-2 rounded-xl text-sm font-semibold"><i class="fa-solid fa-plus mr-1"></i> Buat Nota</a>
</div>
<div class="grid grid-cols-3 gap-2 mb-3">
  <div class="bg-red-50 border border-red-200 p-3 rounded-2xl text-center">
    <div class="text-[11px] text-red-600 font-semibold">PIUTANG (SISA)</div>
    <div class="font-bold text-red-700 text-sm">Rp <?php echo e(number_format($sumPiutang,0,',','.')); ?></div>
    <div class="text-[10px] text-red-500">Belum Lunas + DP</div>
  </div>
  <div class="bg-amber-50 border border-amber-200 p-3 rounded-2xl text-center">
    <div class="text-[11px] text-amber-700 font-semibold">DP MASUK</div>
    <div class="font-bold text-amber-700 text-sm">Rp <?php echo e(number_format($sumDp,0,',','.')); ?></div>
  </div>
  <div class="bg-emerald-50 border border-emerald-200 p-3 rounded-2xl text-center">
    <div class="text-[11px] text-emerald-700 font-semibold">LUNAS</div>
    <div class="font-bold text-emerald-700 text-sm">Rp <?php echo e(number_format($sumLunas,0,',','.')); ?></div>
  </div>
</div>
<form method="GET" class="bg-white p-3 rounded-2xl shadow-sm border mb-3 space-y-2">
  <div class="grid grid-cols-2 md:grid-cols-7 gap-2">
    <select name="status" class="border rounded-xl px-2 py-2 text-sm">
      <option value="">Semua Status</option>
      <option value="belum_lunas" <?php echo e(request('status')=='belum_lunas'?'selected':''); ?>>Belum Lunas</option>
      <option value="dp" <?php echo e(request('status')=='dp'?'selected':''); ?>>DP</option>
      <option value="lunas" <?php echo e(request('status')=='lunas'?'selected':''); ?>>Lunas</option>
    </select>
    <select name="jenis" class="border rounded-xl px-2 py-2 text-sm">
      <option value="">Semua Jenis</option>
      <option value="barang" <?php echo e(request('jenis')=='barang'?'selected':''); ?>>Barang</option>
      <option value="jasa" <?php echo e(request('jenis')=='jasa'?'selected':''); ?>>Jasa</option>
      <option value="campuran" <?php echo e(request('jenis')=='campuran'?'selected':''); ?>>Campuran</option>
    </select>
    <input type="date" name="dari" value="<?php echo e(request('dari')); ?>" class="border rounded-xl px-2 py-2 text-sm">
    <input type="date" name="sampai" value="<?php echo e(request('sampai')); ?>" class="border rounded-xl px-2 py-2 text-sm">
    <input name="q" value="<?php echo e(request('q')); ?>" placeholder="No nota / pelanggan" class="border rounded-xl px-2 py-2 text-sm md:col-span-2">
    <button class="bg-slate-800 text-white rounded-xl px-4 py-2 text-sm">Filter</button>
  </div>
  <div class="flex flex-wrap gap-2 items-center">
    <a href="<?php echo e(route('manual-notas.index')); ?>" class="text-xs border px-3 py-1.5 rounded-lg bg-white">Reset</a>
    <?php if(request('q') || request('status') || request('jenis')): ?><span class="text-xs bg-slate-100 px-3 py-1.5 rounded-full"><?php echo e($notas->total()); ?> nota</span><?php endif; ?>
    <?php if(request('status')=='belum_lunas' || request('status')=='dp'): ?><span class="text-xs bg-red-100 text-red-700 px-3 py-1.5 rounded-full">Sisa: Rp <?php echo e(number_format($totalPiutangFiltered,0,',','.')); ?></span><?php endif; ?>
  </div>
</form>
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-3 py-2 text-left">Tgl</th><th class="px-3 py-2 text-left">No Nota</th><th class="px-3 py-2 text-left">Pelanggan</th><th class="px-3 py-2 text-center">Jenis</th><th class="px-3 py-2 text-right">Total</th><th class="px-3 py-2 text-right">Sisa</th><th class="px-3 py-2 text-center">Status</th><th class="px-3 py-2 text-center">Tempo</th><th class="px-3 py-2 text-center">Aksi</th></tr></thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $notas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr class="border-t hover:bg-slate-50">
  <td class="px-3 py-2.5 text-xs whitespace-nowrap"><?php echo e($n->tanggal->format('d/m/y')); ?></td>
  <td class="px-3 py-2"><div class="font-mono font-bold text-xs"><?php echo e($n->no_nota); ?></div><div class="text-[11px] text-slate-500"><?php echo e($n->items->count()); ?> item</div></td>
  <td class="px-3 py-2"><div class="font-medium text-sm"><?php echo e($n->pelanggan_nama); ?></div><div class="text-xs text-slate-500"><?php echo e($n->pelanggan_hp ?? '-'); ?></div></td>
  <td class="px-3 py-2 text-center">
    <?php if($n->jenis=='barang'): ?><span class="bg-sky-100 text-sky-700 px-2 py-1 rounded-full text-[11px] font-bold">BARANG</span>
    <?php elseif($n->jenis=='jasa'): ?><span class="bg-violet-100 text-violet-700 px-2 py-1 rounded-full text-[11px] font-bold">JASA</span>
    <?php else: ?><span class="bg-amber-100 text-amber-700 px-2 py-1 rounded-full text-[11px] font-bold">CAMPURAN</span><?php endif; ?>
  </td>
  <td class="px-3 py-2 text-right font-bold whitespace-nowrap">Rp <?php echo e(number_format($n->total,0,',','.')); ?></td>
  <td class="px-3 py-2 text-right whitespace-nowrap <?php echo e($n->sisa_tagihan>0?'text-red-600 font-bold':'text-slate-400'); ?>">Rp <?php echo e(number_format($n->sisa_tagihan,0,',','.')); ?></td>
  <td class="px-3 py-2 text-center">
    <?php if($n->status=='lunas'): ?><span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-xs font-bold">LUNAS</span>
    <?php elseif($n->status=='dp'): ?><span class="bg-amber-100 text-amber-700 px-2 py-1 rounded-full text-xs font-bold">DP Rp <?php echo e(number_format($n->dp_nominal,0,',','.')); ?></span>
    <?php else: ?><span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-bold">BELUM LUNAS</span><?php endif; ?>
  </td>
  <td class="px-3 py-2 text-center text-xs">
    <?php if($n->jatuh_tempo): ?><span class="<?php echo e($n->is_overdue ? 'text-red-600 font-bold' : 'text-slate-600'); ?>"><?php echo e($n->jatuh_tempo->format('d/m/y')); ?></span><?php if($n->is_overdue): ?><div class="text-[10px] text-red-500">Jatuh tempo</div><?php endif; ?>
    <?php else: ?><span class="text-slate-400">-</span><?php endif; ?>
  </td>
  <td class="px-3 py-2"><div class="flex gap-1 justify-center flex-wrap">
      <a href="<?php echo e(route('manual-notas.nota',$n)); ?>" target="_blank" class="bg-slate-800 text-white w-7 h-7 grid place-items-center rounded-lg" title="Cetak A4 Portrait"><i class="fa-solid fa-print text-xs"></i></a>
      <a href="<?php echo e(route('manual-notas.nota-landscape',$n)); ?>" target="_blank" class="bg-indigo-600 text-white w-7 h-7 grid place-items-center rounded-lg" title="Cetak A4 Landscape"><i class="fa-solid fa-table-columns text-xs"></i></a>
      <a href="<?php echo e(route('manual-notas.edit',$n)); ?>" class="bg-amber-100 text-amber-700 w-7 h-7 grid place-items-center rounded-lg" title="Edit"><i class="fa-solid fa-pen text-xs"></i></a>
      <a href="<?php echo e(route('manual-notas.duplicate',$n)); ?>" class="bg-sky-100 text-sky-700 w-7 h-7 grid place-items-center rounded-lg" title="Duplikat"><i class="fa-solid fa-copy text-xs"></i></a>
      <form method="POST" action="<?php echo e(route('manual-notas.destroy',$n)); ?>" onsubmit="return confirm('Hapus nota <?php echo e($n->no_nota); ?>?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="bg-red-100 text-red-600 w-7 h-7 grid place-items-center rounded-lg"><i class="fa-solid fa-trash text-xs"></i></button></form>
    </div></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <tr><td colspan="9" class="px-3 py-8 text-center text-slate-400">Belum ada nota. Klik Buat Nota.</td></tr> <?php endif; ?>
</tbody>
</table>
</div>
<div class="p-3 border-t"><?php echo e($notas->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\data-payroll\resources\views/manual-notas/index.blade.php ENDPATH**/ ?>