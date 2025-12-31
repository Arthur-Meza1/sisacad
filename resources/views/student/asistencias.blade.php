<x-header_layout>
  <x-student.sidebar></x-student.sidebar>

  <main class="flex-1 p-4">
    <div id="view-attendance" class="view-content space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Asistencia</h2>
      <div class="bg-white rounded-xl p-6 shadow-lg">
        <h3 class="font-bold text-lg text-gray-700 mb-3">Tabla de Asistencia</h3>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materia</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asistencia (%)</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Faltas</th>
          </tr>
          </thead>
          <tbody id="attendanceTableBody" class="bg-white divide-y divide-gray-200 text-sm">
          </tbody>
        </table>
      </div>
    </div>
  </main>
</x-header_layout>
