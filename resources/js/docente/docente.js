import $ from 'jquery';
import {
  loadScheduleCalendar,
  openScheduleModal,
  closeScheduleModal,
  saveNewScheduleEvent,
  updateEventButtonState
} from "./calendario.js";

$(document).ready(loadScheduleCalendar);
globalThis.updateEventButtonState = updateEventButtonState;
globalThis.openScheduleModal = openScheduleModal;
globalThis.closeScheduleModal = closeScheduleModal;
globalThis.saveNewScheduleEvent = saveNewScheduleEvent;
