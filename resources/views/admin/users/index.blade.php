<x-header_layout>
  <x-admin.sidebar/>

  <div class="p-6 space-y-8">
    <h2 class="text-3xl font-semibold text-gray-800">Usuarios</h2>
    <a href="{{ route('admin.users.create') }}"
       class="inline-block mt-3 bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl text-sm shadow-sm transition">
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
          class="border border-gray-300 rounded-lg px-4 py-2 w-80 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
          required
        >

        <button
          class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm shadow-sm transition">
          Buscar
        </button>
      </form>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full bg-white rounded-lg shadow">
        <thead>
        <tr class="bg-gray-100">
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Nombre</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Email</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Rol</th>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
          <tr class="border-b">
            <td class="px-4 py-3 text-sm text-gray-700">{{ $user->name }}</td>
            <td class="px-4 py-3 text-sm text-gray-700">{{ $user->email }}</td>
            <td class="px-4 py-3 text-sm text-gray-700">{{ $user->role }}</td>
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
