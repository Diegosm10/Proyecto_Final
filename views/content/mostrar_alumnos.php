<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Alumno.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Persona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/funciones.php';
include $_SERVER['DOCUMENT_ROOT'] . '/guardar_sesion.php';


if (isset($_SESSION['institucion_id']) && isset($_SESSION['materia_id'])) {
    $institucionId = $_SESSION['institucion_id'];
    $materiaId = $_SESSION['materia_id'];

    $alumnos = Alumno::mostrarAlumnosMatriculados($institucionId, $materiaId);

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <a href="../../index.php" class="home-btn">Inicio</a>
    <div class="container">
        <h2>Listado de alumnos</h2>
        <table id="mi-tabla">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($alumnos)) {
                    foreach ($alumnos as $alumno) { ?>
                        <tr>
                            <td><?php echo $alumno['nombre']; ?></td>
                            <td><?php echo $alumno['apellido']; ?></td>
                            <td><?php echo $alumno['email'] ?></td>
                            <td>
                                <a href="editar_alumno.php?id=<?php echo $alumno['id']; ?>" class="btn-editar">Editar</a>
                            </td>
                            <td>
                                <a href="../../main.php?id=<?php echo $alumno['id']; ?>&eliminar_alumno=1" class="btn-eliminar"
                                    onclick="eliminarAlumno(event)">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php }
                    ;
                } ?>
            </tbody>
        </table>
        <a href="ver_condicion.php" class="btn-registro">Ver
            condición</a>
    </div>
</body>
<script src="../js/fn.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>