<?php

namespace App\Services;

use App\Models\Docente;
use App\Models\Sesion;

class DocenteService {
  private $horarioService;

  public function __construct() {
    $this->horarioService = new HorarioService();
  }

  public function getGroupDataFromId($id) {
    $docente = Docente::where('user_id', $id)->firstOrFail();

    return $docente->grupos()
                   ->with('registros', 'curso')
                   ->withCount('registros')
                   ->get()
                   ->map(function ($grupo) {
                      $nregistros = $grupo->registros_count;
                      $promedio_parcial = $grupo->registros
                        ->flatMap(fn ($registro) => $registro->getNotasParcial())
                        ->filter()
                        ->avg();
                      $promedio_continua = $grupo->registros
                        ->flatMap(fn ($registro) => $registro->getNotasContinua())
                        ->filter()
                        ->avg();
                      return [
                        "curso" => [
                          "id" => $grupo->id,
                          "nombre" => $grupo->curso->nombre,
                          "tipo" => $grupo->tipo
                        ],
                        "registros" => [
                          "cantidad" => $nregistros,
                          "notas" => $grupo->registros->map(
                            fn ($registro) =>
                            [$registro->parcial1, $registro->parcial2, $registro->parcial3,
                              $registro->continua1, $registro->continua2, $registro->continua3,
                              $registro->sustitutorio]),
                          "promedio_parcial" => round($promedio_parcial),
                          "promedio_continua" => round($promedio_continua),
                        ]
                      ];
                    });
  }

  public function getHorarioFromId($id) {
    return $this->horarioService->get(Docente::class, $id, true);
  }
}
