<x-sidebar_layout>
    <x-slot:title>
        Dashboard Estudiante
    </x-slot:title>
    <x-slot:nav_options>
        <a href="#" class="active"><i class="fas fa-home"></i> Inicio</a> <a href="#"><i class="fas fa-book-open"></i>
            Mis Cursos</a> <a href="#"><i class="fas fa-poll"></i> Notas y Rendimiento</a> <a href="#"><i
                class="fas fa-user-check"></i> Asistencia</a> <a href="#"><i class="fas fa-bell"></i> Notificaciones</a>
        <a href="#"><i class="fas fa-calendar-alt"></i> Calendario Académico</a> <a href="#"><i class="fas fa-cog"></i>
            Configuración</a> <a href="#"><i class="fas fa-question-circle"></i> Ayuda</a>
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
            <div class="widget calendar-widget">
                <h3>Horario del Mes: Octubre</h3>
                <div class="calendar-visual">

                    <!-- Encabezado de días -->
                    <div class="day-header">Lun</div>
                    <div class="day-header">Mar</div>
                    <div class="day-header">Mié</div>
                    <div class="day-header">Jue</div>
                    <div class="day-header">Vie</div>
                    <div class="day-header">Sáb</div>
                    <div class="day-header">Dom</div>

                    <!-- Días previos del mes anterior (septiembre) -->
                    <div class="day-cell prev-month">29</div>
                    <div class="day-cell prev-month">30</div>

                    <!-- Días del mes de octubre -->
                    <div class="day-cell">1</div>
                    <div class="day-cell">2</div>
                    <div class="day-cell">3</div>
                    <div class="day-cell">4</div>
                    <div class="day-cell">5</div>

                    <div class="day-cell">6</div>
                    <div class="day-cell">7</div>
                    <div class="day-cell">8</div>
                    <div class="day-cell">9</div>
                    <div class="day-cell">10</div>
                    <div class="day-cell">11</div>
                    <div class="day-cell">12</div>

                    <div class="day-cell">13</div>
                    <div class="day-cell">14</div>
                    <div class="day-cell">15</div>
                    <div class="day-cell">16</div>
                    <div class="day-cell">17</div>
                    <div class="day-cell">18</div>
                    <div class="day-cell">19</div>

                    <div class="day-cell">20</div>
                    <div class="day-cell">21</div>
                    <div class="day-cell">22</div>
                    <div class="day-cell">23</div>
                    <div class="day-cell">24</div>
                    <div class="day-cell">25</div>
                    <div class="day-cell">26</div>

                    <div class="day-cell">27</div>
                    <div class="day-cell">28</div>
                    <div class="day-cell">29</div>
                    <div class="day-cell">30</div>
                    <div class="day-cell">31</div>


                    <div class="day-cell next-month">1</div>
                    <div class="day-cell next-month">2</div>
                </div>
            </div>

            <div class="widget schedule-widget">
                <h3>Horario Semanal - Tercer Año (Grupo A)</h3>
                <p class="schedule-note">Aula 203</p>
                <table class="schedule-table">
                    <thead>
                    <tr>
                        <th>HORA</th>
                        <th>LUNES</th>
                        <th>MARTES</th>
                        <th>MIÉRCOLES</th>
                        <th>JUEVES</th>
                        <th>VIERNES</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="time-slot">7:00 - 8:40</td>
                        <td class="course-cell theory">Mat. Aplicada a la Computación (A) T.</td>
                        <td class="course-cell lab">Análisis y Diseño de Algoritmos Lab02</td>
                        <td class="course-cell theory">Trabajo Interdisciplinar II T.</td>
                        <td></td>
                        <td class="course-cell theory">Análisis y Diseño de Algoritmos T.</td>
                    </tr>
                    <tr>
                        <td class="time-slot">8:50 - 10:30</td>
                        <td class="course-cell lab">Ingeniería de Software II Lab04</td>
                        <td class="course-cell practice">Mat. Aplicada a la Computación (A) P.</td>
                        <td></td>
                        <td></td>
                        <td class="course-cell lab">Mat. Aplicada a la Computación Lab02</td>
                    </tr>
                    <tr>
                        <td class="time-slot">10:40 - 12:20</td>
                        <td></td>
                        <td class="course-cell practice">Mat. Aplicada a la Computación (A) P.</td>
                        <td class="course-cell practice">Sistemas Operativos P. (A)</td>
                        <td class="course-cell practice">Trabajo Interdisciplinar II P.</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="time-slot">12:20 - 14:00</td>
                        <td class="course-cell theory">Sistemas Operativos Teoría (A)</td>
                        <td class="course-cell lab">Sistemas Operativos Lab01</td>
                        <td class="course-cell theory">Ingeniería de Software II T. A</td>
                        <td class="course-cell practice">Ingeniería de Software II P. A</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="time-slot">15:50 - 17:30</td>
                        <td class="course-cell theory">Análisis y Diseño de Algoritmos T.</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
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
                <p class="chat-text new-alert">Cambio de Aula: El curso de Redes ahora es en el Aula F-201. (Ver
                    Notificación)</p>
                <p class="chat-text">Recordatorio: La encuesta de satisfacción docente cierra este viernes.</p>
            </div>

        </section>
    </div>
</x-sidebar_layout>
