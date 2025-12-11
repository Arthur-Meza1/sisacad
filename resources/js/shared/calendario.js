import {convertDateStringToDate, convertDiaToInt, ucfirst} from "../common/Utils.js";
import tippy from "tippy.js";
import {Calendar} from "fullcalendar";

export class Calendario {
  #fullCalendarOptions;
  #onEventDidMount = (info) => true;

  /**
   * @param data
   */
  constructor(data) {
    const events = this.#createEvents(data);
    const self = this;

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

      eventDidMount: function(info) {
        if(!self.#onEventDidMount(info))
          return;

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
    this.#fullCalendarOptions.eventDidMount = callback;
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
      sesionSet.add(`${convertDateStringToDate(item.fecha).getDay()}${item.horaInicio}${item.horaFin}`);
      return {
        title: `${item.grupo.nombre} - ${ucfirst(item.tipo)}`,
        className: "ec-session",
        start: `${item.fecha}T${item.horaInicio}`,
        end: `${item.fecha}T${item.horaFin}`,
        extendedProps: item,
      }
    });

    const horario =
      data
        .horario
        .filter(item => !sesionSet.has(`${convertDiaToInt(item.dia)}${item.horaInicio}${item.horaFin}`))
        .map(function (item) {
          const colorMap = { teoria: '#60a5fa', laboratorio: '#2aa87c' };
          return {
            title: `${item.grupo.nombre} - ${ucfirst(item.tipo)}`,
            backgroundColor: colorMap[item.tipo],
            borderColor: colorMap[item.tipo],
            daysOfWeek: [convertDiaToInt(item .dia)],
            startTime: item.horaInicio,
            endTime: item.horaFin,
            extendedProps: item,
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

    return [...horario, ...sesiones, ...others];
  }
}
