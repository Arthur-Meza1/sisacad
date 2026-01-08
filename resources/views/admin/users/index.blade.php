<x-header_layout>
  <x-admin.sidebar/>
  <script src="//unpkg.com/alpinejs" defer></script>

  <div class="w-full p-6 space-y-8">
    <h2 class="text-3xl font-semibold text-gray-800">Usuarios</h2>
    <a href="{{ route('admin.users.create') }}"
       class="inline-block mt-3 bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl shadow-sm transition">
      Nuevo Usuario
    </a>

    @if(session('success'))
      <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg shadow-sm border border-green-200">
        {{ session('success') }}
      </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-4">
      <p class="text-gray-500 text-sm">
        Ingresa un nombre para buscar usuarios.
      </p>
      <form action="{{ route('admin.users.search') }}" method="GET" class="flex items-center gap-3">
        <input
          type="text"
          name="query"
          placeholder="Buscar usuarios..."
          class="border border-gray-300 rounded-lg px-4 py-2 w-80 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
          required
        >

        <button
          class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow-sm transition">
          Buscar
        </button>
      </form>
    </div>

    <div class="overflow-x-auto"
         x-data="{ openDelete: false, deleteAction: '' }">

      <table class="min-w-full bg-white rounded-lg shadow">
        <thead>
        <tr class="bg-gray-100">
          <th class="px-4 py-2 text-left font-semibold text-gray-600">ID</th>
          <th class="px-4 py-2 text-left font-semibold text-gray-600">Nombre</th>
          <th class="px-4 py-2 text-left font-semibold text-gray-600">Email</th>
          <th class="px-4 py-2 text-left font-semibold text-gray-600">Rol</th>
          <th class="px-4 py-2 text-center font-semibold text-gray-600">Acciones</th>
        </tr>
        </thead>

        <tbody>
        @forelse($users as $user)
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-3 text-gray-700">{{ $user->id->getValue() }}</td>
            <td class="px-4 py-3 text-gray-700">{{ $user->name }}</td>
            <td class="px-4 py-3 text-gray-700">{{ $user->email }}</td>
            <td class="px-4 py-3 text-gray-700">{{ $user->role }}</td>

            <td class="px-4 py-3 text-center space-x-3">
              @if($user->role != 'admin')
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
            <td colspan="4" class="px-4 py-4 text-center text-gray-400">
              No se encontraron resultados
            </td>
          </tr>
        @endforelse
        </tbody>
      </table>

      {{-- Modal eliminar --}}
      <div x-show="openDelete"
           x-transition
           class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
           style="display:none">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">
            Confirmar eliminación
          </h3>

          <p class="text-sm text-gray-600 mb-6">
            ¿Seguro que deseas eliminar este usuario? Esta acción no se puede deshacer.
          </p>

          <div class="flex justify-end gap-3">
            <button
              @click="openDelete = false"
              class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-100">
              Cancelar
            </button>

            <form :action="deleteAction" method="POST">
              @csrf
              @method('DELETE')
              <button
                type="submit"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Eliminar
              </button>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</x-header_layout>
