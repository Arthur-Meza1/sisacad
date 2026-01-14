import {ContentLoader} from "../common/ContentLoader.js";
import 'tippy.js/dist/tippy.css';
import {Calendario} from "../shared/calendario.js";

let fullCalendarInstance;

export function loadScheduleCalendar(data) {
  const calendario = new Calendario(data);
  const container = document.getElementById("calendarContainer");
  fullCalendarInstance = calendario.render(fullCalendarInstance, container);
}

window.loadScheduleCalendar = loadScheduleCalendar;
