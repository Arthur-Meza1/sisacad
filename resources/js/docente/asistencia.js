import $ from "jquery";

export function onSessionClick(id, nombre) {
  document.getElementById("asistencia-title").textContent = `Asistencia - ${nombre}`;
  loadSesion(id);
}

let g_asistencias;
function loadSesion(id) {
  $.get(`/api/teacher/sesion/${id}`)
    .done(function(data) {
      resetAsistenciaMap();

      $("#asistencia-submit-button").prop("disabled", !data.editable);

      document.getElementById("asistencia_input_sesion_id").value = data.sesion.id;
      document.getElementById('asistencia-table-body').innerHTML = "";
      if(data.sesion.asistencias.length !== 0) {
        $("#asistencia-empty").hide();
        $("#asistencia-tabla").show();
      } else {
        $("#asistencia-empty").show();
        $("#asistencia-tabla").hide();
      }

      data.sesion.asistencias.forEach(x => addAsistencia(x, data.editable));

      document.getElementById('modal-asistencia').classList.remove('hidden');
    }).fail(function (data) {
    console.error(data.responseText);
  });
}

function resetAsistenciaMap() {
  g_asistencias = new Map();
}

function addAsistencia(x, enabled) {
  document.getElementById('asistencia-table-body').innerHTML += `
  <tr
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
                               ${enabled ? "" : "disabled"}
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

function borrarSesion() {
}

window.borrarSesion = borrarSesion;
window.closeAsistenciaModal = closeAsistenciaModal;
