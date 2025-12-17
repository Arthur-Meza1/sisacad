<x-header_layout>
  <x-student.sidebar></x-student.sidebar>

  <main class="flex-1 p-4">
    <div id="view-dashboard" class="view-content space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Resumen General</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card bg-white rounded-xl p-5 shadow-lg border-b-4 border-indigo-500">
          <p class="text-sm font-medium text-gray-500">Promedio General</p>
          <strong id="avgGrade" class="text-3xl font-extrabold text-indigo-600">-</strong>
          <p class="text-xs text-gray-400 mt-1">Calculado sobre 6 materias</p>
        </div>
        <div class="card bg-white rounded-xl p-5 shadow-lg border-b-4 border-cyan-500">
          <p class="text-sm font-medium text-gray-500">Asistencia Promedio</p>
          <strong id="attSummary" class="text-3xl font-extrabold text-cyan-600">-</strong>
          <p class="text-xs text-gray-400 mt-1">En el ciclo actual</p>
        </div>
        <div class="card bg-white rounded-xl p-5 shadow-lg border-b-4 border-purple-500">
          <p class="text-sm font-medium text-gray-500">Cursos Activos</p>
          <strong id="coursesCount" class="text-3xl font-extrabold text-purple-600">6</strong>
          <p class="text-xs text-gray-400 mt-1">Incluye laboratorios</p>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-lg">
          <h3 class="font-bold text-lg text-gray-700 mb-3">Cursos y Laboratorios Matriculados</h3>
          <div id="courseList" class="space-y-2 text-sm">
            @foreach($grupos as $grupo)
              <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                <span class="font-medium text-indigo-700">{{$grupo['nombre']}} ({{$grupo['turno']}}) - {{ucfirst($grupo['tipo'])}}</span>
                <span class="text-xs text-gray-500">Docente: {{$grupo['docente']}}</span>
              </div>
            @endforeach
          </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-lg">
          <h3 class="font-bold text-lg text-gray-700 mb-3 flex items-center">
            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
            Próximos Eventos
          </h3>
          <ul id="upcomingEvents" class="mt-2 text-sm text-gray-700 space-y-3">
            <li class="p-2 border-l-4 border-amber-500 bg-amber-50 rounded-r-lg">
              <p class="font-medium">Clase: Matemáticas</p>
              <p class="text-xs text-gray-500">Hoy, 3:00 PM</p>
            </li>
            <li class="p-2 border-l-4 border-fuchsia-500 bg-fuchsia-50 rounded-r-lg">
              <p class="font-medium">Laboratorio: Física</p>
              <p class="text-xs text-gray-500">Mañana, 8:00 AM</p>
            </li>
          </ul>
          <h3 class="font-bold text-lg text-gray-700 mt-5 mb-3">Últimas Actividades</h3>
          <ul id="activities" class="text-sm text-gray-600 space-y-2"></ul>
        </div>
      </div>
    </div>

    <div id="view-enrollment" class="view-content space-y-6 hidden">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Matrícula de Laboratorios</h2>
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-lg">
          <h3 class="font-bold text-xl text-gray-700 mb-4">Laboratorios Disponibles</h3>
          <div id="availableLabsList" class="space-y-3">
          </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-lg">
          <h3 class="font-bold text-xl text-gray-700 mb-4 text-indigo-600">Mi Matrícula Actual</h3>
          <div id="enrolledLabsList" class="space-y-3">
            <p class="text-gray-500 text-sm">Aún no has matriculado laboratorios.</p>
          </div>
        </div>
      </div>
    </div>

    <div id="view-schedule" class="view-content space-y-6 hidden">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Horario</h2>
      <div class="bg-white rounded-xl p-6 shadow-lg relative">
        <div id="calendarContainer" style="min-height:300px"></div>
      </div>
    </div>

    <div id="view-grades" class="view-content hidden">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">
        Estadísticas de Notas
      </h2>

      <div class="flex flex-col lg:flex-row gap-6">
        <div class="flex-1 space-y-6">
          <!-- Gráfica -->
          <div class="relative bg-white rounded-2xl p-6 shadow-lg border border-gray-100 overflow-hidden">
            <h3 id="chart-title" class="font-semibold text-lg text-gray-700 mb-4 text-center">
              Rendimiento Final por Materia (Base 20)
            </h3>

            <!-- Contenedor del gráfico -->
            <div id="gradeChartDetail" class="h-[380px]"></div>
          </div>
        </div>

        <aside class="w-full lg:w-72 bg-white rounded-xl p-6 shadow-md h-fit sticky top-6">
          <h3 class="font-bold text-lg text-gray-700 mb-4">Seleccionar Curso</h3>
          <div id="courses-buttons-container" class="flex flex-col gap-3">
            <!-- Botones dinámicos -->
          </div>
        </aside>
      </div>
    </div>

    <div id="view-attendance" class="view-content space-y-6 hidden">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Estadísticas de Asistencia</h2>
      <div class="bg-white rounded-xl p-6 shadow-lg">
        <h3 class="font-bold text-xl text-gray-700 mb-4">Tendencia de Asistencia por Curso (%)</h3>
        <div id="attChartDetail" style="height:350px;"></div>
      </div>
      <div class="bg-white rounded-xl p-6 shadow-lg">
        <h3 class="font-bold text-lg text-gray-700 mb-3">Tabla de Asistencia</h3>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materia</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asistencia (%)</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Faltas</th>
          </tr>
          </thead>
          <tbody id="attendanceTableBody" class="bg-white divide-y divide-gray-200 text-sm">
          </tbody>
        </table>
      </div>
    </div>
  </main>
</x-header_layout>
