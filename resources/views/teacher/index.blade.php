<x-header_layout>
  <x-teacher.sidebar></x-teacher.sidebar>

  <main class="flex-1 p-4">
    <div id="view-dashboard" class="view-content space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Resumen de Cursos</h2>
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-lg">
          <h3 class="font-bold text-lg text-gray-700 mb-3">Mis Cursos Asignados</h3>
          <div id="teacherCourseList" class="space-y-2 text-sm">
            @foreach($grupos as $grupo)
              <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                <div>
                  <span class="font-medium text-indigo-700">{{$grupo['nombre']}} ({{$grupo['turno']}}) - {{ucfirst($grupo['tipo'])}}</span>
                  <div class="text-xs mt-1">
                    <a href="{{ route('teacher.temas.index', ['grupo' => $grupo['id'] ?? ($grupo['grupo_id'] ?? 0)]) }}" class="text-indigo-600 hover:underline">Temas</a>
                    <span class="text-gray-400 mx-1">|</span>
                    <a href="{{ route('teacher.libreta.editor', ['grupo' => $grupo['id'] ?? ($grupo['grupo_id'] ?? 0)]) }}" class="text-gray-600 hover:underline">Libreta</a>
                  </div>
                </div>
                <span class="text-xs text-gray-500">Alumnos: {{$grupo['cantidad']}}</span>
              </div>
            @endforeach
          </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-lg">
          <h3 class="font-bold text-lg text-gray-700 mt-5 mb-3">Sílabo</h3>
          <div class="mt-2">
            @if(session('success'))
              <div class="text-sm text-green-600 mb-2">{{ session('success') }}</div>
            @endif
            @if(session('error'))
              <div class="text-sm text-red-600 mb-2">{{ session('error') }}</div>
            @endif
            <form action="{{ route('teacher.silabo.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-2">
              @csrf
              <label class="block text-xs text-gray-600">Seleccionar Curso</label>
              <select name="grupo" class="w-full border rounded p-2 text-sm">
                @foreach($grupos as $grupo)
                  <option value="{{$grupo['id'] ?? $grupo['grupo_id'] ?? ''}}">{{$grupo['nombre']}} ({{$grupo['turno']}})</option>
                @endforeach
              </select>
              <label class="block text-xs text-gray-600">Archivo (PDF, DOC, DOCX)</label>
              <input type="file" name="silabo" accept=".pdf,.doc,.docx" class="w-full text-sm" />
              <div class="flex items-center space-x-2">
                <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">Subir Sílabo</button>
                <div class="relative group">
                  <a
                    href="{{ route('teacher.silabo.download', ['grupo' => $grupos[0]['id'] ?? ($grupos[0]['grupo_id'] ?? 0)]) }}"
                    aria-label="Descargar sílabo"
                    class="inline-flex items-center justify-center w-7 h-7 rounded text-indigo-700 hover:bg-indigo-100
                       transition focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    <i class="fas fa-download"></i>
                  </a>
                  <span
                    class="pointer-events-none absolute -top-9 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-md bg-gray-800 text-white text-xs
                       px-2 py-1 opacity-0 scale-95 transition group-hover:opacity-100 group-hover:scale-100">
                    Descargar sílabo
                  </span>
                </div>

                <div class="relative group">
                  <a
                    href="{{route('teacher.silabo.plantilla')}}"
                    aria-label="Descargar plantilla"
                    class="inline-flex items-center justify-center w-7 h-7 rounded text-indigo-700 hover:bg-indigo-100
                       transition focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    <i class="fas fa-file-pdf"></i>
                  </a>
                  <span
                    class="pointer-events-none absolute -top-9 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-md bg-gray-800 text-white text-xs
                       px-2 py-1 opacity-0 scale-95 transition group-hover:opacity-100 group-hover:scale-100">
                    Descargar plantilla
                  </span>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</x-header_layout>
