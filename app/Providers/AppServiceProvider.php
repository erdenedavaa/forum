<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Filesystem\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('*', function($view)
        {
            $channels = \Cache::rememberForever('channels', function(){
                return Channel::all();
            });

            $view->with('channels', $channels);
        });

        \Validator::extend('spamfree', 'App\Rules\SpamFree@passes');

//        \View::share('channels', Channel::all());
        // Ene ni testing deer algaa uusgesen
    }
}
