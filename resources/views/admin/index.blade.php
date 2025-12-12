<x-header_layout>
  <x-admin.sidebar />

  <main class="flex-1 p-4">
    <div id="view-dashboard" class="view-content space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Panel de Administración</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card bg-white rounded-xl p-5 shadow-lg border-b-4 border-indigo-500">
          <p class="text-sm font-medium text-gray-500">Usuarios Registrados</p>
          <strong id="usersCount" class="text-3xl font-extrabold text-indigo-600">{{$users_count}}</strong>
          <p class="text-xs text-gray-400 mt-1">Incluye docentes, alumnos, etc</p>
        </div>
        <div class="card bg-white rounded-xl p-5 shadow-lg border-b-4 border-cyan-500">
          <p class="text-sm font-medium text-gray-500">Cursos Activos</p>
          <strong id="coursesCount" class="text-3xl font-extrabold text-cyan-600">{{$courses_count}}</strong>
          <p class="text-xs text-gray-400 mt-1">En todos los años</p>
        </div>
      </div>
    </div>
  </main>
</x-header_layout>
