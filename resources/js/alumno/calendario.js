import $ from "jquery";
import { Calendar } from "fullcalendar";
import tippy from "tippy.js";
import 'tippy.js/dist/tippy.css';
import Swal from 'sweetalert2';

let loaded = false;
let fullCalendarInstance;

export function loadScheduleCalendar() {
  if (loaded) return;

  $.ajax({
    url: '/api/student/horario',
    method: 'GET',
    beforeSend: () => $('#calendar-loading').show(),
    success: function(data) {
      loaded = true;
      $('#calendar-loading').hide();
      renderScheduleCalendar(data);
    },
    error: function() {
      $('#calendar-loading').hide();
      $('#calendarContainer').html(`
        <div class="text-red-500 bg-red-50 p-3 rounded-lg">
          Error al cargar horario. Intenta nuevamente.
        </div>
      `);
    }
  });
}

function renderScheduleCalendar(horarioMap) {
  const calendarEl = document.getElementById('calendarContainer');
  if (!calendarEl) return;

  if (fullCalendarInstance?.destroy) fullCalendarInstance.destroy();

  const dayMap = { lunes:1, martes:2, miércoles:3, jueves:4, viernes:5 };
  const tipoMap = { teoria: 'Teoría', laboratorio: 'Laboratorio' };
  const colorMap = { teoria: '#60a5fa', laboratorio: '#34d399' };

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

  fullCalendarInstance = new Calendar(calendarEl, {
    initialView: 'timeGridWeek',
    slotHeight: 60,
    slotMinTime: '07:00:00',
    slotMaxTime: oldestEvent.endTime,
    weekends: false,
    allDaySlot: false,
    nowIndicator: true,
    height: 'auto',
    locale: 'es',
    selectable: false,
    editable: false,

    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'timeGridWeek,timeGridDay'
    },

    events: fullCalendarEvents,

    eventDidMount: function(info) {
      const props = info.event.extendedProps;
      tippy(info.el, {
        content: `
          <div>
            <strong>${props.nombre}</strong><br>
            Tipo: ${tipoMap[props.tipo]}<br>
            Aula: ${props.aula}<br>
            Turno: ${props.turno}<br>
            Horario: ${props.horaInicio} - ${props.horaFin}
          </div>
        `,
        allowHTML: true,
        placement: 'top',
        theme: 'light'
      });
    },

    eventClick: function(info) {
      const props = info.event.extendedProps;
      Swal.fire({
        title: props.nombre,
        html: `
          <div class="text-left space-y-2">
            <div><strong>Tipo:</strong> ${tipoMap[props.tipo]}</div>
            <div><strong>Aula:</strong> ${props.aula}</div>
            <div><strong>Turno:</strong> ${props.turno}</div>
            <div><strong>Día:</strong> ${props.dia}</div>
            <div><strong>Horario:</strong> ${props.horaInicio} - ${props.horaFin}</div>
          </div>
        `,
        icon: 'info',
        confirmButtonText: 'Cerrar',
        width: '500px'
      });
    }
  });

  fullCalendarInstance.render();
}
