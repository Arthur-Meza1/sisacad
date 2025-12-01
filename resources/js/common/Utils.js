export function convertDiaToInt(dia) {
  const s_dayMap = {
    'lunes': 1,
    'martes': 2,
    'miercoles': 3,
    'jueves': 4,
    'viernes': 5
  };

  return s_dayMap[dia.toLowerCase()];
}

export function convertIntToDia(dia) {
  const s_dayMap = {
    1: 'lunes',
    2: 'martes',
    3: 'miercoles',
    4: 'jueves',
    5: 'viernes'
  };

  return s_dayMap[dia];
}

export function formatDate(d) {
  return `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;
}

export function formatTime(d) {
  return `${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;
}

export function ucfirst(val) {
  return String(val).charAt(0).toUpperCase() + String(val).slice(1);
}

export function isDateInEvent(date, event) {
  return event.start <= date && event.end >= date;
}

export function isInNowEvent(event) {
  return isDateInEvent(new Date(), event);
}

export function convertTimeStrToDate(timeStr) {
  const [h, m, s] = timeStr.split(":").map(Number);
  return new Date(0, 0, 0, h, m, s);
}

export function convertDateStringToDate(dateStr) {
  const [y, m, d] = dateStr.split("-").map(Number);
  return new Date(y, m-1, d);
}

export function sameDay(a, b) {
  return a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a.getDate() === b.getDate();
}
