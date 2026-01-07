<x-header_layout>
  <x-student.sidebar></x-student.sidebar>

  <main class="flex-1 p-4">
    <div class="space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Temas y Progreso por Curso</h2>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-[70vh]">
        <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-lg h-full flex flex-col">
          <h3 class="font-bold text-lg text-gray-700 mb-3">
            Mis Cursos Asignados
          </h3>
          <div class="space-y-2 text-sm overflow-y-auto py-1">
            @foreach($grupos as $grupo)
              <div
                class="curso p-3 bg-gray-50 rounded-lg hover:cursor-pointer outline-1 mx-1 hover:outline outline-gray-300"
                data-id="{{$grupo['id']}}"
              >
                <div class="flex-col">
                  <div class="flex justify-between">
                    <span class="font-medium text-indigo-700">{{$grupo['nombre']}} ({{$grupo['turno']}})</span>
                    <span class="text-xs text-gray-500">{{$grupo['docente']}}</span>
                  </div>
                  <a href="{{route('teacher.silabo.download', $grupo['id'])}}" onclick="event.stopPropagation()" class="text-xs text-gray-600 hover:underline">Sílabo</a>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-lg h-full flex flex-col">
          <h3 class="font-bold text-lg text-gray-700 mb-3">
            Temas <span id="progreso-badge" class="text-sm text-gray-500 ml-2">(Progreso: --%)</span>
          </h3>
          <div class="flex-1 overflow-y-auto pr-2">
            @foreach($grupos as $grupo)
              <div class="temas hidden space-y-3" data-id="{{$grupo['id']}}" data-progreso="{{ $grupo['progreso'] ?? 0 }}">
                @if(!empty($grupo['unidades']))
                  <div class="space-y-4">
                    @foreach($grupo['unidades'] as $unidad)
                      <div class="border rounded-lg bg-gray-50">
                        <button class="w-full text-left px-4 py-2 font-semibold text-gray-700 unidad-toggle">
                          {{ $unidad['nombre'] }}
                        </button>
                        <div class="px-4 py-2 unidad-contenido hidden">
                          @foreach($unidad['capitulos'] as $cap)
                            <div class="mb-3">
                              <p class="text-sm font-semibold text-gray-600">{{ $cap['nombre'] }}</p>
                              <div class="mt-2 space-y-1">
                                @foreach($cap['temas'] as $tema)
                                  <div class="flex items-start space-x-3 p-1 rounded-lg">
                                    <div class="flex-shrink-0 mt-1">
                                      @if(!empty($tema['enseñado']))
                                        <div class="w-4 h-4 bg-green-500 rounded-full flex items-center justify-center text-white text-xs">✓</div>
                                      @else
                                        <div class="w-3 h-3 border-2 border-gray-300 rounded-full"></div>
                                      @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                      <p class="text-sm text-gray-800">{{ $tema['orden'] }}. {{ $tema['nombre'] }}</p>
                                      @if(!empty($tema['fecha_enseñado']))
                                        <p class="text-xs text-gray-400">Enseñado: {{ $tema['fecha_enseñado'] }}</p>
                                      @endif
                                    </div>
                                  </div>
                                @endforeach
                              </div>
                            </div>
                          @endforeach
                        </div>
                      </div>
                    @endforeach
                  </div>
                @else
                  @foreach($grupo['temas'] as $tema)
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                      <div class="flex-shrink-0 mt-1">
                        @if(!empty($tema['enseñado']))
                          <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center text-white">✓</div>
                        @else
                          <div class="w-5 h-5 border-2 border-gray-300 rounded-full"></div>
                        @endif
                      </div>
                      <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">{{ $tema['orden'] }}. {{ $tema['nombre'] }}</p>
                        @if(!empty($tema['fecha_enseñado']))
                          <p class="text-xs text-gray-400">Enseñado: {{ $tema['fecha_enseñado'] }}</p>
                        @endif
                      </div>
                    </div>
                  @endforeach
                @endif
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    (function(){
      const cursos = document.querySelectorAll('.curso');
      const temas  = document.querySelectorAll('.temas');

      // Accordion toggles for unidades
      function initUnidades() {
        document.querySelectorAll('.unidad-toggle').forEach(btn => {
          btn.addEventListener('click', () => {
            const contenido = btn.nextElementSibling;
            contenido.classList.toggle('hidden');
          });
        });
      }

      cursos.forEach(curso => {
        curso.addEventListener('click', e => {
          if (e.target.tagName === 'A') return;

          cursos.forEach(c =>
            c.classList.remove('outline', 'outline-2', 'outline-indigo-500')
          );

          curso.classList.add('outline', 'outline-2', 'outline-indigo-500');

          temas.forEach(t => t.classList.add('hidden'));
          const temasContainer = document.querySelector(`.temas[data-id="${curso.dataset.id}"]`);
          temasContainer.classList.remove('hidden');
          // update progreso badge
          const progreso = temasContainer.dataset.progreso ?? '--';
          const badge = document.getElementById('progreso-badge');
          if (badge) badge.textContent = `(Progreso: ${progreso}%)`;
          // initialize accordion toggles for the visible temas container
          initUnidades();
        });
      });
    })();
  </script>
</x-header_layout>
