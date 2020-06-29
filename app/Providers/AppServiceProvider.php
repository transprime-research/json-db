<?php

namespace App\Providers;

use App\Builders\JsonBuilder;
use Illuminate\Database\Query\Builder;
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
        //
        $this->app->instance(Builder::class, JsonBuilder::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->app->singleton(Builder::class, JsonBuilder::class);
        $this->app->instance(Builder::class, JsonBuilder::class);
    }
}
