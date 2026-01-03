<x-header_layout>
  <x-teacher.sidebar></x-teacher.sidebar>

  <main class="flex-1 p-4">
    <div id="view-grades-input" class="view-content space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Libreta de Notas</h2>

      <div id="courseCardSelector" class="space-y-4">
        <h3 class="font-bold text-xl text-gray-700">Selecciona un Curso para Gestionar</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach($grupos as $grupo)
            <a href="{{route('teacher.libreta.editor', $grupo['id'])}}"
              class="text-start p-6 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition text-white">
              <h3 class="text-xl font-bold mb-2">
                {{$grupo['nombre']}} ({{$grupo['turno']}}) - {{ucfirst($grupo['tipo'])}}
              </h3>
              <p class="text-sm opacity-90">{{$grupo['cantidad']}} Alumnos</p>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  </main>
</x-header_layout>
