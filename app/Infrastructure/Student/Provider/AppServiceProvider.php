<?php

namespace App\Infrastructure\Student\Provider;

use App\Domain\Student\Repository\IAlumnoRepository;
use App\Infrastructure\Student\Repository\EloquentAlumnoRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      $this->app->bind(IAlumnoRepository::class, EloquentAlumnoRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
