import $ from 'jquery';
import * as XLSX from 'https://cdn.sheetjs.com/xlsx-0.20.3/package/xlsx.mjs';
import {ContentLoader} from "../common/ContentLoader.js";

let g_updates = null;
let g_inputs = null;
let g_courseName = null;

globalThis.handleCourseCardClick = (courseId, courseName) => {
  loadGradeTable(courseId, courseName);
};


globalThis.showCourseSelection = () => {
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
};

function loadGradeTable(courseId, courseName) {
  document.getElementById('courseCardSelector').classList.add('hidden');
  document.getElementById('courseManagementPanels').classList.remove('hidden');

  document.getElementById('currentCourseTitle').textContent = `Curso: ${courseName}`;
  document.getElementById('currentCourseInfo').textContent = `Código: ${courseId}`;

  document.querySelectorAll('.course-card-grades').forEach(card => {
    if (card.dataset.courseid === courseId) {
      card.classList.add('selected-card-active');
    } else {
      card.classList.remove('selected-card-active');
    }
  });

  new ContentLoader({
    url: `/api/teacher/grupo/${courseId}/notas`, containerName: '#gradeTableBody'
  }).load(function (data, container) {
    g_courseName = courseName;
    resetGlobalData();
    console.log(data);
    renderGradeTable(data);
  });
}

function resetGlobalData() {
  g_updates = new Map();
  g_inputs = new Map();
}

function renderGradeTable(data) {
  const tbody = document.getElementById('gradeTableBody');

  document.getElementById('studentCount').textContent = `${data.length} alumnos`;

  tbody.innerHTML = data.map((student, index) => {
    return `
          <tr class="${index % 2 === 0 ? 'bg-gray-50' : 'bg-white'} hover:bg-blue-50">
            <td class="px-4 py-3 whitespace-nowrap font-medium cui">${student.alumno_id}</td>
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
    if (!e.target.matches("input")) return;

    const input = e.target;
    if (!g_updates.has(input.dataset.id)) {
      g_updates.set(input.dataset.id, new Map());
    }
    const map = g_updates.get(input.dataset.id);
    map.set(input.dataset.type, input.value);

    createObserverInputFromRow(e.target.closest("tr"));
  });

  forceObserverInput(tbody);
}

function forceObserverInput(tbody) {
  tbody.querySelectorAll("tr").forEach(e => createObserverInputFromRow(e));
}

function createObserverInputFromRow(row) {
  if (!row) return;

  const inputs = row.querySelectorAll("input");
  const values = new Map();
  const promLabel = row.querySelector(".average-display");
  const estadoLabel = row.querySelector(".estado-display");
  const cui = Number.parseInt(row.querySelector(".cui").textContent);
  inputs.forEach(x => values.set(x.dataset.type, x.value));

  if (cui && !g_inputs.has(cui)) {
    g_inputs.set(cui, inputs);
  }

  onInputChange(values, promLabel, estadoLabel);
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
    parcial1, parcial2, parcial3, continua1, continua2, continua3, sustitutorio
  } = values;

  sustitutorio = (sustitutorio === "" || sustitutorio === null || sustitutorio === undefined) ? Number.NaN : Number(sustitutorio);

  if (!Number.isNaN(sustitutorio)) {
    if (Number(parcial1) <= Number(parcial2)) {
      parcial1 = sustitutorio;
    } else {
      parcial2 = sustitutorio;
    }
  }

  const notas = [Number(parcial1), Number(parcial2), Number(parcial3), Number(continua1), Number(continua2), Number(continua3)].filter(n => !Number.isNaN(n));

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

globalThis.saveAllGrades = () => {
  if (!hasUnsavedChanges()) {
    alert('No hay cambios que guardar');
    return;
  }

  sendUpdateToServer(updatesMapToJSON());

  resetGlobalData();
  updateSaveStatus();
};

function updatesMapToJSON() {
  const payload = [];
  for (const [registro_id, notasMap] of g_updates) {
    payload.push({
      registro_id,
      notas: Object.fromEntries(Array.from(notasMap, ([key, value]) => [key, value === null || value === undefined || value === '' ? null : Number(value)]))
    });
  }

  return payload;
}

function sendUpdateToServer(json) {
  const data = {
    _token: $('meta[name="csrf-token"]').attr('content'), data: json
  };
  console.log(json);
  $.post(`/api/teacher/notas/guardar`, data)
    .done(function (data) {
      alert("Notas guardades exitosamente!");
    })
    .fail(function (data) {
      alert("Error - ver consola");
      console.error(data.responseText);
    });
}


globalThis.downloadLibretaTemplate = () => {
  globalThis.location.href = '/api/teacher/libreta/descargar';
};

globalThis.handleExcelImport = (files) => {
  if (!files.length) return;

  const file = files[0];
  const reader = new FileReader();

  reader.onload = function (e) {
    const data = new Uint8Array(e.target.result);
    const workbook = XLSX.read(data, {type: 'array'});

    const firstSheetName = workbook.SheetNames[0];
    const worksheet = workbook.Sheets[firstSheetName];

    const jsonData = XLSX.utils.sheet_to_json(worksheet, {header: 1});

    importGradesFromExcel(jsonData);
  };

  reader.readAsArrayBuffer(file);
};

function importGradesFromExcel(data) {
  for (let i = 1; i < data.length; ++i) {
    const row = data[i];
    if (!row) continue;

    const cui = Number.parseInt(row[0]);
    const inputs = g_inputs.get(cui) ?? null;
    if (!cui || !inputs) continue;

    importGradeFromRow(row, inputs)
  }
}

function setInputValue(input, value) {
  input.value = value;
  input.dispatchEvent(new Event('input', {bubbles: true}));
}

function importGradeFromRow(row, inputs) {
  setInputValue(inputs[0], Number.parseInt(row[1])); // Parcial 1
  setInputValue(inputs[1], Number.parseInt(row[2])); // Continua 1
  setInputValue(inputs[2], Number.parseInt(row[3])); // Parcial 2
  setInputValue(inputs[3], Number.parseInt(row[4])); // Continua 2
  setInputValue(inputs[4], Number.parseInt(row[5])); // Parcial 3
  setInputValue(inputs[5], Number.parseInt(row[6])); // Continua 3
  setInputValue(inputs[6], Number.parseInt(row[7])); // Sustitutorio
}

globalThis.exportToExcel = () => {
  const data = [['CUI', 'Parcial 1', 'Continua 1', 'Parcial 2', 'Continua 2', 'Parcial 3', 'Continua 3', 'Sustitutorio']];

  const obj = Object.fromEntries(g_inputs);
  Object.entries(obj).forEach(([k, v]) => {
    data.push([k, v[0].value, v[1].value, v[2].value, v[3].value, v[4].value, v[5].value, v[6].value,]);
  });

  const ws = XLSX.utils.aoa_to_sheet(data);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, 'Notas');
  const fileName = `Notas_${g_courseName}_${new Date().toISOString().split('T')[0]}.xlsx`;
  XLSX.writeFile(wb, fileName);
};
