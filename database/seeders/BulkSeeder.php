<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Infrastructure\Shared\Model\User;
use App\Infrastructure\Student\Model\Alumno;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BulkSeeder extends Seeder
{
  public function run()
  {
    $path = database_path('data/bulk.txt');

    if (!file_exists($path)) {
      $this->command->error('bulk.txt not found');
      return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    DB::transaction(function () use ($lines) {
      foreach ($lines as $line) {
        $name = trim($line);

        if ($name === '') {
          continue;
        }

        // 1️⃣ Create user
        $user = User::firstOrCreate(
          ['email' => $this->emailFromName($name)],
          [
            'name' => $name,
            'password' => bcrypt('password'),
            'role' => 'student', // must match users_role_check
          ]
        );

        // 2️⃣ Create alumno
        Alumno::firstOrCreate([
          'user_id' => $user->id,
        ]);
      }
    });
  }

  private function emailFromName(string $name): string
  {
    $slug = Str::slug($name, '.');
    return $slug . '@unsa.edu.pe';
  }
}


