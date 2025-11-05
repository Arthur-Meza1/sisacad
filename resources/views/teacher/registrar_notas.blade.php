<x-sidebar_layout>
  <x-slot:title>
    Registrar Notas
  </x-slot:title>

  <x-slot:nav_options>
    <a href="#"><i class="fas fa-home"></i>Inicio</a>
    <a href="#"><i class="fas fa-book-open"></i>Mis Cursos</a>
    <a href="#" class="active"><i class="fas fa-poll-h"></i>Gestión de Notas</a>
    <a href="#"><i class="fas fa-user-check"></i>Asistencia</a>
    <a href="#"><i class="fas fa-paperclip"></i>Materiales</a>
    <a href="#"><i class="fas fa-comments"></i>Comunicaciones</a>
    <a href="#"><i class="fas fa-calendar-alt"></i>Calendario</a>
    <a href="#"><i class="fas fa-cog"></i>Configuración</a>
  </x-slot:nav_options>

  <div class="main-content">
    <header class="header-top">
      <h2>Registro de Notas - {{ $docente->user->name }}</h2>
      <div class="menu-icon">
        <i class="fas fa-bars"></i>
      </div>
    </header>

    <section class="content-section">
      <div class="widget">
        <h3>Seleccionar Curso</h3>
        <form method="GET" action="{{ route('docente.registrar_notas') }}">
          <select name="grupo_id" class="input-select" onchange="this.form.submit()">
            <option value="">-- Selecciona un curso --</option>
            @foreach($docente->grupos as $grupo)
              <option value="{{ $grupo->id }}" {{ request('grupo_id') == $grupo->id ? 'selected' : '' }}>
                {{ $grupo->curso->nombre }} ({{ $grupo->tipo }})
              </option>
            @endforeach
          </select>
        </form>
      </div>

      @if(isset($grupoSeleccionado))
        <div class="widget">
          <h3>Notas de {{ $grupoSeleccionado->curso->nombre }} ({{ $grupoSeleccionado->tipo }})</h3>

          <form method="POST" action="{{ route('docente.guardar_notas', $grupoSeleccionado->id) }}">
            @csrf

            <table class="data-table">
              <thead>
              <tr>
                <th>Alumno</th>
                <th>Continua 1</th>
                <th>Parcial 1</th>
                <th>Continua 2</th>
                <th>Parcial 2</th>
                <th>Continua 3</th>
                <th>Parcial 3</th>
                <th>Sustitutorio</th>
              </tr>
              </thead>
              <tbody>
              @foreach($grupoSeleccionado->matriculas as $matricula)
                @php
                  $registro = $matricula->alumno->registros
                      ->firstWhere('grupo_curso_id', $grupoSeleccionado->id);
                @endphp
                <tr>
                  <td>{{ $matricula->alumno->user->name }}</td>
                  <td><input type="number" step="0.1" name="registros[{{ $matricula->id }}][continua1]" value="{{ $registro->continua1 ?? '' }}"></td>
                  <td><input type="number" step="0.1" name="registros[{{ $matricula->id }}][parcial1]" value="{{ $registro->parcial1 ?? '' }}"></td>
                  <td><input type="number" step="0.1" name="registros[{{ $matricula->id }}][continua2]" value="{{ $registro->continua2 ?? '' }}"></td>
                  <td><input type="number" step="0.1" name="registros[{{ $matricula->id }}][parcial2]" value="{{ $registro->parcial2 ?? '' }}"></td>
                  <td><input type="number" step="0.1" name="registros[{{ $matricula->id }}][continua3]" value="{{ $registro->continua3 ?? '' }}"></td>
                  <td><input type="number" step="0.1" name="registros[{{ $matricula->id }}][parcial3]" value="{{ $registro->parcial3 ?? '' }}"></td>
                  <td><input type="number" step="0.1" name="registros[{{ $matricula->id }}][sustitutorio]" value="{{ $registro->sustitutorio ?? '' }}"></td>
                </tr>
              @endforeach
              </tbody>
            </table>

            <div class="form-actions">
              <button type="submit" class="primary-btn">
                <i class="fas fa-save"></i> Guardar Notas
              </button>
            </div>
          </form>
        </div>
      @endif
    </section>
  </div>
</x-sidebar_layout>
