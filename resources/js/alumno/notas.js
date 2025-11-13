import $ from 'jquery';

export function loadAvailableCourses() {
  $.ajax({
    url: '/api/student/cursos',
    method: 'GET',
    beforeSend: function() {
      $('#courses-buttons-container').html(`
                <div class="flex items-center space-x-2 text-gray-500">
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600"></div>
                    <span>Cargando cursos...</span>
                </div>
            `);
    },
    success: function(courses) {
      renderCourseButtons(courses);
    },
    error: function(xhr) {
      $('#courses-buttons-container').html(`
                <div class="text-red-500 bg-red-50 p-3 rounded-lg">
                    Error al cargar cursos. Intenta nuevamente.
                </div>
            `);
    }
  });
}

function renderCourseButtons(courses) {
  if (courses.length === 0) {
    $('#courses-buttons-container').html(`
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
      <span class="text-base tracking-wide">${course.nombre}</span>
  </button>
`).join('');

  $('#courses-buttons-container').html(buttonsHTML);

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
  showLoading();

  $.ajax({
    url: `/api/student/cursos/${courseId}/notas`,
    method: 'GET',
    success: function(courseData) {
      renderGradeChart(courseData);
      hideLoading();
    },
    error: function(xhr) {
      hideLoading();
      console.error('Error:', xhr);
    }
  });
}

function showLoading() {
  $('#grades-loading').removeClass('hidden');
}

function hideLoading() {
  $('#grades-loading').addClass('hidden');
}

let gradeChartDetail;

function renderGradeChart(data) {
  const yaxis = [
    'Parcial',
    'Continua',
  ];
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

  if (!gradeChartDetail) {
    gradeChartDetail = echarts.init(document.getElementById('gradeChartDetail'));
  }

  gradeChartDetail.setOption(gradeChartOptions);
  gradeChartDetail.resize();
}
