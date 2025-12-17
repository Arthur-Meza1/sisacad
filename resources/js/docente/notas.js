import {ContentLoader} from "../common/ContentLoader.js";

window.loadAnalyticsView =  (self, id) => {
  document.querySelectorAll('.course-button').forEach(btn => {
    btn.classList.remove('bg-indigo-600', 'text-white');
    btn.classList.add('text-gray-600', 'hover:bg-indigo-100', 'hover:text-indigo-700');
  });


  self.classList.add('bg-indigo-600', 'text-white');
  self.classList.remove('text-gray-600', 'hover:bg-indigo-100', 'hover:text-indigo-700');

  new ContentLoader({
    url: `/api/teacher/grupo/${id}/notas`,
    containerName: "#studentButtonsContainer"
  }).load(renderGradeChart);
};

let gradeChartInstance;

function renderGradeChart(data, container) {
  console.log(data);

  const chartTitleElement = document.getElementById('chartTitle');
  const chartMessageElement = document.getElementById('chartMessage');
  const chartCanvas = document.getElementById('gradeChart');

  const studentButtonsContainer = document.getElementById('studentButtonsContainer'); //El contenedor de alumnos
  studentButtonsContainer.innerHTML = '';
  const avgButton = document.createElement('button');
  avgButton.className = 'w-full text-left p-3 rounded-lg bg-indigo-600 text-white transition duration-150 active-analysis';
  avgButton.textContent = 'Promedio General del Curso';
  studentButtonsContainer.appendChild(avgButton);
  // 2. Crear botones para cada estudiante
  data.forEach(student => {
    const studentButton = document.createElement('button');
    // Usamos un estilo distinto para diferenciar estudiantes del promedio
    studentButton.className = 'w-full text-left p-3 rounded-lg text-gray-600 hover:bg-green-100 hover:text-green-700 transition duration-150 student-button';
    studentButton.textContent = student.nombre;
    // studentButton.dataset.studentId = student.id;

    studentButton.addEventListener('click', () => {
      // Lógica para activar/desactivar el botón (manejo de estilos)
      document.querySelectorAll('#studentButtonsContainer button').forEach(btn => {
        btn.classList.remove('bg-indigo-600', 'text-white', 'bg-green-600');
        btn.classList.add('text-gray-600');
        if (btn.textContent === 'Promedio General del Curso') {
          btn.classList.add('hover:bg-indigo-100', 'hover:text-indigo-700');
        } else {
          btn.classList.add('hover:bg-green-100', 'hover:text-green-700');
        }
      });
      studentButton.classList.add('bg-green-600', 'text-white');
      studentButton.classList.remove('text-gray-600', 'hover:bg-green-100', 'hover:text-green-700');

      // TODO: (Esdras) falta implementar esto, mergear de la rama 'estadistica-notas-docente'
      renderStudentChart(student); // Renderiza el gráfico individual
    });
    studentButtonsContainer.appendChild(studentButton);
  });

  chartMessageElement.classList.add('hidden');
  chartCanvas.classList.remove('hidden');

  if (gradeChartInstance) {
    gradeChartInstance.destroy();
  }

  chartTitleElement.textContent = "Promedio General del Curso";
}
