<?php
namespace App\Http\Controllers;
use App\Models\Reseller;
use Illuminate\Http\Request;
class ResellerController extends Controller
{
    public function index(Request $r){
        $q = Reseller::query();
        if($s=$r->q) $q->where('nama','like',"%$s%")->orWhere('no_hp','like',"%$s%");
        $resellers = $q->withCount(['transactions as piutang_sum'=>function($qq){ $qq->where('status','belum_lunas'); }])->latest()->paginate(10)->withQueryString();
        // hitung total piutang per reseller manual sum
        foreach($resellers as $res){
            $res->total_piutang = \App\Models\VoucherTransaction::where('reseller_id',$res->id)->where('status','belum_lunas')->sum('nominal');
            $res->total_lunas = \App\Models\VoucherTransaction::where('reseller_id',$res->id)->where('status','lunas')->sum('nominal');
        }
        return view('resellers.index', compact('resellers'));
    }
    public function create(){ return view('resellers.create'); }
    public function store(Request $r){
        $r->validate(['nama'=>'required|string|max:100','no_hp'=>'nullable|string|max:30','alamat'=>'nullable','catatan'=>'nullable']);
        Reseller::create($r->only('nama','no_hp','alamat','catatan'));
        return redirect()->route('resellers.index')->with('ok','Reseller ditambahkan');
    }
    public function edit(Reseller $reseller){ return view('resellers.edit', compact('reseller')); }
    public function update(Request $r, Reseller $reseller){
        $r->validate(['nama'=>'required|string|max:100','no_hp'=>'nullable|string|max:30']);
        $reseller->update($r->only('nama','no_hp','alamat','catatan'));
        return redirect()->route('resellers.index')->with('ok','Reseller diperbarui');
    }
    public function destroy(Reseller $reseller){
        $reseller->delete();
        return back()->with('ok','Reseller dihapus');
    }
}
