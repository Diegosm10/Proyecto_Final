<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Alumno.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Persona.php';
include $_SERVER['DOCUMENT_ROOT'] . '/guardar_sesion.php';


if (isset($_SESSION['institucion_id']) && isset($_SESSION['materia_id'])) {
    $institucionId = $_SESSION['institucion_id'];
    $materiaId = $_SESSION['materia_id'];

    $alumnos = Alumno::mostrarAlumnosMatriculados($institucionId, $materiaId);
    $notas = Alumno::obtenerNotas($materiaId);
}
if (isset($_SESSION['mensaje_exito'])) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Registro Exitoso',
                    text: '" . $_SESSION['mensaje_exito'] . "',
                    confirmButtonText: 'Aceptar',
                    timer: 3000  // Duración de la alerta en milisegundos (opcional)
                });
            });
        </script>";
    unset($_SESSION['mensaje_exito']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificaciones</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <a href="../../index.php" class="home-btn">Inicio</a>
    <div class="container">
        <form method="post" action="../../main.php">
            <h2>Listado de alumnos matriculados</h2>
            <table id="mi-tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Email</th>
                        <th>Parcial 1</th>
                        <th>Parcial 2</th>
                        <th>Final</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($alumnos)) {
                        foreach ($alumnos as $alumno): ?>
                            <tr>
                                <td><input type="hidden" name="alumno_ids[]"
                                        value="<?php echo $alumno['id']; ?>"><?php echo $alumno['id']; ?>
                                </td>
                                <td><?php echo $alumno['nombre'] ?></td>
                                <td><?php echo $alumno['apellido'] ?></td>
                                <td><?php echo $alumno['dni'] ?></td>
                                <td><?php echo $alumno['email'] ?></td>
                                <td>
                                    <input type="number" name="nota1[<?php echo $alumno['id']; ?>]"
                                        value="<?php echo isset($notas[$alumno['id']]['nota_1']) ? $notas[$alumno['id']]['nota_1'] : ''; ?>"
                                        required min="0" max="10">
                                </td>
                                <td>
                                    <input type="number" name="nota2[<?php echo $alumno['id']; ?>]"
                                        value="<?php echo isset($notas[$alumno['id']]['nota_2']) ? $notas[$alumno['id']]['nota_2'] : ''; ?>"
                                        required min="0" max="10">
                                </td>
                                <td>
                                    <input type="number" name="nota3[<?php echo $alumno['id']; ?>]"
                                        value="<?php echo isset($notas[$alumno['id']]['nota_3']) ? $notas[$alumno['id']]['nota_3'] : ''; ?>"
                                        required min="0" max="10">
                                </td>
                            </tr>
                        <?php endforeach;
                    } ?>
                </tbody>
            </table>
            <button type="submit" name="notas" class="btn-registro">Cargar</button>
        </form>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>