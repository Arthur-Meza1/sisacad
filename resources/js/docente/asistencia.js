export function loadAsistencia(props) {
  document.getElementById('modal-asistencia').classList.remove('hidden');
  console.log(props);
  document.getElementById("asistencia-title").textContent = `Asistencia - ${props.nombre}`;
}

function closeAsistenciaModal() {
  document.getElementById('modal-asistencia').classList.add('hidden');
}

window.closeAsistenciaModal = closeAsistenciaModal;

document.querySelectorAll('.row-select').forEach(row => {
  row.addEventListener('click', function (e) {
    // Evitar que el click directo en el checkbox duplique el toggle
    if (e.target.tagName.toLowerCase() === 'input') return;

    const checkbox = row.querySelector('input[type="checkbox"]');
    checkbox.checked = !checkbox.checked;
  });
});
