@use(App\Enums\DiaSemana)
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

        $dias = [DiaSemana::Lunes, DiaSemana::Martes , DiaSemana::Miercoles, DiaSemana::Jueves, DiaSemana::Viernes];
        $horas = [
            '07:00 - 08:40',
            '08:50 - 10:30',
            '10:40 - 12:20',
            '12:20 - 14:00',
            '15:50 - 17:30',
        ];

        $horario = [];
        foreach ($horas as $hora) {
            foreach ($dias as $dia) {
                $horario[$hora][$dia->value] = '';
            }
        }

        foreach ($alumno->grupos as $grupo) {
            foreach ($grupo->bloqueHorario as $bloque) {
                foreach ($horas as $rango) {
                    if (Str::startsWith($rango, substr($bloque->horaInicio, 0, 5))) {
                        $horario[$rango][$bloque->dia->value] = "{$grupo->curso->nombre} ({$grupo->tipo})";
                    }
                }
            }
        }
        @endphp

        <table class="schedule-table">
          <thead>
          <tr>
            <th>HORA</th>
            @foreach($dias as $dia)
              <th>{{ strtoupper($dia->value) }}</th>
            @endforeach
          </tr>
          </thead>
          <tbody>
          @foreach($horas as $hora)
            <tr>
              <td class="time-slot">{{ $hora }}</td>
              @foreach($dias as $dia)
                <td class="course-cell">
                  {{ $horario[$hora][$dia->value] ?? '' }}
                </td>
              @endforeach
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>

      <div class="widget">
        <h3>Métricas Clave</h3>
        <div class="progress-circles">
          <div class="progress-item">
            <div class="circle-placeholder c-90">90%</div>
            <div>
              <strong>Asistencia General</strong>
              <p class="description">Porcentaje acumulado.</p>
            </div>
          </div>
          <div class="progress-item">
            <div class="circle-placeholder c-3-8">3.8</div>
            <div>
              <strong>GPA Ponderado</strong>
              <p class="description">Promedio general del semestre.</p>
            </div>
          </div>
          <div class="progress-item">
            <div class="circle-placeholder c-75">75%</div>
            <div>
              <strong>Cursos Aprobados</strong>
              <p class="description">Créditos completados del total.</p>
            </div>
          </div>
        </div>
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
        <p class="chat-text new-alert">Cambio de Aula: El curso de Redes ahora es en el Aula F-201. (Ver Notificación)</p>
        <p class="chat-text">Recordatorio: La encuesta de satisfacción docente cierra este viernes.</p>
      </div>
    </section>
  </div>
</x-sidebar_layout>
