<?php

namespace App\Providers;

use App\Services\Crontab\CrontabReader;
use Illuminate\Support\ServiceProvider;
use App\Services\Crontab\FileCrontabReader;
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
        $this->app->bind(CrontabReader::class, FileCrontabReader::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
    }
}
