<x-sidebar_layout>
  <x-slot:title>
    Dashboard Estudiante
  </x-slot:title>
  <x-slot:nav_options>
    <a href="#" class="active"><i class="fas fa-home"></i>Inicio</a>
    <a href="#"><i class="fas fa-book-open"></i>Mis Cursos</a>
    <a href="#"><i class="fas fa-poll"></i> Notas y Rendimiento</a>
    <a href="#"><i class="fas fa-user-check"></i>Asistencia</a>
    <a href="#"><i class="fas fa-bell"></i> Notificaciones</a>
    <a href="#"><i class="fas fa-calendar-alt"></i>Calendario Académico</a>
    <a href="#"><i class="fas fa-cog"></i>Configuración</a>
    <a href="#"><i class="fas fa-question-circle"></i>Ayuda</a>
  </x-slot:nav_options>

  <div class="main-content">
    <header class="header-top">
      <div class="search-bar">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Buscar cursos, notas o información...">
      </div>
      <div class="menu-icon">
        <i class="fas fa-bars"></i>
      </div>
    </header>

    <section class="widgets-grid">
      <div class="widget schedule-widget">
        <h3>Horario Semanal</h3>
        <p class="schedule-note">{{ $alumno->user->name }}</p>

        @php
          $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];
          foreach ($alumno->grupos as $grupo) {
              foreach ($grupo->bloqueHorario as $bloque) {
                $horario["$bloque->horaInicio-$bloque->horaFin"][$bloque->dia] = "{$grupo->curso->nombre} ($grupo->tipo)";
              }
          }
          ksort($horario)
        @endphp

        <table class="schedule-table">
          <thead>
          <tr>
            <th>HORA</th>
            @foreach($dias as $dia)
              <th>{{ strtoupper($dia) }}</th>
            @endforeach
          </tr>
          </thead>
          <tbody>
          @foreach($horario as $hora => $cursos)
            <tr>
              <td class="time-slot">{{ $hora }}</td>
              @foreach($dias as $dia)
                <td class="course-cell">
                  {{ $cursos[$dia] ?? '' }}
                </td>
              @endforeach
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>

      <div class="widget">
        <h3>Registros Académicos</h3>

        @forelse($alumno->registros as $registro)
          <div class="registro-item">
            <p><strong>{{ $registro->grupoCurso->curso->nombre }}</strong></p>
            <ul>
              <li>Parcial 1: {{ $registro->parcial1 ?? '—' }}</li>
              <li>Parcial 2: {{ $registro->parcial2 ?? '—' }}</li>
              <li>Parcial 3: {{ $registro->parcial3 ?? '—' }}</li>
              <li>Continua 1: {{ $registro->continua1 ?? '—' }}</li>
              <li>Continua 2: {{ $registro->continua2 ?? '—' }}</li>
              <li>Continua 3: {{ $registro->continua3 ?? '—' }}</li>
              <li>Sustitutorio: {{ $registro->sustitutorio ?? '—' }}</li>
            </ul>
          </div>
        @empty
          <p>No hay registros disponibles.</p>
        @endforelse
      </div>

      <div class="widget">
        <h3>Próximos Eventos</h3>
        <div class="events-list">
          <p><strong>05 Nov:</strong> Examen Final - Cálculo I</p>
          <p><strong>12 Nov:</strong> Fecha Límite - Pago Pensión</p>
          <p><strong>20 Nov:</strong> Entrega Proyecto - Sistemas</p>
        </div>
      </div>

      <div class="widget chat-widget">
        <h3>Últimos Comunicados</h3>
        <p class="chat-text new-alert">Cambio de Aula: El curso de Redes ahora es en el Aula F-201. (Ver
          Notificación)</p>
        <p class="chat-text">Recordatorio: La encuesta de satisfacción docente cierra este viernes.</p>
      </div>
    </section>
  </div>
</x-sidebar_layout>
