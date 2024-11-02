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

function registrarAlumno(){
    Swal.fire({
        title: "¿Registrar alumno?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, registrar"
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: "Registrado!",
            text: "Alumno registrado con éxito",
            icon: "success",
            timer: 1600
          });
          setTimeout (()=>{
            document.getElementById("formulario_registro").submit();
          },1600)
        }
      })
}

function registrarAlumnoMateria(){
    Swal.fire({
        title: "¿Estás seguro?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, matricular"
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: "Matriculado!",
            text: "Alumno matriculado con éxito",
            icon: "success",
            timer: 1600
          });
          setTimeout (()=>{
            document.getElementById("formulario_registro").submit();
          },1600)
        }
      })
}

function registrarNotas(){
    Swal.fire({
        title: "¿Registrar notas?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, registrar"
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: "Registrado!",
            text: "Notas registradas con éxito",
            icon: "success",
            timer: 1600
          });
          setTimeout (()=>{
            document.getElementById("formulario_registro").submit();
          },1600)
        }
      })
}

function registrarAsistencia(){
    Swal.fire({
        title: "¿Registrar asistencias?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, registrar"
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: "Registrado!",
            text: "Asistencias registradas con éxito",
            icon: "success",
            timer: 1600
          });
          setTimeout (()=>{
            document.getElementById("formulario_registro").submit();
          },1600)
        }
      })
}