<?php
namespace App\Http\Controllers;
use App\Models\ClientAcquisition;
use App\Models\Employee;
use Illuminate\Http\Request;

class ClientAcquisitionController extends Controller
{
    public function index(Request $r){
        $bulan = $r->bulan;
        $tahun = $r->tahun;
        $q = ClientAcquisition::with('employee')->latest('tanggal');
        if($bulan) $q->whereMonth('tanggal',$bulan);
        if($tahun) $q->whereYear('tanggal',$tahun);
        if($r->employee_id) $q->where('employee_id',$r->employee_id);
        if($s=$r->q) $q->where('nama_klien','like',"%$s%");
        $items = $q->paginate(15)->withQueryString();
        $employees = Employee::where('is_active',true)->orderBy('nama')->get();
        $totalInsentif = (clone $q)->sum('nominal_insentif');
        return view('acquisitions.index', compact('items','employees','totalInsentif'));
    }
    public function create(){
        $employees = Employee::where('is_active',true)->orderBy('nama')->get();
        return view('acquisitions.create', compact('employees'));
    }
    public function store(Request $r){
        $r->validate([
            'employee_id'=>'required|exists:employees,id',
            'nama_klien'=>'required|string|max:150',
            'alamat_klien'=>'nullable|string|max:500',
            'tanggal'=>'required|date',
            'nominal_insentif'=>'required|numeric|min:0',
            'keterangan'=>'nullable|string|max:500',
        ]);
        ClientAcquisition::create($r->only('employee_id','nama_klien','alamat_klien','tanggal','nominal_insentif','keterangan'));
        return redirect()->route('acquisitions.index')->with('ok','Klien baru dicatat');
    }
    public function edit(ClientAcquisition $acquisition){
        $employees = Employee::where('is_active',true)->orderBy('nama')->get();
        return view('acquisitions.edit', compact('acquisition','employees'));
    }
    public function update(Request $r, ClientAcquisition $acquisition){
        $r->validate([
            'employee_id'=>'required|exists:employees,id',
            'nama_klien'=>'required|string|max:150',
            'tanggal'=>'required|date',
            'nominal_insentif'=>'required|numeric|min:0',
        ]);
        $acquisition->update($r->only('employee_id','nama_klien','alamat_klien','tanggal','nominal_insentif','keterangan'));
        return redirect()->route('acquisitions.index')->with('ok','Data diperbarui');
    }
    public function destroy(ClientAcquisition $acquisition){
        $acquisition->delete();
        return back()->with('ok','Data dihapus');
    }
}
