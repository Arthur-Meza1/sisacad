import {ContentLoader} from "../common/ContentLoader.js";
import {Calendar} from "fullcalendar";
import tippy from "tippy.js";

let g_calendarLoader = new ContentLoader({
  "url": "/api/teacher/horario",
  "containerName": "#fullCalendar"
});
let g_fullCalendarInstance;
let g_horarioMap;

export function loadScheduleCalendar() {
  g_calendarLoader.load(renderScheduleCalendar);
}

export function openScheduleModal() {
  document.getElementById('scheduleModal').classList.remove('hidden');
  document.getElementById('scheduleModal').classList.add('flex');
}
export function closeScheduleModal(event) {
  // Si se hace clic fuera del modal (en el fondo gris), se cierra
  if (event && event.target.id !== 'scheduleModal') return;
  document.getElementById('scheduleModal').classList.remove('flex');
  document.getElementById('scheduleModal').classList.add('hidden');
  document.getElementById('scheduleForm').reset(); // Limpiar el formulario
}

function renderScheduleCalendar(horarioMap, container) {
  if (g_fullCalendarInstance?.destroy) g_fullCalendarInstance.destroy();
  g_horarioMap = horarioMap;
  console.log(g_horarioMap);

  const dayMap = { lunes:1, martes:2, miércoles:3, jueves:4, viernes:5 };
  const tipoMap = { teoria: 'Teoría', laboratorio: 'Laboratorio' };
  const colorMap = { teoria: '#60a5fa', laboratorio: '#2aa87c' };

  const fullCalendarEvents = horarioMap.map(item => ({
    title: `${item.nombre} - ${tipoMap[item.tipo]}`,
    daysOfWeek: [dayMap[item.dia]],
    startTime: item.horaInicio,
    endTime: item.horaFin,
    backgroundColor: colorMap[item.tipo],
    borderColor: colorMap[item.tipo],
    extendedProps: item
  }));

  const oldestEvent = fullCalendarEvents.reduce((prev, curr) => {
    const toMinutes = t => t.split(':').reduce((h, m) => h*60 + +m, 0);
    return toMinutes(curr.endTime) > toMinutes(prev.endTime) ? curr : prev;
  });

  g_fullCalendarInstance = new Calendar(container[0], {
    initialView: 'timeGridWeek',
    slotHeight: 60,
    slotMinTime: '07:00:00',
    slotMaxTime: oldestEvent.endTime,
    weekends: false,
    allDaySlot: false,
    nowIndicator: true,
    height: 'auto',
    locale: 'es',
    selectable: true,
    editable: false,

    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'timeGridWeek,timeGridDay'
    },

    events: fullCalendarEvents,

    eventClick: function(info) {
      if(isActualEvent(info.event)) {
      }
    },

    select: function (info) {
      openScheduleModal();
    },

    eventDidMount: function(info) {
      if (isActualEvent(info.event))
        info.el.classList.add('ec-now');
    }
  });

  g_fullCalendarInstance.render();
}

function isActualEvent(event) {
  const now = new Date();
  return event.start <= now && event.end >= now;
}

export function saveNewScheduleEvent() {
  const title = document.getElementById('eventTitle').value;
  const date = document.getElementById('eventDate').value;
  const location = document.getElementById('eventLocation').value;
  const start = document.getElementById('eventStart').value;
  const end = document.getElementById('eventEnd').value;

  const startDateTime = `${date}T${start}:00`;
  const endDateTime = `${date}T${end}:00`;

  // 1. Validación de Horas
  if (startDateTime >= endDateTime) {
    alert('Error: La hora de fin debe ser posterior a la hora de inicio.');
    return;
  }

  // --- NUEVO: VERIFICACIÓN DE CONFLICTOS PERSONALES ---
  const isConflict = g_horarioMap.some(existingEvent => {
    // Ignoramos eventos sin inicio/fin definidos (aunque no debería pasar)
    if (!existingEvent.horaInicio || !existingEvent.horaFin) return false;

    // Convertimos las fechas/horas a objetos Date para compararlas fácilmente
    const newStart = new Date(startDateTime);
    const newEnd = new Date(endDateTime);
    const existingStart = new Date(existingEvent.horaInicio);
    const existingEnd = new Date(existingEvent.horaFin);

    // Lógica de superposición: [A empieza antes de B termina] AND [B empieza antes de A termina]
    const overlap = newStart < existingEnd && existingStart < newEnd;

    return overlap;
  });

  if (isConflict) {
    // En lugar de bloquear la reserva, ADVERTIMOS y preguntamos si desea continuar.
    const confirmation = confirm(
      'Curse de Horarios\n' +
      'Esta hora se superpone con una clase/reserva que ya tienes en tu horario.\n\n' +
      '¿Deseas guardar la reserva de todos modos?'
    );

    if (!confirmation) {
      alert('Reserva cancelada');
      return; // Detiene la función si el usuario cancela
    }
  }
  // --- FIN DE LA VERIFICACIÓN ---

  const newEvent = {
    id: `custom-${Date.now()}`,
    title: `${title} (${location})`,
    start: startDateTime,
    end: endDateTime,
    extendedProps: {
      course: title,
      location: location,
      type: 'flexible'
    },
    color: isConflict ? '#dc2626' : '#f97316' // Rojo si hay conflicto, Naranja si no hay
  };

  // 2. Añadir el evento al arreglo de datos
  // g_horarioMap.push(newEvent);
  console.log(newEvent);

  // 3. Añadir el evento al calendario ya renderizado
  if (g_fullCalendarInstance) {
    g_fullCalendarInstance.addEvent(newEvent);
    alert(`¡Hora reservada con éxito! `);
    closeScheduleModal();
  } else {
  }
}
