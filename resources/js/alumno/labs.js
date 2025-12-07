import {ContentLoader} from "../common/ContentLoader.js";
import $ from "jquery";

export function loadEnrollmentView() {
  loadAvailableLabs();
  loadLabs();
}

window.enrollLab = enrollLab;
window.removeEnrollment = removeEnrollment;

let g_cuposLoader = new ContentLoader({
  "url": "/api/student/cupos",
  "containerName": "#availableLabsList"
});

let g_labsLoader = new ContentLoader({
  "url": "/api/student/labs",
  "containerName": "#enrolledLabsList"
});

function loadAvailableLabs() {
  g_cuposLoader.load(renderAvailableLabs);
}

function loadLabs() {
  g_labsLoader.load(renderLabs);
}

function renderAvailableLabs(data, container) {
  if (data.length === 0) {
    container.html('<p class="text-gray-500 mt-4">No hay laboratorios disponibles para matricular.</p>');
    return;
  }

  container.html(data.map(lab => `
        <div class="flex justify-between items-center p-3 border rounded-lg bg-gray-50 hover:bg-gray-100 transition">
            <div>
                <p class="font-medium text-gray-800">${lab.nombre}</p>
                <p class="text-xs text-gray-500">Turno: ${lab.turno} | Docente: ${lab.docente}</p>
            </div>
            <button onclick="enrollLab(${lab.id})" class="px-3 py-1 text-sm rounded-full bg-indigo-500 text-white hover:bg-indigo-600 transition">
                Matricular
            </button>
        </div>
    `).join(''));
}

function enrollLab(labId) {
  const data = {
    'id': labId,
    '_token': $('meta[name="csrf-token"]').attr('content')
  };

  $.post('/api/student/matricular', data)
    .done(function() {
      g_cuposLoader.unload();
      g_labsLoader.unload();
      loadEnrollmentView();
    })
    .fail(function (data) {
      console.error(data.responseText);
    });
}

function removeEnrollment(labId) {
  const data = {
    'id': labId,
    '_token': $('meta[name="csrf-token"]').attr('content')
  };

  $.post('/api/student/desmatricular', data)
    .done(function() {
      g_cuposLoader.unload();
      g_labsLoader.unload();
      loadEnrollmentView();
    })
    .fail(function (data) {
      console.error(data.responseText);
    });
}

function renderLabs(data, container) {
  if (data.length === 0) {
    container.html('<p class="text-gray-500 text-sm">Aún no te has matriculado en algún laboratorio.</p>');
    return;
  }

  container.html(data.map(lab => `
        <div class="flex justify-between items-center p-3 border border-indigo-200 rounded-lg bg-indigo-50">
            <div>
                <p class="font-medium text-indigo-700">${lab.nombre}</p>
                <p class="text-xs text-indigo-400">Turno: ${lab.turno} | Docente: ${lab.docente}</p>
            </div>
            <button onclick="removeEnrollment(${lab.id})" class="text-xs px-3 py-1 rounded-full border border-red-400 text-red-600 hover:bg-red-100 transition">
                Quitar
            </button>
        </div>
    `).join(''));
}
