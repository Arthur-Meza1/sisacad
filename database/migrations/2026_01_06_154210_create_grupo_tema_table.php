<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('grupo_tema', function (Blueprint $table) {
      $table->id();
      $table->foreignId('grupo_id')
        ->constrained('grupo_cursos')
        ->onDelete('cascade');
      $table->foreignId('tema_id')
        ->constrained('temas')
        ->onDelete('cascade');
      $table->boolean('enseñado')->default(false);
      $table->date('fecha_enseñado')->nullable();
      $table->text('notas')->nullable();
      $table->timestamps();

      $table->unique(['grupo_id', 'tema_id']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('grupo_tema');
  }
};
