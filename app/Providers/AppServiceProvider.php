<?php

namespace App\Providers;

use App\Domain\Teacher\Repository\IDocenteRepository;
use App\Domain\Teacher\Repository\IGrupoCursoRepository;
use App\Infrastructure\Teacher\Repository\EloquentDocenteRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
