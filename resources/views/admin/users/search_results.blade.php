<x-header_layout>
  <x-admin.sidebar></x-admin.sidebar>
  <div class="p-6 space-y-6">

    <h2 class="text-2xl font-bold text-gray-800 mb-4">Resultados de búsqueda: {{count($results)}}</h2>

    {{-- Formulario --}}
    <form action="{{ route('admin.users.search') }}" method="GET" class="mb-6">
      <input type="text" name="query" value="{{ request('query') }}" placeholder="Buscar usuarios..."
             class="border rounded-lg px-3 py-2 w-80" required>

      <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg ml-2 text-sm">
        Buscar
      </button>

      <a href="{{ route('admin.users.index') }}"
         class="ml-2 text-sm text-gray-500 hover:text-gray-700">
        Volver
      </a>
    </form>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white rounded-lg shadow">
        <thead>
        <tr class="bg-gray-100">
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Nombre</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Email</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Rol</th>
          <th class="px-4 py-2 text-center font-semibold text-gray-600">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @forelse($results as $user)
          <tr class="border-b">
            <td class="px-4 py-3 text-sm text-gray-700">{{ $user->name }}</td>
            <td class="px-4 py-3 text-sm text-gray-700">{{ $user->email }}</td>
            <td class="px-4 py-3 text-sm text-gray-700">{{ $user->role }}</td>
            <td class="px-4 py-3 text-center space-x-3">
              @if($user->role != 'admin')
                {{-- Ver --}}
                <a href="{{ route($user->role == 'teacher' ? 'admin.users.show.teacher' :'admin.users.show.student', $user->id->getValue()) }}"
                   class="text-blue-600 hover:text-blue-800">
                  <i class="fas fa-eye"></i>
                </a>

                {{-- Editar --}}
                <a
                  href="{{route($user->role == 'teacher' ? 'admin.users.edit.teacher' : 'admin.users.edit.student', $user->id->getValue())}}"
                  class="text-indigo-600 hover:text-indigo-800">
                  <i class="fas fa-edit"></i>
                </a>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="3" class="px-4 py-4 text-center text-gray-400">
              No se encontraron resultados
            </td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

  </div>
</x-header_layout>
