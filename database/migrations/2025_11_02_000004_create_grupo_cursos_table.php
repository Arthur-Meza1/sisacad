<?php

use App\Infrastructure\Shared\Model\Curso;
use App\Infrastructure\Teacher\Model\Docente;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grupo_cursos', function (Blueprint $table) {
            $table->id();
            $table->enum('turno', ['A', 'B', 'C', 'D']);
            $table->foreignIdFor(Docente::class)->constrained();
            $table->foreignIdFor(Curso::class)->constrained();
            $table->enum('tipo', ['teoria', 'laboratorio']);
            $table->index(['curso_id', 'tipo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_cursos');
    }
};
