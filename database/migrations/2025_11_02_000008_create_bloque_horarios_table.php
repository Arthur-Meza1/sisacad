<?php

use App\Infrastructure\Shared\Model\Aula;
use App\Infrastructure\Shared\Model\GrupoCurso;
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
        Schema::create('bloque_horarios', function (Blueprint $table) {
            $table->id();
            $table->time('horaInicio');
            $table->time('horaFin');
            $table->enum('dia', ['lunes', 'martes', 'miercoles', 'jueves', 'viernes']);
            $table->foreignIdFor(GrupoCurso::class)->constrained();
            $table->foreignIdFor(Aula::class)->constrained();
            $table->index(['dia', 'horaInicio', 'horaFin']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bloque_horarios');
    }
};
