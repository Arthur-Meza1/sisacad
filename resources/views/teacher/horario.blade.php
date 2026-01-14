<x-header_layout>
  <x-teacher.sidebar></x-teacher.sidebar>

  <main class="flex-1 p-4">
    <div id="view-schedule" class="view-content space-y-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Mi Horario Semanal</h2>

        <div onclick="openScheduleModal()"
           class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 transition flex items-center">
          <svg class="w-5 h-5 mr-1" viewBox="0 0 20 20">
            <path fill-rule="evenodd" fill="currentColor"
                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                  clip-rule="evenodd"></path>
          </svg>
          Reservar Hora Extra
        </div>
      </div>

      <div class="relative bg-white rounded-xl p-6 shadow-lg">
        <div class="flex">
          <div id="fullCalendar" class="p-4 flex-1"></div>
        </div>
      </div>
    </div>

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

    <div id="scheduleModal"
         class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4 hidden"
         onclick="closeScheduleModal(event)">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-100"
           onclick="event.stopPropagation()">
        <div class="p-6 border-b flex justify-between items-center">
          <h3 class="text-xl font-bold text-gray-800">Reservar Clase</h3>
          <button onclick="closeScheduleModal()" class="text-gray-500 hover:text-gray-800 text-2xl leading-none">
            &times;
          </button>
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
                <input type="date" id="eventDate" onchange="updateEventButtonState()" required
                       class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:ring-indigo-500 focus:border-indigo-500">
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
                <input type="time" id="eventStart" onchange="updateEventButtonState()" required
                       class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:ring-indigo-500 focus:border-indigo-500">
              </div>
              <div>
                <label for="eventEnd" class="block text-sm font-medium text-gray-700">Hora de Fin:</label>
                <input type="time" id="eventEnd" onchange="updateEventButtonState()" required
                       class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:ring-indigo-500 focus:border-indigo-500">
              </div>
            </div>

            <div class="mt-6 text-right">
              <button type="button" onclick="closeScheduleModal()"
                      class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 transition mr-3">
                Cancelar
              </button>
              <button type="submit" id="event-submit-button"
                      class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-indigo-600 disabled:bg-indigo-400 hover:bg-indigo-700 transition">
                Reservar Hora
              </button>
              <div id="event-submit-error" class="text-red-500">

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>

  <script>
    globalThis.HORARIO_DATA = @json($horario);
    globalThis.GRUPOS_DATA = @json($grupos);
  </script>
  @vite('resources/js/docente/docente.js')
</x-header_layout>
