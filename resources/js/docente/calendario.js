import {ContentLoader} from "../common/ContentLoader.js";
import {
  formatTime,
  formatDate,
  isInNowEvent, sameDay
} from "../common/Utils.js";
import $ from "jquery";
import 'tippy.js/dist/tippy.css';
import {onEventClick} from "./asistencia.js";
import {Calendario} from "../shared/calendario.js";

let g_calendarLoader = new ContentLoader({
  "url": "/api/teacher/horario",
  "containerName": "#fullCalendar"
});
let g_fullCalendarInstance;

export function updateEventButtonState() {
  const date = document.getElementById('eventDate').value;
  const start = document.getElementById('eventStart').value;
  const end = document.getElementById('eventEnd').value;
  const event_button = document.getElementById('event-submit-button');

  if (!date || !start || !end) {
    event_button.disabled = true;
    return;
  }

  const startDateTime = new Date(`${date}T${start}:00`);
  const endDateTime = new Date(`${date}T${end}:00`);

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
    loadAulasDisponibles(date, start, end);
  }
}

function loadAulasDisponibles(date, start, end) {
  $.post('/api/teacher/aulas', {
    fecha: date,
    hora_inicio: start,
    hora_fin: end,
    _token: $('meta[name="csrf-token"]').attr('content')
  }).done(function(data) {
    const aulasSelect = document.getElementById("eventLocation");
    aulasSelect.innerHTML = '<option value="">Selecciona un ambiente</option>';
    data.forEach(function (aula) {
      const option = document.createElement('option');
      option.value = aula.id;
      option.textContent = aula.nombre;
      aulasSelect.appendChild(option);
    });

    if(aulasSelect.children.length === 1) {
      document.getElementById("event-submit-error").textContent = "No hay aulas disponibles";
    }
  }).fail(function (data) {
    console.error(data.responseText);
  });
}

export function loadScheduleCalendar() {
  g_fullCalendarInstance?.updateSize();
  g_calendarLoader.load(renderScheduleCalendar);
}

export function openScheduleModal(start = new Date(), end = new Date()) {
  document.getElementById('eventDate').value = formatDate(start);
  document.getElementById('eventStart').value = formatTime(start);
  document.getElementById('eventEnd').value = formatTime(end);
  document.getElementById('scheduleModal').classList.remove('hidden');
  document.getElementById('scheduleModal').classList.add('flex');
  updateEventButtonState();
}
export function closeScheduleModal(event) {
  if (event && event.target.id !== 'scheduleModal') return;
  document.getElementById('scheduleModal').classList.remove('flex');
  document.getElementById('scheduleModal').classList.add('hidden');
  document.getElementById('scheduleForm').reset(); // Limpiar el formulario
}

function renderScheduleCalendar(data, container) {
  const calendario = new Calendario(data)
    .eventClick(function(info) {
      if(isInNowEvent(info.event)) {
        let props = {...info.event.extendedProps, fecha: formatDate(info.event.start)};
        onEventClick(props);
      }
    })
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
    .eventDidMount(function(info) {
      const props = info.event.extendedProps || {};
      if(Object.keys(props).length === 0)
        return false;

      if (isInNowEvent(info.event))
        info.el.classList.add('ec-now');

      return true;
    })
    .selectable();

    g_fullCalendarInstance = calendario.render(g_fullCalendarInstance, container[0]);
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

export function saveNewScheduleEvent() {
  const grupoId = document.getElementById('eventCurso').value;
  const date = document.getElementById('eventDate').value;
  const locationId = document.getElementById('eventLocation').value;
  const start = document.getElementById('eventStart').value;
  const end = document.getElementById('eventEnd').value;

  const props = {
    "grupo_id": grupoId,
    "fecha": date,
    "hora_inicio": start,
    "hora_fin": end,
    "aula_id": locationId,
    "from_bloque": false,
  };

  crearSesion(props);
}

export function reloadScheduleCalendar() {
  g_calendarLoader.unload();
  loadScheduleCalendar();
}

function crearSesion(props) {
  props._token = $('meta[name="csrf-token"]').attr('content');
  console.log(props);
  $.post('/api/teacher/sesion', props)
    .done(function() {
      closeScheduleModal();
      reloadScheduleCalendar();
  }).fail(function (data) {
    console.error(data.responseText);
  });
}
