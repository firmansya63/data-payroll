<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\CompanySetting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Share data perusahaan ke slip, nota, dan layout (aman jika tabel belum migrate: try/catch)
        View::composer(['payrolls.slip','transactions.nota','transactions.nota-rekap','manual-notas.nota','manual-notas.nota-landscape','layouts.app'], function ($view) {
            try {
                $view->with('company', \App\Models\CompanySetting::current());
            } catch (\Throwable $e) {
                $view->with('company', null);
            }
        });
    }
}
