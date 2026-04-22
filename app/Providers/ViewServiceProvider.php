<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       View::composer('*', function ($view) {
            $numbers = [
                'admin_1' => config('whatsapp.admin_1'),
                'admin_2' => config('whatsapp.admin_2'),
                'admin_3' => config('whatsapp.admin_3'),
            ];

            $view->with($numbers);
       });
    }
}
