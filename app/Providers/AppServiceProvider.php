<?php

namespace App\Providers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
   public function boot()
{
    View::composer('*', function ($view) {
        $antrean_pengembalian = Pengembalian::where('status_pengembalian', 'diajukan')->count();
        // Asumsi ada status 'pending' untuk peminjaman baru
        $antrean_peminjaman = Peminjaman::where('status_peminjaman', 'pending')->count(); 

        $view->with([
            'antrean_pengembalian' => $antrean_pengembalian,
            'antrean_peminjaman' => $antrean_peminjaman,
            'notif_count' => $antrean_pengembalian + $antrean_peminjaman
        ]);
    });
}
}