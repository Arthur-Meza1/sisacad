import $ from 'jquery';
import * as echarts from 'echarts';
import {ContentLoader} from "../common/ContentLoader.js";

let gradeChartDetail;

export function selectCourse(courseId, courseName) {
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

window.selectCourse = selectCourse;

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
  let originalParcial = null;
  if (data.sustitutorio) {
    originalParcial = [...data.parcial];
    if (data.parcial[0] <= data.parcial[1]) {
      data.parcial[0] = data.sustitutorio;
    } else {
      data.parcial[1] = data.sustitutorio;
    }
  }

  let gradeChartOptions = {
    tooltip: { trigger: 'item' },
    xAxis: {
      type: 'category',
      boundaryGap: false,
      data: ['Nota 1', 'Nota 2', 'Nota 3']
    },
    yAxis: {
      type: 'value',
      min: 0,
      max: 20,
      interval: 1
    },
    series: [
      {
        name: "Parcial",
        symbolSize: 12,
        type: 'line',
        smooth: false,
        emphasis: {
          focus: 'series'
        },
        lineStyle: {
          width: 4
        },
        data: data.parcial
      },
      {
        name: "Continua",
        symbolSize: 12,
        type: 'line',
        smooth: false,
        emphasis: {
          focus: 'series'
        },
        lineStyle: {
          width: 4
        },
        data: data.continua
      },
      {
        name: "Parcial",
        symbolSize: 12,
        type: 'line',
        silent: true,
        smooth: false,
        itemStyle: {
          color: '#FFA500',      // relleno
          opacity: 0.6,
        },
        lineStyle: {
          color: '#FFA500',   // naranja
          type: 'dashed',     // discontinuo
          opacity: 0.6,
          width: 4
        },
        z: -10,
        data: originalParcial
      },
    ],
    legend: {
      top: 10
    }
  };

  if(!gradeChartDetail) {
    gradeChartDetail = echarts.init(container[0]);
  }

  gradeChartDetail.setOption(gradeChartOptions);
}
