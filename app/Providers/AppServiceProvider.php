<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;


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

        Paginator::useBootstrap();

        app()->singleton('showModal',function () {
            if (session()->has('showModal')) {
                return session()->get('showModal');
            }else{
                return 'no';
            }

        });

        app()->singleton('lang',function (){
            if(session()->has('lang')){
                return session()->get('lang');
            }// session lang exist
            else{
                return 'ar';
            }
        });
        Schema::defaultStringLength(191);
        view()->share('settings', Setting::first());

    }
}
