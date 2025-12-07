import $ from 'jquery';
import {ContentLoader} from "../common/ContentLoader.js";
import {ucfirst} from "../common/Utils.js";

let gradeChartDetail;
let cursosLoader = new ContentLoader(
  {
      url: "/api/student/cursos",
      containerName: "#courses-buttons-container",
  }
);

export function loadAvailableCourses() {
  cursosLoader.load((data, container) => {
    renderCourseButtons(data, container);
  });
}

function renderCourseButtons(courses, container) {
  if (courses.length === 0) {
    container.html(`
            <div class="text-gray-500 italic">
                No tienes cursos asignados.
            </div>
        `);
    return;
  }

  const buttonsHTML = courses.map(course => `
    <button
      class="course-btn flex items-center justify-center w-full sm:w-auto
             font-medium px-5 py-2.5 rounded-xl shadow-md
             transition-all duration-200 ease-out transform
             hover:text-gray-50
             hover:bg-blue-700 hover:shadow-lg hover:-translate-y-0.5
             focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2"
      data-course-id="${course.id}"
      data-course-name="${course.nombre}">
        <span class="text-base tracking-wide">${course.nombre} (${course.turno}) - ${ucfirst(course.tipo)}</span>
    </button>
    `).join('');

  container.html(buttonsHTML);

  // Agregar event listeners a los botones
  $('.course-btn').on('click', function() {
    const courseId = $(this).data('course-id');
    const courseName = $(this).data('course-name');

    selectCourse(courseId, courseName);
  });
}

function selectCourse(courseId, courseName) {
  // Desactivar todos los botones
  $('.course-btn').removeClass('active');

  // Activar solo el seleccionado
  const $selected = $(`.course-btn[data-course-id="${courseId}"]`);
  $selected.addClass('active').removeClass('bg-blue-200 text-gray-500');

  // Actualizar título del gráfico
  $('#chart-title').text(`Rendimiento en ${courseName}`);

  // Aquí puedes llamar tu función AJAX
  loadCourseData(courseId);
}

function loadCourseData(courseId) {
  new ContentLoader({
    url: `/api/student/cursos/${courseId}/notas`,
    containerName: '#gradeChartDetail',
  }).load((data, container) => {
    renderGradeChart(data, container);
  }, () => {
    if(gradeChartDetail) {
      gradeChartDetail.dispose();
      gradeChartDetail = null;
    }
  });
}

function renderGradeChart(data, container) {
  const xaxis = ['Nota 1', 'Nota 2', 'Nota 3'];

  const generateSeriesList = () => {
    const seriesList = [];
    const rankingMap = new Map(Object.entries(data));
    rankingMap.forEach((data, name) => {
      const series = {
        name,
        symbolSize: 12,
        type: 'line',
        smooth: false,
        emphasis: {
          focus: 'series'
        },
        endLabel: {
          show: true,
          formatter: '{a}',
          distance: 20
        },
        lineStyle: {
          width: 4
        },
        data
      };
      seriesList.push(series);
    });
    return seriesList;
  };

  let seriesList = generateSeriesList();

  let legendText = seriesList
    .map(
      s => `${s.name}: ${s.data.join(', ')}`
    )
    .join('\n');

  let gradeChartOptions = {
    tooltip: { trigger: 'item' },
    grid: {
      top: 80,
      left: 40,
      right: 80,
      bottom: 80,
      containLabel: true
    },
    xAxis: {
      type: 'category',
      boundaryGap: false,
      data: xaxis
    },
    yAxis: {
      type: 'value',
      min: 0,
      max: 20
    },
    series: seriesList,

    graphic: [
      {
        type: 'group',
        left: 'center',
        bottom: 10,
        children: [
          {
            type: 'text',
            style: {
              text: legendText,
              fill: '#374151',
              font: '14px sans-serif',
              lineHeight: 22,
              textAlign: 'center'
            }
          }
        ]
      }
    ]
  };

  if(!gradeChartDetail) {
    gradeChartDetail = echarts.init(container[0]);
  }

  gradeChartDetail.setOption(gradeChartOptions);
}
