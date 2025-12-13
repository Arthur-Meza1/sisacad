import $ from 'jquery';
import {ContentLoader} from "../common/ContentLoader.js";

let g_updates = new Map();

export function handleCourseCardClick(courseId, courseName) {
  loadGradeTable(courseId, courseName);
}
window.handleCourseCardClick = handleCourseCardClick;

export function showCourseSelection() {
  if (hasUnsavedChanges()) {
    if (!confirm('Tienes cambios sin guardar. ¿Seguro que quieres salir?')) {
      return;
    }
  }

  document.getElementById('courseManagementPanels').classList.add('hidden');
  document.getElementById('courseCardSelector').classList.remove('hidden');
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
    resetGlobalData();
    console.log(data);
    renderGradeTable(data);
  });
}

function resetGlobalData() {
  g_updates = new Map();
}

function renderGradeTable(data) {
  const tbody = document.getElementById('gradeTableBody');

  document.getElementById('studentCount').textContent = `${data.length} alumnos`;

  tbody.innerHTML = data.map((student, index) => {
    return `
          <tr class="${index % 2 === 0 ? 'bg-gray-50' : 'bg-white'} hover:bg-blue-50">
            <td class="px-4 py-3 whitespace-nowrap font-medium">${student.alumno_id}</td>
            <td class="px-4 py-3 whitespace-nowrap">${student.nombre}</td>

            <!-- Parciales -->
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <input type="number" min="0" max="20" step="1"
                       value="${student.parcial[0] || ''}"
                       data-id="${student.registro_id}"
                       data-type="parcial1"
                       class="w-16 p-1 border rounded text-center grade-input"
                       >
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <input type="number" min="0" max="20" step="1"
                       value="${student.continua[0] || ''}"
                       data-id="${student.registro_id}"
                       data-type="continua1"
                       class="w-16 p-1 border rounded text-center grade-input"
                       >
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <input type="number" min="0" max="20" step="1"
                       value="${student.parcial[1] || ''}"
                       data-id="${student.registro_id}"
                       data-type="parcial2"
                       class="w-16 p-1 border rounded text-center grade-input"
                       >
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <input type="number" min="0" max="20" step="1"
                       value="${student.continua[1] || ''}"
                       data-id="${student.registro_id}"
                       data-type="continua2"
                       class="w-16 p-1 border rounded text-center grade-input"
                       >
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <input type="number" min="0" max="20" step="1"
                       value="${student.parcial[2] || ''}"
                       data-id="${student.registro_id}"
                       data-type="parcial3"
                       class="w-16 p-1 border rounded text-center grade-input"
                       >
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <input type="number" min="0" max="20" step="1"
                       value="${student.continua[2] || ''}"
                       data-id="${student.registro_id}"
                       data-type="continua3"
                       class="w-16 p-1 border rounded text-center grade-input"
                       >
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <input type="number" min="0" max="20" step="1"
                       value="${student.sustitutorio || ''}"
                       data-id="${student.registro_id}"
                       data-type="sustitutorio"
                       class="w-16 p-1 border rounded text-center grade-input"
                       >
            </td>

            <!-- Promedio (calculado) -->
            <td class="px-4 py-3 whitespace-nowrap text-center font-bold">
                <span class="average-display" data-id="${student.registro_id}"></span>
            </td>

            <!-- Estado -->
            <td class="px-4 py-3 whitespace-nowrap text-center">
                <span class="px-3 py-1 rounded-full text-xs font-medium estado-display" data-id="${student.registro_id}">
                </span>
            </td>
          </tr>
        `;
  }).join('');

  createObserverInputs(tbody);
}

function createObserverInputs(tbody) {
  tbody.addEventListener("input", e => {
    if(!e.target.matches("input")) return;

    const input = e.target;
    if(!g_updates.has(input.dataset.id)) {
      g_updates.set(input.dataset.id, new Map());
    }
    const map = g_updates.get(input.dataset.id);
    map.set(input.dataset.type, input.value);

    createObserverInputFromRow(e.target.closest("tr"));
  });

  forceObserverInput(tbody);
}

function createObserverInputFromRow(row) {
  if(!row)
    return;

  const values = new Map();
  const promLabel = row.querySelector(".average-display");
  const estadoLabel = row.querySelector(".estado-display");
  row.querySelectorAll("input").forEach(x => values.set(x.dataset.type, x.value));

  onInputChange(values, promLabel, estadoLabel);
}

function forceObserverInput(tbody) {
  tbody.querySelectorAll("tr").forEach(e => createObserverInputFromRow(e));
}

function onInputChange(values, promLabel, estadoLabel) {
  updateSaveStatus();

  const average = calculateStudentAverage(Object.fromEntries(values));

  promLabel.textContent = average.toFixed(1);

  const estado = average >= 10.5 ? 'Aprobado' : 'Desaprobado';
  const estadoColor = average >= 10.5 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';

  estadoLabel.textContent = estado;
  estadoLabel.className = `px-3 py-1 rounded-full text-xs font-medium ${estadoColor} estado-display`;
}

function calculateStudentAverage(values) {
  let {
    parcial1,
    parcial2,
    parcial3,
    continua1,
    continua2,
    continua3,
    sustitutorio
  } = values;

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

function updateSaveStatus() {
  const statusElement = document.getElementById('saveStatus');
  if (hasUnsavedChanges()) {
    statusElement.textContent = '⚠️ Tienes cambios sin guardar';
    statusElement.classList.add('text-red-600', 'font-medium');
    statusElement.classList.remove('text-gray-500');
  } else {
    statusElement.textContent = 'Sin cambios por guardar';
    statusElement.classList.remove('text-red-600', 'font-medium');
    statusElement.classList.add('text-gray-500');
  }
}

function hasUnsavedChanges() {
  return g_updates.size !== 0;
}

export function saveAllGrades() {
  if(!hasUnsavedChanges()) {
    alert('No hay cambios que guardar');
    return;
  }

  // console.log(JSON.stringify(Object.fromEntries(g_updates)));
  const data = {
    _token: $('meta[name="csrf-token"]').attr('content'),
    data: updatesMapToJSON()
  };
  console.log(data);
  $.post(`/api/teacher/notas/guardar`, data)
    .done(function (data) {
      console.log(data);
    })
    .fail(function (data) {
      console.error(data.responseText);
    })

  resetGlobalData();
  updateSaveStatus();
}
window.saveAllGrades = saveAllGrades;

function updatesMapToJSON() {
  const payload = [];
  for(const [registro_id, notasMap] of g_updates) {
    payload.push({
      registro_id,
      notas: Object.fromEntries(notasMap)
    });
  }

  return payload;
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
