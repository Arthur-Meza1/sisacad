import $ from "jquery";
import {reloadScheduleCalendar} from "./calendario.js";

export function onEventClick(props) {
  document.getElementById("asistencia-title").textContent = `Asistencia - ${props.grupo.nombre}`;
  loadSesiones(props);
}

function loadSesiones(props) {
  const data = {
    fecha: props.fecha,
    hora_inicio: props.horaInicio,
    hora_fin: props.horaFin,
    grupo_id: props.grupo.id,
    aula_id: props.aula.id,
    _token: $('meta[name="csrf-token"]').attr('content')
  }
  console.log(props);
  $.post('/api/teacher/sesion', data)
    .done(function(data) {
      document.getElementById('asistencia-table-body').innerHTML = "";
      if(data.sesion.asistencias.length != 0) {
        $("#asistencia-empty").hide();
        $("#asistencia-tabla").show();
      } else {
        $("#asistencia-empty").show();
        $("#asistencia-tabla").hide();
      }
      data.sesion.asistencias.forEach(x => addAsistencia(x));

      document.getElementById('modal-asistencia').classList.remove('hidden');
      reloadScheduleCalendar();
    }).fail(function (data) {
    console.error(data.responseText);
  });
}

function addAsistencia(x) {
  document.getElementById('asistencia-table-body').innerHTML += `
  <tr class="row-select border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-4 px-4 font-semibold text-gray-800">
                       ${x.alumno.nombre}
                    </td>
                    <td class="py-4 px-4 text-center">
                      <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox"
                               name="alumno_id"
                               value="${x.alumno.id}"
                               required
                               class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2">
                      </label>
                    </td>
                  </tr>
  `;
}

function onLoadedSesion(data, container) {
  console.log(data);
}

function closeAsistenciaModal() {
  document.getElementById('modal-asistencia').classList.add('hidden');
}

window.closeAsistenciaModal = closeAsistenciaModal;

document.querySelectorAll('.row-select').forEach(row => {
  row.addEventListener('click', function (e) {
    // Evitar que el click directo en el checkbox duplique el toggle
    if (e.target.tagName.toLowerCase() === 'input') return;

    const checkbox = row.querySelector('input[type="checkbox"]');
    checkbox.checked = !checkbox.checked;
  });
});
