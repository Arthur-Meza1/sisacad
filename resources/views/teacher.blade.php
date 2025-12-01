<x-header_layout>
  <aside class="w-64 p-4 sticky top-20 h-full">
    <nav class="space-y-2 font-medium">
      <a href="#" data-view="dashboard" class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100 active-link">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
        Inicio
      </a>
      <a href="#" data-view="grades-input" class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100 inactive-link">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        Libreta y Asistencia
      </a>
      <a href="#" data-view="schedule" class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100 inactive-link">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        Horario
      </a>
      <nav class="space-y-2 font-medium">
        <a href="#" data-view="analytics" class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100 inactive-link">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0v-5a2 2 0 012-2h2a2 2 0 012 2v5m-6 0h.01"></path></svg>
          Análisis de Notas
        </a>
      </nav>
    </nav>
  </aside>

  <main class="flex-1 p-4">
    <div id="view-dashboard" class="view-content space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Resumen de Cursos</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card bg-white rounded-xl p-5 shadow-lg border-b-4 border-indigo-500">
          <p class="text-sm font-medium text-gray-500">Cursos a Cargo</p>
          <strong id="coursesTaught" class="text-3xl font-extrabold text-indigo-600">{{count($grupos)}}</strong>
          <p class="text-xs text-gray-400 mt-1">Clases y Laboratorios</p>
        </div>
        <div class="card bg-white rounded-xl p-5 shadow-lg border-b-4 border-cyan-500">
          <p class="text-sm font-medium text-gray-500">Total de Alumnos</p>
          <strong id="totalStudents" class="text-3xl font-extrabold text-cyan-600">-</strong>
          <p class="text-xs text-gray-400 mt-1">En todos los cursos</p>
        </div>
        <div class="card bg-white rounded-xl p-5 shadow-lg border-b-4 border-purple-500">
          <p class="text-sm font-medium text-gray-500">Próxima Evaluación</p>
          <strong id="nextEvaluation" class="text-3xl font-extrabold text-purple-600">Progr. II</strong>
          <p class="text-xs text-gray-400 mt-1">Viernes, 10 AM</p>
        </div>
      </div>
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-lg">
          <h3 class="font-bold text-lg text-gray-700 mb-3">Mis Cursos Asignados</h3>
          <div id="teacherCourseList" class="space-y-2 text-sm">
            @foreach($grupos as $grupo)
              <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                <span class="font-medium text-indigo-700">{{$grupo['nombre']}} ({{ucfirst($grupo['tipo'])}})</span>
                <span class="text-xs text-gray-500">Alumnos: {{$grupo['cantidad']}} | P. Parcial: {{$grupo['promedio_parcial']}} | P. Continua: {{$grupo['promedio_continua']}}</span>
              </div>
            @endforeach
          </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-lg">
          <h3 class="font-bold text-lg text-gray-700 mb-3 flex items-center">
            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
            Horas Próximas
          </h3>
          <ul id="upcomingClasses" class="mt-2 text-sm text-gray-700 space-y-3">
            <li class="p-2 border-l-4 border-amber-500 bg-amber-50 rounded-r-lg">
              <p class="font-medium">Clase: Programación II (B301)</p>
              <p class="text-xs text-gray-500">Hoy, 3:00 PM</p>
            </li>
            <li class="p-2 border-l-4 border-fuchsia-500 bg-fuchsia-50 rounded-r-lg">
              <p class="font-medium">Tutoría (Oficina)</p>
              <p class="text-xs text-gray-500">Mañana, 8:00 AM</p>
            </li>
          </ul>
          <h3 class="font-bold text-lg text-gray-700 mt-5 mb-3">Tareas Pendientes</h3>
          <ul id="pendingTasks" class="text-sm text-gray-600 space-y-2">
            <li class="text-gray-500">• Revisar 12 Tareas de Mat. Discretas</li>
            <li class="text-gray-500">• Ingresar notas de Laboratorio</li>
          </ul>
        </div>
      </div>
    </div>

    <div id="view-grades-input" class="view-content space-y-6 hidden">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Libreta de Notas y Registro de Asistencia</h2>

      <div id="courseCardSelector" class="space-y-4">
        <h3 class="font-bold text-xl text-gray-700">Selecciona un Curso para Gestionar</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach($grupos as $grupo)
          <div onclick="selectCourseForManagement({{$grupo['id']}}, '{{$grupo['nombre']}}')" class="p-6 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg cursor-pointer hover:shadow-xl hover:scale-105 transition text-white">
            <h3 class="text-xl font-bold mb-2">{{$grupo['nombre']}}</h3>
            <p class="text-sm opacity-90">{{$grupo['cantidad']}} Alumnos</p>
            <p class="text-xs opacity-75 mt-1">P. Parcial: {{$grupo['promedio_parcial']}} | P. Continua: {{$grupo['promedio_continua']}}</p>
          </div>
          @endforeach
        </div>
      </div>

      <div id="courseManagementPanels" class="space-y-6 hidden">
        <div class="bg-white rounded-xl p-4 shadow-lg flex justify-between items-center border-l-4 border-indigo-500">
          <h3 class="font-semibold text-lg text-gray-700">Opciones de Libreta</h3>
          <div class="flex gap-3">
            <button onclick="backToCourseSelection()" class="px-4 py-2 rounded-lg text-sm font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition">
              <svg class="inline w-4 h-4 mr-1 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
              Seleccionar Otro Curso
            </button>
            <button onclick="importNotes()" class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
              Importar Notas (Excel)
            </button>
            <button onclick="exportGradebook()" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 transition">
              Descargar Libreta/Informe
            </button>
          </div>
        </div>

        <div id="gest-1-asistencia" class="bg-white rounded-xl p-6 shadow-lg">
          <h3 class="font-bold text-xl text-gray-700 mb-4">1. Gestión de Asistencia y Curso: <span id="currentCourseNameAtt" class="text-indigo-600"></span></h3>

          <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="flex-1">
              <label for="courseSelectGrades" class="block text-sm font-medium text-gray-700">Curso Seleccionado:</label>
              <select id="courseSelectGrades" class="mt-1 p-2 border rounded-lg w-full text-lg font-semibold bg-gray-100" disabled>
              </select>
            </div>
            <div class="flex-1">
              <label for="sessionSelectAttendance" class="block text-sm font-medium text-gray-700">Sesión de Clase (Asistencia):</label>
              <select id="sessionSelectAttendance" class="mt-1 p-2 border rounded-lg w-full">
              </select>
            </div>
          </div>

          <button onclick="saveAttendanceOnly()" class="px-5 py-2 rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 transition">
            Guardar Asistencia de la Sesión
          </button>
          <div id="attendancePanel" class="hidden mt-6 border-t pt-4">
            <h4 class="font-bold text-lg text-gray-700 mb-3">Lista de Alumnos - Registrar Asistencia</h4>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                  <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                  <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                  <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                </tr>
                </thead>
                <tbody id="attendanceTableBody" class="bg-white divide-y divide-gray-200 text-sm">
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div id="gest-2-notas" class="bg-white rounded-xl p-6 shadow-lg">
          <h3 class="font-bold text-xl text-gray-700 mb-4">2. Gestión de Notas por Unidad: <span id="currentCourseNameGrades" class="text-indigo-600"></span></h3>
          <div id="unitButtonsContainer" class="flex gap-4 mb-6">
          </div>
        </div>

        <div id="unitGradePanel" class="hidden bg-white rounded-xl p-6 shadow-lg space-y-4">
          <h3 id="panelTitle" class="font-bold text-xl text-gray-700">Gestión de Notas - Unidad X</h3>
          <div id="unitGradeContent">
          </div>
        </div>
      </div>
    </div>

    <div id="view-schedule" class="view-content space-y-6 hidden">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Mi Horario Semanal</h2>

        <button onclick="openScheduleModal()" class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 transition flex items-center">
          <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
          </svg>
          Reservar Hora Extra
        </button>
      </div>

      <div class="relative bg-white rounded-xl p-6 shadow-lg">

        <div class="flex">
          <!-- Calendario -->
          <div id="fullCalendar" class="p-4 flex-1"></div>

          <!-- ⭐ Leyenda a la derecha (vertical) -->

        </div>

      </div>
    </div>

    <div id="view-analytics" class="view-content space-y-6 hidden">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Análisis y Estadísticas de Rendimiento</h2>

      <div class="flex flex-col lg:flex-row gap-6">

        <div class="w-full lg:w-80 flex-shrink-0 space-y-6">
          <div id="courseSelector" class="bg-white p-4 rounded-xl shadow-lg h-min">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Seleccionar Curso</h3>
            <div id="courseButtonsContainer" class="space-y-3">
            </div>
          </div>

          <div id="studentSelector" class="bg-white p-4 rounded-xl shadow-lg h-min">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Seleccionar Análisis / Alumno</h3>
            <div id="studentButtonsContainer" class="space-y-3">
            </div>
          </div>
        </div>

        <div class="flex-1 bg-white p-6 rounded-xl shadow-lg">
          <h3 id="chartTitle" class="text-xl font-semibold text-gray-800 mb-4">Selecciona un curso para ver estadísticas</h3>
          <div class="h-[500px]">
            <canvas id="gradeChart"></canvas>
          </div>
          <div id="chartMessage" class="mt-4 text-center text-gray-500 hidden">
            No hay datos de notas registradas para este curso o los datos son insuficientes.
          </div>
        </div>
      </div>
    </div>

    <div id="scheduleModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden flex items-center justify-center z-50 p-4" onclick="closeScheduleModal(event)">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-100" onclick="event.stopPropagation()">
        <div class="p-6 border-b flex justify-between items-center">
          <h3 class="text-xl font-bold text-gray-800">Reservar Clase</h3>
          <button onclick="closeScheduleModal()" class="text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
        </div>
        <div class="p-6">
          <form id="scheduleForm" onsubmit="event.preventDefault(); saveNewScheduleEvent()">
            <div class="mb-4">
              <label for="eventCurso" class="block text-sm font-medium text-gray-700">Curso:</label>
              <select id="eventCurso" required
                      class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                <option value="">Selecciona un curso</option>
                @foreach($grupos as $grupo)
                <option value="{{$grupo['id']}}">{{$grupo['nombre']}} - {{ucfirst($grupo['tipo'])}}</option>
                @endforeach
              </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
              <div>
                <label for="eventDate" class="block text-sm font-medium text-gray-700">Día:</label>
                <input type="date" id="eventDate" onchange="updateEventButtonState()" required class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:ring-indigo-500 focus:border-indigo-500">
              </div>
              <div>
                <label for="eventLocation" class="block text-sm font-medium text-gray-700">Aula/Laboratorio:</label>
                <select id="eventLocation" required
                        class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                  <option value="">Selecciona un ambiente</option>
                </select>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
              <div>
                <label for="eventStart" class="block text-sm font-medium text-gray-700">Hora de Inicio:</label>
                <input type="time" id="eventStart" onchange="updateEventButtonState()" required class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:ring-indigo-500 focus:border-indigo-500">
              </div>
              <div>
                <label for="eventEnd" class="block text-sm font-medium text-gray-700">Hora de Fin:</label>
                <input type="time" id="eventEnd" onchange="updateEventButtonState()" required class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:ring-indigo-500 focus:border-indigo-500">
              </div>
            </div>

            <div class="mt-6 text-right">
              <button type="button" onclick="closeScheduleModal()" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 transition mr-3">
                Cancelar
              </button>
              <button type="submit" id="event-submit-button" class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-indigo-600 disabled:bg-indigo-400 hover:bg-indigo-700 transition">
                Reservar Hora
              </button>
              <div id="event-submit-error" class="text-red-500">

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal fondo -->
    <div id="modal-asistencia"
         class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">

      <!-- Contenido del modal -->
      <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl p-6 relative">

        <!-- Botón cerrar -->
        <button onclick="closeAsistenciaModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
          ✕
        </button>

        <h1 id="asistencia-title" class="text-2xl font-bold text-gray-800 mb-2">
        </h1>
        <p class="text-gray-600 mb-6">Registre la asistencia de los alumnos para esta sesión</p>

        <form method="POST" action="route('asistencia.guardar', $grupo->id) ">
          @csrf

            <div id="asistencia-empty" class="text-center py-12 bg-slate-50 rounded-lg border border-dashed border-slate-200">
              <i class="fas fa-users-slash text-5xl mb-4 text-slate-400"></i>
              <p class="text-slate-500 text-lg">No hay alumnos matriculados en este grupo</p>
              <p class="text-slate-400 text-sm mt-2">Los alumnos aparecerán aquí una vez se matriculen</p>
            </div>

            <div id="asistencia-tabla" class="hidden overflow-x-auto border border-gray-200 rounded-lg mb-6">
              <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-gray-50">
                  <th class="py-3 px-4 border-b font-medium text-gray-700 text-left min-w-[300px]">Alumno</th>
                  <th class="py-3 px-4 border-b font-medium text-gray-700 text-center w-32">Presente</th>
                </tr>
                </thead>
                <tbody id="asistencia-table-body" class="text-sm">

                  <tr class="row-select border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-4 px-4 font-semibold text-gray-800">
                       $alumno->user->name
                    </td>
                    <td class="py-4 px-4 text-center">
                      <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox"
                               name="asistencia[$alumno->id ]"
                               value="1"
                               required
                               class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2">
                      </label>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>


          <div class="flex flex-col md:flex-row justify-between items-center gap-4 mt-6 pt-6 border-t border-gray-200">
            <div class="text-sm text-gray-600 flex items-center">
              <i class="fas fa-info-circle mr-2 text-blue-500"></i>
              Marque la asistencia para cada alumno
            </div>
            <div class="flex gap-3">
              <button type="button"
                      onclick="document.getElementById('modal-asistencia').classList.add('hidden')"
                      class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Cerrar
              </button>
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition flex items-center gap-2 shadow-sm">
                  <i class="fas fa-save"></i> Guardar Asistencia
                </button>
            </div>
          </div>

        </form>

      </div>
    </div>

  </main>

  @vite(['resources/js/docente/docente.js'])
</x-header_layout>
