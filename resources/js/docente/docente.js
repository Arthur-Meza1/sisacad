import $ from 'jquery';
import {
  loadScheduleCalendar,
  openScheduleModal,
  closeScheduleModal,
  saveNewScheduleEvent,
  updateEventButtonState
} from "./calendario.js";

$(document).ready(loadScheduleCalendar);
window.updateEventButtonState = updateEventButtonState;
window.openScheduleModal = openScheduleModal;
window.closeScheduleModal = closeScheduleModal;
window.saveNewScheduleEvent = saveNewScheduleEvent;
