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
        Schema::create('sesions', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignIdFor(GrupoCurso::class)->constrained();
            $table->foreignIdFor(Aula::class)->constrained();
            $table->date('fecha');
            $table->time('horaInicio');
            $table->time('horaFin');
            $table->boolean('from_bloque')->default(false);
            $table->index(['horaInicio', 'horaFin', 'fecha', 'from_bloque']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesions');
    }
};
