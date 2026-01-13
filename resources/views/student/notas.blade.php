<x-header_layout>
  <x-student.sidebar></x-student.sidebar>

  <main class="flex-1 p-4">
    <div id="view-grades" class="view-content">
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
            @forelse($cursos as $curso)
              <button
                onclick="selectCourse({{$curso['id']}}, '{{$curso['nombre']}}')"
                class="course-btn flex items-center justify-center w-full sm:w-auto
             font-medium px-5 py-2.5 rounded-xl shadow-md
             transition-all duration-200 ease-out transform
             hover:text-gray-50
             hover:bg-blue-700 hover:shadow-lg hover:-translate-y-0.5
             focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                <span class="text-base tracking-wide">{{$curso['nombre']}} ({{$curso['turno']}}) - {{ucfirst($curso['tipo'])}}</span>
              </button>
            @empty
              <div class="text-gray-500 italic">
                No tienes cursos asignados.
              </div>
            @endforelse
          </div>
        </aside>
      </div>
    </div>
  </main>

  {{--@vite('resources/js/alumno/notas.js')--}}
</x-header_layout>
