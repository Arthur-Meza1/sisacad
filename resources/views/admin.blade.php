<x-sidebar_layout>
    <x-slot:title>
        Dashboard Administrador
    </x-slot:title>
    <x-slot:nav_options>
        <a href="#" class="active"><i class="fas fa-home"></i> Inicio</a>
        <a href="#"><i class="fas fa-users-cog"></i>Gestión de Usuarios</a>
        <a href="#"><i class="fas fa-university"></i> Gestión Académica</a>
        <a href="#"><i class="fas fa-money-bill-wave"></i> Administrativo/Finanzas</a>
        <a href="#"><i class="fas fa-chart-line"></i> Reportes y Analíticas</a>
        <a href="#"><i class="fas fa-bell"></i>Notificaciones Globales</a>
        <a href="#"><i class="fas fa-cogs"></i> Configuración del Sistema</a>
    </x-slot:nav_options>

    <div class="main-content">
        <header class="header-top">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar usuarios, cursos, o reportes...">
            </div>
            <div class="menu-icon">
                <i class="fas fa-bars"></i>
            </div>
        </header>

        <section class="widgets-grid">
            <div class="widget action-summary-widget">
                <h3>Estado y Acciones</h3>
                <div class="system-status">
                    <p><strong>Periodo Actual:</strong> <span class="status-badge status-active">2025-II</span></p>
                    <p><strong>Estado del Sistema:</strong> <span
                            class="status-badge status-system-ok">Activo (100%)</span></p>
                    <p><strong>Último Backup:</strong> Hace 12 horas</p>
                </div>
                <div class="quick-actions">
                    <button class="action-button primary-btn"><i class="fas fa-user-plus"></i> Crear Nuevo Usuario
                    </button>
                    <button class="action-button secondary-btn admin-orange"><i class="fas fa-lock-open"></i> Abrir
                        Periodo 2026-I
                    </button>
                    <button class="action-button default-btn"><i class="fas fa-database"></i> Ejecutar Backup</button>
                </div>
            </div>

            <div class="widget metrics-summary-grid schedule-widget">
                <h3>Métricas del Sistema</h3>
                <div class="summary-cards-container">
                    <div class="summary-card student-card">
                        <i class="fas fa-user-graduate card-icon"></i>
                        <span class="card-value">210</span>
                        <span class="card-label">Estudiantes (Total)</span>
                    </div>
                    <div class="summary-card teacher-card">
                        <i class="fas fa-chalkboard-teacher card-icon"></i>
                        <span class="card-value">35</span>
                        <span class="card-label">Docentes</span>
                    </div>
                    <div class="summary-card course-card">
                        <i class="fas fa-book card-icon"></i>
                        <span class="card-value">50</span>
                        <span class="card-label">Cursos Activos</span>
                    </div>
                    <div class="summary-card alert-card">
                        <i class="fas fa-exclamation-circle card-icon"></i>
                        <span class="card-value new-alert-value">7</span>
                        <span class="card-label">Alertas Críticas</span>
                    </div>
                </div>
            </div>

            <div class="widget">
                <h3>Usuarios por Rol</h3>
                <div class="progress-circles">
                    <div class="progress-item">
                        <div class="circle-placeholder c-user-alum">85%</div>
                        <div>
                            <strong>Alumnos</strong>
                            <p class="description">Usuarios principales del sistema.</p>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="circle-placeholder c-user-doc">14%</div>
                        <div>
                            <strong>Docentes</strong>
                            <p class="description">Cuentas con privilegios de notas.</p>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="circle-placeholder c-user-sec">1%</div>
                        <div>
                            <strong>Admin/Secretaría</strong>
                            <p class="description">Cuentas con privilegios de gestión.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget schedule-widget">
                <h3>Alumnos por Carrera</h3>
                <div class="chart-placeholder placeholder-line" style="height: 150px;">
                    Gráfico de Barras: Estudiantes por Programa Académico
                </div>
            </div>

            <div class="widget chat-widget">
                <h3>Actividad del Sistema (Logs)</h3>
                <p class="chat-text new-alert">Error DB: La conexión con el servidor de pagos falló hace 3 minutos.
                    (Prioridad Alta)</p>
                <p class="chat-text">Admin: Usuario 'jdiaz' reseteó la contraseña a 'alumno045'.</p>
                <p class="chat-text">Sistema: Se realizó el cierre parcial del curso 'MAT101'.</p>
            </div>
        </section>
    </div>
</x-sidebar_layout>
