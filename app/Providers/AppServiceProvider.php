<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; 
use App\Models\PengadaanTanah;  
use App\Models\Row;    

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.sidebar', function ($view) {
            $view->with('daftarPengadaanTanah', PengadaanTanah::where('kategori', 'pengadaan-tanah')->latest()->get());
            $view->with('daftarRow', Row::latest()->get());
        });
    }
}