import * as echarts from 'echarts';

export function createArrowsFromStudents(data, index, container) {
  const option = {
    title: {
      text: "Notas Parciales & Continuas",
      left: "center",
      textStyle: {
        fontSize: 20,
        fontWeight: "bold",
        color: "#333"
      }
    },
    tooltip: {
      trigger: "axis",
    },
    legend: {
      top: 50,
      left: "center",
      textStyle: {
        fontSize: 14,
        color: "#555"
      },
      data: ["Parcial", "Continua"]
    },
    grid: {
      top: 100,
      left: '10%',
      right: '10%',
      bottom: '10%',
      containLabel: true
    },
    xAxis: {
      name: "Unidad",
      type: 'category',
      boundaryGap: false,
      data: ["1", "2", "3"],
      splitLine: {
        lineStyle: {
          opacity: 0.2
        }
      },
      axisLine: {
        lineStyle: {
          color: "#999"
        }
      }
    },
    yAxis: {
      name: "Nota",
      type: 'value',
      min: 0,
      max: 20,
      interval: 2,
      splitLine: {
        lineStyle: {
          opacity: 0.2
        }
      },
      axisLine: {
        lineStyle: {
          color: "#999"
        }
      }
    },
    series: [
      {
        name: "Parcial",
        data: data[index].parcial,
        type: 'line',
        lineStyle: {
          width: 3,
          color: "#5470C6"
        },
        symbolSize: 8,
      },
      {
        name: "Continua",
        data: data[index].continua,
        type: 'line',
        lineStyle: {
          width: 3,
          color: "#91CC75"
        },
        symbolSize: 8,
      },
      {
        name: "Promedio Parcial",
        data: [0,1,2].map(i => data.reduce((sum, x) => sum + x.parcial[i], 0) / data.length),
        type: 'line',
        smooth: true,
        lineStyle: {
          type: 'dashed',
          width: 2,
          color: "#ff0000",
          opacity: 0.3,
        },
        symbol: 'circle',
        symbolSize: 6,
        z: -1,
      },
      {
        name: "Promedio Continua",
        data: [0,1,2].map(i => data.reduce((sum, x) => sum + x.continua[i], 0) / data.length),
        type: 'line',
        smooth: true,
        lineStyle: {
          type: 'dashed',
          width: 2,
          color: "#002aff",
          opacity: 0.3,
        },
        symbol: 'circle',
        symbolSize: 6,
        z: -1,
      },
      {
        type: 'line',
        data: Array(3).fill(null),
        silent: true,
        markLine: {
          data: [
            { yAxis: 10.5 }
          ],
        },
        tooltip: {
          show: false  // desactiva tooltip solo para esta serie
        }
      }
    ]
  };


  let chart = echarts.getInstanceByDom(container);
  if (!chart) {
    chart = echarts.init(container);
  } else {
    chart.clear();
  }
  chart.setOption(option);
}
