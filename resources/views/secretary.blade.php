<x-sidebar_layout>
    <x-slot:title>
        Dashboard Docente
    </x-slot:title>
    <x-slot:nav_options>
        <a href="#" class="active"><i class="fas fa-home"></i> Inicio</a>
        <a href="#"><i class="fas fa-user-graduate"></i> Gestión Estudiantes</a>
        <a href="#"><i class="fas fa-book-reader"></i>Gestión Matrículas</a>
        <a href="#"><i class="fas fa-chalkboard-teacher"></i> Gestión Docentes</a>
        <a href="#"><i class="fas fa-calendar-alt"></i> Horarios</a>
        <a href="#"><i class="fas fa-file-invoice"></i>Reportes y Docs</a>
        <a href="#"><i class="fas fa-bullhorn"></i> Notificaciones</a>
        <a href="#"><i class="fas fa-cog"></i> Configuración</a>
    </x-slot:nav_options>

    <div class="main-content">
        <header class="header-top">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar alumnos, docentes, o cursos...">
            </div>
            <div class="menu-icon">
                <i class="fas fa-bars"></i>
            </div>
        </header>

        <section class="widgets-grid">

            <div class="widget calendar-widget">
                <h3>Resumen Administrativo</h3>
                <div class="calendar-note" style="text-align: left; margin-top: 5px;">
                    <p style="font-size: 1.1em; color: var(--color-primary); font-weight: bold;">
                        <i class="fas fa-calendar-check"></i> Periodo Activo: 2025-II
                    </p>
                    <p>Inicio de clases: 02 Sep. | Cierre de notas: 15 Dic.</p>
                </div>
                <button class="action-button primary-btn" style="width: 100%; margin-top: 15px;">
                    <i class="fas fa-user-plus"></i> Registrar Nuevo Estudiante
                </button>
            </div>

            <div class="widget metrics-summary-grid schedule-widget">
                <h3>Métricas del Semestre</h3>
                <div class="summary-cards-container">
                    <div class="summary-card student-card">
                        <i class="fas fa-user-graduate card-icon"></i>
                        <span class="card-value">210</span>
                        <span class="card-label">Estudiantes</span>
                    </div>
                    <div class="summary-card course-card">
                        <i class="fas fa-book card-icon"></i>
                        <span class="card-value">35</span>
                        <span class="card-label">Cursos Activos</span>
                    </div>
                    <div class="summary-card teacher-card">
                        <i class="fas fa-chalkboard-teacher card-icon"></i>
                        <span class="card-value">18</span>
                        <span class="card-label">Docentes</span>
                    </div>
                    <div class="summary-card class-card">
                        <i class="fas fa-clock card-icon"></i>
                        <span class="card-value new-alert-value">4</span>
                        <span class="card-label">Clases Programadas Hoy</span>
                    </div>
                </div>
            </div>

            <div class="widget">
                <h3>Matrículas Pendientes</h3>
                <div class="progress-circles">
                    <div class="progress-item">
                        <div class="circle-placeholder c-70">70%</div>
                        <div>
                            <strong>Matriculados vs. Total</strong>
                            <p class="description">Matrículas completadas.</p>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="circle-placeholder c-40">40</div>
                        <div>
                            <strong>Cambios Solicitados</strong>
                            <p class="description">Pendientes de aprobación (retiros/grupos).</p>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="circle-placeholder c-12">12</div>
                        <div>
                            <strong>Nuevos Ingresos</strong>
                            <p class="description">Fichas de registro por validar.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget">
                <h3>Reportes y Documentación</h3>
                <div class="events-list">
                    <p><i class="fas fa-download"></i> <a href="#">Actas de Evaluación (Pendientes)</a></p>
                    <p><i class="fas fa-download"></i> <a href="#">Lista de Matrícula General</a></p>
                    <p><i class="fas fa-download"></i> <a href="#">Reporte de Asistencia Semanal</a></p>
                </div>
            </div>

            <div class="widget chat-widget">
                <h3>Comunicados y Alertas</h3>
                <p class="chat-text new-alert">¡Alerta! Conflicto de horario detectado en el curso Álgebra I (Aula F-201).</p>
                <p class="chat-text">Recordatorio a Docentes: La fecha límite para subir notas parciales es el viernes.</p>
            </div>

        </section>
    </div>
</x-sidebar_layout>
