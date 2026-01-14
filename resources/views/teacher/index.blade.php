<x-header_layout>
  <x-teacher.sidebar></x-teacher.sidebar>

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
                <span class="font-medium text-indigo-700">{{$grupo['nombre']}} ({{$grupo['turno']}}) - {{ucfirst($grupo['tipo'])}}</span>
                <span class="text-xs text-gray-500">Alumnos: {{$grupo['cantidad']}}</span>
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
  </main>
</x-header_layout>
