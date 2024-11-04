<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_final/controllers/Institucion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_final/conexion.php';
session_start();
    $parametros = Institucion::obtenerTodosParametrosRam();
    $instituciones = Institucion::obtenerInstituciones();
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
        <form method="post" action="../../main.php" id="formulario_registro">
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
                                <td><?php echo htmlspecialchars($institucion['nombre'])?></td>
                                <td>
                                    <input type="number" name="nota_regular[<?php echo $institucion['id'] ?>]" 
                                    value="<?php echo isset($parametros[$institucion['id']]['nota_regular']) ? $parametros[$institucion['id']]['nota_regular'] : '' ?>" required>
                                </td>
                                <td>
                                    <input type="number" name="nota_promocion[<?php echo $institucion['id']; ?>]"
                                    value="<?php echo isset($parametros[$institucion['id']]['nota_promocion']) ? $parametros[$institucion['id']]['nota_promocion'] : '' ?>" required>
                                </td>
                                <td>
                                    <input type="number" name="asistencia_regular[<?php echo $institucion['id'] ?>]"
                                    value="<?php echo isset($parametros[$institucion['id']]['asistencia_regular']) ? $parametros[$institucion['id']]['asistencia_regular'] : '' ?>" required>
                                <td>
                                    <input type="number" name="asistencia_promocion[<?php echo $institucion['id'] ?>]"
                                    value="<?php echo isset($parametros[$institucion['id']]['asistencia_promocion']) ? $parametros[$institucion['id']]['asistencia_promocion'] : '' ?>" required>
                                </td>
                            </tr>
                        <?php };
                    } ?>
                </tbody>
            </table>
            <input type="button" value="Modificar" name="parametros_ram" onclick="actualizarParametros()">
        </form>
    </div>
</body>

</html>