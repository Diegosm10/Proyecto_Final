<?php

require_once "conexion.php";
require_once "controllers/Usuario.php";
require_once "controllers/Institucion.php";
require_once "controllers/Profesor.php";
require_once "controllers/Alumno.php";
require_once 'controllers/Materia.php';
require_once 'funciones.php';

$database = new Database();
$db = $database->connect();

/*
Usuario de administrador
email: diego1234@gmail.com
contraseña: diego1234
*/

if (isset($_POST["profesor"])) {

    $usuario = new Usuario($db);

    $nombre = limpiarCadena($_POST["nombre_profesor"]);
    $apellido = limpiarCadena($_POST["apellido"]);
    $email = limpiarCadena($_POST["email_profesor"]);
    $dni = limpiarCadena($_POST["dni"]);
    $legajo = limpiarCadena($_POST["legajo"]);
    $fecha_nacimiento = limpiarCadena($_POST["fecha_nacimiento"]);
    $password = limpiarCadena($_POST["contrasena"]);

    $usuario->nombre = $nombre;
    $usuario->apellido = $apellido;
    $usuario->setEmail($email);
    $usuario->setPassword($password);
    $usuario->condicion = "profesor";

    if (verificarDatos("^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$", $nombre)) {
        $errors['nombre'] = "El nombre solo puede contener letras.";
    }
    if (verificarDatos("^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$", $apellido)) {
        $errors['apellido'] = "El apellido solo puede contener letras.";
    }
    if (verificarDatos("^\d{7,8}$", $dni)) {
        $errors['dni'] = "El DNI debe ser un número de 7 u 8 dígitos.";
    }
    if (verificarDatos("^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$", $email)) {
        $errors['email'] = "Por favor ingrese un email válido.";
    }

    if (!empty($errors)) {
        $query = http_build_query($errors);
        header("Location: views/content/registro_alumno.php?$query");
        exit;
    }

    $profesor = new Profesor($db);

    $profesor->setNombre($nombre);
    $profesor->setApellido($apellido);
    $profesor->setDni($dni);
    $profesor->setEmail($email);
    $profesor->setLegajo($legajo);
    $profesor->setFechaNacimiento($fecha_nacimiento);

    $usuario->create();
    $profesor->createProfesor();
    $_SESSION['mensaje_exito'] = "El profesor se registró exitosamente.";
    header("location: views/content/registro_profesor.php");
}

if (isset($_POST["asociar_materias_profesor"])) {
    $profesor_id = limpiarCadena($_POST["profesor_id"]);
    $materia_id = limpiarCadena($_POST["materia_id"]);
    $institucion_id = limpiarCadena($_POST["institucion_id"]);

    $profesor_id = intval($profesor_id);
    $materia_id = intval($materia_id);
    $institucion_id = intval($institucion_id);

    $consulta = "INSERT INTO materias_profesor (profesor_id, materias_id, institucion_id)
                 VALUES (:profesor_id, :materia_id, :institucion_id)";

    $stmt = $db->prepare($consulta);
    $stmt->bindParam(':profesor_id', $profesor_id);
    $stmt->bindParam(':materia_id', $materia_id);
    $stmt->bindParam(':institucion_id', $institucion_id);
    $stmt->execute();
    $_SESSION['mensaje_exito'] = "La materia se registró exitosamente.";
    header("location: views/content/registro_profesor.php");
}

if (isset($_POST["institucion"])) {
    $errors = [];

    $institucion = new Institucion($db);

    $nombre = limpiarCadena($_POST["nombre_institucion"]);
    $direccion = limpiarCadena($_POST["direccion"]);
    $telefono = limpiarCadena($_POST["telefono"]);
    $email = limpiarCadena($_POST["email_institucion"]);
    $cue = limpiarCadena($_POST["cue"]);
    $nota_regular = limpiarCadena($_POST["nota_regular"]);
    $nota_promocion = limpiarCadena($_POST["nota_promocion"]);
    $asistencia_regular = limpiarCadena($_POST["asistencia_regular"]);
    $asistencia_promocion = limpiarCadena($_POST["asistencia_promocion"]);



    $institucion->nombre = $nombre;
    $institucion->direccion = $direccion;
    $institucion->telefono = $telefono;
    $institucion->setEmail($email);
    $institucion->cue = $cue;

    if ($institucion->create()) {
        $institucionId = $db->lastInsertId();

        $parametros = Institucion::insertarParametrosRam($nota_regular, $nota_promocion, $asistencia_regular, $asistencia_promocion, $institucionId);
        $_SESSION['mensaje_exito'] = "La institución se registró exitosamente.";
        header("Location: views/content/registro_institucion.php");
    }
}

if (isset($_POST["materia"])) {
    $errors = [];


    $materia = new Materia($db);

    $nombre = limpiarCadena($_POST["nombre_materia"]);

    if (verificarDatos("^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$", $nombre)) {
        $errors['nombre'] = "El nombre solo puede contener letras.";
    }

    if (!empty($errors)) {
        $query = http_build_query($errors);
        header("Location: views/content/registro_materias.php?$query");
        exit;
    }

    $materia->nombre = $nombre;

    if ($materia->create()) {
        $_SESSION['mensaje_exito'] = "La materia se registró exitosamente.";
        header("location: views/content/registro_materias.php");
    }

}

if (isset($_POST["asociar_materia_institucion"])) {

    $selector_materia = limpiarCadena($_POST["materias"]);
    $selector_institucion = limpiarCadena($_POST["instituciones"]);

    $consulta = "INSERT INTO materias_institucion (institucion_id, materias_id)
    VALUES (:institucion_id, :materias_id)";

    $stmt = $db->prepare($consulta);
    $selector_materia = intval($selector_materia);
    $selector_institucion = intval($selector_institucion);

    $stmt->bindParam(':institucion_id', $selector_institucion);
    $stmt->bindParam(':materias_id', $selector_materia);

    if ($stmt->execute()) {
        $_SESSION['mensaje_exito'] = "La materia se registró exitosamente.";
        header("location: views/content/registro_institucion.php");
    }


}

if (isset($_POST["matricular"])) {
    $errors = [];



    $nombre = limpiarCadena($_POST["nombre"]);
    $apellido = limpiarCadena($_POST["apellido"]);
    $dni = limpiarCadena($_POST["dni"]);
    $email = limpiarCadena($_POST["email"]);
    $fecha_nacimiento = limpiarCadena($_POST["fecha_nacimiento"]);

    if (verificarDatos("^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$", $nombre)) {
        $errors['nombre'] = "El nombre solo puede contener letras.";
    }
    if (verificarDatos("^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$", $apellido)) {
        $errors['apellido'] = "El apellido solo puede contener letras.";
    }
    if (verificarDatos("^\d{7,8}$", $dni)) {
        $errors['dni'] = "El DNI debe ser un número de 7 u 8 dígitos.";
    }
    if (verificarDatos("^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$", $email)) {
        $errors['email'] = "Por favor ingrese un email válido.";
    }

    if (!empty($errors)) {
        $query = http_build_query($errors);
        header("Location: views/content/registro_alumno.php?$query");
        exit;
    }
    $alumno = new Alumno($db);

    $alumno->setNombre($nombre);
    $alumno->setApellido($apellido);
    $alumno->setDni($dni);
    $alumno->setEmail($email);
    $alumno->setFechaNacimiento($fecha_nacimiento);

    if ($alumno->createAlumno()) {
        $_SESSION['mensaje_exito'] = "El alumno se registró exitosamente.";
        header("location: views/content/registro_alumno.php");
    }
    ;
}

if (isset($_POST["asociar_alumno_materia"])) {
    var_dump($_POST);
    $alumnoId = $_POST['alumno_id'];
    $materiaId = $_POST['materia_id'];

    $resultado = Alumno::matricularAlumno($materiaId, $alumnoId);

    if ($resultado) {
        $_SESSION['mensaje_exito'] = "Alumno matriculado exitosamente.";
        header("location: views/content/registro_alumno.php");
        exit;
    }
}

if (isset($_POST["notas"])) {

    $alumnoIds = $_POST['alumno_ids'];
    $notas1 = $_POST["nota1"];
    $notas2 = $_POST["nota2"];
    $notas3 = $_POST["nota3"];
    $materiaId = $_SESSION['materia_id'];

    foreach ($alumnoIds as $alumnoId) {
        $nota1 = isset($notas1[$alumnoId]) ? $notas1[$alumnoId] : null;
        $nota2 = isset($notas2[$alumnoId]) ? $notas2[$alumnoId] : null;
        $nota3 = isset($notas3[$alumnoId]) ? $notas3[$alumnoId] : null;

        if ($nota1 !== null && $nota2 !== null && $nota3 !== null) {
            Alumno::registrarNotas($alumnoId, $materiaId, [$nota1, $nota2, $nota3]);

        }
    }
    $_SESSION['mensaje_exito'] = "Las notas se registraron exitosamente.";
    header("Location: views/content/registro_notas.php");
    exit;
}

if (isset($_POST['asistencia'])) {

    $fecha = $_POST['fecha'];
    $materiaId = $_SESSION['materia_id'];
    $alumnoIds = $_POST['alumno_ids'];
    $asistencias = $_POST['asistencias'];

    foreach ($alumnoIds as $index => $alumnoId) {
        $asistencia = trim($asistencias[$index]);

        if ($asistencia == "presente" || $asistencia == "ausente") {
            Alumno::registrarAsistencia($alumnoId, $materiaId, $fecha, $asistencia);

        }
    }
    $_SESSION['mensaje_exito'] = "Las asistencias se registraron exitosamente.";
    header("location: views/content/registro_asistencia.php");
    exit;
}

if (isset($_POST['modificar_parametros'])) {
    $institucionids = $_POST['institucion_ids'];
    $nota_regular = $_POST['nota_regular'];
    $nota_promocion = $_POST['nota_promocion'];
    $asistencia_regular = $_POST['asistencia_regular'];
    $asistencia_promocion = $_POST['asistencia_promocion'];

    foreach ($institucionids as $institucionid) {
        $nota_regular_value = isset($nota_regular[$institucionid]) ? $nota_regular[$institucionid] : null;
        $nota_promocion_value = isset($nota_promocion[$institucionid]) ? $nota_promocion[$institucionid] : null;
        $asistencia_regular_value = isset($asistencia_regular[$institucionid]) ? $asistencia_regular[$institucionid] : null;
        $asistencia_promocion_value = isset($asistencia_promocion[$institucionid]) ? $asistencia_promocion[$institucionid] : null;

        if ($nota_regular_value !== null && $nota_promocion_value !== null && $asistencia_regular_value !== null && $asistencia_promocion_value !== null) {
            Institucion::actualizarParametros($institucionid, $nota_regular_value, $nota_promocion_value, $asistencia_regular_value, $asistencia_promocion_value);
        }
    }
    $_SESSION['mensaje_exito'] = "Los parametros se modificaron exitosamente.";
    header("location: views/content/config.php");
    exit;
}

if (isset($_POST["editar_alumno"])) {
    $alumnoId = limpiarCadena($_POST["id"]);
    $nombre = limpiarCadena($_POST["nombre"]);
    $apellido = limpiarCadena($_POST["apellido"]);
    $dni = limpiarCadena($_POST["dni"]);
    $email = limpiarCadena($_POST["email"]);
    $fecha_nacimiento = limpiarCadena($_POST["fecha_nacimiento"]);

    if (verificarDatos("^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$", $nombre)) {
        $errors['nombre'] = "El nombre solo puede contener letras.";
    }
    if (verificarDatos("^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$", $apellido)) {
        $errors['apellido'] = "El apellido solo puede contener letras.";
    }
    if (verificarDatos("^\d{7,8}$", $dni)) {
        $errors['dni'] = "El DNI debe ser un número de 7 u 8 dígitos.";
    }
    if (verificarDatos("^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$", $email)) {
        $errors['email'] = "Por favor ingrese un email válido.";
    }

    if (!empty($errors)) {
        $query = http_build_query($errors);
        header("Location: views/content/registro_alumno.php?$query");
        exit;
    }

    $alumno = new Alumno($db);
    $alumno->setNombre($nombre);
    $alumno->setApellido($apellido);
    $alumno->setDni($dni);
    $alumno->setEmail($email);
    $alumno->setFechaNacimiento($fecha_nacimiento);

    if ($alumno->actualizarAlumno($alumnoId)) {
        $_SESSION['mensaje_exito'] = "El alumno se modificó exitosamente.";
        header("Location: /views/content/mostrar_alumnos.php");
        exit;
    } else {
        echo "Error al actualizar el alumno.";
    }
}

if (isset($_GET['eliminar_alumno']) && isset($_GET['id'])) {
    $alumnoId = $_GET['id'];
    $resultado = Alumno::eliminarAlumno($alumnoId);

    if ($resultado) {
        header('Location: views/content/mostrar_alumnos.php');
        exit;
    } else {
        echo 'Hubo un problema al eliminar al alumno.';
    }
}





