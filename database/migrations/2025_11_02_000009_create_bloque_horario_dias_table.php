<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Aula;
use App\Models\BloqueHorario;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bloque_horario_dias', function (Blueprint $table) {
            $table->id();
            $table->time('horaInicio');
            $table->time('horaFin');
            $table->string('dia');
            $table->foreignIdFor(BloqueHorario::class)->constrained();
            $table->foreignIdFor(Aula::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bloque_horario_dias');
    }
};
