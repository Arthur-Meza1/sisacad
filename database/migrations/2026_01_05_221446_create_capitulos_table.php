<?php

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
      Schema::create('capitulos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('unidad_id')
          ->constrained('unidades')
          ->cascadeOnDelete();

        $table->string('nombre');
        $table->unsignedInteger('orden');
        $table->timestamps();
      });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capitulos');
    }
};
