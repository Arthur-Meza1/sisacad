<x-sidebar_layout>
  <x-slot:title>Asistencia - {{ $grupo->curso->nombre }}</x-slot:title>

  <x-slot:nav_options>
    <a href="{{ route('teacher') }}"><i class="fas fa-home"></i>Inicio</a>
    <a href="{{ route('asistencia.index') }}" class="active"><i class="fas fa-user-check"></i>Tomar Asistencia</a>
  </x-slot:nav_options>

  <div class="main-content">
    <h2 class="text-2xl font-bold mb-4">
      Asistencia - {{ $grupo->curso->nombre }} ({{ $grupo->turno }})
    </h2>

    <form method="POST" action="{{ route('asistencia.guardar', $grupo->id) }}">
      @csrf
      <table class="w-full border-collapse border border-gray-300">
        <thead class="bg-gray-100">
        <tr>
          <th class="border border-gray-300 px-4 py-2 text-left">Alumno</th>
          <th class="border border-gray-300 px-4 py-2 text-center">Presente</th>
          <th class="border border-gray-300 px-4 py-2 text-center">Ausente</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($alumnos as $alumno)
          <tr>
            <td class="border border-gray-300 px-4 py-2">{{ $alumno->user->name }}</td>
            <td class="border border-gray-300 text-center">
              <input type="radio" name="asistencia[{{ $alumno->id }}]" value="1" required>
            </td>
            <td class="border border-gray-300 text-center">
              <input type="radio" name="asistencia[{{ $alumno->id }}]" value="0">
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>

      <div class="mt-6 flex justify-end">
        <button type="submit" class="action-button primary-btn">
          <i class="fas fa-save"></i> Guardar Asistencia
        </button>
      </div>
    </form>
  </div>
</x-sidebar_layout>
