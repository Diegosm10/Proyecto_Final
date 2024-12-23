<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Materia.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Alumno.php';
include $_SERVER['DOCUMENT_ROOT'] . '/guardar_sesion.php';

$errors = [];
if (!empty($_GET)) {
    foreach ($_GET as $key => $message) {
        $errors[$key] = htmlspecialchars($message);
    }
}
if (isset($_SESSION['mensaje_exito'])) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Registro Exitoso',
                    text: '" . $_SESSION['mensaje_exito'] . "',
                    confirmButtonText: 'Aceptar',
                    timer: 1400
                });
            });
        </script>";
    unset($_SESSION['mensaje_exito']);
}

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
            <form method="post" action="../../main.php" id="registroFormAlumno">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <span class="error-message"><?php echo $errors['nombre'] ?? ''; ?></span>
                <br>

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
                <span class="error-message"><?php echo $errors['apellido'] ?? ''; ?></span>
                <br>

                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni" required minlength="7" maxlength="8">
                <span class="error-message"><?php echo $errors['dni'] ?? ''; ?></span>
                <br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <span class="error-message"><?php echo $errors['email'] ?? ''; ?></span>
                <br>

                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>

                <button type="submit" class="btn-registro" name="matricular">Registrar</button>
            </form>
        </div>


        <div class="menu-card">
            <h2>Matricular a materias</h2>
            <form method="post" action="../../main.php" onsubmit="evitar_envio_formulario()">
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
                <button type="submit" class="btn-registro" name="asociar_alumno_materia">Matricular a materia</button>
            </form>
        </div>

    </div>
</body>
<script src="../js/fn.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>