<?php

namespace App\Providers;

use App\Interfaces\HorarioServiceInterface;
use App\Services\HorarioService;
use Illuminate\Support\ServiceProvider;

class HorarioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(HorarioServiceInterface::class, HorarioService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
