<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Token;
use App\Models\User;
use App\FeeSetup;
use Config;
use Artisan;
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
        // $possesionCharges = FeeSetup::findOrFail(20);
        // $developmentCharges = FeeSetup::findOrFail(21);
        
        Config::Set('possesionCharges', 0);
        Config::Set('developmentCharges',0);
        Schema::defaultStringLength(191);
    }
}
