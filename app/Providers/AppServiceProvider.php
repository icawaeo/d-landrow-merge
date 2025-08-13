<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
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
        View::composer('*', function ($view) {
            $projectsForReview = collect(); // Default collection kosong
            if (Auth::guard('admin')->check()) {
                $userRole = Auth::guard('admin')->user()->role;

                if ($userRole === 'admin1') {
                    $pengadaanTanah = PengadaanTanah::where('status_persetujuan', 'menunggu_admin_1')->latest()->get();
                    $row = Row::where('status_persetujuan', 'menunggu_admin_1')->latest()->get();
                    $projectsForReview = $pengadaanTanah->concat($row);
                } elseif ($userRole === 'admin2') {
                    $pengadaanTanah = PengadaanTanah::where('status_persetujuan', 'menunggu_admin_2')->latest()->get();
                    $row = Row::where('status_persetujuan', 'menunggu_admin_2')->latest()->get();
                    $projectsForReview = $pengadaanTanah->concat($row);
                } elseif ($userRole === 'admin3') {
                    $pengadaanTanah = PengadaanTanah::where('status_persetujuan', 'menunggu_admin_3')->latest()->get();
                    $row = Row::where('status_persetujuan', 'menunggu_admin_3')->latest()->get();
                    $projectsForReview = $pengadaanTanah->concat($row);
                }
            }
            $view->with('projectsForReview', $projectsForReview);
        });
    }
}