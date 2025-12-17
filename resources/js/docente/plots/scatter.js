import * as echarts from "echarts";
import {transform} from "echarts-stat";

echarts.registerTransform(transform.regression);

export function createScatterPlotFromData(data, container) {
  if(data == null || data.length == 0) {
    data = [{
      nombre: "",
      parcial: [null, null, null],
      continua: [null, null, null]
    }];
  }

  const option = {
    dataset: [
      // Parcial 1
      {
        source: data.map(x => ({
          alumno: x.nombre,
          parcial: x.parcial[0] + (Math.random() - 0.5) * 0.3,
          continua: x.continua[0] + (Math.random() - 0.5) * 0.3
        }))
      },
      // Parcial 2
      {
        source: data.map(x => ({
          alumno: x.nombre,
          parcial: x.parcial[1] + (Math.random() - 0.5) * 0.3,
          continua: x.continua[1] + (Math.random() - 0.5) * 0.3
        }))
      },
      // Parcial 3
      {
        source: data.map(x => ({
          alumno: x.nombre,
          parcial: x.parcial[2] + (Math.random() - 0.5) * 0.3,
          continua: x.continua[2] + (Math.random() - 0.5) * 0.3
        }))
      },
      {
        source: data.flatMap(x => [
          [x.parcial[0], x.continua[0]],
          [x.parcial[1], x.continua[1]],
          [x.parcial[2], x.continua[2]],
        ])
      },
      {
        fromDatasetIndex: 3,
        transform: {
          type: 'ecStat:regression',
          config: { method: 'polynomial', order: 1 }
        }
      }
    ],
    tooltip: {
      trigger: 'item',
      formatter: p => {
        const v = p.value || null;
        return `
          <strong>${v.alumno}</strong><br>
          Parcial: ${Math.round(v.parcial)}<br>
          Continua: ${Math.round(v.continua)}
        `;
      },
      axisPointer: {
        type: 'cross'
      }
    },
    title: {
      text: "Notas Parciales vs Notas Continuas",
    },
    xAxis: {
      name: "Parcial",
      min: 0,
      max: 20,
      interval: 1,
      splitLine: {
        lineStyle: {
          opacity: 0.3  // más transparente
        }
      }
    },
    yAxis: {
      name: "Continua",
      min: 0,
      max: 20,
      interval: 1,
      splitLine: {
        lineStyle: {
          opacity: 0.3  // más transparente
        }
      }
    },
    series: [
      { name: 'Unidad 1', type: 'scatter', datasetIndex: 0, encode: { x: 'parcial', y: 'continua' } },
      { name: 'Unidad 2', type: 'scatter', datasetIndex: 1, encode: { x: 'parcial', y: 'continua' } },
      { name: 'Unidad 3', type: 'scatter', datasetIndex: 2, encode: { x: 'parcial', y: 'continua' } },
      { name: 'Regresión', type: 'line', datasetIndex: 4, smooth: true, silent: true}
    ],
    legend: {
    }
  };

  let chart = echarts.getInstanceByDom(container);
  if (!chart) {
    chart = echarts.init(container);
  } else {
    chart.clear();
  }
  chart.setOption(option);
}
