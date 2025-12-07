import $ from 'jquery';
import {loadAvailableCourses} from "./notas";
import {loadScheduleCalendar} from "./calendario";
import {loadEnrollmentView} from "./labs";

$(document).ready(function() {
  $('.nav-link').on('click', function() {
    let view = $(this).data('view');
    changeView(view);
  });
});

let currentView = 'dashboard';
const views = document.querySelectorAll('.view-content');
const navLinks = document.querySelectorAll('.nav-link');

function changeView(viewId) {
  if (currentView === viewId) return;

  views.forEach(view => view.classList.add('hidden'));
  document.getElementById(`view-${viewId}`).classList.remove('hidden');

  navLinks.forEach(link => {
    if (link.dataset.view === viewId) {
      link.classList.remove('inactive-link');
      link.classList.add('active-link');
    } else {
      link.classList.remove('active-link');
      link.classList.add('inactive-link');
    }
  });

  currentView = viewId;

  if(viewId === 'dashboard') {
    window.location.href = "/";
  }

  if (viewId === 'grades') {
    loadAvailableCourses();
  }
  if (viewId === 'attendance') {
      initAttChart();
  }
  if (viewId === 'schedule') loadScheduleCalendar();
  if (viewId === 'enrollment') loadEnrollmentView();
}

function removeEnrollment(labId) {
    const labToRemove = enrolledLabs.find(lab => lab.id === labId);
    if (confirm(`¿Estás seguro de quitar el laboratorio "${labToRemove.name}" de tu matrícula?`)) {
        enrolledLabs = enrolledLabs.filter(lab => lab.id !== labId);
        alert(`Matrícula para ${labToRemove.name} eliminada.`);
        renderEnrollmentView();
    }
}

document.addEventListener('DOMContentLoaded', () => {
  changeView('dashboard');
});
