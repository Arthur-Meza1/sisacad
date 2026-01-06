<x-header_layout>
  <main class="flex-1 p-4">
    <div class="bg-white rounded-xl p-6 shadow-lg">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">
        Temas del curso: {{ $grupo->curso->nombre }} ({{ $grupo->turno }})
      </h2>

      {{-- Sección de debug (temporal) --}}
      @if(isset($debug))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
          <h3 class="font-bold">Debug Info:</h3>
          <p>Curso ID: {{ $debug['curso_id'] }}</p>
          <p>Capítulos en BD: {{ $debug['capitulos_count'] }}</p>
          <p>Temas en BD: {{ $debug['temas_count'] }}</p>
          <p>{{ $debug['message'] }}</p>
        </div>
      @endif

      @forelse($grupo->curso->capitulos as $capitulo)
        <div class="mb-4 p-3 bg-gray-50 rounded">
          <h3 class="font-bold text-lg text-blue-700">{{ $capitulo->nombre }}</h3>
          <ul class="list-disc ml-6 mt-2">
            @forelse($capitulo->temas as $tema)
              <li class="py-1">{{ $tema->titulo }}</li>
            @empty
              <li class="text-gray-500 italic">No hay temas en este capítulo</li>
            @endforelse
          </ul>
        </div>
      @empty
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
          <p class="font-bold">¡Atención!</p>
          <p>No hay capítulos para este curso.</p>
          <p class="text-sm mt-2">Posibles causas:</p>
          <ul class="list-disc ml-5 text-sm">
            <li>El sílabo no se procesó correctamente</li>
            <li>El parser no encontró la sección de contenido temático</li>
            <li>No hay datos en la base de datos</li>
          </ul>
        </div>
      @endforelse
    </div>
  </main>
</x-header_layout>
