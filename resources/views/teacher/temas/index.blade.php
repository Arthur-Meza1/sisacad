<x-header_layout>
  <x-teacher.sidebar></x-teacher.sidebar>

  <main class="flex-1 p-4">
    <div class="view-content space-y-6">
      <div class="bg-white rounded-xl p-4 shadow-lg flex justify-between items-center border-l-4 border-indigo-500">
        <div class="flex items-center gap-5">
          <div class="relative group">
            <a
              href="{{route('teacher.index')}}"
              aria-label="Seleccionar otro curso"
              class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 hover:bg-indigo-200
                       transition focus:outline-none focus:ring-2 focus:ring-indigo-300">
              <i class="fas fa-arrow-left"></i>
            </a>

            <span
              class="pointer-events-none absolute -top-9 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-md bg-gray-800 text-white text-xs
                       px-2 py-1 opacity-0 scale-95 transition group-hover:opacity-100 group-hover:scale-100">
                Seleccionar otro curso
              </span>
          </div>
          <div>
            <h3 class="font-bold text-lg text-gray-700" id="currentCourseTitle">Curso: {{ $grupo->curso->nombre }} ({{ $grupo->turno }})</h3>
            <p class="text-sm text-gray-500" id="currentCourseInfo">Docente: {{ Auth::user()->name }}</p>
          </div>
        </div>

        <!-- Progreso -->
        <div class="bg-blue-50 p-4 rounded-lg">
          <div class="text-center">
            <p class="text-sm text-blue-800">Progreso</p>
            <p class="text-3xl font-bold text-blue-600">{{ $porcentaje }}%</p>
            <p class="text-sm text-blue-700">
              {{ $temasEnseñados }} / {{ $totalTemas }} temas
            </p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl p-6 shadow-lg">
        <!-- Unidades -->
        @foreach($estructura as $unidadId => $unidad)
          <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-700 mb-4 p-3 bg-gray-100 rounded-lg">
              {{ $unidad['nombre'] }}
            </h3>

            @foreach($unidad['capitulos'] as $capitulo)
              <div class="ml-4 mb-6">
                <h4 class="font-bold text-lg text-blue-700 mb-2">{{ $capitulo['nombre'] }}</h4>

                <div class="space-y-2 ml-4">
                  @foreach($capitulo['temas'] as $tema)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                      <div class="flex items-center space-x-3">
                        <!-- Botón -->
                        <button
                          class="marcar-enseñado w-8 h-8 rounded-full flex items-center justify-center border-2
                               {{ $tema['enseñado'] ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-gray-300 text-gray-600 hover:border-green-400' }}"
                          data-tema-id="{{ $tema['id'] }}"
                          data-grupo-id="{{ $grupo->id }}"
                          data-actualmente="{{ $tema['enseñado'] ? '1' : '0' }}"
                          title="{{ $tema['enseñado'] ? 'Click para desmarcar' : 'Click para marcar como enseñado' }}">

                          @if($tema['enseñado'])
                            ✓
                          @else
                            {{ $tema['orden'] }}
                          @endif
                        </button>

                        <div>
                          <span class="font-medium text-gray-800">{{ $tema['titulo'] }}</span>
                          @if($tema['enseñado'] && $tema['fecha_enseñado'])
                            <p class="text-xs text-green-600 mt-1">
                              ✓ {{ \Carbon\Carbon::parse($tema['fecha_enseñado'])->format('d/m/Y') }}
                            </p>
                          @endif
                        </div>
                      </div>

                      @if($tema['enseñado'] && $tema['notas'])
                        <div class="text-sm text-gray-500 max-w-xs text-right">
                          <span class="text-xs text-gray-400">Notas:</span><br>
                          {{ \Illuminate\Support\Str::limit($tema['notas'], 50) }}
                        </div>
                      @endif
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        @endforeach

        @if(empty($estructura))
          <div class="text-center py-8 text-gray-500">
            <p>No hay temas cargados para este curso.</p>
            <p class="text-sm mt-2">Sube un sílabo PDF para importar los temas.</p>
          </div>
        @endif
      </div>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const botones = document.querySelectorAll('.marcar-enseñado');
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      botones.forEach(boton => {
        boton.addEventListener('click', async function() {
          const temaId = this.dataset.temaId;
          const grupoId = this.dataset.grupoId;
          const actualmente = this.dataset.actualmente === '1';
          const nuevoEstado = !actualmente;

          // Loading
          const originalHTML = this.innerHTML;
          this.innerHTML = '<div class="w-4 h-4 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>';
          this.disabled = true;

          try {
            const response = await fetch('/teacher/tema/toggle-enseñado', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
              },
              body: JSON.stringify({
                grupo_id: grupoId,
                tema_id: temaId,
                enseñado: nuevoEstado
              })
            });

            const data = await response.json();

            if (data.success) {
              // Actualizar visual
              this.dataset.actualmente = nuevoEstado ? '1' : '0';

              if (nuevoEstado) {
                this.classList.remove('bg-white', 'border-gray-300', 'text-gray-600', 'hover:border-green-400');
                this.classList.add('bg-green-500', 'border-green-500', 'text-white');
                this.innerHTML = '✓';
                this.title = 'Click para desmarcar';
              } else {
                this.classList.remove('bg-green-500', 'border-green-500', 'text-white');
                this.classList.add('bg-white', 'border-gray-300', 'text-gray-600', 'hover:border-green-400');
                this.innerHTML = originalHTML.replace('✓', '{{ $tema["orden"] ?? "" }}');
                this.title = 'Click para marcar como enseñado';
              }

              // Recargar para actualizar estadísticas
              setTimeout(() => location.reload(), 1000);

            } else {
              alert('Error: ' + (data.message || 'No se pudo guardar'));
              this.innerHTML = originalHTML;
            }
          } catch (error) {
            console.error('Error:', error);
            alert('Error de conexión');
            this.innerHTML = originalHTML;
          } finally {
            this.disabled = false;
          }
        });
      });
    });
  </script>
</x-header_layout>
