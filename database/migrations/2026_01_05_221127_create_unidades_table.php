<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('unidades', function (Blueprint $table) {
      $table->id();

      $table->foreignId('curso_id')
        ->constrained('cursos')
        ->cascadeOnDelete();

      $table->string('nombre');       // PRIMERA UNIDAD
      $table->unsignedInteger('orden'); // 1, 2, 3

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('unidades');
  }
};
