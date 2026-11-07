<?php
namespace App\Http\Controllers;
use App\Models\VoucherTransaction;
use App\Models\Reseller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherTransactionController extends Controller
{
    private function priceList(){
        return config('voucher.types', [
            '3k' => ['label'=>'3.000','retail'=>3000,'reseller'=>2500],
            '5k' => ['label'=>'5.000','retail'=>5000,'reseller'=>4000],
            '10k' => ['label'=>'10.000','retail'=>10000,'reseller'=>9000],
        ]);
    }

    public function index(Request $r){
        $q = VoucherTransaction::with('reseller')->latest('tanggal')->latest('id');
        if($r->status && in_array($r->status,['lunas','belum_lunas'])) $q->where('status',$r->status);
        if($r->reseller_id) $q->where('reseller_id',$r->reseller_id);
        if($r->voucher_type && isset($this->priceList()[$r->voucher_type])) $q->where('voucher_type',$r->voucher_type);
        if($r->dari) $q->whereDate('tanggal','>=',$r->dari);
        if($r->sampai) $q->whereDate('tanggal','<=',$r->sampai);
        if($r->q){
            $s=$r->q;
            $q->where(function($qq) use($s){
                $qq->where('keterangan','like',"%$s%")->orWhereHas('reseller',fn($x)=>$x->where('nama','like',"%$s%"));
            });
        }
        $transactions = $q->paginate(15)->withQueryString();
        $resellers = Reseller::orderBy('nama')->get();
        $totalPiutang = (clone $q)->where('status','belum_lunas')->sum('nominal');
        $sumPiutang = VoucherTransaction::where('status','belum_lunas')->sum('nominal');
        $sumLunas = VoucherTransaction::where('status','lunas')->sum('nominal');
        $types = $this->priceList();
        return view('transactions.index', compact('transactions','resellers','totalPiutang','sumPiutang','sumLunas','types'));
    }
    public function create(){
        $resellers = Reseller::orderBy('nama')->get();
        $types = $this->priceList();
        return view('transactions.create', compact('resellers','types'));
    }
    public function store(Request $r){
        $types = $this->priceList();
        $r->validate([
            'reseller_id'=>'required|exists:resellers,id',
            'qty_3k'=>'nullable|integer|min:0|max:10000',
            'qty_5k'=>'nullable|integer|min:0|max:10000',
            'qty_10k'=>'nullable|integer|min:0|max:10000',
            'voucher_type'=>'nullable|in:3k,5k,10k',
            'qty'=>'nullable|integer|min:1|max:10000',
            'tanggal'=>'required|date',
            'status'=>'required|in:lunas,belum_lunas',
            'keterangan'=>'nullable|string|max:500',
        ]);
        if($r->filled('voucher_type') && $r->filled('qty') && (int)$r->qty>0 && (int)($r->qty_3k ?? 0)==0 && (int)($r->qty_5k ?? 0)==0 && (int)($r->qty_10k ?? 0)==0){
            $t = $types[$r->voucher_type];
            $qty = (int)$r->qty;
            $ket = $r->keterangan ?: $qty.' voucher '.$t['label'];
            VoucherTransaction::create([
                'reseller_id'=>$r->reseller_id,
                'voucher_type'=>$r->voucher_type,
                'qty'=>$qty,
                'harga_satuan'=>$t['reseller'],
                'harga_retail'=>$t['retail'],
                'tanggal'=>$r->tanggal,
                'nominal'=>$qty*$t['reseller'],
                'status'=>$r->status,
                'keterangan'=>$ket,
                'created_by'=>Auth::id(),
            ]);
            return redirect()->route('transactions.index')->with('ok','Transaksi '.$qty.'×'.$t['label'].' disimpan: Rp '.number_format($qty*$t['reseller'],0,',','.'));
        }
        $map = ['3k'=>(int)($r->qty_3k ?? 0),'5k'=>(int)($r->qty_5k ?? 0),'10k'=>(int)($r->qty_10k ?? 0)];
        if(array_sum($map)==0) return back()->withErrors(['qty_5k'=>'Isi minimal 1 jenis vocer (isi >0, yang tidak dibeli biarkan 0)'])->withInput();
        $totalNominal=0; $created=[];
        $keteranganAuto=$r->keterangan;
        if(!$keteranganAuto){ $parts=[]; foreach($map as $k=>$q) if($q>0) $parts[]=$q.' voucher '.$types[$k]['label']; $keteranganAuto=implode(' + ', $parts); }
        foreach($map as $type=>$qty){ if($qty<=0) continue; $t=$types[$type]; $nominal=$qty*$t['reseller']; $totalNominal+=$nominal;
            VoucherTransaction::create(['reseller_id'=>$r->reseller_id,'voucher_type'=>$type,'qty'=>$qty,'harga_satuan'=>$t['reseller'],'harga_retail'=>$t['retail'],'tanggal'=>$r->tanggal,'nominal'=>$nominal,'status'=>$r->status,'keterangan'=>$keteranganAuto,'created_by'=>Auth::id()]);
            $created[]=$qty.'×'.$t['label'];
        }
        return redirect()->route('transactions.index')->with('ok','Transaksi '.implode(' + ',$created).' disimpan. Total Rp '.number_format($totalNominal,0,',','.').' ('.count($created).' baris)');
    }
    public function edit(VoucherTransaction $transaction){
        $resellers = Reseller::orderBy('nama')->get();
        $types = $this->priceList();
        return view('transactions.edit', compact('transaction','resellers','types'));
    }
    public function update(Request $r, VoucherTransaction $transaction){
        $types = $this->priceList();
        $r->validate([
            'reseller_id'=>'required|exists:resellers,id',
            'voucher_type'=>'required|in:3k,5k,10k',
            'qty'=>'required|integer|min:1|max:10000',
            'tanggal'=>'required|date',
            'status'=>'required|in:lunas,belum_lunas',
            'keterangan'=>'nullable|string|max:500',
        ]);
        $t = $types[$r->voucher_type];
        $qty = (int)$r->qty;
        $hargaSatuan = $t['reseller'];
        $hargaRetail = $t['retail'];
        $nominal = $qty * $hargaSatuan;
        $ket = $r->keterangan ?: $qty.' voucher '.$t['label'];
        $transaction->update([
            'reseller_id'=>$r->reseller_id,
            'voucher_type'=>$r->voucher_type,
            'qty'=>$qty,
            'harga_satuan'=>$hargaSatuan,
            'harga_retail'=>$hargaRetail,
            'tanggal'=>$r->tanggal,
            'nominal'=>$nominal,
            'status'=>$r->status,
            'keterangan'=>$ket,
        ]);
        return redirect()->route('transactions.index')->with('ok','Transaksi diperbarui');
    }
    public function destroy(VoucherTransaction $transaction){
        $transaction->delete();
        return back()->with('ok','Transaksi dihapus');
    }
    public function markLunas(VoucherTransaction $transaction){
        $transaction->update(['status'=>'lunas']);
        if(request()->wantsJson()) return response()->json(['ok'=>true]);
        return back()->with('ok','Status diubah menjadi Lunas');
    }
    public function rekap(Request $r){
        $types = $this->priceList();
        $base = VoucherTransaction::query();
        if($r->dari) $base->whereDate('tanggal','>=',$r->dari);
        if($r->sampai) $base->whereDate('tanggal','<=',$r->sampai);
        if($r->status && in_array($r->status,['lunas','belum_lunas'])) $base->where('status',$r->status);
        if($r->voucher_type && isset($types[$r->voucher_type])) $base->where('voucher_type',$r->voucher_type);
        if($r->reseller_id) $base->where('reseller_id',$r->reseller_id);
        if($r->q){
            $s = $r->q;
            $ids = Reseller::where('nama','like',"%$s%")->orWhere('no_hp','like',"%$s%")->pluck('id');
            if($ids->isEmpty()){
                $base->whereRaw('1=0');
            } else {
                $base->whereIn('reseller_id',$ids);
            }
        }
        $rows = (clone $base)->selectRaw("
            reseller_id,
            COUNT(*) as trx_count,
            SUM(qty) as total_qty,
            SUM(CASE WHEN voucher_type='3k' THEN qty ELSE 0 END) as qty_3k,
            SUM(CASE WHEN voucher_type='5k' THEN qty ELSE 0 END) as qty_5k,
            SUM(CASE WHEN voucher_type='10k' THEN qty ELSE 0 END) as qty_10k,
            SUM(nominal) as total_nominal,
            SUM(CASE WHEN status='belum_lunas' THEN nominal ELSE 0 END) as piutang,
            SUM(CASE WHEN status='lunas' THEN nominal ELSE 0 END) as lunas
        ")->groupBy('reseller_id')->with('reseller')->get();
        $rows = $rows->sortByDesc(fn($x)=>(float)$x->piutang)->values();
        $grand = [
            'trx_count' => (int)$rows->sum('trx_count'),
            'qty_3k' => (int)$rows->sum('qty_3k'),
            'qty_5k' => (int)$rows->sum('qty_5k'),
            'qty_10k' => (int)$rows->sum('qty_10k'),
            'total_qty' => (int)$rows->sum('total_qty'),
            'piutang' => (float)$rows->sum('piutang'),
            'lunas' => (float)$rows->sum('lunas'),
            'total_nominal' => (float)$rows->sum('total_nominal'),
        ];
        $resellers = Reseller::orderBy('nama')->get();
        return view('transactions.rekap', compact('rows','grand','types','resellers'));
    }
    public function notaRekap(Request $r, Reseller $reseller){
        $types = $this->priceList();
        $q = VoucherTransaction::where('reseller_id',$reseller->id);
        if($r->dari) $q->whereDate('tanggal','>=',$r->dari);
        if($r->sampai) $q->whereDate('tanggal','<=',$r->sampai);
        if($r->status && in_array($r->status,['lunas','belum_lunas'])) $q->where('status',$r->status);
        if($r->voucher_type && isset($types[$r->voucher_type])) $q->where('voucher_type',$r->voucher_type);
        
        $aggr = (clone $q)->selectRaw("COUNT(*) as trx_count, SUM(qty) as total_qty, SUM(CASE WHEN voucher_type='3k' THEN qty ELSE 0 END) as qty_3k, SUM(CASE WHEN voucher_type='5k' THEN qty ELSE 0 END) as qty_5k, SUM(CASE WHEN voucher_type='10k' THEN qty ELSE 0 END) as qty_10k, SUM(nominal) as total_nominal, SUM(CASE WHEN status='belum_lunas' THEN nominal ELSE 0 END) as piutang, SUM(CASE WHEN status='lunas' THEN nominal ELSE 0 END) as lunas")->first();
        
        // Group transactions by date (tanggal)
        $rawDetails = (clone $q)->orderBy('tanggal')->orderBy('id')->get();
        $details = $rawDetails->groupBy(fn($item) => $item->tanggal->format('Y-m-d'))->map(function($group, $date) {
            return (object)[
                'tanggal' => \Carbon\Carbon::parse($date),
                'trx_count' => $group->count(),
                'qty_3k' => $group->where('voucher_type', '3k')->sum('qty'),
                'qty_5k' => $group->where('voucher_type', '5k')->sum('qty'),
                'qty_10k' => $group->where('voucher_type', '10k')->sum('qty'),
                'total_qty' => $group->sum('qty'),
                'nominal' => $group->sum('nominal'),
                'statuses' => $group->pluck('status')->unique(),
                'is_all_lunas' => $group->every(fn($i) => $i->status == 'lunas'),
                'is_all_belum' => $group->every(fn($i) => $i->status == 'belum_lunas'),
            ];
        })->values();

        $periode = null;
        if($r->dari || $r->sampai) $periode = trim(($r->dari ?: 'awal').' s/d '.($r->sampai ?: now()->format('Y-m-d')));
        return view('transactions.nota-rekap', compact('reseller','aggr','details','types','periode'));
    }
    public function nota(VoucherTransaction $transaction){
        $transaction->load('reseller');
        $types = $this->priceList();
        return view('transactions.nota', compact('transaction','types'));
    }
}
