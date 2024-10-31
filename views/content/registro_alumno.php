<?php
require_once __DIR__ . '/../../conexion.php';
require_once __DIR__ . '/../../controllers/Institucion.php';

$instituciones = Institucion::obtenerInstituciones();

if (isset($_GET['institucion_id'])) {
    $materias = Institucion::obtenerMateriasPorInstitucion($_GET['institucion_id']);
    header('Content-Type: application/json');
    echo json_encode($materias);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matricular alumno</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <a href="../../index.php" class="home-btn">Inicio</a>
    <div class="container">
        <div class="menu-card">
            <h2>Matricular Alumno</h2>
            <form method="POST" action="../../main.php">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>

                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>

                <label for="institucion_id">Institución:</label>
                <select id="institucion_id" name="institucion_id" onchange="cargarMaterias()" required>
                    <option value="">Seleccione una institución</option>
                    <?php foreach ($instituciones as $institucion): ?>
                        <option value="<?= $institucion['id']; ?>"><?= $institucion['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="materia_id">Materia:</label>
                <select id="materia_id" name="materia_id" required>
                    <option value="">Seleccione una materia</option>
                </select>

                <button type="submit" name="matricular">Matricular Alumno</button>
            </form>
        </div>
    </div>
</body>
<script src="../js/fn.js"></script>

</html>