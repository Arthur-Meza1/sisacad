<aside class="w-64 p-4 sticky top-20 h-full">
  <nav class="space-y-2 font-medium">
    <a href="{{ route('teacher.index') }}" data-view="dashboard"
       class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('teacher.index*') ? 'active-link' : 'inactive-link' }}">
      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
      </svg>
      Inicio
    </a>
    <a href="{{ route('teacher.libreta.index') }}" data-view="grades-input"
       class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('teacher.libreta*') ? 'active-link' : 'inactive-link' }}">
      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
      </svg>
      Libreta
    </a>
    <a href="{{ route('teacher.horario.index') }}" data-view="schedule"
       class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('teacher.horario*') ? 'active-link' : 'inactive-link' }}">
      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
      </svg>
      Horario
    </a>
    <a href="{{ route('teacher.notas') }}" data-view="analytics"
       class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('teacher.notas*') ? 'active-link' : 'inactive-link' }}">
      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
           xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0v-5a2 2 0 012-2h2a2 2 0 012 2v5m-6 0h.01"></path>
      </svg>
      Análisis de Notas
    </a>
  </nav>
</aside>
