<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer(
            'layouts.dokter',
            \App\Http\View\Composers\SidebarComposer::class
        );

        View::composer('layouts.app', function ($view) {
            $view->with('klinik', \App\Models\InfoKlinik::first());
        });
    }
}
