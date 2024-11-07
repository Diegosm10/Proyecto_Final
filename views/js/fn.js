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

 
   function evitar_envio_formulario(){
    var isValid = true;  // Inicializamos la variable isValid como verdadera (el formulario puede enviarse)

    // Obtenemos los valores de los inputs
    var nombre = document.getElementById("nombre").value;
    var apellido = document.getElementById("apellido").value;
    var dni = document.getElementById("dni").value;
    var email = document.getElementById("email").value;
    var fechaNacimiento = document.getElementById("fecha_nacimiento").value;

    // Validación de Nombre (solo letras)
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/.test(nombre)) {
        alert("El nombre solo puede contener letras.");
        isValid = false;  // Marcamos la validación como falsa si hay un error
    }

    // Validación de Apellido (solo letras)
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/.test(apellido)) {
        alert("El apellido solo puede contener letras.");
        isValid = false;  // Marcamos la validación como falsa si hay un error
    }

    // Validación de DNI (solo números y una longitud mínima)
    if (!/^\d{7,8}$/.test(dni)) {
        alert("El DNI debe ser un número de 7 u 8 dígitos.");
        isValid = false;  // Marcamos la validación como falsa si hay un error
    }

    // Validación de Email (formato correcto de email)
    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        alert("Por favor ingrese un email válido.");
        isValid = false;  // Marcamos la validación como falsa si hay un error
    }

    // Validación de Fecha de Nacimiento (no vacío)
    if (!fechaNacimiento) {
        alert("Por favor ingrese su fecha de nacimiento.");
        isValid = false;  // Marcamos la validación como falsa si hay un error
    }

    // Si hay errores de validación, no enviamos el formulario
    if (!isValid) {
        event.preventDefault();  // Detenemos el envío del formulario si hay errores
    }
};

function registrarAlumno() {
  event.preventDefault(); 
  Swal.fire({
      title: '¿Estás seguro?',
      text: "¿Quieres registrar este alumno?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, registrar',
      cancelButtonText: 'Cancelar'
  }).then((result) => {
      if (result.value) {
          document.formulario_registro_alumno.submit();
      }
      return false;
  });
};

function registrarAlumnoMateria() {
  event.preventDefault();
  Swal.fire({
      title: '¿Estás seguro?',
      text: "¿Quieres matricular a este alumno en la materia seleccionada?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, matricular',
      cancelButtonText: 'Cancelar'
  }).then((result) => {
      if (result.isConfirmed) {
        console.log("Formulario confirmado"); 
          event.target.submit();
      }
  });
};

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
            document.getElementById("formulario").submit();
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
            document.getElementById("formulario").submit();
          },1600)
        }
      })
}

function actualizarParametros(){
  Swal.fire({
      title: "¿Actualizar parámetros?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, modificar"
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Actualizados!",
          text: "Parametros actualizados con éxito",
          icon: "success",
          timer: 1600
        });
        setTimeout (()=>{
          document.getElementById("formulario").submit();
        },1600)
      }
    })
}

function registrarInstitucion(){
  Swal.fire({
    title: "¿Registrar institución?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, registrar"
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Registrado!",
        text: "Institución registrada con éxito",
        icon: "success",
        timer: 1600
      });
      setTimeout (()=>{
        document.getElementById("formulario").submit();
      },1600)
    }
  })
}

function registroMateriaInstitucion(){
  Swal.fire({
    title: "¿Registrar materia a institución?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, registrar"
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Registrado!",
        text: "Materia registrada con éxito",
        icon: "success",
        timer: 1600
      });
      setTimeout (()=>{
        document.getElementById("formulario").submit();
      },1600)
    }
  })
}

function registrarProfesor(){
  Swal.fire({
    title: "¿Registrar profesor?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, registrar"
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Registrado!",
        text: "Profesor registrado con éxito",
        icon: "success",
        timer: 1600
      });
      setTimeout (()=>{
        document.getElementById("formulario").submit();
      },1600)
    }
  })
}

function registrarMateriaProfesor(){
  Swal.fire({
    title: "¿Registrar profesor a materia?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, registrar"
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Registrado!",
        text: "Materia registrada con éxito",
        icon: "success",
        timer: 1600
      });
      setTimeout (()=>{
        document.getElementById("formulario").submit();
      },1600)
    }
  })
}

function registrarMaterias(){
  Swal.fire({
    title: "¿Registrar materia?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, registrar"
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Registrada!",
        text: "Materia registrada con éxito",
        icon: "success",
        timer: 1600
      });
      setTimeout (()=>{
        document.getElementById("formulario").submit();
      },1600)
    }
  })
}


function eliminarAlumno(event) {
  event.preventDefault();

  Swal.fire({
    title: "¿Estás seguro de eliminar a este alumno?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Eliminado!",
        text: "Alumno eliminado con éxito",
        icon: "success",
        timer: 1600,
      });
      setTimeout(() => {
        if (result.isConfirmed) {
          window.location.href = event.target.href;
      }
      }, 1600); 
    }
  });
}