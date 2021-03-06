<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        if(env('App_ENV') !== 'local'){
            //URL::forceScheme('https');
        }

        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return  url('/')."/password/reset/{$token}";
        });
    }
}
