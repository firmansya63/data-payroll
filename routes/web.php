<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\VoucherTransactionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ClientAcquisitionController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\ManualNotaController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\UserController;

Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class,'showLogin'])->name('login');
    Route::post('/login', [AuthController::class,'login'])->name('login.attempt');
});
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:admin,attendance'])->group(function () {
    Route::get("presences/scan", [PresenceController::class,"scan"])->name("presences.scan");
    Route::post("presences/scan-store", [PresenceController::class,"scanStore"])->name("presences.scanStore");
});

Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get("/", [DashboardController::class,"index"])->name("dashboard");
    Route::resource("resellers", ResellerController::class);
    Route::get("transactions/rekap", [VoucherTransactionController::class,"rekap"])->name("transactions.rekap");
    Route::get("transactions/rekap/{reseller}/nota", [VoucherTransactionController::class,"notaRekap"])->name("transactions.rekap.nota");
    Route::resource("transactions", VoucherTransactionController::class)->parameters(["transactions"=>"transaction"]);
    Route::patch("transactions/{transaction}/lunas", [VoucherTransactionController::class,"markLunas"])->name("transactions.lunas");
    Route::get("transactions/{transaction}/nota", [VoucherTransactionController::class,"nota"])->name("transactions.nota");
    Route::resource("employees", EmployeeController::class);
    Route::get("presences/calendar", [PresenceController::class,"calendar"])->name("presences.calendar");
    Route::get("presences", function (\Illuminate\Http\Request $r) { return redirect()->route("presences.calendar", $r->only("bulan","tahun","employee_id")); })->name("presences.index");
    Route::get("employees/{employee}/qrcode", [PresenceController::class,"qrcodeCard"])->name("employees.qrcode");

    Route::resource("presences", PresenceController::class)->only(["create","store","destroy"]);
    Route::get("presences-bulk", [PresenceController::class,"bulk"])->name("presences.bulk");
    Route::post("presences-bulk", [PresenceController::class,"bulkStore"])->name("presences.bulkStore");
    Route::resource("acquisitions", ClientAcquisitionController::class)->parameters(["acquisitions"=>"acquisition"]);
    Route::resource("deductions", DeductionController::class);
    Route::resource("payrolls", PayrollController::class)->only(["index","create","store","show","destroy"]);
    Route::get("payrolls/{payroll}/slip", [PayrollController::class,"slip"])->name("payrolls.slip");
    Route::resource('users', UserController::class)->except(['show']);
    Route::get("/profile", [ProfileController::class,"edit"])->name("profile.edit");
    Route::patch("/profile", [ProfileController::class,"update"])->name("profile.update");
    Route::patch("/profile/password", [ProfileController::class,"updatePassword"])->name("profile.password");
    Route::get("manual-notas/{nota}/nota", [ManualNotaController::class,"nota"])->name("manual-notas.nota");
    Route::get("manual-notas/{nota}/nota-landscape", [ManualNotaController::class,"notaLandscape"])->name("manual-notas.nota-landscape");
    Route::get("manual-notas/{nota}/duplicate", [ManualNotaController::class,"duplicate"])->name("manual-notas.duplicate");
    Route::resource("manual-notas", ManualNotaController::class)->parameters(["manual-notas"=>"nota"]);
    Route::get("settings/company", [CompanySettingController::class,"index"])->name("settings.company.index");
    Route::put("settings/company", [CompanySettingController::class,"update"])->name("settings.company.update");
    
    // Signature verification routes
    Route::get("signature/verify", [SignatureController::class,"verify"])->name("signature.verify");
    Route::get("signature/verify/{hash}", [SignatureController::class,"verify"])->name("signature.verify.hash");
    Route::post("signature/verify/manual", [SignatureController::class,"verifyManual"])->name("signature.verify.manual");
    Route::get("signature/barcode/{payroll}", [SignatureController::class,"barcode"])->name("signature.barcode");
    Route::get("signature/qrcode/{payroll}", [SignatureController::class,"qrcode"])->name("signature.qrcode");
});