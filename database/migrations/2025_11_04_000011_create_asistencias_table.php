<?php

use App\Infrastructure\Shared\Model\Sesion;
use App\Infrastructure\Student\Model\Alumno;
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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sesion::class)->constrained();
            $table->foreignIdFor(Alumno::class)->constrained();
            $table->boolean('presente')->default(false);
            $table->timestamps();
            $table->index(['sesion_id', 'alumno_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
