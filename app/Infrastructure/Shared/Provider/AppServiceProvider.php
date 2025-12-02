<?php

namespace App\Infrastructure\Shared\Provider;

use App\Domain\Shared\Repository\IAulaRepository;
use App\Domain\Shared\Repository\IHorarioRepository;
use App\Domain\Shared\Repository\ISesionRepository;
use App\Infrastructure\Shared\Repository\EloquentAulaRepository;
use App\Infrastructure\Shared\Repository\EloquentHorarioRepository;
use App\Infrastructure\Shared\Repository\EloquentSesionRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->bind(IHorarioRepository::class, EloquentHorarioRepository::class);
    $this->app->bind(IAulaRepository::class, EloquentAulaRepository::class);
    $this->app->bind(ISesionRepository::class, EloquentSesionRepository::class);
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    //
  }
}
