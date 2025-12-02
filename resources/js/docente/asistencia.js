import $ from "jquery";
import {reloadScheduleCalendar} from "./calendario.js";

export function onEventClick(props) {
  console.log(props);
  document.getElementById("asistencia-title").textContent = `Asistencia - ${props.grupo.nombre}`;
  loadSesiones(props);
}

let g_asistencias;
function loadSesiones(props) {
  const data = {
    fecha: props.fecha,
    hora_inicio: props.horaInicio,
    hora_fin: props.horaFin,
    grupo_id: props.grupo.id,
    aula_id: props.aula.id,
    _token: $('meta[name="csrf-token"]').attr('content')
  }
  $.post('/api/teacher/sesion', data)
    .done(function(data, _, jqXHR) {
      document.getElementById("asistencia_input_sesion_id").value = data.sesion.id;
      document.getElementById('asistencia-table-body').innerHTML = "";
      if(data.sesion.asistencias.length !== 0) {
        $("#asistencia-empty").hide();
        $("#asistencia-tabla").show();
      } else {
        $("#asistencia-empty").show();
        $("#asistencia-tabla").hide();
      }
      g_asistencias = new Map();
      data.sesion.asistencias.forEach(x => addAsistencia(x));

      document.getElementById('modal-asistencia').classList.remove('hidden');

      if(jqXHR.status === 201)
        reloadScheduleCalendar();
    }).fail(function (data) {
    console.error(data.responseText);
  });
}

function addAsistencia(x) {
  document.getElementById('asistencia-table-body').innerHTML += `
  <tr
    onclick="this.querySelector('input[type=checkbox]').checked = !this.querySelector('input[type=checkbox]').checked"
    class="row-select border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-4 px-4 font-semibold text-gray-800">
                       ${x.alumno.nombre}
                    </td>
                    <td class="py-4 px-4 text-center">
                      <input type="hidden" name="${x.alumno.id}" value="0">
                      <label class="inline-flex items-center cursor-pointer">
                        <input ${x.presente ? "checked" : ""} type="checkbox"
                               name="${x.alumno.id}"
                               value="1"
                               class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2">
                      </label>
                    </td>
                  </tr>
  `;
  g_asistencias.set(x.alumno.id.toString(), x.presente ? "1" : "0");
}

$(document).ready(function () {
  $("#asistencia-form").on("submit", onSendAsistencia);
});

function onSendAsistencia(e) {
  e.preventDefault();

  const $form = $(this);
  if (!$form[0].checkValidity()) {
    console.error("!$form[0].checkValidity())");
    $form[0].reportValidity();
    return false;
  }

  const formData = $form.serializeArray();
  const dataMap = new Map();

  formData.forEach(item => {
    dataMap.set(item.name, item.value);
  });

  const changedMap = Array.from(dataMap).filter(([k,v]) => {
    const old = g_asistencias.get(k);
    return old && old !== v;
  }).reduce((acc, [name, value]) => {
    acc[name] = value;
    return acc;
  }, {});

  const laravelData = {
    _token: formData[0].value,
    sesion_id: formData[1].value,
    alumnos: changedMap
  };

  console.log("Cambios:");
  console.log(changedMap);

  $.ajax({
    url: $form.attr('action'),
    type: 'POST',
    data: laravelData,
    dataType: 'json',
    timeout: 10000,
  })
    .done(function(response) {
      closeAsistenciaModal();
    })
    .fail(function(xhr, status, error) {
      alert("Error - Ver Consola");
      console.error(xhr.responseText);
    });

  return false;
}

function closeAsistenciaModal() {
  document.getElementById('modal-asistencia').classList.add('hidden');
}

window.closeAsistenciaModal = closeAsistenciaModal;
