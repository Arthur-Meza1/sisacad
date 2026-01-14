import {ContentLoader} from "../common/ContentLoader.js";
import {createBoxPlotFromData} from "./plots/boxplot.js";
import {createScatterPlotFromData} from "./plots/scatter.js";
import {createBarsFromContinua, createBarsFromParcial} from "./plots/histograma.js";
import {createArrowsFromStudents} from "./plots/flechas.js";

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

function renderGradeChart(data, container) {
  initializeGradeButtons(data, data); // Pasar los datos globales

  const chart1 = document.getElementById("gradeChart1");
  const chart2 = document.getElementById("gradeChart2");
  const chart3 = document.getElementById("gradeChart3");
  const chart4 = document.getElementById("gradeChart4");

  createBoxPlotFromData(data, chart1);
  createScatterPlotFromData(data, chart2);
  createBarsFromParcial(data, chart3);
  createBarsFromContinua(data, chart4);

  // Mostrar los gráficos del curso
  document.getElementById('courseChartsContainer').classList.remove('hidden');
  document.getElementById('studentChartsContainer').classList.add('hidden');
  document.getElementById('chartTitle').textContent = 'Análisis General del Curso';
}

function initializeGradeButtons(data, allData) {
  const studentButtonsContainer = document.getElementById('studentButtonsContainer'); //El contenedor de alumnos
  studentButtonsContainer.innerHTML = '';
  const avgButton = document.createElement('button');
  avgButton.className = 'w-full text-left p-3 rounded-lg bg-indigo-600 text-white transition duration-150 active-analysis font-medium';
  avgButton.textContent = 'Promedio General del Curso';
  avgButton.addEventListener('click', () => {
    // Mostrar gráficos del curso
    document.getElementById('courseChartsContainer').classList.remove('hidden');
    document.getElementById('studentChartsContainer').classList.add('hidden');
    document.getElementById('chartTitle').textContent = 'Análisis General del Curso';

    // Actualizar estilos de botones
    document.querySelectorAll('#studentButtonsContainer button').forEach(btn => {
      btn.classList.remove('bg-indigo-600', 'text-white', 'bg-green-600');
      btn.classList.add('text-gray-600');
      if (btn.textContent === 'Promedio General del Curso') {
        btn.classList.add('hover:bg-indigo-100', 'hover:text-indigo-700');
      } else {
        btn.classList.add('hover:bg-green-100', 'hover:text-green-700');
      }
    });
    avgButton.classList.add('bg-indigo-600', 'text-white');
    avgButton.classList.remove('text-gray-600', 'hover:bg-indigo-100', 'hover:text-indigo-700');
  });
  studentButtonsContainer.appendChild(avgButton);

  // 2. Crear botones para cada estudiante
  data.forEach((student, index) => {
    const studentButton = document.createElement('button');
    // Usamos un estilo distinto para diferenciar estudiantes del promedio
    studentButton.className = 'w-full text-left p-3 rounded-lg text-gray-600 hover:bg-green-100 hover:text-green-700 transition duration-150 student-button font-medium';
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

      renderStudentChart(student, index, allData); // Renderiza el gráfico individual
    });
    studentButtonsContainer.appendChild(studentButton);
  });
}

function renderStudentChart(student, studentIndex, allData) {
  // Ocultar gráficos del curso y mostrar gráficos del alumno
  document.getElementById('courseChartsContainer').classList.add('hidden');
  document.getElementById('studentChartsContainer').classList.remove('hidden');

  // Actualizar título
  document.getElementById('chartTitle').textContent = `Análisis Detallado: ${student.nombre}`;

  // Obtener contenedores de gráficos del alumno
  const chart1 = document.getElementById("studentChart1");
  const chart2 = document.getElementById("studentChart2");

  // Crear gráfico de flechas (líneas de evolución personal)
  createArrowsFromStudents(allData, studentIndex, chart1);

  // Crear segundo gráfico: podrías usar scatter solo del alumno o un gráfico comparativo
  // Por ahora, vamos a mostrar un box plot con el alumno destacado
  createBoxPlotFromData(allData, chart2);
}
