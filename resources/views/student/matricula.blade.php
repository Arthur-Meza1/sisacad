<x-header_layout>
  <x-student.sidebar></x-student.sidebar>

  <main class="flex-1 p-4">
    <div id="view-enrollment" class="view-content space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Matrícula de Laboratorios</h2>
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-lg">
          <h3 class="font-bold text-xl text-gray-700 mb-4">Laboratorios Disponibles</h3>
          <div id="availableLabsList" class="space-y-3">
            @forelse($cupos as $cupo)
              <form method="POST" action="/api/student/matricular">
                @csrf
                <input name="id" value="{{$cupo['id']}}" hidden>
                <div class="flex justify-between items-center p-3 border rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                  <div>
                    <p class="font-medium text-gray-800">{{$cupo['nombre']}} - {{ucfirst($cupo['tipo'])}}</p>
                    <p class="text-xs text-gray-500">Turno: {{$cupo['turno']}} | Docente: {{$cupo['docente']}}</p>
                  </div>
                  <button type="submit" class="px-3 py-1 text-sm rounded-full bg-indigo-500 text-white hover:bg-indigo-600 transition">
                    Matricular
                  </button>
                </div>
              </form>
            @empty
              <p class="text-gray-500 mt-4">No hay laboratorios disponibles para matricular.</p>
            @endforelse
          </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-lg">
          <h3 class="font-bold text-xl text-gray-700 mb-4 text-indigo-600">Mi Matrícula Actual</h3>
          <div id="enrolledLabsList" class="space-y-3">
            @forelse($labs as $lab)
              <form method="POST" action="/api/student/desmatricular">
                @csrf
                <input name="id" value="{{$lab['id']}}" hidden>
                <div class="flex justify-between items-center p-3 border border-indigo-200 rounded-lg bg-indigo-50">
                  <div>
                    <p class="font-medium text-indigo-700">{{$lab['nombre']}} - {{ucfirst($lab['tipo'])}}</p>
                    <p class="text-xs text-indigo-400">Turno: {{$lab['turno']}} | Docente: {{$lab['docente']}}}</p>
                  </div>
                  <button onclick="removeEnrollment({{$lab['id']}})" class="text-xs px-3 py-1 rounded-full border border-red-400 text-red-600 hover:bg-red-100 transition">
                    Quitar
                  </button>
                </div>
              </form>
            @empty
              <p class="text-gray-500 text-sm">Aún no has matriculado laboratorios.</p>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </main>

  @vite(['resources/js/alumno/labs.js'])
</x-header_layout>
