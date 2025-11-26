<?php

namespace App\Infrastructure\Teacher\Provider;

use App\Domain\Teacher\Repository\IDocenteRepository;
use App\Domain\Teacher\Repository\IGrupoCursoRepository;
use App\Infrastructure\Teacher\Repository\EloquentDocenteRepository;
use App\Infrastructure\Teacher\Repository\EloquentGrupoCursoRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IDocenteRepository::class, EloquentDocenteRepository::class);
        $this->app->bind(IGrupoCursoRepository::class, EloquentGrupoCursoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
