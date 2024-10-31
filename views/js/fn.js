function cargarMaterias() {
    const institucionId = document.getElementById('institucion_id').value;

    fetch(`index.php?institucion_id=${institucionId}`)
        .then(response => response.json())
        .then(materias => {
            const materiaSelect = document.getElementById('materia_id');
            materiaSelect.innerHTML = '<option value="">Seleccione una materia</option>';
            materias.forEach(materia => {
                const option = document.createElement('option');
                option.value = materia.id;
                option.textContent = materia.nombre;
                materiaSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error al cargar materias:', error));
}

function cargarMateriasProfesor() {
    const institucionId = document.getElementById('institucion_id').value;

    fetch(`registro_profesor.php?institucion_id=${institucionId}`)
        .then(response => response.json())
        .then(materias => {
            const materiaSelect = document.getElementById('materia_id');
            materiaSelect.innerHTML = '<option value="">Seleccione una materia</option>';
            materias.forEach(materia => {
                const option = document.createElement('option');
                option.value = materia.id;
                option.textContent = materia.nombre;
                materiaSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error al cargar materias:', error));
}

document.getElementById('materia_id').addEventListener('change', function() {
    const institucionId = document.getElementById('institucion_id').value;
    const materiaId = this.value;

    // Solo enviar cuando ambas selecciones están hechas
    if (institucionId && materiaId) {
        fetch('guardar_sesion.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `institucion_id=${institucionId}&materia_id=${materiaId}`
        })
        .then(response => response.text())
        .catch(error => console.error('Error al guardar en sesión:', error));
    }
});
/*
function obtenerAsistencias() {
    const fecha = document.getElementById('fecha').value;
    if (!fecha) return;

    fetch(`../../ajax/obtener_asistencias.php?fecha=${fecha}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const alumnos = document.querySelectorAll('tbody tr');
            alumnos.forEach((alumno) => {
                const id = alumno.querySelector('input[name="alumno_ids[]"]').value; // Obtener el ID del alumno
                const asistenciaSelect = alumno.querySelector('select[name="asistencias[]"]');
                
                if (data[id]) {
                    asistenciaSelect.value = data[id]; // Actualiza el select si hay datos
                } else {
                    asistenciaSelect.value = 'presente'; // Por defecto
                }
            });
        })
        .catch(error => console.error('Error:', error));
}
        */
  function obtenerAsistencias() {
    const fecha = document.getElementById('fecha').value;
    console.log("Fecha seleccionada:", fecha); // Comprobar valor
    if (!fecha) return;
    fetch(`../../obtener_asistencias.php?fecha=${fecha}`)
    .then(response => response.text()) // Usa .text() en lugar de .json() para ver la respuesta cruda
    .then(data => {
        console.log("Respuesta del servidor:", data); // Muestra la respuesta completa
        return JSON.parse(data); // luego intenta convertir a JSON
    })
    .then(data => {
        console.log(data);
        const alumnos = document.querySelectorAll('tbody tr');
        alumnos.forEach((alumno) => {
            const id = alumno.querySelector('input[name="alumno_ids[]"]').value; // Obtener el ID del alumno
            const asistenciaSelect = alumno.querySelector('select[name="asistencias[]"]');
            
            if (data[id]) {
                asistenciaSelect.value = data[id]; // Actualiza el select si hay datos
            } else {
                asistenciaSelect.value = 'presente'; // Por defecto
            }
        });
    })
    .catch(error => console.error('Error:', error));
}
