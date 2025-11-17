import $ from 'jquery';
import {loadAvailableCourses} from "./notas";
import {loadScheduleCalendar} from "./calendario";

$(document).ready(function() {
  $('.nav-link').on('click', function() {
    let view = $(this).data('view');
    changeView(view);
  });
});

const grades = [12, 14, 9, 13, 16, 17];
const attData = [90, 80, 95, 100, 85, 92];
const subjects = ['Matemáticas', 'Física', 'Programación', 'Inglés', 'Sistemas', 'Lab. Avanzado'];
const courseList = subjects.map((name, i) => ({ name, grade: grades[i], attendance: attData[i] }));

const today = new Date();
const todayISO = today.toISOString().slice(0, 10);
const tomorrow = new Date(today);
tomorrow.setDate(today.getDate() + 1);
const tomorrowISO = tomorrow.toISOString().slice(0, 10);


const availableLabs = [
    { name: 'Lab. de Circuitos I', code: 'ELEC-205', id: 1 },
    { name: 'Lab. de Química Avanzada', code: 'QUIM-310', id: 2 },
    { name: 'Lab. de Base de Datos', code: 'COMP-201', id: 3 },
    { name: 'Lab. de Redes y Telecomunicaciones', code: 'TELE-401', id: 4 }
];
let enrolledLabs = [
    { name: 'Lab. de Circuitos I', code: 'ELEC-205', id: 1 }
];


let currentView = 'dashboard';
const views = document.querySelectorAll('.view-content');
const navLinks = document.querySelectorAll('.nav-link');

function changeView(viewId) {
  if (currentView === viewId) return;

  views.forEach(view => view.classList.add('hidden'));
  document.getElementById(`view-${viewId}`).classList.remove('hidden');

  navLinks.forEach(link => {
    if (link.dataset.view === viewId) {
      link.classList.remove('inactive-link');
      link.classList.add('active-link');
    } else {
      link.classList.remove('active-link');
      link.classList.add('inactive-link');
    }
  });

  currentView = viewId;

  if (viewId === 'grades') {
    loadAvailableCourses();
  }
  if (viewId === 'attendance') {
      initAttChart();
  }
  if (viewId === 'schedule') loadScheduleCalendar();
  if (viewId === 'enrollment') renderEnrollmentView();
}

// Inicialización de Gráficos (Global)
function initAttChart() {
    if (!attChartDetail) {
        attChartDetail = echarts.init(document.getElementById('attChartDetail'));
        attChartDetail.setOption(attChartOptions);
    }
    attChartDetail.resize();
}


const avg = (grades.reduce((a, b) => a + b, 0) / grades.length).toFixed(2);
document.getElementById('avgGrade').textContent = avg;
document.getElementById('attSummary').textContent = Math.round(attData.reduce((a, b) => a + b, 0) / attData.length) + '%';
document.getElementById('activities').innerHTML = ['Inscripción a Laboratorio', 'Entrega: Tarea 3', 'Foro: Consultas']
  .map(a => `<li class="text-gray-500">• ${a}</li>`)
  .join('');

document.getElementById('courseList').innerHTML = courseList.map(c => `
  <div class="flex justify-between items-center p-2 border-b hover:bg-gray-50 rounded-md">
    <span class="font-medium">${c.name}</span>
    <span class="text-xs text-gray-500">Nota: ${c.grade} | Asistencia: ${c.attendance}%</span>
  </div>
`).join('');
function renderEnrollmentView() {
    renderAvailableLabs();
    renderEnrolledLabs();
}

function renderAvailableLabs() {
    const listContainer = document.getElementById('availableLabsList');
    const availableToEnroll = availableLabs.filter(lab =>
        !enrolledLabs.some(eLab => eLab.id === lab.id)
    );

    if (availableToEnroll.length === 0) {
        listContainer.innerHTML = '<p class="text-gray-500 mt-4">No hay laboratorios disponibles para matricular.</p>';
        return;
    }

    listContainer.innerHTML = availableToEnroll.map(lab => `
        <div class="flex justify-between items-center p-3 border rounded-lg bg-gray-50 hover:bg-gray-100 transition">
            <div>
                <p class="font-medium text-gray-800">${lab.name}</p>
                <p class="text-xs text-gray-500">Código: ${lab.code}</p>
            </div>
            <button onclick="enrollLab(${lab.id})" class="px-3 py-1 text-sm rounded-full bg-indigo-500 text-white hover:bg-indigo-600 transition">
                Matricular
            </button>
        </div>
    `).join('');
}

function renderEnrolledLabs() {
    const listContainer = document.getElementById('enrolledLabsList');

    if (enrolledLabs.length === 0) {
        listContainer.innerHTML = '<p class="text-gray-500 text-sm">Aún no has matriculado laboratorios.</p>';
        return;
    }

    listContainer.innerHTML = enrolledLabs.map(lab => `
        <div class="flex justify-between items-center p-3 border border-indigo-200 rounded-lg bg-indigo-50">
            <div>
                <p class="font-medium text-indigo-700">${lab.name}</p>
                <p class="text-xs text-indigo-400">Código: ${lab.code}</p>
            </div>
            <button onclick="removeEnrollment(${lab.id})" class="text-xs px-3 py-1 rounded-full border border-red-400 text-red-600 hover:bg-red-100 transition">
                Quitar
            </button>
        </div>
    `).join('');
}

function enrollLab(labId) {
    const labToEnroll = availableLabs.find(lab => lab.id === labId);
    if (labToEnroll && !enrolledLabs.some(lab => lab.id === labId)) {
        enrolledLabs.push(labToEnroll);
        alert(`¡${labToEnroll.name} ha sido matriculado con éxito!`);
        renderEnrollmentView();
    }
}

function removeEnrollment(labId) {
    const labToRemove = enrolledLabs.find(lab => lab.id === labId);
    if (confirm(`¿Estás seguro de quitar el laboratorio "${labToRemove.name}" de tu matrícula?`)) {
        enrolledLabs = enrolledLabs.filter(lab => lab.id !== labId);
        alert(`Matrícula para ${labToRemove.name} eliminada.`);
        renderEnrollmentView();
    }
}


const dayMap = {
  'Lunes': 1,
  'Martes': 2,
  'Miércoles': 3,
  'Jueves': 4,
  'Viernes': 5
};

const rawScheduleData = [
  { dia: 'Lunes', hora: 7, duracion: 120, nombre: 'Lab. Física (A102)', tipo: 'lab' },
  { dia: 'Lunes', hora: 10, duracion: 120, nombre: 'Clase: Programación (B301)', tipo: 'class' },
  { dia: 'Lunes', hora: 14, duracion: 120, nombre: 'Clase: Matemáticas (C401)', tipo: 'class' },
  { dia: 'Martes', hora: 9, duracion: 120, nombre: 'Clase: Sistemas (B302)', tipo: 'class' },
  { dia: 'Martes', hora: 17, duracion: 120, nombre: 'Clase: Inglés (A101)', tipo: 'class' },
  { dia: 'Miércoles', hora: 12, duracion: 120, nombre: 'Almuerzo', tipo: 'lunch' },
  { dia: 'Miércoles', hora: 16, duracion: 180, nombre: 'Lab. Avanzado (D203)', tipo: 'lab' },
  { dia: 'Jueves', hora: 8, duracion: 120, nombre: 'Clase: Física (C402)', tipo: 'class' },
  { dia: 'Jueves', hora: 15, duracion: 120, nombre: 'Reunión Grupo', tipo: 'other' },
  { dia: 'Viernes', hora: 7, duracion: 120, nombre: 'Tutoría', tipo: 'other' }
];

const attChartOptions = {
  title: { text: 'Tendencia de Asistencia por Curso (%)', left: 'center' },
  xAxis: { type: 'category', data: subjects, boundaryGap: false },
  yAxis: { type: 'value', min: 0, max: 100 },
  series: [{
    type: 'line',
    data: attData,
    smooth: true,
    lineStyle: { color: '#06b6d4', width: 3 },
    itemStyle: { color: '#06b6d4' },
    areaStyle: {
      color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
        { offset: 0, color: 'rgba(6, 182, 212, 0.4)' },
        { offset: 1, color: 'rgba(6, 182, 212, 0.0)' }
      ])
    }
  }],
  tooltip: { trigger: 'axis' },
  grid: { left: 50, right: 30, bottom: 80 },
  dataZoom: [{ type: 'slider', show: true, xAxisIndex: [0], start: 0, end: 100, bottom: 10 }]
};


document.getElementById('attendanceTableBody').innerHTML = courseList.map(c => {
  let faltas = Math.round((100 - c.attendance) / 10);
  let statusColor = c.attendance >= 85 ? 'text-green-600' : 'text-red-600';
  return `
    <tr>
      <td class="px-6 py-4 whitespace-nowrap">${c.name}</td>
      <td class="px-6 py-4 whitespace-nowrap"><span class="${statusColor}">${c.attendance}%</span></td>
      <td class="px-6 py-4 whitespace-nowrap">${faltas}</td>
    </tr>
  `;
}).join('');


window.addEventListener('resize', () => {
  if (gradeChartDetail) gradeChartDetail.resize();
  if (attChartDetail) attChartDetail.resize();
});

document.addEventListener('DOMContentLoaded', () => {
  changeView('dashboard');
  renderEnrollmentView();
});
