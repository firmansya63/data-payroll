<?php
namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanySettingController extends Controller
{
    public function index()
    {
        $company = CompanySetting::current();
        return view('settings.company', compact('company'));
    }

    public function update(Request $r)
    {
        $r->validate([
            'name' => 'required|string|max:100',
            'tagline' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'website' => 'nullable|string|max:150',
            'logo' => 'nullable|image|max:2048|mimes:png,jpg,jpeg,webp',
            'pimpinan_nama' => 'nullable|string|max:100',
            'pimpinan_jabatan' => 'nullable|string|max:100',
            'footer_text' => 'nullable|string|max:500',
        ]);

        $company = CompanySetting::current();

        $data = $r->only(['name','tagline','address','phone','email','website','pimpinan_nama','pimpinan_jabatan','footer_text']);

        if ($r->hasFile('logo')) {
            if ($company->logo_path && Storage::disk('public')->exists($company->logo_path)) {
                Storage::disk('public')->delete($company->logo_path);
            }
            $path = $r->file('logo')->store('company', 'public');
            $data['logo_path'] = $path;
        }

        // hapus logo
        if ($r->boolean('remove_logo') && $company->logo_path) {
            if (Storage::disk('public')->exists($company->logo_path)) Storage::disk('public')->delete($company->logo_path);
            $data['logo_path'] = null;
        }

        $company->update($data);

        return back()->with('ok','Data perusahaan berhasil disimpan');
    }
}
