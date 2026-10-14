<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Nota <?php echo e($nota->no_nota); ?> (A4 Landscape)</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>*{font-family:Inter,sans-serif} @page{size:A4 landscape; margin:12mm} @media print{.no-print{display:none!important}} *{-webkit-print-color-adjust:exact;print-color-adjust:exact}</style>
</head>
<body class="bg-slate-100 p-2 md:p-3">
<div class="no-print max-w-[900px] mx-auto mb-3 flex gap-2 flex-wrap">
  <button onclick="window.print()" class="flex-1 min-w-[120px] bg-indigo-600 text-white py-2.5 rounded-xl font-semibold">Cetak (A4 Landscape)</button>
  <a href="<?php echo e(route('manual-notas.nota',$nota)); ?>" class="px-4 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-semibold">↩ A4 Portrait</a>
  <a href="<?php echo e(route('manual-notas.index')); ?>" class="px-4 py-2.5 border bg-white rounded-xl text-sm">Kembali</a>
</div>
<div class="max-w-[900px] mx-auto bg-white p-5 shadow border print:shadow-none print:p-3">
  <div class="flex items-center gap-3 border-b-2 border-slate-800 pb-3 mb-3">
    <img src="<?php echo e(($company ?? null) ? $company->logoUrl() : asset('logo.png')); ?>" alt="<?php echo e(($company->name ?? 'Datanet')); ?>" class="h-10 w-10 object-contain shrink-0">
    <div class="flex-1 text-center">
      <div class="font-bold text-base tracking-tight text-[#1b2d4a] leading-none"><?php echo e(strtoupper($company->name ?? 'DATANET')); ?></div>
      <?php if(!empty($company->address)): ?><div class="text-[9px] text-slate-500 leading-tight mt-0.5"><?php echo e($company->address); ?></div><?php endif; ?>
      <?php if(!empty($company->phone)): ?><div class="text-[9px] text-slate-500"><?php echo e($company->phone); ?></div><?php endif; ?>
      <div class="text-[11px] font-semibold mt-1">NOTA PENJUALAN</div>
    </div>
    
  </div>
  <div class="grid grid-cols-2 gap-3 mb-3">
    <div class="text-xs space-y-1 bg-slate-50 border rounded-xl p-3">
      <div class="flex justify-between"><span class="text-slate-500">No Nota</span><span class="font-mono font-bold"><?php echo e($nota->no_nota); ?></span></div>
      <div class="flex justify-between"><span class="text-slate-500">Tanggal</span><span class="font-semibold"><?php echo e($nota->tanggal->translatedFormat('d F Y')); ?></span></div>
      <?php if($nota->jatuh_tempo): ?><div class="flex justify-between"><span class="text-slate-500">Jatuh Tempo</span><span class="font-semibold <?php echo e($nota->is_overdue ? 'text-red-600' : ''); ?>"><?php echo e($nota->jatuh_tempo->translatedFormat('d F Y')); ?> <?php if($nota->is_overdue): ?>(Overdue)<?php endif; ?></span></div><?php endif; ?>
      <?php if($nota->metode_bayar): ?><div class="flex justify-between"><span class="text-slate-500">Bayar</span><span class="font-semibold capitalize"><?php echo e($nota->metode_bayar); ?></span></div><?php endif; ?>
      <div class="flex justify-between"><span class="text-slate-500">Items</span><span class="font-semibold"><?php echo e($nota->items->count()); ?> baris</span></div>
    </div>
    <div class="bg-slate-50 border rounded-xl p-3 text-xs">
      <div class="text-[10px] text-slate-400 font-semibold mb-1">PELANGGAN</div>
      <div class="font-bold text-sm text-[#1b2d4a]"><?php echo e($nota->pelanggan_nama); ?></div>
      <?php if($nota->pelanggan_hp): ?><div class="text-slate-600">HP: <?php echo e($nota->pelanggan_hp); ?></div><?php endif; ?>
      <?php if($nota->pelanggan_alamat): ?><div class="text-slate-500 leading-tight mt-1"><?php echo e($nota->pelanggan_alamat); ?></div><?php endif; ?>
    </div>
  </div>
  <div class="border rounded-xl overflow-hidden mb-3">
    <div class="bg-slate-900 text-white px-3 py-2 text-xs font-semibold flex justify-between"><span>Rincian</span><span class="bg-white/20 px-2 py-0.5 rounded-full"><?php echo e($nota->items->count()); ?> item</span></div>
    <table class="w-full text-xs leading-tight table-fixed border-collapse">
      <colgroup><col style="width:5%"><col style="width:52%"><col style="width:9%"><col style="width:17%"><col style="width:17%"></colgroup>
      <thead class="bg-slate-50 text-slate-500 text-[11px] uppercase tracking-wide"><tr><th class="px-2 py-2 text-left font-semibold">No</th><th class="px-2 py-2 text-left font-semibold">Uraian</th><th class="px-2 py-2 text-center font-semibold">Qty</th><th class="px-2 py-2 text-right font-semibold">Harga</th><th class="px-2 py-2 text-right font-semibold">Subtotal</th></tr></thead>
      <tbody class="text-sm">
        <?php $__currentLoopData = $nota->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="border-t">
          <td class="px-2 py-2 text-xs text-slate-500 tabular-nums"><?php echo e($i+1); ?></td>
          <td class="px-2 py-2"><div class="font-medium text-sm break-words"><?php echo e($it->nama); ?></div><div class="text-[11px] text-slate-500"><?php echo e($it->satuan); ?><?php if($it->diskon_item>0): ?> <span class="text-red-600">· Disc -<?php echo e(number_format($it->diskon_item,0,',','.')); ?></span><?php endif; ?></div></td>
          <td class="px-2 py-2 text-center text-xs tabular-nums"><?php echo e(rtrim(rtrim(number_format($it->qty,2,',','.'),'0'),',')); ?></td>
          <td class="px-2 py-2 text-right text-xs tabular-nums whitespace-nowrap">Rp <?php echo e(number_format($it->harga_satuan,0,',','.')); ?></td>
          <td class="px-2 py-2 text-right font-semibold text-xs tabular-nums whitespace-nowrap">Rp <?php echo e(number_format($it->subtotal,0,',','.')); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
      <tfoot class="text-xs">
        <tr class="border-t bg-slate-50"><td colspan="4" class="px-2 py-2 text-right text-slate-600">Subtotal</td><td class="px-2 py-2 text-right font-semibold tabular-nums">Rp <?php echo e(number_format($nota->subtotal,0,',','.')); ?></td></tr>
        <?php if($nota->diskon_tipe && $nota->diskon_nilai>0): ?>
        <tr class="border-t"><td colspan="4" class="px-2 py-2 text-right text-slate-600">Diskon <?php if($nota->diskon_tipe=='persen'): ?> <?php echo e(rtrim(rtrim(number_format($nota->diskon_nilai,2,',','.'),'0'),',')); ?>% <?php else: ?> Nominal <?php endif; ?></td><td class="px-2 py-2 text-right text-red-600 tabular-nums">- Rp <?php echo e(number_format($nota->diskon_tipe=='persen' ? $nota->subtotal*$nota->diskon_nilai/100 : $nota->diskon_nilai,0,',','.')); ?></td></tr>
        <?php endif; ?>
        <?php if($nota->biaya_lain>0): ?><tr class="border-t"><td colspan="4" class="px-2 py-2 text-right text-slate-600"><?php echo e($nota->biaya_lain_label ?: 'Biaya Lain'); ?></td><td class="px-2 py-2 text-right tabular-nums">+ Rp <?php echo e(number_format($nota->biaya_lain,0,',','.')); ?></td></tr><?php endif; ?>
        <tr class="border-t bg-slate-900 text-white font-bold text-sm"><td colspan="4" class="px-2 py-2 text-right">TOTAL</td><td class="px-2 py-2 text-right tabular-nums">Rp <?php echo e(number_format($nota->total,0,',','.')); ?></td></tr>
      </tfoot>
    </table>
  </div>
  <?php if($nota->status=='lunas'): ?>
  <div class="bg-emerald-50 border-2 border-emerald-300 rounded-xl p-3 text-center mb-3">
    <div class="text-2xl">✅</div>
    <div class="text-sm font-bold text-emerald-700 tracking-widest">L U N A S</div>
    <div class="text-xs text-emerald-600 mt-1">Pembayaran telah diterima. Terima kasih.</div>
  </div>
  <?php elseif($nota->status=='dp'): ?>
  <div class="bg-amber-50 border-2 border-amber-300 rounded-xl p-3 text-center mb-3">
    <div class="text-xs font-bold text-amber-700 tracking-widest">D P</div>
    <div class="text-sm text-slate-700 mt-1">DP Dibayar: <b class="text-amber-700">Rp <?php echo e(number_format($nota->dp_nominal,0,',','.')); ?></b></div>
    <div class="text-lg font-bold text-red-600 mt-1">Sisa: Rp <?php echo e(number_format($nota->sisa_tagihan,0,',','.')); ?></div>
    <?php if($nota->jatuh_tempo): ?><div class="text-xs text-slate-600 mt-1">Jatuh tempo: <?php echo e($nota->jatuh_tempo->translatedFormat('d F Y')); ?></div><?php endif; ?>
  </div>
  <?php else: ?>
  <div class="bg-red-50 border-2 border-red-300 rounded-xl p-3 text-center mb-3">
    <div class="text-xs font-bold text-red-600 tracking-widest">BELUM LUNAS</div>
    <div class="text-sm text-red-700 mt-1">Sisa Tagihan:</div>
    <div class="text-2xl font-bold text-red-700">Rp <?php echo e(number_format($nota->sisa_tagihan,0,',','.')); ?></div>
    <?php if($nota->jatuh_tempo): ?><div class="text-xs text-red-600 mt-1">Jatuh tempo: <?php echo e($nota->jatuh_tempo->translatedFormat('d F Y')); ?> <?php if($nota->is_overdue): ?> — OVERDUE <?php endif; ?></div><?php endif; ?>
  </div>
  <?php endif; ?>
  <?php if($nota->keterangan): ?><div class="border rounded-xl p-3 mb-3 text-xs"><span class="text-slate-500">Ket:</span> <?php echo e($nota->keterangan); ?></div><?php endif; ?>
  <div class="flex justify-between text-xs mt-4">
    <div class="text-center"><div class="mb-8 text-slate-500">Penerima</div><div class="border-t pt-1 px-6"><?php echo e($nota->pelanggan_nama); ?></div></div>
    <div class="text-center"><div class="mb-8 text-slate-500"><?php echo e(($company->pimpinan_jabatan ?? 'Admin')); ?></div><div class="border-t pt-1 px-6"><?php echo e(($company->pimpinan_nama ?? $company->name ?? 'Datanet')); ?></div></div>
  </div>
  <div class="text-center text-[10px] text-slate-400 mt-4 border-t pt-2"><?php echo e($nota->catatan_nota ?? 'Terima kasih atas kepercayaan Anda'); ?><br>Dicetak: <?php echo e(now()->translatedFormat('d/m/Y H:i')); ?> | A4 Landscape | No: <?php echo e($nota->no_nota); ?></div>
</div>
<script>window.onload=()=>setTimeout(()=>window.print(),400)</script>
</body>
</html>
<?php /**PATH C:\laragon\www\data-payroll\resources\views/manual-notas/nota-landscape.blade.php ENDPATH**/ ?>