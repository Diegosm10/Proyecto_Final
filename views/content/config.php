<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Institucion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/conexion.php';
session_start();

if(isset($_SESSION['institucion_id'])){
    $institucionId = $_SESSION['institucion_id'];
    $parametros = Institucion::obtenerParametrosRam($institucionId);
    $instituciones = Institucion::obtenerInstituciones();
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
    <div class="container">
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
                        foreach ($parametros as $parametro): ?>
                            <tr>
                                <td><?php echo $instituciones['nombre']?></td>
                                <td><?php echo isset($parametro['nota_regular']) ? $parametro['nota_regular'] : ''; ?></td>
                                <td><?php echo isset($parametro['nota_promocion']) ? $parametro['nota_promocion'] : ''; ?></td>
                                <td><?php echo isset($parametro['asistencia_regular']) ? $parametro['asistencia_regular'] : ''; ?></td>
                                <td><?php echo isset($parametro['asistencia_promocion']) ? $parametro['asistencia_promocion'] : ''; ?></td>
                            </tr>
                        <?php endforeach;
                    } ?>
                </tbody>
            </table>
    </div>
</body>

</html>