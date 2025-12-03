import {ContentLoader} from "../common/ContentLoader.js";

export function loadAnalyticsView(self, id) {
  document.querySelectorAll('.course-button').forEach(btn => {
    btn.classList.remove('bg-indigo-600', 'text-white');
    btn.classList.add('text-gray-600', 'hover:bg-indigo-100', 'hover:text-indigo-700');
  });


  self.classList.add('bg-indigo-600', 'text-white');
  self.classList.remove('text-gray-600', 'hover:bg-indigo-100', 'hover:text-indigo-700');

  new ContentLoader({
    url: `/api/teacher/${id}/notas`,
    containerName: "#studentButtonsContainer"
  }).load(addStudentButton);
}

function addStudentButton(data, container) {
  console.log(data);
}

window.loadAnalyticsView = loadAnalyticsView;
