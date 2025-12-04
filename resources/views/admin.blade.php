<x-header_layout>
  <aside class="w-64 p-4 sticky top-20 h-full">
    <nav class="space-y-2 font-medium">
      <a href="#" data-view="dashboard" class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100 active-link">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l-2 2m0 0l-7 7m7-7v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1v-7a1 1 0 00-.293-.707l-2-2"></path></svg>
        Inicio
      </a>
      <a href="{{ route('admin.users.index') }}" data-view="users" class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100 inactive-link">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3h-1m-4 5v-2a3 3 0 00-3-3H9m4 5H5v-2a3 3 0 013-3h1m4 0a3 3 0 01-3-3V9m6 0a3 3 0 00-3-3m-4 0a3 3 0 013-3m0 6a3 3 0 010 6"></path></svg>
        Usuarios
      </a>
      <a href="#" data-view="courses" class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100 inactive-link">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7"></path></svg>
        Cursos
      </a>
      <a href="#" data-view="reports" class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100 inactive-link">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h6m-4 0h4"></path></svg>
        Reportes
      </a>
      <a href="#" data-view="settings" class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100 inactive-link">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3a2 2 0 012 2v1h-4V5a2 2 0 012-2zM4 8h16M4 12h16M4 16h16"></path></svg>
        Configuración
      </a>
    </nav>
  </aside>

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
