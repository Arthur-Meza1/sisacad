<x-header_layout>
  <x-student.sidebar></x-student.sidebar>

  <main class="flex-1 p-4">
    <div id="view-schedule" class="view-content space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Horario</h2>
      <div class="bg-white rounded-xl p-6 shadow-lg relative">
        <div id="calendarContainer" style="min-height:300px"></div>
      </div>
    </div>
  </main>

  {{--@vite('resources/js/alumno/calendario.js')--}}

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      loadScheduleCalendar(@json($horario));
    });
  </script>
</x-header_layout>
