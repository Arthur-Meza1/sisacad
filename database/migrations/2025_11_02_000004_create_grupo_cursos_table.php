<?php

use App\Models\Curso;
use App\Models\Docente;
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
            $table->string('turno');
            $table->foreignIdFor(Docente::class)->constrained();
            $table->foreignIdFor(Curso::class)->constrained();
            $table->string('tipo');
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
