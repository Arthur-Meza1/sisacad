<?php

namespace App\Infrastructure\Shared\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tema extends Model
{
  use HasFactory;

  protected $table = 'temas';

  protected $fillable = [
    'capitulo_id',
    'titulo',
    'orden'
  ];

  public function capitulo()
  {
    return $this->belongsTo(Capitulo::class);
  }

  /**
   * Grupos donde este tema ha sido enseñado
   */
  public function gruposEnseñado()
  {
    return $this->belongsToMany(GrupoCurso::class, 'grupo_tema', 'tema_id', 'grupo_id')
      ->withPivot('enseñado', 'fecha_enseñado', 'notas')
      ->wherePivot('enseñado', true);
  }

  public function gruposConEstado()
  {
    return $this->belongsToMany(GrupoCurso::class, 'grupo_tema', 'tema_id', 'grupo_id')
      ->withPivot('enseñado', 'fecha_enseñado', 'notas');
  }

  /**
   * Helper: Verificar si está enseñado en un grupo específico
   */
  public function estaEnseñadoEnGrupo($grupoId)
  {
    return $this->gruposConEstado()
      ->where('grupo_curso_id', $grupoId)
      ->wherePivot('enseñado', true)
      ->exists();
  }

  /**
   * Helper: Obtener estado completo en un grupo
   */
  public function estadoEnGrupo($grupoId)
  {
    return $this->gruposConEstado()
      ->where('grupo_curso_id', $grupoId)
      ->first();
  }
}
