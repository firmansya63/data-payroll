
<?php $__env->startSection('title','Bulk Presensi Harian'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-lg font-bold mb-1">Bulk Presensi Harian</h1>
<p class="text-sm text-slate-500 mb-3">Isi kehadiran semua karyawan untuk satu tanggal. Dipakai dari klik tanggal di Kalender.</p>
<form method="POST" action="<?php echo e(route('presences.bulkStore')); ?>" class="bg-white p-4 rounded-2xl shadow-sm border space-y-3">
<?php echo csrf_field(); ?>
<label class="block text-sm max-w-xs">Tanggal*<input type="date" name="tanggal" value="<?php echo e($tanggal); ?>" required class="w-full mt-1 border rounded-xl px-3 py-2"></label>
<div class="overflow-x-auto border rounded-xl">
<table class="w-full text-sm">
<thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-3 py-2 text-left">Karyawan</th><th class="px-3 py-2">Status</th></tr></thead>
<tbody>
<?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $cur = $existing[$e->id] ?? 'hadir'; ?>
<tr class="border-t">
<td class="px-3 py-2"><div class="font-medium"><?php echo e($e->nama); ?></div><div class="text-xs text-slate-500"><?php echo e($e->jabatan); ?></div></td>
<td class="px-3 py-2">
  <input type="hidden" name="presences[<?php echo e($i); ?>][employee_id]" value="<?php echo e($e->id); ?>">
  <select name="presences[<?php echo e($i); ?>][status]" class="border rounded-xl px-2 py-1.5 text-sm w-full">
    <option value="hadir" <?php echo e($cur=='hadir'?'selected':''); ?>>Hadir</option><option value="izin" <?php echo e($cur=='izin'?'selected':''); ?>>Izin</option><option value="sakit" <?php echo e($cur=='sakit'?'selected':''); ?>>Sakit</option><option value="alpha" <?php echo e($cur=='alpha'?'selected':''); ?>>Alpha</option>
  </select>
</td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>
</div>
<div class="flex gap-2"><button class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-semibold">Simpan Semua</button><a href="<?php echo e(route('presences.calendar', ['bulan'=>\Carbon\Carbon::parse($tanggal)->month,'tahun'=>\Carbon\Carbon::parse($tanggal)->year])); ?>" class="px-6 py-2.5 border rounded-xl">Batal</a></div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\data-payroll\resources\views/presences/bulk.blade.php ENDPATH**/ ?>