<x-header_layout>
  <x-teacher.sidebar></x-teacher.sidebar>

  <main class="flex-1 p-4">
    <div id="scheduleModal"
         class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4"
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
    globalThis.AULAS_DATA = @@json($aulas);
  </script>
  @vite('resources/js/docente/docente.js')
</x-header_layout>
