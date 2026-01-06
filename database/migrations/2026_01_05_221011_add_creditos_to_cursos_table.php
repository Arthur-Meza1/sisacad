<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new  class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void
  {
    Schema::table('cursos', function (Blueprint $table) {
      $table->unsignedTinyInteger('creditos')->nullable()->after('nombre');
    });
  }

  public function down(): void
  {
    Schema::table('cursos', function (Blueprint $table) {
      $table->dropColumn('creditos');
    });
  }

};
