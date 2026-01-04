<x-header_layout>
  <x-teacher.sidebar></x-teacher.sidebar>

  <main class="flex-1 p-4">
    <div class="bg-white rounded-xl p-6 shadow-lg">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Temas del Curso</h2>

      @if(session('success'))
        <div class="text-sm text-green-600 mb-2">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="text-sm text-red-600 mb-2">{{ session('error') }}</div>
      @endif

      <div class="mb-4">
        <form action="{{ route('teacher.temas.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-2">
          @csrf
          <input type="hidden" name="grupo" value="{{ $grupo }}" />
          <label class="block text-xs text-gray-600">Archivo (pdf/doc/docx/zip/txt)</label>
          <input type="file" name="tema" accept=".pdf,.doc,.docx,.zip,.txt" class="w-full text-sm" />
          <div class="mt-2">
            <button class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">Subir Tema</button>
            <a href="{{ route('teacher.index') }}" class="ml-2 text-sm text-gray-600 hover:underline">Volver</a>
          </div>
        </form>
      </div>

      <h3 class="font-bold text-lg text-gray-700 mb-2">Archivos</h3>
      <ul class="space-y-2">
        @forelse($files as $f)
          <li class="flex justify-between items-center p-2 border rounded">
            <div>
              <div class="font-medium">{{ $f['original_name'] ?? $f['name'] }}</div>
              <div class="text-xs text-gray-500">{{ number_format(($f['size'] ?? 0) / 1024, 2) }} KB</div>
            </div>
            <div class="space-x-2">
              <a href="{{ route('teacher.temas.download', ['grupo' => $grupo, 'file' => urlencode($f['name'])]) }}" class="px-2 py-1 bg-gray-100 rounded text-sm">Descargar</a>
            </div>
          </li>
        @empty
          <li class="text-sm text-gray-500">No hay archivos para este curso.</li>
        @endforelse
      </ul>
    </div>
  </main>
</x-header_layout>