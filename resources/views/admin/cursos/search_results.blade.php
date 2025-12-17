<x-header_layout>
  <x-admin.sidebar/>

  <div class="p-6 space-y-8 w-full">
    <h2 class="text-3xl font-semibold text-gray-800">Buscar Cursos</h2>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-4">
      <p class="text-gray-500 text-sm">
        Ingresa un nombre para buscar cursos.
      </p>
      <form action="{{ route('admin.cursos.search') }}" method="GET" class="flex items-center gap-3">
        <input
          type="text"
          name="query"
          value="{{request('query')}}"
          placeholder="Buscar usuarios..."
          class="border border-gray-300 rounded-lg px-4 py-2 w-80 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
          required
        >

        <button
          class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm shadow-sm transition">
          Buscar
        </button>
      </form>
    </div>

    <h3 class="text-3 font-semibold text-gray-800">Resultados: {{count($results)}}</h3>

    @forelse($results as $curso)
      <x-admin.course_card :curso="$curso"/>
    @empty
      <div class="text-center text-gray-500 py-12">
        No se han encontrado resultados.
      </div>
    @endforelse
  </div>
</x-header_layout>
