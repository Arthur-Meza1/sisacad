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

  const horario = data.horario.map((item) => {
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

  const fullCalendarEvents = [...horario];

  fullCalendarInstance = new Calendar(container[0], {
    initialView: 'timeGridWeek',
    slotMinTime: '07:00:00',
    slotMaxTime: '20:10:00',
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
