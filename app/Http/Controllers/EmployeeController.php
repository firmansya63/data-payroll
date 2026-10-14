<?php
namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
class EmployeeController extends Controller
{
    public function index(Request $r){
        $q = Employee::query();
        if($s=$r->q) $q->where('nama','like',"%$s%")->orWhere('jabatan','like',"%$s%");
        if($r->has('aktif')) $q->where('is_active', $r->aktif==1);
        $employees = $q->latest()->paginate(15)->withQueryString();
        return view('employees.index', compact('employees'));
    }
    public function create(){ return view('employees.create'); }
    public function store(Request $r){
        $r->validate([
            'nama'=>'required|string|max:100',
            'jabatan'=>'required|in:teknisi,marketing,admin,lainnya',
            'gaji_pokok'=>'required|numeric|min:0',
            'bonus_per_hadir'=>'nullable|numeric|min:0',
            'no_hp'=>'nullable|string|max:30',
            'alamat'=>'nullable',
        ]);
        Employee::create($r->only('nama','jabatan','gaji_pokok','bonus_per_hadir','no_hp','alamat') + ['is_active'=>true]);
        return redirect()->route('employees.index')->with('ok','Karyawan ditambahkan');
    }
    public function edit(Employee $employee){ return view('employees.edit', compact('employee')); }
    public function update(Request $r, Employee $employee){
        $r->validate([
            'nama'=>'required|string|max:100',
            'jabatan'=>'required|in:teknisi,marketing,admin,lainnya',
            'gaji_pokok'=>'required|numeric|min:0',
            'bonus_per_hadir'=>'nullable|numeric|min:0',
        ]);
        $employee->update($r->only('nama','jabatan','gaji_pokok','bonus_per_hadir','no_hp','alamat') + ['is_active'=>$r->has('is_active')]);
        return redirect()->route('employees.index')->with('ok','Karyawan diperbarui');
    }
    public function destroy(Employee $employee){
        $employee->delete();
        return back()->with('ok','Karyawan dihapus');
    }
}
