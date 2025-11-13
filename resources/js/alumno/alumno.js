import $ from 'jquery';
import {loadAvailableCourses} from "./notas";

$(document).ready(function() {
  $('.nav-link').on('click', function() {
    let view = $(this).data('view');
    changeView(view);
  });
});

/*

Cursos
Necesitariamos ver el avance del curso
*/

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

  setTimeout(() => {
    if (viewId === 'grades') {
      loadAvailableCourses();
      //initGradeChart();
    }
    if (viewId === 'attendance') {
        initAttChart();
    }
    if (viewId === 'schedule') renderScheduleCalendar();
    if (viewId === 'enrollment') renderEnrollmentView();
  }, 50);
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

const colorMap = {
  'class': '#60a5fa',
  'lab': '#34d399',
  'lunch': '#fbbf24',
  'other': '#a78bfa'
};

function timeToHoursMinutesSeconds(minutes) {
  const hours = Math.floor(minutes / 60);
  const mins = minutes % 60;
  return `${hours.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:00`;
}

const fullCalendarEvents = rawScheduleData.map(item => {
  const startMin = item.hora * 60;
  const endMin = startMin + item.duracion;
  return {
    title: item.nombre,
    daysOfWeek: [dayMap[item.dia]],
    startTime: timeToHoursMinutesSeconds(startMin),
    endTime: timeToHoursMinutesSeconds(endMin),
    backgroundColor: colorMap[item.tipo],
    borderColor: colorMap[item.tipo],
  };
});

let fullCalendarInstance;

const gradeChartOptions = {
  title: { text: 'Rendimiento Final por Materia (Base 20)', left: 'center', textStyle: { color: '#333', fontSize: 16 } },
  xAxis: { type: 'category', data: subjects, axisLabel: { interval: 0, rotate: 30, color: '#666' } },
  yAxis: { type: 'value', min: 0, max: 20, interval: 5 },
  series: [{
    type: 'bar',
    data: grades.map(g => ({
      value: g,
      itemStyle: {
        borderRadius: [8, 8, 0, 0],
        color: g >= 14 ? '#10b981' : (g >= 11 ? '#f59e0b' : '#ef4444')
      }
    })),
    barWidth: '50%',
    markLine: {
      data: [{ name: 'Aprobado (11)', yAxis: 11, lineStyle: { type: 'dashed', color: '#4338ca', width: 2 } }]
    }
  }],
  tooltip: {
    trigger: 'axis',
    formatter: (params) => {
      const grade = params[0].value;
      const status = grade >= 11 ? 'APROBADO' : 'DESAPROBADO';
      return `<strong>${params[0].name}</strong><br/>Nota: ${grade}<br/>Estado: ${status}`;
    }
  },
  grid: { left: 50, right: 30, bottom: 60 }
};

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


function renderScheduleCalendar() {
  const calendarEl = document.getElementById('calendarContainer');
  if (!calendarEl) return;

  if (fullCalendarInstance && typeof fullCalendarInstance.destroy === 'function') {
    fullCalendarInstance.destroy();
  }

  fullCalendarInstance = new FullCalendar.Calendar(calendarEl, {
    initialView: 'timeGridWeek',
    slotMinTime: '07:00:00',
    slotMaxTime: '20:00:00',
    weekends: false,
    allDaySlot: false,
    nowIndicator: true,
    height: 'auto',
    locale: 'es',
    selectable: true,
    editable: true,
    selectMirror: true,

    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'timeGridWeek,timeGridDay'
    },

    events: fullCalendarEvents,

    select: function (info) {
      const title = prompt('Nombre del evento:');
      if (title) {
        fullCalendarInstance.addEvent({
          title,
          start: info.start,
          end: info.end,
          allDay: info.allDay,
          backgroundColor: '#60a5fa',
          borderColor: '#3b82f6'
        });
      }
      fullCalendarInstance.unselect();
    },

    eventDrop: function (info) {
      alert(`Evento "${info.event.title}" movido a ${info.event.start.toLocaleString()}`);
    },

    eventResize: function (info) {
      alert(`Evento "${info.event.title}" ajustado: termina ${info.event.end.toLocaleString()}`);
    },

    eventClick: function (info) {
      if (confirm(`¿Eliminar evento "${info.event.title}"?`)) {
        info.event.remove();
      }
    },

    eventDidMount: function (info) {
      info.el.style.fontSize = '0.85rem';
      info.el.style.padding = '3px';
    }
  });

  fullCalendarInstance.render();
}


window.addEventListener('resize', () => {
  if (gradeChartDetail) gradeChartDetail.resize();
  if (attChartDetail) attChartDetail.resize();
});

document.addEventListener('DOMContentLoaded', () => {
  changeView('dashboard');
  renderEnrollmentView();
});
