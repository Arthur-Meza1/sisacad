<x-header_layout>
  <x-admin.sidebar/>

  <div class="w-full p-6 space-y-8">
    <div class="space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Temas y Progreso por Curso</h2>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-[70vh]">
        <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-lg h-full flex flex-col">
          <h3 class="font-bold text-lg text-gray-700 mb-3">
            Cursos Asignados
          </h3>
          <div class="space-y-2 text-sm overflow-y-auto py-1">
            @foreach($grupos as $grupo)
              <div
                class="curso p-3 bg-gray-50 rounded-lg hover:cursor-pointer outline-1 mx-1 hover:outline outline-gray-300"
                data-id="{{$grupo['id']}}"
              >
                <div class="flex-col">
                  <div class="flex justify-between">
                    <span class="font-medium text-indigo-700">{{$grupo['nombre']}} ({{$grupo['turno']}}) - {{ucfirst($grupo['tipo'])}}</span>
                  </div>
                  <a href="{{route('teacher.silabo.download', $grupo['id'])}}" onclick="event.stopPropagation()" class="text-xs text-gray-600 hover:underline">Sílabo</a>
                </div>
              </div>
            @endforeach
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
