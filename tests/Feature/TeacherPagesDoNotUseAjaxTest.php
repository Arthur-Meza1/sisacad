<?php

namespace Tests\Feature;

use App\Infrastructure\Shared\Model\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherPagesDoNotUseAjaxTest extends TestCase
{
  use RefreshDatabase;

  private array $routes = [
    'teacher.dashboard' => '/teacher',
    'teacher.libreta' => '/teacher/libreta',
    'teacher.horario' => '/teacher/horario',
    'teacher.notas' => '/teacher/notas',
  ];

  private function authenticateTeacher(): void
  {
    $user = User::factory()->create([
      'name' => "Test Teacher",
      'email' => "test@teacher.com",
      'role' => 'teacher',
    ]);

    $this->actingAs($user);
  }

  #[Test]
  public function teacher_pages_are_not_ajax_requests()
  {
    $this->authenticateTeacher();

    foreach ($this->routes as $route) {
      $response = $this->get($route);

      $this->assertFalse(
        request()->ajax(),
        "La ruta {$route} está siendo tratada como AJAX"
      );

      $response->assertStatus(200);
    }
  }

  #[Test]
  public function teacher_pages_do_not_change_behavior_when_ajax_header_is_sent()
  {
    $this->authenticateTeacher();

    foreach ($this->routes as $route) {
      $response = $this->get($route, [
        'X-Requested-With' => 'XMLHttpRequest',
      ]);

      $response->assertStatus(200);
      $response->assertHeaderMissing('Content-Type', 'application/json');
    }
  }

  #[Test]
  public function teacher_pages_do_not_contain_ajax_code_in_html()
  {
    $this->authenticateTeacher();

    foreach ($this->routes as $route) {
      $response = $this->get($route);

      $content = $response->getContent();

      $this->assertStringNotContainsString('fetch(', $content);
      $this->assertStringNotContainsString('XMLHttpRequest', $content);
      $this->assertStringNotContainsString('axios', $content);
      $this->assertStringNotContainsString('$.ajax', $content);
    }
  }
}
