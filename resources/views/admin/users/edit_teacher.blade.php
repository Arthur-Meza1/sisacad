<x-header_layout>
  <x-admin.sidebar/>

  <div class="w-full p-6 space-y-8">
    <div class="space-y-6">
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
                    <p class="text-gray-500 mt-4">No dispone de grupos.</p>
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
                        <button
                          type="button"
                          onclick="openModal({{$id->getValue()}}, {{ $grupoDisponible->id }}, '{{$grupoDisponible->tipo}}')"
                          class="px-3 py-1 text-sm rounded-full bg-indigo-500 text-white hover:bg-indigo-600 transition"
                        >
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

  {{-- MODAL --}}
  <div
    id="modal"
    class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center"
  >
    <div
      class="bg-white rounded-xl shadow-xl
           w-[90vw] h-[90vh]
           p-6 flex flex-col"
    >

      <h3 class="text-xl font-bold text-gray-800 mb-4">
        Seleccionar
      </h3>

      {{-- TURNO --}}

      {{-- CONTENIDO SCROLLEABLE --}}
      <div
        id="horariosContainer"
        class="flex-1 grid grid-cols-1 gap-3 overflow-y-auto mb-6"
      >
        {{-- JS inyecta aquí --}}
      </div>

      {{-- FOOTER FIJO --}}
      <div class="flex justify-end gap-3 pt-4 border-t">
        <div class="space-y-1 mb-4">
          <label for="turno" class="block text-sm font-medium text-gray-700">
            Turno
          </label>

          <select
            id="turno"
            name="turno"
            class="w-full rounded-lg border-gray-300 shadow-sm
               focus:border-indigo-500 focus:ring-indigo-500 text-sm"
            required
          >
            <option value="" disabled selected>
              Seleccione un turno
            </option>

            @foreach(\App\Domain\Shared\ValueObject\GrupoTurno::allowedTurno() as $t)
              <option value="{{ $t }}">{{ $t }}</option>
            @endforeach
          </select>
        </div>
        <button
          type="button"
          onclick="closeModal()"
          class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-100"
        >
          Cancelar
        </button>

        <button
          type="button"
          id="confirmBtn"
          onclick="confirmHorario()"
          disabled
          class="px-4 py-2 rounded-lg text-white bg-gray-400 cursor-not-allowed"
        >
          Aceptar
        </button>
      </div>

    </div>
  </div>

  <div id="scheduleModal"
       class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4 hidden"
       onclick="closeScheduleModal(event)">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-100"
         onclick="event.stopPropagation()">
      <div class="p-6 border-b flex justify-between items-center">
        <h3 class="text-xl font-bold text-gray-800">Asignar grupo</h3>
        <button onclick="closeScheduleModal()" class="text-gray-500 hover:text-gray-800 text-2xl leading-none">
          &times;
        </button>
      </div>
      <div class="p-6">
        <form id="scheduleForm" onsubmit="event.preventDefault(); saveNewScheduleEvent()">
          <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
              <label for="eventDay" class="block text-sm font-medium text-gray-700">Día:</label>
              <select id="eventDay" required
                      onchange="updateEventButtonState()"
                      class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                <option value="">Selecciona un dia</option>
                <option value="lunes">Lunes</option>
                <option value="martes">Martes</option>
                <option value="miercoles">Miercoles</option>
                <option value="jueves">Jueves</option>
                <option value="viernes">Viernes</option>
              </select>
            </div>
            <div>
              <label for="eventLocation" class="block text-sm font-medium text-gray-700">Aula/Laboratorio:</label>
              <select id="eventLocation" required
                      onchange="updateEventButtonState()"
                      class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                <option value="">Selecciona un ambiente</option>
                @foreach(\App\Infrastructure\Shared\Model\Aula::all() as $aula)
                  <option value="{{$aula->id}}">{{$aula->nombre}}</option>
                @endforeach
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



  <script>
    globalThis.HORARIO_DATA = @json($horario);
  </script>

  @vite('resources/js/admin/admin.js')

  @vite('resources/js/alumno/calendario.js')

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      loadScheduleCalendar(@json($horario));
    });
  </script>
</x-header_layout>
