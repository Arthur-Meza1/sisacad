import $ from 'jquery';
import {ContentLoader} from "../common/ContentLoader.js";

let selectedCourseForGrades = null;
let hasUnsavedChanges = false;

export function handleCourseCardClick(courseId, courseName) {
  loadGradeTable(courseId, courseName);
}
window.handleCourseCardClick = handleCourseCardClick;

export function showCourseSelection() {
  if (hasUnsavedChanges) {
    if (!confirm('Tienes cambios sin guardar. ¿Seguro que quieres salir?')) {
      return;
    }
  }

  document.getElementById('courseManagementPanels').classList.add('hidden');
  document.getElementById('courseCardSelector').classList.remove('hidden');
  selectedCourseForGrades = null;
  hasUnsavedChanges = false;
  updateSaveStatus();

  document.querySelectorAll('.course-card-grades').forEach(card => {
    card.classList.remove('selected-card-active');
  });
}

window.showCourseSelection = showCourseSelection;

function renderCourseCardsForGrades() {
  const container = document.getElementById('courseCardsContainer');

  container.innerHTML = courses.map((c) => {
    const cardStyle = 'p-6 ' + gradientClasses + ' rounded-xl shadow-lg cursor-pointer hover:shadow-xl hover:scale-105 transition text-white';

    return `
          <div
            class="course-card-grades ${cardStyle}"
            data-courseid="${c.id}"
            onclick="handleCourseCardClick('${c.id}')"
          >
            <h3 class="text-xl font-bold mb-2">${c.name}</h3>
            <p class="text-sm opacity-90">${c.students} Alumnos</p>
            <p class="text-xs mt-2 opacity-80">Promedio: ${c.avgGrade}</p>
          </div>
        `;
  }).join('');

  // Estilo para tarjetas seleccionadas
  let style = document.getElementById('gradeCardStyle');
  if (!style) {
    style = document.createElement('style');
    style.id = 'gradeCardStyle';
    style.innerHTML = `
            .selected-card-active {
                box-shadow: 0 0 0 4px #60a5fa !important;
                opacity: 1 !important;
                transform: scale(1.05) !important;
            }
        `;
    document.head.appendChild(style);
  }
}

function loadGradeTable(courseId, courseName) {
  selectedCourseForGrades = courseId;

  document.getElementById('courseCardSelector').classList.add('hidden');
  document.getElementById('courseManagementPanels').classList.remove('hidden');

  document.getElementById('currentCourseTitle').textContent = `Curso: ${courseName}`;
  document.getElementById('currentCourseInfo').textContent =
    `Código: ${courseId}`;

  document.querySelectorAll('.course-card-grades').forEach(card => {
    if (card.dataset.courseid === courseId) {
      card.classList.add('selected-card-active');
    } else {
      card.classList.remove('selected-card-active');
    }
  });

  new ContentLoader({
    url: `/api/teacher/grupo/${courseId}/notas`,
    containerName: '#gradeTableBody'
  }).load(function(data, container) {
    renderGradeTable(data);
  });
}

function renderGradeTable(data) {
  const tbody = document.getElementById('gradeTableBody');

  document.getElementById('studentCount').textContent = `${data.length} alumnos`;

  tbody.innerHTML = data.map((student, index) => {
    const promedio = calculateStudentAverage(student);
    const estado = promedio >= 11 ? 'Aprobado' : 'Desaprobado';
    const estadoColor = promedio >= 11 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';

    return `
          <tr class="${index % 2 === 0 ? 'bg-gray-50' : 'bg-white'} hover:bg-blue-50">
            <td class="px-4 py-3 whitespace-nowrap font-medium">${student.id}</td>
            <td class="px-4 py-3 whitespace-nowrap">${student.nombre}</td>

            <!-- Parciales -->
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <input type="number" min="0" max="20" step="0.5"
                       value="${student.parcial[0] || ''}"
                       data-id="${student.id}"
                       data-type="parcial1"
                       class="w-16 p-1 border rounded text-center grade-input"
                       onchange="markAsChanged()">
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <input type="number" min="0" max="20" step="0.5"
                       value="${student.parcial[1] || ''}"
                       data-id="${student.id}"
                       data-type="parcial2"
                       class="w-16 p-1 border rounded text-center grade-input"
                       onchange="markAsChanged()">
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <input type="number" min="0" max="20" step="0.5"
                       value="${student.parcial[2] || ''}"
                       data-id="${student.id}"
                       data-type="parcial3"
                       class="w-16 p-1 border rounded text-center grade-input"
                       onchange="markAsChanged()">
            </td>

            <!-- Continuas -->
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <input type="number" min="0" max="20" step="0.5"
                       value="${student.continua[0] || ''}"
                       data-id="${student.id}"
                       data-type="continua1"
                       class="w-16 p-1 border rounded text-center grade-input"
                       onchange="markAsChanged()">
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <input type="number" min="0" max="20" step="0.5"
                       value="${student.continua[1] || ''}"
                       data-id="${student.id}"
                       data-type="continua2"
                       class="w-16 p-1 border rounded text-center grade-input"
                       onchange="markAsChanged()">
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <input type="number" min="0" max="20" step="0.5"
                       value="${student.continua[2] || ''}"
                       data-id="${student.id}"
                       data-type="continua3"
                       class="w-16 p-1 border rounded text-center grade-input"
                       onchange="markAsChanged()">
            </td>

            <!-- Sustitutorio -->
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <input type="number" min="0" max="20" step="0.5"
                       value="${student.sustitutorio || ''}"
                       data-id="${student.id}"
                       data-type="sustitutorio"
                       class="w-16 p-1 border rounded text-center grade-input"
                       onchange="markAsChanged()">
            </td>

            <!-- Promedio (calculado) -->
            <td class="px-4 py-3 whitespace-nowrap text-center font-bold">
                <span class="average-display" data-id="${student.id}">${promedio.toFixed(1)}</span>
            </td>

            <!-- Estado -->
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <span class="px-3 py-1 rounded-full text-xs font-medium ${estadoColor} estado-display" data-id="${student.id}">
                    ${estado}
                </span>
            </td>
          </tr>
        `;
  }).join('');

  hasUnsavedChanges = false;
  updateSaveStatus();
}

function calculateStudentAverage(student) {
  let parcial1 = student.parcial[0];
  let parcial2 = student.parcial[1];
  let parcial3 = student.parcial[2];
  let continua1 = student.continua[0];
  let continua2 = student.continua[1];
  let continua3 = student.continua[2];
  let sustitutorio = student.sustitutorio;

  sustitutorio = (sustitutorio === "" || sustitutorio === null || sustitutorio === undefined)
    ? NaN
    : Number(sustitutorio);

  if (!isNaN(sustitutorio)) {

    if (Number(parcial1) <= Number(parcial2)) {
      parcial1 = sustitutorio;
    } else {
      parcial2 = sustitutorio;
    }
  }

  const notas = [
    Number(parcial1),
    Number(parcial2),
    Number(parcial3),
    Number(continua1),
    Number(continua2),
    Number(continua3)
  ].filter(n => !isNaN(n));

  if (notas.length === 0) return 0;

  const suma = notas.reduce((total, n) => total + n, 0);
  return suma / notas.length;
}

function markAsChanged() {
  hasUnsavedChanges = true;
  updateSaveStatus();
}

function updateSaveStatus() {
  const statusElement = document.getElementById('saveStatus');
  if (hasUnsavedChanges) {
    statusElement.textContent = '⚠️ Tienes cambios sin guardar';
    statusElement.classList.add('text-red-600', 'font-medium');
    statusElement.classList.remove('text-gray-500');
  } else {
    statusElement.textContent = 'Sin cambios por guardar';
    statusElement.classList.remove('text-red-600', 'font-medium');
    statusElement.classList.add('text-gray-500');
  }
}

function calculateAverages() {
  const inputs = document.querySelectorAll('.grade-input');
  const studentData = {};

  inputs.forEach(input => {
    const studentId = input.dataset.id;
    const type = input.dataset.type;
    const value = parseFloat(input.value) || 0;

    if (!studentData[studentId]) {
      studentData[studentId] = {};
    }
    studentData[studentId][type] = value;
  });


  Object.keys(studentData).forEach(studentId => {
    const grades = studentData[studentId];
    const promedio = calculateStudentAverage(grades);


    const avgDisplay = document.querySelector(`.average-display[data-id="${studentId}"]`);
    if (avgDisplay) {
      avgDisplay.textContent = promedio.toFixed(1);
    }

    const estado = promedio >= 11 ? 'Aprobado' : 'Desaprobado';
    const estadoColor = promedio >= 11 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    const estadoDisplay = document.querySelector(`.estado-display[data-id="${studentId}"]`);
    if (estadoDisplay) {
      estadoDisplay.textContent = estado;
      estadoDisplay.className = `px-3 py-1 rounded-full text-xs font-medium ${estadoColor} estado-display`;
      estadoDisplay.setAttribute('data-id', studentId);
    }
  });

  alert('Promedios calculados exitosamente');
}

function saveAllGrades() {
  if (!selectedCourseForGrades) {
    alert('No hay un curso seleccionado');
    return;
  }

  const course = courses.find(c => c.id === selectedCourseForGrades);
  const inputs = document.querySelectorAll('.grade-input');
  const updates = [];

  inputs.forEach(input => {
    const studentId = input.dataset.id;
    const type = input.dataset.type;
    const value = parseFloat(input.value) || null;

    const studentList = allStudents[selectedCourseForGrades];
    const student = studentList.find(s => s.id == studentId);

    if (student && student.grades[type] !== value) {
      updates.push({
        studentId,
        name: student.name,
        type,
        oldValue: student.grades[type],
        newValue: value
      });

      student.grades[type] = value;
    }
  });

  console.log('Guardando notas para', course.name, ':', updates);

  calculateAverages();

  hasUnsavedChanges = false;
  updateSaveStatus();

  alert(`Notas guardadas exitosamente para ${course.name}`);
}

function handleExcelImport(files) {
  if (!files.length) return;

  const file = files[0];
  const reader = new FileReader();

  reader.onload = function(e) {
    const data = new Uint8Array(e.target.result);
    const workbook = XLSX.read(data, { type: 'array' });

    const firstSheetName = workbook.SheetNames[0];
    const worksheet = workbook.Sheets[firstSheetName];

    const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

    importGradesFromExcel(jsonData);
  };

  reader.readAsArrayBuffer(file);
}

function importGradesFromExcel(data) {
  if (!selectedCourseForGrades) {
    alert('Selecciona un curso primero');
    return;
  }

  const studentList = allStudents[selectedCourseForGrades];
  let importedCount = 0;

  for (let i = 1; i < data.length; i++) {
    const row = data[i];
    if (!row || row.length < 9) continue;

    const studentId = parseInt(row[0]);
    const student = studentList.find(s => s.id === studentId);

    if (student) {
      student.grades.parcial1 = parseFloat(row[2]) || student.grades.parcial1;
      student.grades.parcial2 = parseFloat(row[3]) || student.grades.parcial2;
      student.grades.parcial3 = parseFloat(row[4]) || student.grades.parcial3;
      student.grades.continua1 = parseFloat(row[5]) || student.grades.continua1;
      student.grades.continua2 = parseFloat(row[6]) || student.grades.continua2;
      student.grades.continua3 = parseFloat(row[7]) || student.grades.continua3;
      student.grades.sustitutorio = parseFloat(row[8]) || student.grades.sustitutorio;

      importedCount++;
    }
  }

  renderGradeTable(selectedCourseForGrades);
  calculateAverages();

  alert(`Importación completada. ${importedCount} estudiantes actualizados.`);
}

function exportToExcel() {
  if (!selectedCourseForGrades) {
    alert('Selecciona un curso primero');
    return;
  }

  const course = courses.find(c => c.id === selectedCourseForGrades);
  const studentList = allStudents[selectedCourseForGrades];

  const data = [
    ['ID', 'Nombre', 'Parcial 1', 'Parcial 2', 'Parcial 3', 'Continua 1', 'Continua 2', 'Continua 3', 'Sustitutorio', 'Promedio', 'Estado']
  ];

  studentList.forEach(student => {
    const promedio = calculateStudentAverage(student.grades);
    const estado = promedio >= 11 ? 'Aprobado' : 'Desaprobado';

    data.push([
      student.id,
      student.name,
      student.grades.parcial1 || '',
      student.grades.parcial2 || '',
      student.grades.parcial3 || '',
      student.grades.continua1 || '',
      student.grades.continua2 || '',
      student.grades.continua3 || '',
      student.grades.sustitutorio || '',
      promedio.toFixed(1),
      estado
    ]);
  });

  const ws = XLSX.utils.aoa_to_sheet(data);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, 'Notas');

  const fileName = `Notas_${course.name}_${new Date().toISOString().split('T')[0]}.xlsx`;
  XLSX.writeFile(wb, fileName);
}

function initGradeInputView() {
  document.getElementById('courseCardSelector').classList.remove('hidden');
  document.getElementById('courseManagementPanels').classList.add('hidden');

  renderCourseCardsForGrades();

  selectedCourseForGrades = null;
  hasUnsavedChanges = false;
  updateSaveStatus();
}

function initStudentsView() {
  const select = document.getElementById('courseSelectStudents');
  select.innerHTML = courses.map(c =>
    `<option value="${c.id}">${c.name} (${c.students} alumnos)</option>`
  ).join('');
  renderStudentList(select.value);
}

function renderStudentList(courseId) {
  const studentList = allStudents[courseId] || [];
  const tbody = document.getElementById('studentTableBody');

  tbody.innerHTML = studentList.map(s => {
    const attColor = s.attendance >= 85 ? 'text-green-600' : 'text-red-600';
    const gradeColor = s.grade >= 11 ? 'text-indigo-600' : 'text-red-600';
    return `
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">${s.id}</td>
            <td class="px-6 py-4 whitespace-nowrap">${s.name}</td>
            <td class="px-6 py-4 whitespace-nowrap text-center"><span class="${attColor}">${s.attendance}%</span></td>
            <td class="px-6 py-4 whitespace-nowrap text-center"><span class="${gradeColor}">${s.grade}</span></td>
          </tr>
        `;
  }).join('');
}

/*document.getElementById('teacherCourseList').innerHTML = courses.map(c => `
  <div class="flex justify-between items-center p-2 border-b hover:bg-gray-50 rounded-md">
    <span class="font-medium">${c.name} (${c.id})</span>
    <span class="text-xs text-gray-500">Alumnos: ${c.students} | Promedio: ${c.avgGrade}</span>
  </div>
`).join('');*/
