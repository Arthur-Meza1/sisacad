import * as echarts from 'echarts';

export function createBoxPlotFromData(data, container) {
  const option = {
    title: {
      text: "Notas Parciales & Continuas"
    },
    legend: {
      top: 50
    },
    grid: {
      top: 90,              // deja espacio suficiente para título + leyenda
      left: '10%',
      right: '10%',
      bottom: '10%',
      containLabel: true
    },
    xAxis: {
      name: "Unidad",
      type: 'category',
      boundaryGap: true,
      nameGap: 30,
      splitArea: {
        show: true
      },
      splitLine: {
        show: false
      }
    },
    yAxis: {
      name: 'Notas',
      type: 'value',
      min: 0,
      max: 20,
      splitArea: {
        show: false
      },
      splitLine: {
        lineStyle: {
          opacity: 0.3  // más transparente
        }
      },
      interval: 1,
    },
    tooltip: {
      trigger: 'item',   // muestra tooltip por serie individual
      formatter: function (params) {
        if (params.seriesType === 'boxplot') {
          const vals = params.data;
          return `
        <strong>${params.name}</strong><br/>
        Mínimo: ${vals[1]}<br/>
        Q1: ${vals[2]}<br/>
        Mediana: ${vals[3]}<br/>
        Q3: ${vals[4]}<br/>
        Máximo: ${vals[5]}
      `;
        }
      },
      axisPointer: {
        type: 'shadow'   // ayuda a ver la barra que corresponde al tooltip
      }
    },
    dataset: [
      {
        source: [
          data.map(x => x.parcial[0]),
          data.map(x => x.parcial[1]),
          data.map(x => x.parcial[2]),
          data.flatMap(x => x.parcial),
        ]
      },
      {
        source: [
          data.map(x => x.continua[0]),
          data.map(x => x.continua[1]),
          data.map(x => x.continua[2]),
          data.flatMap(x => x.continua),
        ]
      },
      {
        fromDatasetIndex: 0,
        transform: {
          type: 'boxplot',
          config: {
            itemNameFormatter: item => ['Unidad 1','Unidad 2','Unidad 3','Todo'][item.value]
          }
        }
      },
      {
        fromDatasetIndex: 1,
        transform: {
          type: 'boxplot',
          config: {
            itemNameFormatter: item => ['Unidad 1','Unidad 2','Unidad 3','Todo'][item.value]
          }
        }
      },
    ],
    dataZoom: [
      { type: 'inside', start: 0, end: 100 },
      { show: true, type: 'slider', top: '90%', xAxisIndex: 0, start: 0, end: 100 }
    ],
    series: [
      {
        name: "Parcial",
        type: 'boxplot',
        datasetIndex: 2
      },
      {
        name: "Continua",
        type: 'boxplot',
        datasetIndex: 3
      },
      {
        type: 'bar',
        data: [],
        silent: true,
        markLine: {
          data: [
            {yAxis: 10.5}
          ]
        },
      }
    ],
  };

  let chart = echarts.getInstanceByDom(container);
  if (!chart) {
    chart = echarts.init(container);
  } else {
    chart.clear();
  }
  chart.setOption(option);
}
