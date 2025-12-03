import $ from 'jquery';
import {
  loadScheduleCalendar,
  openScheduleModal,
  closeScheduleModal,
  saveNewScheduleEvent,
  updateEventButtonState
} from "./calendario.js";
import {loadAnalyticsView} from "./notas.js";


$(document).ready(function() {
  $('.nav-link').on('click', function() {
    let view = $(this).data('view');
    changeView(view);
  });
});

let currentView = 'dashboard';
function changeView(viewId) {
  if (currentView === viewId) return;

  const views = document.querySelectorAll('.view-content');
  const navLinks = document.querySelectorAll('.nav-link');

  views.forEach(view => view.classList.add('hidden'));
  const targetView = document.getElementById(`view-${viewId}`);
  if (targetView) targetView.classList.remove('hidden');

  navLinks.forEach(link => {
    if (link.dataset.view === viewId) {
      link.classList.add('active-link');
      link.classList.remove('inactive-link');
    } else {
      link.classList.remove('active-link');
      link.classList.add('inactive-link');
    }
  });

  currentView = viewId;

  //if (viewId === 'dashboard') initDashboardView();
  //if (viewId === 'grades-input') initGradeInputView();
  if (viewId === 'schedule') loadScheduleCalendar();
  /*
  if (viewId === 'students') initStudentsView();
  */
}

window.updateEventButtonState = updateEventButtonState;
window.openScheduleModal = openScheduleModal;
window.closeScheduleModal = closeScheduleModal;
window.saveNewScheduleEvent = saveNewScheduleEvent;
window.selectCourseForManagement = function (courseId, courseName) {
  const cardsSection = document.getElementById('courseCardSelector');
  const managementPanels = document.getElementById('courseManagementPanels');
  const courseSelectGrades = document.getElementById('courseSelectGrades');
  const currentCourseNameAtt = document.getElementById('currentCourseNameAtt');
  const currentCourseNameGrades = document.getElementById('currentCourseNameGrades');
  const unitGradePanel = document.getElementById('unitGradePanel');

  if (!cardsSection || !managementPanels || !courseSelectGrades) return;

  // Ocultar el panel de edición de notas (si estaba abierto)
  if (unitGradePanel) unitGradePanel.classList.add('hidden');

  // 1. Ocultar el selector de tarjetas
  cardsSection.classList.add('hidden');

  // 2. Mostrar los paneles de gestión (Notas y Asistencia)
  managementPanels.classList.remove('hidden');

  // 3. Actualizar el indicador de curso en los títulos
  courseSelectGrades.innerHTML = `<option value="${courseId}" selected>${courseName}</option>`;
  currentCourseNameAtt.textContent = courseName;
  currentCourseNameGrades.textContent = courseName;

  // 4. Inicializar los botones de unidad y la lista de asistencia
  // initUnitButtons(courseId);
}

window.backToCourseSelection = function() {
  const cardsSection = document.getElementById('courseCardSelector');
  const managementPanels = document.getElementById('courseManagementPanels');
  const unitGradePanel = document.getElementById('unitGradePanel');

  if (!cardsSection || !managementPanels) return;

  // 1. Ocultar el panel de edición de notas (por si estaba visible)
  if (unitGradePanel) unitGradePanel.classList.add('hidden');

  // 2. Ocultar los paneles de gestión
  managementPanels.classList.add('hidden');

  // 3. Mostrar el selector de tarjetas
  cardsSection.classList.remove('hidden');

  document.getElementById('attendanceTableBody').innerHTML = '';
  document.getElementById('unitButtonsContainer').innerHTML = '';
}

function initUnitButtons(courseId) {
  console.log(`Cargando unidades para el curso: ${courseId}`);

  const panel = document.getElementById('unitGradePanel');
  if (panel) panel.classList.add('hidden');

  // 1. Generar los botones de Unidad (U1, U2, U3)
  const unitButtonsContainer = document.getElementById('unitButtonsContainer');
  if (unitButtonsContainer) {

    // Mapeo de colores simple para los botones de unidad
    const UNIT_BUTTON_CONFIG = {
      'U1': { color: 'bg-indigo-600 hover:bg-indigo-700' },
      'U2': { color: 'bg-green-600 hover:bg-green-700' },
      'U3': { color: 'bg-purple-600 hover:bg-purple-700' },
    };

    unitButtonsContainer.innerHTML = Object.keys(UNIT_MAP).map(unitId => {
      const gradeTypes = UNIT_MAP[unitId].join(', ');
      const config = UNIT_BUTTON_CONFIG[unitId] || { color: 'bg-gray-600 hover:bg-gray-700' };

      return `
                <button onclick="showUnitGradePanel('${unitId}')"
                        class="unit-btn px-6 py-3 rounded-lg text-sm font-medium text-white ${config.color} transition">
                    ${unitId} (${gradeTypes})
                </button>
            `;
    }).join('');
  }

  // renderAttendancePanel(courseId);
}

function renderAttendancePanel(courseId) {
  const studentList = allStudents[courseId] || [];
  const attendancePanel = document.getElementById('attendancePanel');
  const tbody = document.getElementById('attendanceTableBody');

  if (studentList.length === 0) {
    if (attendancePanel) attendancePanel.classList.add('hidden');
    return;
  }

  if (attendancePanel) attendancePanel.classList.remove('hidden');

  tbody.innerHTML = studentList.map(student => `
        <tr data-id="${student.id}">
            <td class="px-3 py-2 whitespace-nowrap font-mono text-xs">${student.id}</td>
            <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-900">${student.name}</td>
            <td class="px-3 py-2 whitespace-nowrap text-center">
                <input type="checkbox" data-id="${student.id}"
                       class="h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500 attendance-checkbox"
                       ${student.currentAtt ? 'checked' : ''}>
                <span class="ml-2 text-sm text-gray-600 ${student.currentAtt ? '' : 'text-red-600'}">${student.currentAtt ? 'Presente' : 'Ausente'}</span>
            </td>
        </tr>
    `).join('');

  tbody.querySelectorAll('.attendance-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', (e) => {
      const span = e.target.nextElementSibling;
      if (e.target.checked) {
        span.textContent = 'Presente';
        span.classList.remove('text-red-600');
        span.classList.add('text-gray-600');
      } else {
        span.textContent = 'Ausente';
        span.classList.remove('text-gray-600');
        span.classList.add('text-red-600');
      }
    });
  });
}
