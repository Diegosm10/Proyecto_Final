<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Institucion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Materia.php';

$materias = Materia::obtenerMaterias();
$instituciones = Institucion::obtenerInstituciones();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu institucion</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <a href="../../index_admin.php" class="home-btn">Inicio</a>
    <div class="container">
        <div class="menu-card">
            <h2>Dar de alta institucion</h2>
            <form action="../../main.php" method="post">

                <label for="nombre_institucion">Nombre:</label>
                <input type="text" name="nombre_institucion" id="nombre_institucion" required>

                <label for="direccion">Direccion:</label>
                <input type="text" name="direccion" id="direccion" required>

                <label for="telefono">Telefono:</label>
                <input type="text" name="telefono" id="telefono" minlength="10" maxlength="10" required>

                <label for="email_institucion">Email:</label>
                <input type="email" name="email_institucion" id="email_institucion" required>

                <label for="cue">CUE:</label>
                <input type="text" name="cue" id="cue" minlength="8" maxlength="8" required>

                <p>Parametros RAM:</p>
                <label for="nota_regular">Nota para regular:</label>
                <input type="number" name="nota_regular" id="nota_regular" required>

                <label for="nota_promocion">Nota para promoción:</label>
                <input type="number" name="nota_promocion" id="nota_promocion" required>

                <label for="asistencia_regular">Asistencia para regular:</label>
                <input type="number" name="asistencia_regular" id="asistencia_regular" required>

                <label for="asistencia_promocion">Asistencia para promoción:</label>
                <input type="number" name="asistencia_promocion" id="asistencia_promocion" required>

                <button type="submit" name="institucion" class="btn-registro">Registrar</button>
            </form>
        </div>


        <div class="menu-card">
            <h2>Añadir materias a instituciones</h2>
            <form action="main.php" method="post" class="formulario">

                <label for="materias">Materia:</label>
                <select id="materias" name="materias">
                    <option value="">Seleccione una materia</option>
                    <?php foreach ($materias as $materia): ?>
                        <option value="<?= $materia['id']; ?>"><?= $materia['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="instituciones">Institucion:</label>
                <select id="instituciones" name="instituciones">
                    <option value="">Seleccione una institución</option>
                    <?php foreach ($instituciones as $institucion): ?>
                        '<option value="<?= $institucion['id']; ?>"><?= $institucion['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" name="asociar_materia" class="btn-registro">Agregar
                    materia</button>

            </form>
        </div>
    </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/fn.js"></script>

</html>