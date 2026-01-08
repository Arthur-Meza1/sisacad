import {Calendario} from "../shared/calendario.js";
import {onSessionClick} from "../docente/asistencia.js";
import 'tippy.js/dist/tippy.css';
import $ from "jquery";

let g_docenteId;
let g_cursoId;
let g_tipo;
window.openModal = function(docenteId, cursoId, tipo) {
  g_docenteId = docenteId;
  g_cursoId = cursoId;
  g_tipo = tipo;
  document.getElementById('modal').classList.remove('hidden');
  document.getElementById('modal').classList.add('flex');

  renderSelectHorario(HORARIO_DATA);
}

window.closeModal = function() {
  document.getElementById('modal').classList.add('hidden');
  document.getElementById('modal').classList.remove('flex');
}

let g_fullCalendarInstance;

function renderSelectHorario(data) {
  const horarioContainer = document.getElementById("horariosContainer");

  const calendario = new Calendario(data)
    .select(function(info) {
      const overlappingEvents = getOverlappingEventsInRange(info.start, info.end);
      let start = info.start;
      let end = info.end;
      const firstOverlap = overlappingEvents.at(0);
      if(firstOverlap && firstOverlap.start < info.start && info.start < firstOverlap.end) {
        start = firstOverlap.end;
      }

      const lastOverlap = overlappingEvents.at(-1);
      if(lastOverlap && lastOverlap.end > info.end && info.end > lastOverlap.start) {
        end = lastOverlap.start;
      }
      if(start < end)
        openScheduleModal(start, end);
    })
    .selectable()
    .headless();

  g_fullCalendarInstance = calendario.render(g_fullCalendarInstance, horarioContainer);
}

window.openScheduleModal = function(start = new Date(), end = new Date()) {
  document.getElementById('eventStart').value = formatTime(start);
  document.getElementById('eventEnd').value = formatTime(end);
  document.getElementById('scheduleModal').classList.remove('hidden');
  document.getElementById('scheduleModal').classList.add('flex');
  updateEventButtonState();
}

window.updateEventButtonState = function() {
  const day = document.getElementById('eventDay').value;
  const start = document.getElementById('eventStart').value;
  const end = document.getElementById('eventEnd').value;
  const event_button = document.getElementById('event-submit-button');

  if (!day || !start || !end) {
    event_button.disabled = true;
    return;
  }

  const today = new Date().toISOString().split('T')[0];

  const startDateTime = new Date(`${today}T${start}:00`);
  const endDateTime   = new Date(`${today}T${end}:00`);

  const overlappingEvents = getOverlappingEventsInRange(startDateTime, endDateTime);

  const doesOverlap = overlappingEvents.length !== 0 || !(startDateTime < endDateTime);

  event_button.disabled = doesOverlap;
  const errorLabel = document.getElementById("event-submit-error");
  if (doesOverlap) {
    let conflictMessages = [];

    overlappingEvents.forEach(x => {
      const hora = new Date(x.start).toLocaleTimeString('es-ES', {
        hour: '2-digit',
        minute: '2-digit'
      });
      conflictMessages.push(`${x.title} (${hora})`);
    });

    let str = "Conflicto con: ";
    str += conflictMessages.join('\n');

    errorLabel.textContent = str;
  } else {
    errorLabel.textContent = "";
  }
}

window.saveNewScheduleEvent = function() {
  const day = document.getElementById('eventDay').value;
  const start = document.getElementById('eventStart').value;
  const end = document.getElementById('eventEnd').value;
  const aula = document.getElementById("eventLocation").value;
  const turno = document.getElementById("turno").value;

  const props = {
    "docente_id": g_docenteId,
    "curso_id": g_cursoId,
    "aula_id": aula,
    "tipo": g_tipo,
    "turno": turno,
    "horaInicio": start,
    "horaFin": end,
    "dia": day.toLowerCase(),
  };

  foo(props);

  closeScheduleModal();
}

function foo(props) {
  props._token = $('meta[name="csrf-token"]').attr('content');
  console.log(props);
  $.post('/api/admin/asignar_curso', props)
    .done(function() {
      window.location.reload();
    }).fail(function (data) {
    console.error(data.responseText);
  });
}

window.closeScheduleModal = function(event) {
  if (event && event.target.id !== 'scheduleModal') return;
  document.getElementById('scheduleModal').classList.remove('flex');
  document.getElementById('scheduleModal').classList.add('hidden');
  document.getElementById('scheduleForm').reset(); // Limpiar el formulario
}

function getOverlappingEventsInRange(start, end) {
  return getCalendarOwnEvents()
    .filter(x => sameDay(start, x.start) && sameDay(end, x.end))
    .filter(x => x.start < end && x.end > start)
    .sort((a, b) => a.start - b.start);
}

function getCalendarOwnEvents() {
  return g_fullCalendarInstance.getEvents();
}

function sameDay(a, b) {
  return a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a.getDate() === b.getDate();
}

function isDateInEvent(date, event) {
  return event.start <= date && event.end >= date;
}

function isInNowEvent(event) {
  return isDateInEvent(new Date(), event);
}

function formatDate(d) {
  return `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;
}

function formatTime(d) {
  return `${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;
}


function confirmHorario() {

  closeModal();
}
