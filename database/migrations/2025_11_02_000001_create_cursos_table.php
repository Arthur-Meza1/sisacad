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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedTinyInteger('creditos')->nullable();
            $table->unsignedTinyInteger('peso_p1')->nullable();
            $table->unsignedTinyInteger('peso_p2')->nullable();
            $table->unsignedTinyInteger('peso_p3')->nullable();
            $table->unsignedTinyInteger('peso_c1')->nullable();
            $table->unsignedTinyInteger('peso_c2')->nullable();
            $table->unsignedTinyInteger('peso_c3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
