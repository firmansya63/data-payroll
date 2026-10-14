<?php $__env->startSection('title','Reseller'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-4">
  <h1 class="text-lg font-bold"><i class="fa-solid fa-store text-sky-600 mr-2"></i>Reseller</h1>
  <a href="<?php echo e(route('resellers.create')); ?>" class="bg-sky-600 text-white px-4 py-2 rounded-xl text-sm font-semibold"><i class="fa-solid fa-plus mr-1"></i> Tambah</a>
</div>
<form method="GET" class="mb-3 flex gap-2">
  <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari nama/no HP..." class="flex-1 border rounded-xl px-3 py-2 text-sm">
  <button class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm">Cari</button>
</form>
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-3 py-2 text-left">Nama</th><th class="px-3 py-2">Kontak</th><th class="px-3 py-2 text-right">Piutang</th><th class="px-3 py-2 text-right">Lunas</th><th class="px-3 py-2">Aksi</th></tr></thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $resellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr class="border-t">
  <td class="px-3 py-2.5"><div class="font-semibold"><?php echo e($r->nama); ?></div><div class="text-xs text-slate-500"><?php echo e(Str::limit($r->alamat,40)); ?></div></td>
  <td class="px-3 py-2 text-center text-xs"><?php echo e($r->no_hp ?? '-'); ?></td>
  <td class="px-3 py-2 text-right font-bold text-red-600">Rp <?php echo e(number_format($r->total_piutang,0,',','.')); ?></td>
  <td class="px-3 py-2 text-right text-emerald-600">Rp <?php echo e(number_format($r->total_lunas,0,',','.')); ?></td>
  <td class="px-3 py-2 flex gap-1 justify-center">
    <a href="<?php echo e(route('resellers.edit',$r)); ?>" class="w-8 h-8 grid place-items-center bg-amber-100 text-amber-700 rounded-lg"><i class="fa-solid fa-pen text-xs"></i></a>
    <form method="POST" action="<?php echo e(route('resellers.destroy',$r)); ?>" onsubmit="return confirm('Hapus?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="w-8 h-8 grid place-items-center bg-red-100 text-red-600 rounded-lg"><i class="fa-solid fa-trash text-xs"></i></button></form>
  </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <tr><td colspan="5" class="px-3 py-8 text-center text-slate-400">Belum ada reseller</td></tr> <?php endif; ?>
</tbody>
</table>
</div>
<div class="p-3 border-t"><?php echo e($resellers->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\data-payroll\resources\views/resellers/index.blade.php ENDPATH**/ ?>