<x-header_layout>
  <x-teacher.sidebar></x-teacher.sidebar>
  @vite('resources/js/docente/notas.js')

  <main class="flex-1 p-4">
    <div id="view-analytics" class="view-content space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Análisis y Estadísticas de Rendimiento</h2>

      <div class="flex flex-col lg:flex-row gap-6">

        <div class="w-full lg:w-80 flex-shrink-0 space-y-6">
          <div id="courseSelector" class="bg-white p-4 rounded-xl shadow-lg h-min">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Seleccionar Curso</h3>
            <div class="space-y-3">
              @foreach($grupos as $grupo)
                <button
                  onclick="loadAnalyticsView(this, {{$grupo['id']}})"
                  class="w-full text-left p-3 rounded-lg text-gray-600 hover:bg-indigo-100 hover:text-indigo-700 transition duration-150 course-button">
                  {{$grupo['nombre']}} ({{$grupo['turno']}}) - {{ucfirst($grupo['tipo'])}}
                </button>
              @endforeach
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
          <div class="w-full">
            <!-- Gráficos generales del curso -->
            <div id="courseChartsContainer" class="space-y-6">
              <div class="h-[500px]" id="gradeChart1"></div>
              <div class="h-[500px]" id="gradeChart2"></div>
              <div class="h-[500px]" id="gradeChart3"></div>
              <div class="h-[500px]" id="gradeChart4"></div>
            </div>

            <!-- Gráficos individuales del alumno -->
            <div id="studentChartsContainer" class="hidden space-y-6">
              <div class="h-[500px]" id="studentChart1"></div>
              <div class="h-[500px]" id="studentChart2"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

</x-header_layout>
