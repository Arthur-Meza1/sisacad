import {ContentLoader} from "../common/ContentLoader.js";
import { Calendar } from "fullcalendar";
import tippy from "tippy.js";
import 'tippy.js/dist/tippy.css';
import {convertDateStringToDate, convertDiaToInt, ucfirst} from "../common/Utils.js";
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
