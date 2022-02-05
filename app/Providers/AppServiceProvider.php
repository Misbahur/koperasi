<?php

namespace App\Providers;

use App\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('*', function (View $view) {
            $total = Notification::where('read', 'false')->get()->count();
            $view->with('total', $total);
        });
        view()->composer('*', function (View $view) {
            // notif in admin
            $notifs = Notification::latest()->take(5)->get();
            $view->with('notif_admin', $notifs);
        });
        view()->composer('*', function (View $view) {
            // notif in nasabah
            $notif = Notification::where('user_id', auth()->user()->id ?? '')->latest()->take(5)->get();
            $view->with('notif_user', $notif);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
