<x-header_layout>
  <div class="p-6 space-y-6">

    <h2 class="text-2xl font-bold text-gray-800 mb-4">Usuarios</h2>

    {{-- Formulario --}}
    <form action="{{ route('admin.users.search') }}" method="GET" class="mb-6">
      <input type="text" name="query" placeholder="Buscar usuarios..."
             class="border rounded-lg px-3 py-2 w-80" required>

      <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg ml-2 text-sm">
        Buscar
      </button>
    </form>

    {{-- Mensaje inicial --}}
    <div class="text-gray-500 text-sm">
      Ingresa un nombre, correo o rol para buscar usuarios.
    </div>

  </div>
</x-header_layout>
