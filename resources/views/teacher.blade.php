<x-sidebar_layout>
    <x-slot:title>
        Dashboard Docente
    </x-slot:title>
    <x-slot:nav_options>
        <a href="#" class="active"><i class="fas fa-home"></i>Inicio</a>
        <a href="#"><i class="fas fa-book-open"></i>Mis Cursos</a>
        <a href="#"><i class="fas fa-poll-h"></i> Gestión de Notas</a>
        <a href="#"><i class="fas fa-user-check"></i>Asistencia</a>
        <a href="#"><i class="fas fa-paperclip"></i>Materiales y Tareas</a>
        <a href="#"><i class="fas fa-comments"></i> Comunicaciones</a>
        <a href="#"><i class="fas fa-calendar-alt"></i>Calendario</a>
        <a href="#"><i class="fas fa-cog"></i>Configuración</a>
    </x-slot:nav_options>

  <ul>
    @foreach(auth()->user()->docente->grupos as $grupo)
      <li>Estás en el curso {{$grupo->curso->nombre}} en el turno {{$grupo->turno}} y el curso es del tipo {{$grupo->tipo}} Y tiene los dias:</li>
      @foreach($grupo->bloqueHorario as $horario)
        <li>Dia: {{$horario->dia}} Inicio: {{$horario->horaInicio}}</li>
      @endforeach
    @endforeach
  </ul>

  <ul>
    @foreach(auth()->user()->docente->grupos as $grupo)
      <li>
        @foreach($grupo->alumnos as $alumno)
          Alumno → {{$alumno->user->name}}
        @endforeach
      </li>
    @endforeach
  </ul>

    <div class="main-content">
        <header class="header-top">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar alumnos, notas o material...">
            </div>
            <div class="menu-icon">
                <i class="fas fa-bars"></i>
            </div>
        </header>

        <section class="widgets-grid">

            <div class="widget action-summary-widget">
                <h3>Actividad Rápida</h3>
                <div class="calendar-note" style="text-align: left; margin-top: 5px;">
                    <p style="font-size: 1.1em; color: var(--color-primary); font-weight: bold;">
                        <i class="fas fa-calendar-check"></i> Periodo Activo: 2025-II
                    </p>
                    <p>Docente titular en 5 cursos.</p>
                </div>
                <div class="quick-actions">
                    <button class="action-button primary-btn"><i class="fas fa-user-check"></i> Tomar Asistencia
                    </button>
                    <button class="action-button secondary-btn"><i class="fas fa-poll-h"></i> Registrar Notas</button>
                    <button class="action-button default-btn"><i class="fas fa-upload"></i> Subir Material</button>
                </div>
            </div>

            <div class="widget metrics-summary-grid schedule-widget">
                <h3>Resumen Semestral</h3>
                <div class="summary-cards-container">
                    <div class="summary-card course-card">
                        <i class="fas fa-book-open card-icon"></i>
                        <span class="card-value">5</span>
                        <span class="card-label">Cursos Asignados</span>
                    </div>
                    <div class="summary-card student-card">
                        <i class="fas fa-user-graduate card-icon"></i>
                        <span class="card-value">120</span>
                        <span class="card-label">Estudiantes Totales</span>
                    </div>
                    <div class="summary-card pending-card alert-card">
                        <i class="fas fa-exclamation-triangle card-icon"></i>
                        <span class="card-value new-alert-value">3</span>
                        <span class="card-label">Evaluaciones Pendientes</span>
                    </div>
                    <div class="summary-card meeting-card">
                        <i class="fas fa-users card-icon"></i>
                        <span class="card-value">2</span>
                        <span class="card-label">Reuniones esta semana</span>
                    </div>
                </div>
            </div>

            <div class="widget">
                <h3>Progreso de Tareas</h3>
                <div class="progress-circles">
                    <div class="progress-item">
                        <div class="circle-placeholder c-85">85%</div>
                        <div>
                            <strong>Entregas a tiempo</strong>
                            <p class="description">Porcentaje de tareas completadas.</p>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="circle-placeholder c-2">2</div>
                        <div>
                            <strong>Notas por Registrar</strong>
                            <p class="description">Cursos pendientes de promediar.</p>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="circle-placeholder c-15">15</div>
                        <div>
                            <strong>Tareas sin Calificar</strong>
                            <p class="description">Pendientes de revisión y calificación.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget">
                <h3>Mis Clases de Hoy</h3>
                <div class="events-list">
                    <p><strong>8:00 - 10:00:</strong> Cálculo I (MAT101) - Aula 302</p>
                    <p><strong>10:00 - 12:00:</strong> Algoritmos (INF201) - Lab 2</p>
                    <p><strong>14:00 - 16:00:</strong> Reunión de Departamento - Virtual</p>
                </div>
            </div>

            <div class="widget chat-widget">
                <h3>Comunicaciones</h3>
                <p class="chat-text new-alert">Notificación de Secretaría: El curso INF201 (Algoritmos) cambia de Lab 2
                    a Lab 5 mañana.</p>
                <p class="chat-text">Mensaje de alumno: Solicitud de revisión de nota de examen parcial.</p>
            </div>

        </section>
    </div>
</x-sidebar_layout>
