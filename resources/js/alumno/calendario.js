import {ContentLoader} from "../common/ContentLoader.js";
import 'tippy.js/dist/tippy.css';
import {Calendario} from "../shared/calendario.js";

let fullCalendarInstance;

let calendarLoader = new ContentLoader(
  {
    "url": "/api/student/horario",
    "containerName": "#calendarContainer"
  }
);

export function loadScheduleCalendar() {
  fullCalendarInstance?.updateSize();
  calendarLoader.load(renderScheduleCalendar);
}

function renderScheduleCalendar(data, container) {
  const calendario = new Calendario(data);
  fullCalendarInstance = calendario.render(fullCalendarInstance, container[0]);
}
