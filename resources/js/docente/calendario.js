import 'tippy.js/dist/tippy.css';
import {onSessionClick} from "./asistencia.js";
import {Calendario} from "../shared/calendario.js";

let g_fullCalendarInstance;

export function loadScheduleCalendar() {
  const container = document.getElementById('fullCalendar');
  renderScheduleCalendar(globalThis.HORARIO_DATA, [container]);
}

export function updateEventButtonState() {
  const date = document.getElementById('eventDate').value;
  const start = document.getElementById('eventStart').value;
  const end = document.getElementById('eventEnd').value;

  const button = document.getElementById('event-submit-button');
  const error = document.getElementById('event-submit-error');

  if (!date || !start || !end) {
    button.disabled = true;
    return;
  }

  const startDT = new Date(`${date}T${start}`);
  const endDT = new Date(`${date}T${end}`);

  const overlaps = getOverlappingEventsInRange(startDT, endDT);

  if (startDT >= endDT || overlaps.length > 0) {
    button.disabled = true;
    error.textContent = buildOverlapMessage(overlaps);
    return;
  }

  button.disabled = false;
  error.textContent = "";
  loadAulasDisponiblesLocal();
}

function loadAulasDisponiblesLocal() {
  const select = document.getElementById("eventLocation");
  select.innerHTML = '<option value="">Selecciona un ambiente</option>';

  globalThis.AULAS_DATA.forEach(aula => {
    const opt = document.createElement('option');
    opt.value = aula.id;
    opt.textContent = aula.nombre;
    select.appendChild(opt);
  });

  if (select.children.length === 1) {
    document.getElementById("event-submit-error").textContent = "No hay aulas disponibles";
  }
}


export function openScheduleModal(start, end) {
  document.getElementById('eventDate').value = formatDate(start);
  document.getElementById('eventStart').value = formatTime(start);
  document.getElementById('eventEnd').value = formatTime(end);

  document.getElementById('scheduleModal').classList.remove('hidden');
  document.getElementById('scheduleModal').classList.add('flex');

  updateEventButtonState();
}

export function closeScheduleModal(e) {
  if (e && e.target.id !== 'scheduleModal') return;
  document.getElementById('scheduleModal').classList.add('hidden');
  document.getElementById('scheduleForm').reset();
}

function renderScheduleCalendar(data, container) {
  const calendar = new Calendario(data)
    .eventClick(info => {
      const props = info.event.extendedProps;
      if (props.sesion) {
        onSessionClick(props.id, props.grupo.nombre);
      }
    })
    .select(info => {
      if (info.start < info.end) {
        openScheduleModal(info.start, info.end);
      }
    })
    .selectable();

  g_fullCalendarInstance = calendar.render(g_fullCalendarInstance, container[0]);
}

function sameDay(a, b) {
  return a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a.getDate() === b.getDate();
}

function getOverlappingEventsInRange(start, end) {
  return g_fullCalendarInstance.getEvents()
    .filter(e => sameDay(start, e.start) && sameDay(end, e.end))
    .filter(e => e.start < end && e.end > start);
}

function buildOverlapMessage(events) {
  if (!events.length) return "";
  return "Conflicto con: " + events.map(e => `${e.title} (${new Date(e.start).toLocaleTimeString('es-ES', {
    hour: '2-digit', minute: '2-digit'
  })})`).join(', ');
}

function formatDate(d) {
  return d.toISOString().slice(0, 10);
}

function formatTime(d) {
  return d.toTimeString().slice(0, 5);
}

export function saveNewScheduleEvent() {
  document.getElementById('scheduleForm').submit();
}

export function reloadScheduleCalendar() {}
