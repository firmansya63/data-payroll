<?php

namespace App\Http\Controllers;

use App\Models\ManualNota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ManualNotaController extends Controller
{
    public function index(Request $r)
    {
        $q = ManualNota::with('items')->latest('tanggal')->latest('id');
        if ($r->status && in_array($r->status, ['lunas','belum_lunas','dp'])) {
            $q->where('status', $r->status);
        }
        if ($r->jenis && in_array($r->jenis, ['barang','jasa','campuran'])) {
            $q->where('jenis', $r->jenis);
        }
        if ($r->dari) $q->whereDate('tanggal', '>=', $r->dari);
        if ($r->sampai) $q->whereDate('tanggal', '<=', $r->sampai);
        if ($r->q) {
            $s = $r->q;
            $q->where(function ($qq) use ($s) {
                $qq->where('no_nota', 'like', "%$s%")
                   ->orWhere('pelanggan_nama', 'like', "%$s%")
                   ->orWhere('pelanggan_hp', 'like', "%$s%");
            });
        }
        $notas = $q->paginate(15)->withQueryString();
        $sumPiutang = ManualNota::whereIn('status', ['belum_lunas','dp'])->sum('sisa_tagihan');
        $sumLunas = ManualNota::where('status','lunas')->sum('total');
        $sumDp = ManualNota::where('status','dp')->sum('dp_nominal');
        $totalPiutangFiltered = (clone $q)->whereIn('status', ['belum_lunas','dp'])->sum('sisa_tagihan');
        return view('manual-notas.index', compact('notas','sumPiutang','sumLunas','sumDp','totalPiutangFiltered'));
    }

    public function create()
    {
        return view('manual-notas.form', ['nota'=>null, 'items'=>[]]);
    }

    public function store(Request $r)
    {
        $data = $this->validateData($r);
        $calc = $this->calculate($r);
        $nota = ManualNota::create(array_merge($data, [
            'subtotal' => $calc['subtotal'],
            'total' => $calc['total'],
            'sisa_tagihan' => $calc['sisa'],
            'jenis' => $calc['jenis'],
            'created_by' => Auth::id(),
        ], $calc['extra']));
        foreach ($calc['items'] as $it) { $nota->items()->create($it); }
        return redirect()->route('manual-notas.index')->with('ok', 'Nota '.$nota->no_nota.' disimpan: Rp '.number_format($calc['total'],0,',','.'));
    }

    public function edit(ManualNota $nota)
    {
        $nota->load('items');
        return view('manual-notas.form', ['nota'=>$nota, 'items'=>$nota->items]);
    }

    public function update(Request $r, ManualNota $nota)
    {
        $data = $this->validateData($r, $nota->id);
        $calc = $this->calculate($r);
        $nota->update(array_merge($data, [
            'subtotal' => $calc['subtotal'],
            'total' => $calc['total'],
            'sisa_tagihan' => $calc['sisa'],
            'jenis' => $calc['jenis'],
        ], $calc['extra']));
        $nota->items()->delete();
        foreach ($calc['items'] as $it) { $nota->items()->create($it); }
        return redirect()->route('manual-notas.index')->with('ok', 'Nota '.$nota->no_nota.' diperbarui');
    }

    public function destroy(ManualNota $nota)
    {
        $nota->delete();
        return redirect()->route('manual-notas.index')->with('ok','Nota dihapus');
    }

    public function nota(ManualNota $nota)
    {
        $nota->load('items');
        return view('manual-notas.nota', compact('nota'));
    }

    public function notaLandscape(ManualNota $nota)
    {
        $nota->load('items');
        return view('manual-notas.nota-landscape', compact('nota'));
    }

    public function duplicate(ManualNota $nota)
    {
        $nota->load('items');
        $newNo = $nota->no_nota.'-COPY';
        $s = 1;
        while (ManualNota::where('no_nota', $newNo)->exists()) { $newNo = $nota->no_nota.'-COPY'.$s; $s++; }
        return view('manual-notas.form', ['nota'=>null,'items'=>$nota->items,'duplicate'=>$nota,'suggestedNo'=>$newNo]);
    }

    private function validateData(Request $r, $ignoreId = null)
    {
        $r->validate([
            'no_nota' => ['required','string','max:50', Rule::unique('manual_notas','no_nota')->ignore($ignoreId)],
            'tanggal' => 'required|date',
            'jatuh_tempo' => 'nullable|date|after_or_equal:tanggal',
            'pelanggan_nama' => 'required|string|max:100',
            'pelanggan_hp' => 'nullable|string|max:30',
            'pelanggan_alamat' => 'nullable|string|max:500',
            'status' => 'required|in:lunas,belum_lunas,dp',
            'metode_bayar' => 'nullable|string|max:30',
            'diskon_tipe' => 'nullable|in:nominal,persen',
            'diskon_nilai' => 'nullable|numeric|min:0',
            'biaya_lain' => 'nullable|numeric|min:0',
            'biaya_lain_label' => 'nullable|string|max:50',
            'dp_nominal' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
            'catatan_nota' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.nama' => 'required|string|max:200',
            'items.*.kategori' => 'required|in:barang,jasa',
            'items.*.qty' => 'required|numeric|min:0.01|max:999999',
            'items.*.satuan' => 'required|string|max:20',
            'items.*.harga_satuan' => 'required|numeric|min:0|max:999999999',
            'items.*.diskon_item' => 'nullable|numeric|min:0',
            'items.*.keterangan_item' => 'nullable|string|max:300',
        ]);
        if ($r->status === 'dp' && (float)($r->dp_nominal ?? 0) <= 0) {
            throw \Illuminate\Validation\ValidationException::withMessages(['dp_nominal'=>'DP nominal wajib diisi saat status DP']);
        }
        return [
            'no_nota' => trim($r->no_nota),
            'tanggal' => $r->tanggal,
            'jatuh_tempo' => $r->jatuh_tempo ?: null,
            'pelanggan_nama' => trim($r->pelanggan_nama),
            'pelanggan_hp' => $r->pelanggan_hp ? trim($r->pelanggan_hp) : null,
            'pelanggan_alamat' => $r->pelanggan_alamat ? trim($r->pelanggan_alamat) : null,
            'status' => $r->status,
            'metode_bayar' => $r->metode_bayar ?: null,
            'diskon_tipe' => $r->diskon_tipe ?: null,
            'diskon_nilai' => (float)($r->diskon_nilai ?? 0),
            'biaya_lain' => (float)($r->biaya_lain ?? 0),
            'biaya_lain_label' => $r->biaya_lain_label ? trim($r->biaya_lain_label) : null,
            'dp_nominal' => (float)($r->dp_nominal ?? 0),
            'keterangan' => $r->keterangan ? trim($r->keterangan) : null,
            'catatan_nota' => $r->catatan_nota ? trim($r->catatan_nota) : null,
        ];
    }

    private function calculate(Request $r): array
    {
        $itemsRaw = $r->input('items', []);
        $items = [];
        $subtotal = 0;
        $hasBarang = false;
        $hasJasa = false;
        foreach ($itemsRaw as $row) {
            if (empty($row['nama'])) continue;
            $qty = (float)($row['qty'] ?? 0);
            $harga = (float)($row['harga_satuan'] ?? 0);
            $diskon = (float)($row['diskon_item'] ?? 0);
            $line = $qty * $harga - $diskon;
            if ($line < 0) $line = 0;
            $subtotal += $line;
            $kat = $row['kategori'] ?? 'barang';
            if ($kat === 'barang') $hasBarang = true;
            if ($kat === 'jasa') $hasJasa = true;
            $items[] = [
                'nama' => trim($row['nama']),
                'kategori' => $kat,
                'qty' => $qty,
                'satuan' => trim($row['satuan'] ?? 'pcs'),
                'harga_satuan' => $harga,
                'diskon_item' => $diskon,
                'subtotal' => $line,
                'keterangan_item' => $row['keterangan_item'] ?? null,
            ];
        }
        if (empty($items)) { abort(422, 'Minimal 1 baris barang/jasa'); }
        $diskonTipe = $r->diskon_tipe;
        $diskonNilai = (float)($r->diskon_nilai ?? 0);
        $diskonGlobal = 0;
        if ($diskonTipe === 'persen' && $diskonNilai > 0) $diskonGlobal = $subtotal * $diskonNilai / 100;
        elseif ($diskonTipe === 'nominal') $diskonGlobal = $diskonNilai;
        if ($diskonGlobal > $subtotal) $diskonGlobal = $subtotal;
        $biayaLain = (float)($r->biaya_lain ?? 0);
        $total = $subtotal - $diskonGlobal + $biayaLain;
        if ($total < 0) $total = 0;
        $status = $r->status;
        $dp = (float)($r->dp_nominal ?? 0);
        if ($dp > $total) $dp = $total;
        if ($status === 'lunas') { $sisa = 0; $dp = 0; }
        elseif ($status === 'dp') { $sisa = $total - $dp; }
        else { $sisa = $total; $dp = 0; }
        $jenis = 'campuran';
        if ($hasBarang && !$hasJasa) $jenis = 'barang';
        elseif (!$hasBarang && $hasJasa) $jenis = 'jasa';
        return [
            'subtotal' => $subtotal,
            'total' => $total,
            'sisa' => $sisa,
            'jenis' => $jenis,
            'items' => $items,
            'extra' => ['diskon_tipe'=>$diskonTipe?:null,'diskon_nilai'=>$diskonTipe?$diskonNilai:0,'dp_nominal'=>$dp],
        ];
    }
}
