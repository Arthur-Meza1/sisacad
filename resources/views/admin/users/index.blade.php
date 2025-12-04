<x-header_layout>
  <div class="p-6 space-y-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Usuarios</h2>

    @if(session('success'))
      <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    <a href="{{ route('admin.users.create') }}"
       class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
      Nuevo Usuario
    </a>

    <form action="{{ route('admin.users.search') }}" method="GET" class="mb-6">
      <input type="text" name="query" placeholder="Buscar usuarios..."
             class="border rounded-lg px-3 py-2 w-80" required>

      <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg ml-2 text-sm">
        Buscar
      </button>
    </form>

    <div class="text-gray-500 text-sm">
      Ingresa un nombre, correo o rol para buscar usuarios.
    </div>
  </div>
</x-header_layout>
