<x-header_layout>
  <x-admin.sidebar/>
  <main class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Crear Usuario</h1>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="font-medium">Nombre</label>
        <input name="name" class="w-full border rounded-lg px-3 py-2" required>
      </div>

      <div>
        <label class="font-medium">Email</label>
        <input type="email" name="email" class="w-full border rounded-lg px-3 py-2" required>
      </div>

      <div>
        <label class="font-medium">Password</label>
        <input type="password" name="password" class="w-full border rounded-lg px-3 py-2" required>
      </div>

      <div>
        <label class="font-medium">Rol</label>
        <select name="role" class="w-full border rounded-lg px-3 py-2" required>
          <option value="admin">Admin</option>
          <option value="secretary">Secretario</option>
          <option value="teacher">Docente</option>
          <option value="student">Alumno</option>
        </select>
      </div>

      <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
        Guardar
      </button>
    </form>

  </main>
</x-header_layout>
