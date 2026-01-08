import tippy from "tippy.js";
import {Calendar} from "fullcalendar";

function convertDiaToInt(dia) {
  const s_dayMap = {
    'lunes': 1,
    'martes': 2,
    'miercoles': 3,
    'jueves': 4,
    'viernes': 5
  };

  return s_dayMap[dia.toLowerCase()];
}

function convertDateStringToDate(dateStr, time) {
  const [y, m, d] = dateStr.split("-").map(Number);
  const [hour, minutes] = time.split(":").map(Number);
  return new Date(y, m-1, d, hour, minutes);
}

function ucfirst(val) {
  return String(val).charAt(0).toUpperCase() + String(val).slice(1);
}

export class Calendario {
  #fullCalendarOptions;
  #eventDidMount;

  /**
   * @param data
   */
  constructor(data) {
    const [events, sesionSet] = this.#createEvents(data);
    const selfEventDidMount = (info) => this?.#eventDidMount(info);
    this.#fullCalendarOptions = {
      initialView: 'timeGridWeek',
      slotMinTime: '06:00:00',
      slotMaxTime: "20:00:00",
      eventMaxStack: 3,
      weekends: false,
      allDaySlot: false,
      nowIndicator: true,
      height: 'auto',
      locale: 'es',

      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'timeGridWeek,timeGridDay'
      },

      events,

      eventDidMount: (info) => {
        const props = info.event.extendedProps;
        tippy(info.el, {
          content: `
          <div>
            <strong>${props.grupo.nombre}</strong><br>
            Tipo: ${ucfirst(props.tipo)}<br>
            Aula: ${props.aula.nombre}<br>
            Turno: ${props.turno}<br>
            Horario: ${props.horaInicio} - ${props.horaFin}
          </div>
        `,
          allowHTML: true,
          placement: 'top',
        });

        if(props.sesion === false) {
          const key = `${info.event.start.toISOString()}${info.event.end.toISOString()}`;
          if(sesionSet.has(key)) {
            info.el.style.display = "none";
          }
        }

        selfEventDidMount(info);
      },
    };
  }

  selectable() {
    this.#fullCalendarOptions.selectable = true;
    return this;
  }

  eventClick(callback) {
    this.#fullCalendarOptions.eventClick = callback;
    return this;
  }

  select(callback) {
    this.#fullCalendarOptions.select = callback;
    return this;
  }

  eventDidMount(callback) {
    this.#eventDidMount = callback;
    return this;
  }

  render(fullCalendarInstance, container) {
    if (fullCalendarInstance?.destroy) fullCalendarInstance.destroy();
    fullCalendarInstance = new Calendar(container, this.#fullCalendarOptions);
    fullCalendarInstance.render();

    return fullCalendarInstance;
  }

  #createEvents(data) {
    const sesionSet =  new Set();
    const sesiones = data.sesiones.map(function (item) {
      const key = `${convertDateStringToDate(item.fecha, item.horaInicio).toISOString()}${convertDateStringToDate(item.fecha, item.horaFin).toISOString()}`;
      sesionSet.add(key);
      return {
        title: `${item.grupo.nombre} - ${ucfirst(item.tipo)}`,
        className: "ec-session",
        start: `${item.fecha}T${item.horaInicio}`,
        end: `${item.fecha}T${item.horaFin}`,
        extendedProps: {
          sesion: true,
          ...item
        },
      }
    });

    const horario =
      data
        .horario
        .map(function (item) {
          const colorMap = { teoria: '#60a5fa', laboratorio: '#2aa87c' };
          return {
            title: `${item.grupo.nombre} - ${ucfirst(item.tipo)}`,
            backgroundColor: colorMap[item.tipo],
            borderColor: colorMap[item.tipo],
            daysOfWeek: [convertDiaToInt(item .dia)],
            startTime: item.horaInicio,
            endTime: item.horaFin,
            extendedProps: {
              sesion: false,
              ...item
            },
          }
        });

    const others = (data.occupied || []).map(function (item) {
      const props = {
        display: 'background',
        backgroundColor: 'red',
      };

      if(item.from_bloque === true) {
        props.daysOfWeek = [convertDiaToInt(item.fecha)];
        props.startTime= item.horaInicio;
        props.endTime = item.horaFin;
      } else {
        props.start = `${item.fecha}T${item.horaInicio}`;
        props.end =`${item.fecha}T${item.horaFin}`;
      }

      return props;
    });

    return [[...horario, ...sesiones, ...others], sesionSet];
  }
}
