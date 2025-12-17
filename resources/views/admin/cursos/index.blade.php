<x-header_layout>
  <x-admin.sidebar/>

  <div class="p-6 space-y-8">
    <h2 class="text-3xl font-semibold text-gray-800">Cursos</h2>

    @forelse($cursos as $curso)
      <div class="bg-white rounded-xl shadow p-6 space-y-4">

        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-xl font-bold text-gray-800">{{ $curso->nombre }}</h3>
            <p class="text-sm text-gray-500">ID: {{ $curso->id->getValue() }}</p>
          </div>
          <span class="px-3 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700 font-medium">
            Grupos asignados : {{count($curso->grupos)}}
          </span>
        </div>

        @foreach($curso->grupos as $grupo)
          <div class="border rounded-lg p-4 bg-gray-50">
            <h4 class="font-semibold text-gray-700 mb-2">Grupo</h4>
            <ul class="text-sm text-gray-600 space-y-1">
              <li><strong>ID:</strong> {{ $grupo->id->getValue() }}</li>
              <li><strong>Turno:</strong> {{ $grupo->turno }}</li>
              <li><strong>Tipo:</strong> {{ $grupo->tipo }}</li>
            </ul>
          </div>
        @endforeach

        <div>
          <h4 class="font-semibold text-gray-700 mb-2">
            Temas ({{ count($curso->temas) }})
          </h4>
          <ul class="list-disc list-inside space-y-1 text-sm text-gray-700">
            @forelse($curso->temas as $tema)
              <li>
                {{ $tema->nombre ?? 'Tema #' . $tema->id }}
              </li>
            @empty
              <li class="text-sm text-gray-500 italic list-none">
                Este curso no tiene temas registrados.
              </li>
            @endforelse
          </ul>
        </div>
      </div>
    @empty
      <div class="text-center text-gray-500 py-12">
        No hay cursos registrados.
      </div>
    @endforelse
  </div>
</x-header_layout>
