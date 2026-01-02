<x-header_layout>
  <x-student.sidebar></x-student.sidebar>

  <main class="flex-1 p-4">
    <div class="space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Temas y Progreso por Curso</h2>

        <div class="grid grid-cols-1 gap-6">
          @foreach($grupos as $grupo)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-indigo-500">
              <!-- Header (toggle button) -->
              <button type="button"
                      class="w-full flex justify-between items-center px-6 py-4 accordion-toggle student-accordion-toggle"
                      data-target="#topics-{{ $grupo['id'] }}"
                      aria-expanded="false"
              >
                <div class="text-left">
                  <h3 class="text-lg font-bold text-gray-800">{{ $grupo['nombre'] }}</h3>
                  <p class="text-sm text-gray-500">{{ $grupo['docente'] }} • Turno {{ $grupo['turno'] }}</p>
                </div>
                <div class="flex items-center space-x-3">
                  <div class="text-right mr-2">
                    <p class="text-sm font-semibold text-indigo-600">0%</p>
                    <p class="text-xs text-gray-500">0</p>
                  </div>
                  <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                  </svg>
                </div>
              </button>

              <!-- Contenido colapsable -->
              <div id="topics-{{ $grupo['id'] }}" class="hidden p-6 border-t border-gray-100">
                @if(empty($grupo['temas']))
                  <p class="text-gray-500 text-sm">Sin temas disponibles</p>
                @else
                  <div class="space-y-3 max-h-60 overflow-y-auto pr-2">
                    @foreach($grupo['temas'] as $tema)
                      <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                          <p class="text-sm font-medium text-gray-800">{{ $tema['orden'] }}. {{ $tema['nombre'] }}</p>
                        </div>
                      </div>
                    @endforeach
                  </div>

                  <div class="mt-5 pt-4 border-t border-gray-200">
                    <div class="flex justify-between items-center mb-2">
                      <p class="text-xs font-semibold text-gray-600">PROGRESO</p>
                      <p class="text-xs font-bold text-indigo-600">0</p>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                      <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">0% completado</p>
                  </div>
                @endif
              </div>
            </div>
          @endforeach
        </div>
    </div>
  </main>

  <script>
    (function(){
      // Maneja toggles del acordeón dentro de este componente
      document.querySelectorAll('.student-accordion-toggle').forEach(function(btn){
        btn.addEventListener('click', function(){
          var target = document.querySelector(btn.dataset.target);
          var expanded = btn.getAttribute('aria-expanded') === 'true';
          btn.setAttribute('aria-expanded', (!expanded).toString());
          if(!target) return;
          target.classList.toggle('hidden');
          // rotate icon
          var icon = btn.querySelector('svg');
          if(icon){
            icon.style.transform = expanded ? 'rotate(0deg)' : 'rotate(180deg)';
          }
        });
      });
    })();
  </script>
</x-header_layout>
