@props(['curso'])

@php($map_group_type = ['laboratorio' => 'Lab', 'teoria' => 'Teoria'])

<div class="bg-white rounded-xl shadow p-6 space-y-4">
  <h3 class="text-xl font-bold text-gray-800">{{ $curso->nombre }}</h3>
  <div class="grid grid-cols-3 gap-4">
    @forelse($curso->grupos as $grupo)
      <div class="border rounded-lg p-4 bg-gray-50">
        {{ $map_group_type [$grupo->tipo] }}<br>
        Grupo {{ $grupo->turno }}
      </div>
    @empty
      <p class="text-sm text-gray-500 italic">
        No hay grupos asignados a este curso.
      </p>
    @endforelse
  </div>

  <div>
    <h4 class="font-semibold text-gray-700 mb-2">Temas ({{ count($curso->temas) }})</h4>
    <ul class="list-disc list-inside space-y-1 text-sm text-gray-700">
      @forelse($curso->temas as $tema)
        <li>{{ $tema->nombre ?? 'Tema #' . $tema->id }}</li>
      @empty
        <li class="text-sm text-gray-500 italic list-none">
          Este curso no tiene temas registrados.
        </li>
      @endforelse
    </ul>
  </div>
</div>
