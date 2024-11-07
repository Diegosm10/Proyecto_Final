<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Alumno.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/funciones.php';
include $_SERVER['DOCUMENT_ROOT'] . '/guardar_sesion.php';

if (isset($_SESSION['institucion_id']) && isset($_SESSION['materia_id'])) {
    $institucionId = $_SESSION['institucion_id'];
    $materiaId = $_SESSION['materia_id'];

    $alumnos = Alumno::mostrarAlumnosMatriculados($institucionId, $materiaId);

}

$promedios = obtenerPromedioNotas($materiaId);

$asistencias = [];
$condiciones = [];
$notasCompletas = true;

if (isset($_POST['dias_totales']) && $_POST['dias_totales'] > 0) {
    $diasTotales = $_POST['dias_totales'];

    $notas = Alumno::obtenerNotas($materiaId);

    foreach ($alumnos as $alumno) {
        $alumnoId = $alumno['id'];
        if (empty($notas[$alumnoId])) {
            $notasCompletas = false;
            break;
        }
    }

    if ($notasCompletas) {
        $asistencias = obtenerPromedioAsistencias($materiaId, $diasTotales);
        $condiciones = obtenerCondicionAlumnos($asistencias, $promedios, $institucionId);
    } else {
        echo 'Le faltan registrar notas para obtener su condicion de alumno';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver condiciones</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <a href="mostrar_alumnos.php" class="home-btn">Volver</a>
    <div class="container">
        <form method="post">
            <label for="dias_totales">Cantidad de días cursados:</label>
            <input type="number" name="dias_totales" id="dias_totales" required>
            <button type="submit">Calcular</button>
        </form>
        <table id="mi-tabla">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Email</th>
                    <th>Promedio notas</th>
                    <th>Porcentaje asistencias</th>
                    <th>Condicion</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($alumnos)) {
                    foreach ($alumnos as $alumno) {
                        $alumnoId = $alumno['id'];
                        $promedioNotas = isset($promedios[$alumnoId]) ? $promedios[$alumnoId] : null;
                        $porcentajeAsistencia = isset($asistencias[$alumnoId]) ? $asistencias[$alumnoId] : null;
                        $condicion = isset($condiciones[$alumnoId]) ? $condiciones[$alumnoId] : 'Faltan datos'; ?>
                        <tr>
                            <td><?php echo $alumno['nombre'] . ' ' . $alumno['apellido']; ?></td>
                            <td><?php echo $alumno['email']; ?></td>
                            <td> <?php
                            $faltaNotas = is_null($promedioNotas);
                            if ($faltaNotas) {
                                echo 'Faltan notas';
                            } else {
                                echo number_format($promedioNotas, 2, ".");
                            }
                            ?></td>
                            <td><?php
                            if ($porcentajeAsistencia !== null) {
                                echo number_format($porcentajeAsistencia, 2, ".") . '%';
                            } else {
                                echo 'No disponible';
                            }
                            ?></td>
                            <td><?php echo $faltaNotas ? 'Faltan notas' : $condicion; ?></td>
                        </tr>
                    <?php }
                    ;
                } ?>
            </tbody>
        </table>
    </div>
</body>

</html>