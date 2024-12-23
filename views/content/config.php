<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Institucion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/conexion.php';
include $_SERVER['DOCUMENT_ROOT'] . '/guardar_sesion.php';

$parametros = Institucion::obtenerTodosParametrosRam();
$instituciones = Institucion::obtenerInstituciones();
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
    <title>Document</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <a href="../../index.php" class="home-btn">Inicio</a>
    <div class="container">
        <form method="post" action="../../main.php">
            <table id="mi-tabla">
                <thead>
                    <tr>
                        <th>Institucion</th>
                        <th>Nota de regular</th>
                        <th>Nota de promoción</th>
                        <th>Asistencia de regular</th>
                        <th>Asistencia de promoción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($parametros)) {
                        foreach ($instituciones as $institucion) { ?>
                            <tr>
                                <td><input type="hidden" name="institucion_ids[]"
                                        value="<?php echo $institucion['id']; ?>"><?php echo $institucion['id']; ?>
                                    <?php echo htmlspecialchars($institucion['nombre']) ?>
                                </td>
                                <td>
                                    <input type="number" name="nota_regular[<?php echo $institucion['id'] ?>]"
                                        value="<?php echo isset($parametros[$institucion['id']]['nota_regular']) ? $parametros[$institucion['id']]['nota_regular'] : '' ?>"
                                        required min="0" max="10">
                                </td>
                                <td>
                                    <input type="number" name="nota_promocion[<?php echo $institucion['id']; ?>]"
                                        value="<?php echo isset($parametros[$institucion['id']]['nota_promocion']) ? $parametros[$institucion['id']]['nota_promocion'] : '' ?>"
                                        required min="0" max="10">
                                </td>
                                <td>
                                    <input type="number" name="asistencia_regular[<?php echo $institucion['id'] ?>]"
                                        value="<?php echo isset($parametros[$institucion['id']]['asistencia_regular']) ? $parametros[$institucion['id']]['asistencia_regular'] : '' ?>"
                                        required min="0" max="100">
                                <td>
                                    <input type="number" name="asistencia_promocion[<?php echo $institucion['id'] ?>]"
                                        value="<?php echo isset($parametros[$institucion['id']]['asistencia_promocion']) ? $parametros[$institucion['id']]['asistencia_promocion'] : '' ?>"
                                        required min="0" max="100">
                                </td>
                            </tr>
                        <?php }
                        ;
                    } ?>
                </tbody>
            </table>
            <button type="submit" name="modificar_parametros" class="btn-registro">Modificar</button>
        </form>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/fn.js"></script>

</html>