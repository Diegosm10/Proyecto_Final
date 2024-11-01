<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Materia.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Alumno.php';


$materias = Materia::obtenerMaterias();
$alumnos = Alumno::obtenerAlumnos(); ?>

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
            <h2>Registrar Alumno</h2>
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
                <button type="submit" name="matricular">Registrar Alumno</button>
            </form>
        </div>


        <div class="menu-card">
            <h2>Matricular a materias</h2>
            <form method="POST" action="../../main.php">
                <label for="alumno_id">Alumno:</label>
                <select id="alumno_id" name="alumno_id" required>
                    <option value="">Seleccione un alumno</option>
                    <?php foreach ($alumnos as $alumno): ?>
                        <option value="<?= $alumno['id']; ?>">
                            <?= $alumno['nombre'] . ' ' . $alumno['apellido']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="materia_id">Materia:</label>
                <select id="materia_id" name="materia_id" required>
                    <option value="">Seleccione una materia</option>
                    <?php foreach ($materias as $materia): ?>
                        <option value="<?= $materia['id']; ?>">
                            <?= $materia['nombre']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" name="asociar_alumno_materia">Matricular</button>
            </form>
        </div>

    </div>
</body>
<script src="../js/fn.js"></script>

</html>