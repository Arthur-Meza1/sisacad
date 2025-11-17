import {ContentLoader} from "../common/ContentLoader.js";
import { Calendar } from "fullcalendar";
import tippy from "tippy.js";
import 'tippy.js/dist/tippy.css';

let fullCalendarInstance;

let calendarLoader = new ContentLoader(
  {
    "url": "/api/student/horario",
    "containerName": "#calendarContainer"
  }
);

export function loadScheduleCalendar() {
  calendarLoader.load(renderScheduleCalendar);
}

function renderScheduleCalendar(horarioMap, container) {
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

  fullCalendarInstance = new Calendar(container[0], {
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
  });

  fullCalendarInstance.render();
}
