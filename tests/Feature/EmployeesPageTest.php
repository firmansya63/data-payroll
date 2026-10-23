<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class EmployeesPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // View dirender langsung (tanpa middleware ShareErrorsFromSession),
        // jadi bag error kosong di-share manual agar layout app tetap bisa dirender.
        view()->share('errors', new ViewErrorBag);
    }

    private function emptyEmployees(): LengthAwarePaginator
    {
        return new LengthAwarePaginator([], 0, 15);
    }

    public function test_halaman_daftar_karyawan_memakai_tema_indigo_violet_fuchsia(): void
    {
        $html = view('employees.index', ['employees' => $this->emptyEmployees()])->render();

        $this->assertStringContainsString('from-indigo-600', $html);
        $this->assertStringContainsString('via-violet-600', $html);
        $this->assertStringContainsString('to-fuchsia-500', $html);
        $this->assertStringContainsString('Karyawan', $html);
        $this->assertStringContainsString(route('employees.create'), $html);
        $this->assertStringContainsString('backdrop-blur-xl', $html);
        $this->assertStringNotContainsString('bg-sky-600', $html);
    }

    public function test_halaman_daftar_karyawan_punya_pencarian_dan_filter_status(): void
    {
        $html = view('employees.index', ['employees' => $this->emptyEmployees()])->render();

        $this->assertStringContainsString('name="q"', $html);
        $this->assertStringContainsString('aktif=1', $html);
        $this->assertStringContainsString('aktif=0', $html);
        $this->assertStringContainsString('Semua', $html);
        $this->assertStringContainsString('Nonaktif', $html);
    }

    public function test_form_tambah_karyawan_memuat_semua_field(): void
    {
        $html = view('employees.create')->render();

        $this->assertStringContainsString('action="'.route('employees.store').'"', $html);
        $this->assertStringContainsString('name="nama"', $html);
        $this->assertStringContainsString('name="jabatan"', $html);
        $this->assertStringContainsString('name="gaji_pokok"', $html);
        $this->assertStringContainsString('name="bonus_per_hadir"', $html);
        $this->assertStringContainsString('name="no_hp"', $html);
        $this->assertStringContainsString('name="alamat"', $html);
        $this->assertStringNotContainsString('bg-sky-600', $html);
    }

    public function test_form_edit_karyawan_terisi_dan_punya_switch_status(): void
    {
        $employee = new Employee([
            'nama' => 'Budi Santoso',
            'jabatan' => 'teknisi',
            'gaji_pokok' => 1500000,
            'bonus_per_hadir' => 10000,
            'is_active' => true,
        ]);
        $employee->id = 7;

        $html = view('employees.edit', ['employee' => $employee])->render();

        $this->assertStringContainsString('action="'.route('employees.update', $employee).'"', $html);
        $this->assertStringContainsString('name="_method"', $html);
        $this->assertStringContainsString('name="is_active"', $html);
        $this->assertStringContainsString('Budi Santoso', $html);
        $this->assertStringContainsString('value="1500000"', $html);
        $this->assertStringNotContainsString('bg-sky-600', $html);
    }
}
