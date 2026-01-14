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
                  <a href="#" onclick="event.stopPropagation()" class="text-xs text-gray-600 hover:underline">Sílabo</a>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-lg h-full flex flex-col">
          <h3 class="font-bold text-lg text-gray-700 mb-3">
            Temas
          </h3>
          <div class="flex-1 overflow-y-auto pr-2">
          @foreach($grupos as $grupo)
              <div class="temas hidden space-y-3" data-id="{{$grupo['id']}}">
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

      cursos.forEach(curso => {
        curso.addEventListener('click', e => {
          if (e.target.tagName === 'A') return;

          // quitar estado activo a todos
          cursos.forEach(c =>
            c.classList.remove('outline', 'outline-2', 'outline-indigo-500')
          );

          // activar el actual
          curso.classList.add('outline', 'outline-2', 'outline-indigo-500');

          // mostrar temas
          temas.forEach(t => t.classList.add('hidden'));
          document
            .querySelector(`.temas[data-id="${curso.dataset.id}"]`)
            .classList.remove('hidden');
        });
      });
    })();
  </script>
</x-header_layout>
