
<?php $__env->startSection('title','Rekap per Reseller'); ?>
<?php $__env->startSection('content'); ?>
<style>@media print{.no-print{display:none!important} body{background:#fff} table{font-size:11px}}</style>
<div class="flex flex-wrap items-center justify-between gap-2 mb-3">
  <h1 class="text-lg font-bold"><i class="fa-solid fa-chart-pie text-[#f68b1e] mr-2"></i>Rekap Voucher per Reseller</h1>
  <div class="no-print flex gap-2">
    <a href="<?php echo e(route('transactions.index')); ?>" class="border bg-white px-3 py-2 rounded-xl text-xs font-semibold"><i class="fa-solid fa-list mr-1"></i> Daftar Transaksi</a>
    <button onclick="window.print()" class="bg-[#1b2d4a] text-white px-3 py-2 rounded-xl text-xs font-semibold"><i class="fa-solid fa-print mr-1"></i> Cetak</button>
  </div>
</div>
<p class="text-xs text-slate-500 mb-3">1 baris = 1 reseller (agregat semua jenis vocer). Multi-vocer 3 jenis dalam 1 tanggal tetap terjumlah ke 1 baris reseller.</p>
<form method="GET" class="no-print bg-white p-3 rounded-2xl border shadow-sm mb-3">
  <div class="grid grid-cols-2 md:grid-cols-7 gap-2">
    <input type="date" name="dari" value="<?php echo e(request('dari')); ?>" class="border rounded-xl px-2 py-2 text-sm">
    <input type="date" name="sampai" value="<?php echo e(request('sampai')); ?>" class="border rounded-xl px-2 py-2 text-sm">
    <select name="status" class="border rounded-xl px-2 py-2 text-sm"><option value="">Semua Status</option><option value="belum_lunas" <?php echo e(request('status')=='belum_lunas'?'selected':''); ?>>Belum Lunas</option><option value="lunas" <?php echo e(request('status')=='lunas'?'selected':''); ?>>Lunas</option></select>
    <select name="voucher_type" class="border rounded-xl px-2 py-2 text-sm"><option value="">Semua Vocer</option><?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($k); ?>" <?php echo e(request('voucher_type')==$k?'selected':''); ?>><?php echo e($t['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
    <select name="reseller_id" class="border rounded-xl px-2 py-2 text-sm"><option value="">Semua Reseller</option><?php $__currentLoopData = $resellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($r->id); ?>" <?php echo e(request('reseller_id')==$r->id?'selected':''); ?>><?php echo e($r->nama); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
    <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari reseller..." class="border rounded-xl px-2 py-2 text-sm">
    <button class="bg-slate-800 text-white rounded-xl px-4 py-2 text-sm font-semibold">Filter</button>
  </div>
  <div class="flex flex-wrap gap-2 mt-2 items-center text-xs"><a href="<?php echo e(route('transactions.rekap')); ?>" class="border px-3 py-1.5 rounded-lg bg-white">Reset</a><span class="text-slate-400"><?php echo e($rows->count()); ?> reseller</span><span class="text-slate-400 hidden md:inline">3K:2.500 | 5K:4.000 | 10K:9.000</span></div>
</form>
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-sm">
<thead class="bg-slate-50 text-[11px] text-slate-500 uppercase tracking-wide"><tr>
<th class="px-2 py-2.5 text-center w-8">No</th>
<th class="px-3 py-2.5 text-left">Reseller</th>
<th class="px-2 py-2.5 text-center">TRX</th>
<th class="px-2 py-2.5 text-center">3K</th>
<th class="px-2 py-2.5 text-center">5K</th>
<th class="px-2 py-2.5 text-center">10K</th>
<th class="px-2 py-2.5 text-center">Total Qty</th>
<th class="px-3 py-2.5 text-right">Piutang</th>
<th class="px-3 py-2.5 text-right">Lunas</th>
<th class="px-3 py-2.5 text-right bg-slate-100">Total</th>
<th class="px-2 py-2.5 text-center no-print">Aksi</th>
</tr></thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php $res=$row->reseller; ?>
<tr class="border-t hover:bg-slate-50">
<td class="px-2 py-2.5 text-center text-xs text-slate-500"><?php echo e($i+1); ?></td>
<td class="px-3 py-2.5"><div class="font-semibold text-sm leading-tight"><?php echo e($res->nama ?? 'Reseller #'.$row->reseller_id); ?></div><div class="text-xs text-slate-500"><?php echo e($res->no_hp ?? '-'); ?></div></td>
<td class="px-2 py-2.5 text-center font-semibold"><?php echo e($row->trx_count); ?></td>
<td class="px-2 py-2.5 text-center <?php if((int)$row->qty_3k==0): ?> text-slate-300 <?php endif; ?>"><?php echo e((int)$row->qty_3k==0 ? '-' : number_format($row->qty_3k,0,',','.')); ?></td>
<td class="px-2 py-2.5 text-center <?php if((int)$row->qty_5k==0): ?> text-slate-300 <?php endif; ?>"><?php echo e((int)$row->qty_5k==0 ? '-' : number_format($row->qty_5k,0,',','.')); ?></td>
<td class="px-2 py-2.5 text-center <?php if((int)$row->qty_10k==0): ?> text-slate-300 <?php endif; ?>"><?php echo e((int)$row->qty_10k==0 ? '-' : number_format($row->qty_10k,0,',','.')); ?></td>
<td class="px-2 py-2.5 text-center font-bold"><?php echo e(number_format($row->total_qty,0,',','.')); ?></td>
<td class="px-3 py-2.5 text-right font-bold text-red-600 whitespace-nowrap">Rp <?php echo e(number_format($row->piutang,0,',','.')); ?></td>
<td class="px-3 py-2.5 text-right font-semibold text-emerald-600 whitespace-nowrap">Rp <?php echo e(number_format($row->lunas,0,',','.')); ?></td>
<td class="px-3 py-2.5 text-right font-bold whitespace-nowrap bg-slate-50">Rp <?php echo e(number_format($row->total_nominal,0,',','.')); ?></td>
<td class="px-2 py-2.5 text-center no-print"><div class="flex gap-1 justify-center flex-wrap"><a href="<?php echo e(route('transactions.index', array_filter(['reseller_id'=>$row->reseller_id,'dari'=>request('dari'),'sampai'=>request('sampai'),'status'=>request('status')]))); ?>" class="inline-flex items-center gap-1 border px-2.5 py-1.5 rounded-lg text-xs hover:bg-slate-50"><i class="fa-solid fa-eye text-[11px]"></i> Detail</a><a href="<?php echo e(route('transactions.rekap.nota', array_filter(['reseller'=>$row->reseller_id,'dari'=>request('dari'),'sampai'=>request('sampai'),'status'=>request('status'),'voucher_type'=>request('voucher_type')]))); ?>" target="_blank" class="inline-flex items-center gap-1 bg-slate-800 text-white px-2.5 py-1.5 rounded-lg text-xs hover:bg-slate-900"><i class="fa-solid fa-print text-[11px]"></i> Nota</a></div></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr><td colspan="11" class="px-3 py-10 text-center text-slate-400 text-sm">Belum ada transaksi</td></tr>
<?php endif; ?>
</tbody>
<?php if($rows->isNotEmpty()): ?>
<tfoot class="bg-[#1b2d4a] text-white text-sm"><tr>
<td colspan="2" class="px-3 py-2.5 text-right font-bold">GRAND TOTAL</td>
<td class="px-2 py-2.5 text-center font-bold"><?php echo e(number_format($grand['trx_count'],0,',','.')); ?></td>
<td class="px-2 py-2.5 text-center font-bold"><?php echo e($grand['qty_3k'] ? number_format($grand['qty_3k'],0,',','.') : '-'); ?></td>
<td class="px-2 py-2.5 text-center font-bold"><?php echo e($grand['qty_5k'] ? number_format($grand['qty_5k'],0,',','.') : '-'); ?></td>
<td class="px-2 py-2.5 text-center font-bold"><?php echo e($grand['qty_10k'] ? number_format($grand['qty_10k'],0,',','.') : '-'); ?></td>
<td class="px-2 py-2.5 text-center font-bold"><?php echo e(number_format($grand['total_qty'],0,',','.')); ?></td>
<td class="px-3 py-2.5 text-right font-bold text-red-300 whitespace-nowrap">Rp <?php echo e(number_format($grand['piutang'],0,',','.')); ?></td>
<td class="px-3 py-2.5 text-right font-bold text-emerald-300 whitespace-nowrap">Rp <?php echo e(number_format($grand['lunas'],0,',','.')); ?></td>
<td class="px-3 py-2.5 text-right font-bold whitespace-nowrap">Rp <?php echo e(number_format($grand['total_nominal'],0,',','.')); ?></td>
<td class="no-print"></td>
</tr></tfoot>
<?php endif; ?>
</table>
</div>
</div>
<p class="text-[11px] text-slate-400 mt-2">TRX = jumlah baris transaksi. Total = Piutang + Lunas. Cetak: Ctrl+P.</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\data-payroll\resources\views/transactions/rekap.blade.php ENDPATH**/ ?>