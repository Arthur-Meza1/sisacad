<x-header_layout>
  <x-admin.sidebar/>

  <div class="w-full p-6 space-y-8">
    <div class="space-y-6">
      <div id="modal-asistencia"
           onclick="if(event.target === this) closeAsistenciaModal()"
           class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

        <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl mx-auto p-6 relative
              max-h-[90vh] overflow-y-auto">

          <button onclick="closeAsistenciaModal()"
                  class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">
            ✕
          </button>

          <h1 id="asistencia-title" class="text-2xl font-bold text-gray-800 mb-2 text-center md:text-left"></h1>
          <p class="text-gray-600 mb-6 text-sm md:text-base text-center md:text-left">
            Registre la asistencia de los alumnos para esta sesión
          </p>

          <form id="asistencia-form">
            @csrf
            <input id="asistencia_input_sesion_id" name="sesion_id" hidden>

            <div id="asistencia-empty"
                 class="text-center py-10 bg-slate-50 rounded-lg border border-dashed border-slate-200">
              <i class="fas fa-users-slash text-5xl mb-4 text-slate-400"></i>
              <p class="text-slate-500 text-lg">No hay alumnos matriculados en este grupo</p>
              <p class="text-slate-400 text-sm mt-2">Los alumnos aparecerán aquí una vez se matriculen</p>
            </div>

            <div id="asistencia-tabla"
                 class="hidden overflow-x-auto border border-gray-200 rounded-lg mb-6">
              <table class="w-full text-left border-collapse min-w-[450px]">
                <thead>
                <tr class="bg-gray-50">
                  <th class="py-3 px-4 border-b font-medium text-gray-700 min-w-[250px]">Alumno</th>
                  <th class="py-3 px-4 border-b font-medium text-gray-700 text-center w-28">Presente</th>
                </tr>
                </thead>

                <tbody id="asistencia-table-body" class="text-sm">
                </tbody>
              </table>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mt-6 pt-6 border-t border-gray-200">
              <div class="text-sm text-gray-600 flex items-center text-center md:text-left">
                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                Marque la asistencia para cada alumno
              </div>

              <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">

                <button type="button"
                        onclick="closeAsistenciaModal()"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium
                         hover:bg-gray-50 transition flex items-center gap-2 justify-center">
                  <i class="fas fa-arrow-left"></i> Cerrar
                </button>
                <button type="button"
                        onclick="borrarSesion()"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium
               transition flex items-center gap-2 shadow-sm justify-center">
                  <i class="fas fa-trash"></i> Borrar
                </button>
                <button id="asistencia-submit-button"
                        type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium
                         transition flex items-center gap-2 shadow-sm justify-center disabled:bg-gray-400
                  disabled:text-gray-200 disabled:shadow-none">
                  <i class="fas fa-save"></i> Guardar Asistencia
                </button>

              </div>
            </div>

          </form>

        </div>
      </div>

      <h2 class="text-2xl font-bold text-gray-800 mb-6">Temas y Progreso por Curso</h2>
          <div id="view-enrollment" class="view-content space-y-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Asignación de Cursos</h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
              <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-lg">
                <h3 class="font-bold text-xl text-gray-700 mb-4">Grupos Actuales</h3>
                <div class="space-y-3">
                  @forelse($grupos as $grupo)
                    <form method="POST" action="#">
                      @csrf
                      <div class="flex justify-between items-center p-3 border rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                        <div>
                          <p class="font-medium text-sm text-gray-800">{{$grupo['nombre']}} ({{$grupo['turno']}}) - {{ucfirst($grupo['tipo'])}}</p>
                        </div>
                      </div>
                    </form>
                  @empty
                    <p class="text-gray-500 mt-4">No hay laboratorios disponibles para matricular.</p>
                  @endforelse
                </div>
              </div>
              <div class="bg-white rounded-xl p-6 shadow-lg">
                <h3 class="font-bold text-xl text-gray-700 mb-4 text-indigo-600">Cursos Disponibles</h3>
                <div class="space-y-3 max-h-[500px] overflow-y-auto">
                  @forelse($gruposDisponibles as $grupoDisponible)
                      <div class="flex justify-between items-center p-3 border border-indigo-200 rounded-lg bg-indigo-50">
                        <div>
                          <p class="font-medium text-indigo-700">{{$grupoDisponible->nombre}} - {{ucfirst($grupoDisponible->tipo)}}</p>
                        </div>
                        <button type="submit" class="px-3 py-1 text-sm rounded-full bg-indigo-500 text-white hover:bg-indigo-600 transition">
                          Añadir
                        </button>
                      </div>
                  @empty
                    <p class="text-gray-500 text-sm">No hay cursos disponibles.</p>
                  @endforelse
                </div>
              </div>
            </div>
          </div>
        </div>

    <div id="view-schedule" class="view-content space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Horario</h2>
      <div class="bg-white rounded-xl p-6 shadow-lg relative">
        <div id="calendarContainer" style="min-height:300px"></div>
      </div>
    </div>
  </div>

  @vite('resources/js/alumno/calendario.js')

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      loadScheduleCalendar(@json($horario));
    });
  </script>
</x-header_layout>
