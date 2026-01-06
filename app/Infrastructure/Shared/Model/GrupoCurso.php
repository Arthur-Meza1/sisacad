<?php

namespace App\Infrastructure\Shared\Model;

use App\Infrastructure\Student\Model\Alumno;
use App\Infrastructure\Teacher\Model\Docente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GrupoCurso extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $fillable = ['turno', 'tipo'];

  public function docente()
  {
    return $this->belongsTo(Docente::class);
  }

  public function curso()
  {
    return $this->belongsTo(Curso::class);
  }

  public function matriculas()
  {
    return $this->hasMany(Matricula::class);
  }

  public function alumnos()
  {
    return $this->belongsToMany(Alumno::class, 'matriculas');
  }

  public function bloqueHorario()
  {
    return $this->hasMany(BloqueHorario::class);
  }

  public function registros()
  {
    return $this->hasMany(Registro::class);
  }

  /**
   * Temas marcados como enseñados en ESTE grupo
   */
  public function temasEnseñados()
  {
    return $this->belongsToMany(Tema::class, 'grupo_tema','grupo_id','tema_id', )
      ->withPivot('enseñado', 'fecha_enseñado', 'notas')
      ->wherePivot('enseñado', true);
  }

  public function temasConEstado()
  {
    return $this->belongsToMany(Tema::class, 'grupo_tema','grupo_id','tema_id', )
      ->withPivot('enseñado', 'fecha_enseñado', 'notas');
  }

  /**
   * Marcar un tema como enseñado en este grupo
   */
  public function marcarTemaEnseñado($temaId, $notas = null)
  {
    return DB::table('grupo_tema')->updateOrInsert(
      [
        'grupo_id' => $this->id,
        'tema_id' => $temaId
      ],
      [
        'enseñado' => true,
        'fecha_enseñado' => now(),
        'notas' => $notas,
        'updated_at' => now(),
        'created_at' => DB::raw('COALESCE(created_at, NOW())')
      ]
    );
  }

  /**
   * Desmarcar un tema como enseñado en este grupo
   */
  public function desmarcarTemaEnseñado($temaId)
  {
    return DB::table('grupo_tema')
      ->where('grupo_id', $this->id)
      ->where('tema_id', $temaId)
      ->update([
        'enseñado' => false,
        'fecha_enseñado' => null,
        'notas' => null,
        'updated_at' => now()
      ]);
  }

  /**
   * Obtener progreso del grupo (porcentaje de temas enseñados)
   */
  public function getProgresoAttribute()
  {
    $totalTemas = $this->curso->capitulos->sum(function($capitulo) {
      return $capitulo->temas->count();
    });
    if ($totalTemas === 0) return 0;

    $temasEnseñados = DB::table('grupo_tema')
      ->where('grupo_id', $this->id)
      ->where('enseñado', true)
      ->count();

    return round(($temasEnseñados / $totalTemas) * 100, 2);
  }

  /**
   * Obtener el próximo tema a enseñar (primer tema no enseñado)
   */
  public function getProximoTemaAttribute()
  {
    // Obtener todos los temas del curso ordenados
    $temas = DB::table('temas')
      ->join('capitulos', 'temas.capitulo_id', '=', 'capitulos.id')
      ->where('capitulos.curso_id', $this->curso->id)
      ->select('temas.*', 'capitulos.unidad_id')
      ->orderBy('capitulos.unidad_id')
      ->orderBy('temas.orden')
      ->get();

    foreach ($temas as $tema) {
      // Verificar si este tema ya fue enseñado en este grupo
      $enseñado = DB::table('grupo_tema')
        ->where('grupo_id', $this->id)
        ->where('tema_id', $tema->id)
        ->where('enseñado', true)
        ->exists();

      if (!$enseñado) {
        // Convertir stdClass a modelo Tema
        return \App\Infrastructure\Shared\Model\Tema::find($tema->id);
      }
    }

    return null; // Todos los temas enseñados
  }

  /**
   * Helper: Verificar si un tema está enseñado en este grupo
   */
  public function temaEstaEnseñado($temaId)
  {
    return DB::table('grupo_tema')
      ->where('grupo_id', $this->id)
      ->where('tema_id', $temaId)
      ->where('enseñado', true)
      ->exists();
  }

  /**
   * Helper: Obtener fecha en que se enseñó un tema
   */
  public function fechaTemaEnseñado($temaId)
  {
    $registro = DB::table('grupo_tema')
      ->where('grupo_id', $this->id)
      ->where('tema_id', $temaId)
      ->where('enseñado', true)
      ->first();

    return $registro ? $registro->fecha_enseñado : null;
  }
}
