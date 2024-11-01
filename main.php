<?php

require_once "conexion.php";
require_once "controllers/Usuario.php";
require_once "controllers/Institucion.php";
require_once "controllers/Profesor.php";
require_once "controllers/Alumno.php";
require_once 'controllers/Materia.php';

$database = new Database();
$db = $database->connect();
session_start();

/*
$usuario = new Usuario($db);

$usuario->nombre = "Diego";
$usuario->apellido = "Segovia Muñiz";
$usuario->setEmail("diego1234@gmail.com");
$usuario->setPassword("diego1234");
$usuario->condicion = "admin";

if($usuario->create()){
    echo "admin creado con exito";
}
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

    $profesor = new Profesor($db);

    $profesor->setNombre($nombre);
    $profesor->setApellido($apellido);
    $profesor->setDni($dni);
    $profesor->setEmail($email);
    $profesor->setLegajo($legajo);
    $profesor->setFechaNacimiento($fecha_nacimiento);

    $usuario->create();
    $profesor->createProfesor();


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
}

if (isset($_POST["institucion"])) {

    $institucion = new Institucion($db);

    $nombre = limpiarCadena($_POST["nombre_institucion"]);
    $direccion = limpiarCadena($_POST["direccion"]);
    $telefono = limpiarCadena($_POST["telefono"]);
    $email = limpiarCadena($_POST["email_institucion"]);
    $cue = limpiarCadena($_POST["cue"]);

    $institucion->nombre = $nombre;
    $institucion->direccion = $direccion;
    $institucion->telefono = $telefono;
    $institucion->setEmail($email);
    $institucion->cue = $cue;

    if ($institucion->create()) {
        return "Institucion registrada con éxito";
    }
}

if (isset($_POST["materia"])) {

    $materia = new Materia($db);

    $nombre = limpiarCadena($_POST["nombre_materia"]);

    $materia->nombre = $nombre;

    if ($materia->create()) {
        return "Materia registrada con éxito";
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

    $stmt->execute();
}

if (isset($_POST["matricular"])) {

    $alumno = new Alumno($db);

    $nombre = limpiarCadena($_POST["nombre"]);
    $apellido = limpiarCadena($_POST["nombre"]);
    $dni = limpiarCadena($_POST["dni"]);
    $email = limpiarCadena($_POST["email"]);
    $fecha_nacimiento = limpiarCadena($_POST["fecha_nacimiento"]);

    $alumno->setNombre($nombre);
    $alumno->setApellido($apellido);
    $alumno->setDni($dni);
    $alumno->setEmail($email);
    $alumno->setFechaNacimiento($fecha_nacimiento);

    if ($alumno->createAlumno()) {
        $alumnoId = $db->lastInsertId();
        $materiaId = $_POST['materia_id'];
        if ($alumno->matricularAlumno($materiaId, $alumnoId)) {
            echo "Alumno matriculado correctamente en la materia.";
            header("location: index.php");
            exit;
        } else {
            echo "Error al matricular al alumno.";
        }
    } else {
        echo "Error al registrar al alumno.";
    }

}

if (isset($_POST["asociar_alumno_materia"])) {
    $alumno = new Alumno($db);

    $alumnoId = limpiarCadena($_POST['alumno_id']);
    $materiaId = limpiarCadena($_POST['materia_id']);

    if ($alumno->matricularAlumno($materiaId, $alumnoId)) {
        header("location: index.php");
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
        // Usa el ID del alumno como índice para obtener las notas
        $nota1 = isset($notas1[$alumnoId]) ? $notas1[$alumnoId] : null;
        $nota2 = isset($notas2[$alumnoId]) ? $notas2[$alumnoId] : null;
        $nota3 = isset($notas3[$alumnoId]) ? $notas3[$alumnoId] : null;

        // Asegúrate de que las notas no sean nulas antes de registrar
        if ($nota1 !== null && $nota2 !== null && $nota3 !== null) {
            Alumno::registrarNotas($alumnoId, $materiaId, [$nota1, $nota2, $nota3]);
        }
    }


    header("Location: index.php");
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
            header("location: index.php");
        }
    }
}





