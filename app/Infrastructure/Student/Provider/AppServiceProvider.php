<?php

namespace App\Infrastructure\Student\Provider;

use App\Domain\Student\Repository\IAlumnoRepository;
use App\Domain\Student\Repository\ICursoRepository;
use App\Infrastructure\Student\Repository\EloquentAlumnoRepository;
use App\Infrastructure\Student\Repository\EloquentCursoRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      $this->app->bind(IAlumnoRepository::class, EloquentAlumnoRepository::class);
      $this->app->bind(ICursoRepository::class, EloquentCursoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
