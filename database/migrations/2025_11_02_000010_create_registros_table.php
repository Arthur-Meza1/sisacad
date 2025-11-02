<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Alumno;
use App\Models\GrupoCurso;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Alumno::class)->constrained();
            $table->foreignIdFor(GrupoCurso::class)->constrained();
            $table->unsignedTinyInteger('parcial1')->nullable();
            $table->unsignedTinyInteger('parcial2')->nullable();
            $table->unsignedTinyInteger('parcial3')->nullable();
            $table->unsignedTinyInteger('continua1')->nullable();
            $table->unsignedTinyInteger('continua2')->nullable();
            $table->unsignedTinyInteger('continua3')->nullable();
            $table->unsignedTinyInteger('sustitutorio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
