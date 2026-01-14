<?php

namespace Tests\Feature\Student;

use App\Infrastructure\Shared\Model\User;
use App\Application\Student\UseCase\GetLabs;
use App\Application\Student\UseCase\GetCupos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery\MockInterface;

class MatriculaControllerTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function test_estudiante_autenticado_pantalla_de_matricula()
  {
    //uso de mockes para saber si funciona bien controllador
    $this->mock(GetLabs::class, function (MockInterface $mock) {
      $mock->shouldReceive('execute')->once()->andReturn([]);
    });

    $this->mock(GetCupos::class, function (MockInterface $mock) {
      $mock->shouldReceive('execute')->once()->andReturn([]);
    });

    $user = User::factory()->create([
      'role' => 'student'
    ]);

    $response = $this->actingAs($user)->get(route('student.matricula'));

    $response->assertStatus(200);
    $response->assertViewIs('student.matricula');
    $response->assertViewHas(['labs', 'cupos']);
  }
}
