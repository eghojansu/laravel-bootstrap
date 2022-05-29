<?php

namespace App\Providers;

use App\Extended\Blueprint as ExtendedBlueprint;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        $services = cloads(app_path('Services'), 'App\\Services');

        array_walk($services, fn (string $name) => $this->app->singleton($name));

        $this->app->bind(Blueprint::class, ExtendedBlueprint::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(64);
    }
}
