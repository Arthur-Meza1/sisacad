<x-sidebar_layout>
  <x-slot:title>Tomar Asistencia</x-slot:title>

  <x-slot:nav_options>
    <a href="{{ route('teacher') }}"><i class="fas fa-home"></i>Inicio</a>
    <a href="{{ route('asistencia.index') }}" class="active"><i class="fas fa-user-check"></i>Tomar Asistencia</a>
    <a href="#"><i class="fas fa-poll-h"></i>Registrar Notas</a>
  </x-slot:nav_options>

  <div class="main-content">
    <h2 class="text-2xl font-bold mb-6">Seleccione un grupo para tomar asistencia</h2>

    @if (session('success'))
      <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($grupos as $grupo)
        <div class="widget hover:shadow-lg transition-all">
          <h3 class="text-xl font-semibold mb-2">{{ $grupo->curso->nombre }}</h3>
          <p><strong>Tipo:</strong> {{ ucfirst($grupo->tipo) }}</p>
          <p><strong>Turno:</strong> {{ $grupo->turno }}</p>
          <p><strong>Sección:</strong> {{ $grupo->seccion }}</p>

          <button class="action-button primary-btn mt-3"
                  onclick="window.location.href='{{ route('asistencia.form', $grupo->id) }}'">
            <i class="fas fa-user-check"></i> Tomar Asistencia
          </button>
        </div>
      @endforeach
    </div>
  </div>
</x-sidebar_layout>
