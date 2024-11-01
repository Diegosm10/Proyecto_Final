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