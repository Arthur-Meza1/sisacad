import * as echarts from 'echarts';

export function createBarsFromParcial(data, container) {
  const option = {
    title: {
      text: "Notas Parciales",
      left: "center",
      textStyle: {
        fontSize: 18,
        fontWeight: "bold"
      }
    },
    legend: {
      top: 50,
      left: "center",
      textStyle: {
        fontSize: 14
      }
    },
    tooltip: {
      trigger: 'axis',
      axisPointer: {
        type: 'shadow',
      }
    },
    grid: {
      top: 90,
      left: '10%',
      right: '10%',
      bottom: '10%',
      containLabel: true
    },
    xAxis: [
      {
        interval: 1,
        position: 'top',
        type: 'value',
      }
    ],
    yAxis: [
      {
        inverse: true,
        type: 'category',
        data: [...data.map(x => x.nombre)]
      }
    ],
    series: [
      {
        name: 'Parcial 1',
        type: 'bar',
        data: [...data.map(x => x.parcial[0])],
      },
      {
        name: 'Parcial 2',
        type: 'bar',
        data: [...data.map(x => x.parcial[1])],
      },
      {
        name: 'Parcial 3',
        type: 'bar',
        data: [...data.map(x => x.parcial[2])],
      },
      {
        type: 'bar',
        data: [],
        silent: true,
        markLine: {
          data: [
            {xAxis: 10.5}
          ]
        },
      },
      {
        name: 'Promedio (Tendencia)',
        type: 'line',
        smooth: true,
        symbol: 'circle',
        symbolSize: 4,
        lineStyle: {
          width: 2,
          color: '#EE6666',
        },
        data: data.map(x => {
          const suma = x.parcial[0] + x.parcial[1] + x.parcial[2];
          return parseFloat((suma / 3).toFixed(2));
        }),
        z: 10
      },
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

export function createBarsFromContinua(data, container) {
  const option = {
    title: {
      text: "Notas Continua",
      left: "center",
      textStyle: {
        fontSize: 18,
        fontWeight: "bold"
      }
    },
    legend: {
      top: 50,
      left: "center",
      textStyle: {
        fontSize: 14
      }
    },
    tooltip: {
      trigger: 'axis',
      axisPointer: {
        type: 'shadow',
      }
    },
    grid: {
      top: 90,
      left: '10%',
      right: '10%',
      bottom: '10%',
      containLabel: true
    },
    xAxis: [
      {
        interval: 1,
        position: 'top',
        type: 'value',
      }
    ],
    yAxis: [
      {
        inverse: true,
        type: 'category',
        data: [...data.map(x => x.nombre)]
      }
    ],
    series: [
      {
        name: 'Continua 1',
        type: 'bar',
        data: [...data.map(x => x.continua[0])],
      },
      {
        name: 'Continua 2',
        type: 'bar',
        data: [...data.map(x => x.continua[1])],
      },
      {
        name: 'Continua 3',
        type: 'bar',
        data: [...data.map(x => x.continua[2])],
      },
      {
        type: 'bar',
        data: [],
        silent: true,
        markLine: {
          data: [
            {xAxis: 10.5}
          ]
        },
      },
      {
        name: 'Promedio (Tendencia)',
        type: 'line',
        smooth: true,
        symbol: 'circle',
        symbolSize: 4,
        lineStyle: {
          width: 2,
          color: '#EE6666',
        },
        data: data.map(x => {
          const suma = x.continua[0] + x.continua[1] + x.continua[2];
          return parseFloat((suma / 3).toFixed(2));
        }),
        z: 10
      },
    ]
  };

  const chart = echarts.init(container);
  chart.setOption(option);
}
