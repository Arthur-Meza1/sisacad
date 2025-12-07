<?php

namespace App\Infrastructure\Admin\Provider;

use App\Domain\Admin\Repository\IUserRepository;
use App\Infrastructure\Admin\Repository\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->bind(
      IUserRepository::class,
      EloquentUserRepository::class
    );

    // Aquí se agregarían otros bindings específicos del Admin (Cursos, Aulas, etc.)
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    //
  }
}
