<aside class="w-64 p-4 sticky top-20 h-full">
  <nav class="space-y-2 font-medium">
    <a href="{{route('student.dashboard')}}" class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100
      {{ request()->routeIs('student.dashboard') ? 'active-link' : 'inactive-link' }}">
      <svg class="w-5 h-5 mr-3" stroke="currentColor" viewBox="0 0 24 24"><path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l-2 2m0 0l-7 7m7-7v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1v-7a1 1 0 00-.293-.707l-2-2"></path></svg>
      Inicio
    </a>
    <a href="{{route('student.matricula')}}" class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100
    {{ request()->routeIs('student.matricula') ? 'active-link' : 'inactive-link' }}">
      <svg class="w-5 h-5 mr-3" stroke="currentColor" viewBox="0 0 24 24"><path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
      Matrícula
    </a>
    <a href="{{route('student.horario')}}" class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100
    {{ request()->routeIs('student.horario') ? 'active-link' : 'inactive-link' }}">
      <svg class="w-5 h-5 mr-3" stroke="currentColor" viewBox="0 0 24 24"><path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
      Horario
    </a>
    <a href="{{route('student.notas')}}" class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100
    {{ request()->routeIs('student.notas') ? 'active-link' : 'inactive-link' }}">
      <svg class="w-5 h-5 mr-3" stroke="currentColor" viewBox="0 0 24 24"><path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6"></path></svg>
      Notas
    </a>
    <a href="#" class="nav-link flex items-center p-3 rounded-lg hover:bg-gray-100 inactive-link">
      <svg class="w-5 h-5 mr-3" stroke="currentColor" viewBox="0 0 24 24"><path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
      Asistencia
    </a>
  </nav>
</aside>
