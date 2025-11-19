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

function renderScheduleCalendar(horarioMap, container) {
  if (fullCalendarInstance?.destroy) fullCalendarInstance.destroy();

  const colorMap = { teoria: '#60a5fa', laboratorio: '#34d399' };

  const fullCalendarEvents = horarioMap.map(function (item) {
    const props = {
      title: `${item.nombre} - ${ucfirst(item.tipo)}`,
      backgroundColor: colorMap[item.tipo],
      borderColor: colorMap[item.tipo],
      extendedProps: item
    };

    if (item.from_bloque) {
      props.daysOfWeek = [convertDiaToInt(item.fecha)];
      props.startTime = item.horaInicio;
      props.endTime = item.horaFin;
    } else {
      props.backgroundColor = "#ab0647";
      props.start = `${item.fecha}T${item.horaInicio}`;
      props.end   = `${item.fecha}T${item.horaFin}`;
    }

    return props;
  });

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
