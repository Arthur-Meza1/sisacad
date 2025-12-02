import {ContentLoader} from "../common/ContentLoader.js";
import {Calendar} from "fullcalendar";
import {
  formatTime,
  formatDate,
  ucfirst,
  convertDiaToInt,
  isInNowEvent, sameDay, convertDateStringToDate
} from "../common/Utils.js";
import $ from "jquery";
import tippy from "tippy.js";
import 'tippy.js/dist/tippy.css';
import {onEventClick} from "./asistencia.js";

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

  const startOverlap = findFirstStartOverlap(startDateTime);
  const endOverlap = findFirstEndOverlap(endDateTime);

  const doesOverlap = startOverlap != null || endOverlap != null || !(startDateTime < endDateTime);

  event_button.disabled = doesOverlap;

  const errorLabel = document.getElementById("event-submit-error");
  if (doesOverlap) {
    let conflictMessages = [];

    if (startOverlap) {
      const hora = new Date(startOverlap.start).toLocaleTimeString('es-ES', {
        hour: '2-digit',
        minute: '2-digit'
      });
      conflictMessages.push(`${startOverlap.title} (${hora})`);
    }

    if (endOverlap) {
      const hora = new Date(endOverlap.start).toLocaleTimeString('es-ES', {
        hour: '2-digit',
        minute: '2-digit'
      });
      conflictMessages.push(`${endOverlap.title} (${hora})`);
    }

    let str = "Conflicto con: ";
    str += conflictMessages.join(' y ');

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
  console.log("Horario:");
  console.log(data);
  if (g_fullCalendarInstance?.destroy) g_fullCalendarInstance.destroy();

  const sesionSet = new Set();

  const sesiones = data.sesiones.map(function (item) {
    sesionSet.add(`${convertDateStringToDate(item.fecha).getDay()}${item.horaInicio}${item.horaFin}`);
    return {
      title: `${item.grupo.nombre} - ${ucfirst(item.tipo)}`,
      backgroundColor: "#ab0647",
      borderColor: "#ab0647",
      start: `${item.fecha}T${item.horaInicio}`,
      end: `${item.fecha}T${item.horaFin}`,
      extendedProps: item,
    }
  });

  const horario =
      data
        .horario
        .filter(item => !sesionSet.has(`${convertDiaToInt(item.dia)}${item.horaInicio}${item.horaFin}`))
        .map(function (item) {
    const colorMap = { teoria: '#60a5fa', laboratorio: '#2aa87c' };
console.log(`${convertDiaToInt(item.dia)}${item.horaInicio}${item.horaFin}`);
    return {
      title: `${item.grupo.nombre} - ${ucfirst(item.tipo)}`,
      backgroundColor: colorMap[item.tipo],
      borderColor: colorMap[item.tipo],
      daysOfWeek: [convertDiaToInt(item .dia)],
      startTime: item.horaInicio,
      endTime: item.horaFin,
      extendedProps: item,
    }
  });

  const others = data.occupied.map(function (item) {
    const props = {
      display: 'background',
      backgroundColor: 'red',
    };

    if(item.from_bloque === true) {
      props.daysOfWeek = [convertDiaToInt(item.fecha)];
      props.startTime= item.horaInicio;
      props.endTime = item.horaFin;
    } else {
      props.start = `${item.fecha}T${item.horaInicio}`;
      props.end =`${item.fecha}T${item.horaFin}`;
    }

    return props;
  });

  const fullCalendarEvents = [...horario, ...sesiones, ...others];

  g_fullCalendarInstance = new Calendar(container[0], {
    initialView: 'timeGridWeek',
    slotHeight: 60,
    slotMinTime: '06:00:00',
    slotMaxTime: "20:00:00",
    eventMaxStack: 3,
    weekends: false,
    allDaySlot: false,
    nowIndicator: true,
    height: 'auto',
    locale: 'es',
    selectable: true,

    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'timeGridWeek,timeGridDay'
    },

    events: fullCalendarEvents,

    eventClick: function(info) {
      if(isInNowEvent(info.event)) {
        let props = {...info.event.extendedProps, fecha: formatDate(info.event.start)};
        onEventClick(props);
      }
    },

    select: function (info) {
      let start = clampStartEvent(info.start);
      let end = clampEndEvent(info.end);
      if(start < end)
        openScheduleModal(start, end);
    },

    eventDidMount: function(info) {
      const props = info.event.extendedProps || {};
      if(Object.keys(props).length === 0)
        return;

      if (isInNowEvent(info.event))
        info.el.classList.add('ec-now');

      const content = `
      <div>
          <strong>${props.grupo.nombre}</strong><br>
          Tipo: ${ucfirst(props.tipo)}<br>
          Aula: ${props.aula.nombre}<br>
          Turno: ${props.turno}<br>
          Horario: ${props.horaInicio} - ${props.horaFin}
        </div>`;

      tippy(info.el, {
        content,
        allowHTML: true,
        placement: 'top',
      });
    }
  });

  g_fullCalendarInstance.render();
}

function findFirstStartOverlap(date) {
  return getCalendarOwnEvents().filter(x =>
    sameDay(date, x.start) && sameDay(date, x.end)
  ).find(x => x.start <= date && date < x.end);
}

function findFirstEndOverlap(date) {
  return getCalendarOwnEvents().filter(x =>
    sameDay(date, x.start) && sameDay(date, x.end)
  ).find(x => x.start < date && date <= x.end);
}

function getCalendarOwnEvents() {
  return g_fullCalendarInstance.getEvents().filter(x => x.extendedProps.length === 0);
}

function clampStartEvent(start) {
  let overlapStart = findFirstStartOverlap(start);
  if(overlapStart) {
    return overlapStart.end;
  }
  return start;
}

function clampEndEvent(end) {
  let overlapEnd = findFirstEndOverlap(end);
  if(overlapEnd) {
    return overlapEnd.start;
  }
  return end;
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
