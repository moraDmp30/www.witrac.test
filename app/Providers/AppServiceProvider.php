<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Command\CommandRepository;
use App\Repositories\Command\EloquentCommandRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(CommandRepository::class, EloquentCommandRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
    }
}
