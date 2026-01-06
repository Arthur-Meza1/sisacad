<x-header_layout>
  <x-teacher.sidebar></x-teacher.sidebar>

  <main class="flex-1 p-4">
    <div id="view-grades-input" class="view-content space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Libreta de Notas</h2>

      <div id="courseManagementPanels" class="space-y-6">
        <div class="bg-white rounded-xl p-4 shadow-lg flex justify-between items-center border-l-4 border-indigo-500">
          <div class="flex items-center gap-2">
            <div class="relative group">
              <a
                href="{{route('teacher.libreta.index')}}"
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
            <h3 class="font-bold text-lg text-gray-700" id="currentCourseTitle">Curso: {{$grupo->curso()->nombre()}} ({{$grupo->grupoTurno()->getValue()}}) - {{ucfirst($grupo->cursoTipo()->getValue())}}</h3>
          </div>
          <div class="flex items-center gap-2">
            <!-- Descargar plantilla -->
            <div class="relative group">
              <a
                href="{{route('teacher.libreta.descargar')}}"
                aria-label="Descargar plantilla"
                class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 hover:bg-indigo-200
                       transition focus:outline-none focus:ring-2 focus:ring-indigo-300">
                <i class="fas fa-download"></i>
              </a>
              <span
                class="pointer-events-none absolute -top-9 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-md bg-gray-800 text-white text-xs
                       px-2 py-1 opacity-0 scale-95 transition group-hover:opacity-100 group-hover:scale-100">
                Descargar plantilla
              </span>
            </div>

            <!-- Importar Excel -->
            <div class="relative group">
              <input
                type="file"
                id="excelFileInput"
                accept=".xlsx,.xls"
                class="hidden"
                onchange="handleExcelImport(this.files)"
              >
              <button
                onclick="document.getElementById('excelFileInput').click()"
                aria-label="Importar Excel"
                class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-green-600 text-white hover:bg-green-700
                       transition focus:outline-none focus:ring-2 focus:ring-green-400">
                <i class="fas fa-file-excel"></i>
              </button>

              <span
                class="
        pointer-events-none
        absolute -top-9 left-1/2 -translate-x-1/2
        whitespace-nowrap
        rounded-md
        bg-gray-800 text-white text-xs
        px-2 py-1
        opacity-0 scale-95
        transition
        group-hover:opacity-100 group-hover:scale-100
      "
              >
      Importar Excel
    </span>
            </div>

            <!-- Exportar Excel -->
            <div class="relative group">
              <button
                onclick="exportToExcel()"
                aria-label="Exportar Excel"
                class="
        inline-flex items-center justify-center
        w-10 h-10 rounded-xl
        bg-blue-600 text-white
        hover:bg-blue-700
        transition
        focus:outline-none focus:ring-2 focus:ring-blue-400
      "
              >
                <i class="fas fa-file-export"></i>
              </button>

              <span
                class="
        pointer-events-none
        absolute -top-9 left-1/2 -translate-x-1/2
        whitespace-nowrap
        rounded-md
        bg-gray-800 text-white text-xs
        px-2 py-1
        opacity-0 scale-95
        transition
        group-hover:opacity-100 group-hover:scale-100
      "
              >
      Exportar Excel
    </span>
            </div>

          </div>

        </div>

        <div class="bg-white rounded-xl p-6 shadow-lg">
          <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-xl text-gray-700">Gestión de Notas</h3>
            <div class="text-sm text-gray-500">
              <span id="studentCount">{{count($registros)}} alumnos</span>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-800 text-white">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">CUI</th>
                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Nombre</th>


                <th
                  class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider bg-blue-100 text-blue-800">
                  Parcial 1
                </th>
                <th
                  class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider bg-green-100 text-green-800">
                  Continua 1
                </th>

                <th
                  class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider bg-blue-100 text-blue-800">
                  Parcial 2
                </th>
                <th
                  class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider bg-green-100 text-green-800">
                  Continua 2
                </th>

                <th
                  class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider bg-blue-100 text-blue-800">
                  Parcial 3
                </th>
                <th
                  class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider bg-green-100 text-green-800">
                  Continua 3
                </th>
                <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider bg-red-100 text-red-800">
                  Sustitutorio
                </th>


                <th
                  class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider bg-purple-100 text-purple-800">
                  Promedio
                </th>


                <th
                  class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider bg-gray-100 text-gray-800">
                  Estado
                </th>
              </tr>
              </thead>
              <tbody id="gradeTableBody" class="bg-white divide-y divide-gray-200 text-sm">
              @foreach($registros as $registro)
                <tr class="${index % 2 === 0 ? 'bg-gray-50' : 'bg-white'} hover:bg-blue-50">
                  <td class="px-4 py-3 whitespace-nowrap font-medium cui">{{$registro['alumno_id']}}</td>
                  <td class="px-4 py-3 whitespace-nowrap">{{$registro['nombre']}}</td>

                  <!-- Parciales -->
                  <td class="px-4 py-3 whitespace-nowrap text-center">
                    <input type="number" min="0" max="20" step="1"
                           value="{{$registro['parcial'][0]}}"
                           data-id="{{$registro['registro_id']}}"
                           data-type="parcial1"
                           class="w-16 p-1 border rounded text-center grade-input"
                    >
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap text-center">
                    <input type="number" min="0" max="20" step="1"
                           value="{{$registro['continua'][0]}}"
                           data-id="{{$registro['registro_id']}}"
                           data-type="continua1"
                           class="w-16 p-1 border rounded text-center grade-input"
                    >
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap text-center">
                    <input type="number" min="0" max="20" step="1"
                           value="{{$registro['parcial'][1]}}"
                           data-id="{{$registro['registro_id']}}"
                           data-type="parcial2"
                           class="w-16 p-1 border rounded text-center grade-input"
                    >
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap text-center">
                    <input type="number" min="0" max="20" step="1"
                           value="{{$registro['continua'][1]}}"
                           data-id="{{$registro['registro_id']}}"
                           data-type="continua2"
                           class="w-16 p-1 border rounded text-center grade-input"
                    >
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap text-center">
                    <input type="number" min="0" max="20" step="1"
                           value="{{$registro['parcial'][2]}}"
                           data-id="{{$registro['registro_id']}}"
                           data-type="parcial3"
                           class="w-16 p-1 border rounded text-center grade-input"
                    >
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap text-center">
                    <input type="number" min="0" max="20" step="1"
                           value="{{$registro['continua'][2]}}"
                           data-id="{{$registro['registro_id']}}"
                           data-type="continua3"
                           class="w-16 p-1 border rounded text-center grade-input"
                    >
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap text-center">
                    <input type="number" min="0" max="20" step="1"
                           value="{{$registro['sustitutorio']}}"
                           data-id="{{$registro['registro_id']}}"
                           data-type="sustitutorio"
                           class="w-16 p-1 border rounded text-center grade-input"
                    >
                  </td>

                  <!-- Promedio (calculado) -->
                  <td class="px-4 py-3 whitespace-nowrap text-center font-bold">
                    <span class="average-display" data-id="{{$registro['registro_id']}}"></span>
                  </td>

                  <!-- Estado -->
                  <td class="px-4 py-3 whitespace-nowrap text-center">
                  <span class="px-3 py-1 rounded-full text-xs font-medium estado-display" data-id="{{$registro['registro_id']}}">
                  </span>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>


          <div class="mt-6 flex justify-between items-center">
            <div class="text-sm text-gray-500">
              <span id="saveStatus">Sin cambios por guardar</span>
            </div>
            <div class="flex gap-3">
              <button onclick="saveAllGrades()"
                      class="px-5 py-2 rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 transition">
                <i class="fas fa-save mr-2"></i> Guardar
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>

  @vite('resources/js/docente/libreta.js')
</x-header_layout>
