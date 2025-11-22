import {ContentLoader} from "../common/ContentLoader.js";
import { Calendar } from "fullcalendar";
import tippy from "tippy.js";
import 'tippy.js/dist/tippy.css';
import {convertDiaToInt, ucfirst} from "../common/Utils.js";

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

function renderScheduleCalendar(data, container) {
  if (fullCalendarInstance?.destroy) fullCalendarInstance.destroy();

  const horario = data.horario.map(function (item) {
    const colorMap = { teoria: '#60a5fa', laboratorio: '#2aa87c' };

    return {
      title: `${item.nombre} - ${ucfirst(item.tipo)}`,
      backgroundColor: colorMap[item.tipo],
      borderColor: colorMap[item.tipo],
      daysOfWeek: [convertDiaToInt(item.dia)],
      startTime: item.horaInicio,
      endTime: item.horaFin,
      extendedProps: item,
    }
  });

  const sesiones = data.sesiones.map(function (item) {
    return {
      title: `${item.nombre} - ${ucfirst(item.tipo)}`,
      backgroundColor: "#ab0647",
      borderColor: "#ab0647",
      start: `${item.fecha}T${item.horaInicio}`,
      end: `${item.fecha}T${item.horaFin}`,
      extendedProps: item,
    }
  });

  const fullCalendarEvents = [...horario, ...sesiones];

  const oldestEvent = fullCalendarEvents.reduce((prev, curr) => {
    const toMinutes = t => t.split(':').reduce((h, m) => h * 60 + +m, 0);

    // curr.endTime existe solo para eventos recurrentes
    // si no existe, extraemos los últimos 5 chars de "YYYY-MM-DDTHH:MM"
    const currEnd = curr.endTime ?? curr.end.slice(-5);
    const prevEnd = prev.endTime ?? prev.end.slice(-5);

    return toMinutes(currEnd) > toMinutes(prevEnd) ? curr : prev;
  });

  fullCalendarInstance = new Calendar(container[0], {
    initialView: 'timeGridWeek',
    slotHeight: 60,
    slotMinTime: '06:00:00',
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
            Tipo: ${ucfirst(props.tipo)}<br>
            Aula: ${props.aula}<br>
            Turno: ${props.turno}<br>
            Horario: ${props.horaInicio} - ${props.horaFin}
          </div>
        `,
        allowHTML: true,
        placement: 'top',
      });
    },
  });

  fullCalendarInstance.render();
}
