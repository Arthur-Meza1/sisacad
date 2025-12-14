import $ from 'jquery';
import {
  loadScheduleCalendar,
  openScheduleModal,
  closeScheduleModal,
  saveNewScheduleEvent,
  updateEventButtonState
} from "./calendario.js";

$(document).ready(function() {
  $('.nav-link').on('click', function() {
    let view = $(this).data('view');
    changeView(view);
  });
});

let currentView = 'dashboard';
function changeView(viewId) {
  if (currentView === viewId) return;

  const views = document.querySelectorAll('.view-content');
  const navLinks = document.querySelectorAll('.nav-link');

  views.forEach(view => view.classList.add('hidden'));
  const targetView = document.getElementById(`view-${viewId}`);
  if (targetView) targetView.classList.remove('hidden');

  navLinks.forEach(link => {
    if (link.dataset.view === viewId) {
      link.classList.add('active-link');
      link.classList.remove('inactive-link');
    } else {
      link.classList.remove('active-link');
      link.classList.add('inactive-link');
    }
  });

  currentView = viewId;

  //if (viewId === 'dashboard') initDashboardView();
  //if (viewId === 'grades-input') initGradeInputView();
  if (viewId === 'schedule') loadScheduleCalendar();
  /*
  if (viewId === 'students') initStudentsView();
  */
}

window.updateEventButtonState = updateEventButtonState;
window.openScheduleModal = openScheduleModal;
window.closeScheduleModal = closeScheduleModal;
window.saveNewScheduleEvent = saveNewScheduleEvent;
