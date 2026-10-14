<?php
namespace App\Http\Controllers;
use App\Models\Deduction;
use App\Models\Employee;
use Illuminate\Http\Request;
class DeductionController extends Controller
{
    public function index(Request $r){
        $q = Deduction::with('employee')->latest('tanggal');
        if($r->employee_id) $q->where('employee_id',$r->employee_id);
        if($r->bulan) $q->whereMonth('tanggal',$r->bulan);
        if($r->tahun) $q->whereYear('tanggal',$r->tahun);
        if($r->status) $q->where('status',$r->status);
        $items = $q->paginate(15)->withQueryString();
        $employees = Employee::where('is_active',true)->orderBy('nama')->get();
        $total = (clone $q)->sum('nominal');
        return view('deductions.index', compact('items','employees','total'));
    }
    public function create(){
        $employees = Employee::where('is_active',true)->orderBy('nama')->get();
        return view('deductions.create', compact('employees'));
    }
    public function store(Request $r){
        $r->validate([
            'employee_id'=>'required|exists:employees,id',
            'tanggal'=>'required|date',
            'nominal'=>'required|numeric|min:0',
            'keterangan'=>'nullable|string|max:500',
        ]);
        Deduction::create($r->only('employee_id','tanggal','nominal','keterangan'));
        return redirect()->route('deductions.index')->with('ok','Potongan/Kasbon dicatat');
    }
    public function edit(Deduction $deduction){
        $employees = Employee::where('is_active',true)->orderBy('nama')->get();
        return view('deductions.edit', compact('deduction','employees'));
    }
    public function update(Request $r, Deduction $deduction){
        $r->validate([
            'employee_id'=>'required|exists:employees,id',
            'tanggal'=>'required|date',
            'nominal'=>'required|numeric|min:0',
        ]);
        $deduction->update($r->only('employee_id','tanggal','nominal','keterangan','status'));
        return redirect()->route('deductions.index')->with('ok','Potongan diperbarui');
    }
    public function destroy(Deduction $deduction){
        $deduction->delete();
        return back()->with('ok','Potongan dihapus');
    }
}
