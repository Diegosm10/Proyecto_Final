<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Alumno.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Persona.php';

session_start();

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencia</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <a href="../../index.php" class="home-btn">Inicio</a>
    <div class="container">

        <form method="post" action="../../main.php" id="formulario_registro">
            <h2>Listado de alumnos matriculados</h2>
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>
            <table id="mi-tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Email</th>
                        <th>Asistencia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($alumnos)) {
                        foreach ($alumnos as $alumno): ?>
                            <tr>
                                <td><input type="hidden" name="alumno_ids[]"
                                        value="<?php echo $alumno['id']; ?>"><?php echo $alumno['id']; ?></td>
                                <td><?php echo $alumno['nombre']; ?></td>
                                <td><?php echo $alumno['apellido']; ?></td>
                                <td><?php echo $alumno['dni']; ?></td>
                                <td><?php echo $alumno['email']; ?></td>
                                <td>
                                    <select name="asistencias[]" required>
                                        <option value="presente">Presente</option>
                                        <option value="ausente">Ausente</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach;
                    } ?>
                </tbody>
            </table>
            <input type="button" value="Guardar" name="asistencia" onclick="registrarAsistenica()">
        </form>
    </div>
</body>
<script src="../js/fn.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>