<?php

namespace App\Providers;

use App\Http\ViewComposers\CategoryComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
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
    public function boot(): void
    {
        view()->composer('includes.header' , CategoryComposer::class);
        view()->composer('add_place' , CategoryComposer::class);
        Gate::define('like-review' , function($user , $review){
            return $user->id != $review->user_id;
        });

        Blade::if('owner' , function(){
            return auth()->check() && auth()->user()->hasrole('Owner');
        });
    }
}
