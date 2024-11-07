<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Institucion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Profesor.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Materia.php';

$instituciones = Institucion::obtenerInstituciones();

if (isset($_GET['institucion_id'])) {
    $materias = Materia::obtenerMateriasPorInstitucion($_GET['institucion_id']);
    header('Content-Type: application/json');
    echo json_encode($materias);
    exit;
}
$profesores = Profesor::obtenerProfesores();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <a href="../../index_admin.php" class="home-btn">Inicio</a>
    <div class="container">
        <div class="menu-card">
            <h2>Dar de alta profesor</h2>
            <form action="../../main.php" method="post">

                <label for="nombre_profesor">Nombre:</label>
                <input type="text" name="nombre_profesor" id="nombre_profesor" required>

                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" id="apellido" required>

                <label for="dni">DNI:</label>
                <input type="text" name="dni" id="dni" required>

                <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" required>

                <label for="email_profesor">Email</label>
                <input type="text" name="email_profesor" id="email_profesor" required>

                <label for="legajo">Legajo:</label>
                <input type="text" name="legajo" id="legajo" minlength="8" maxlength="8" required>

                <label for="contrasena">Contraseña:</label>
                <input type="text" name="contrasena" id="contrasena" required>

                <input type="button" name="profesor" class="btn-registro">Registrar
            </form>
        </div>

        <div class="menu-card">
            <h2>Asociar profesores a materias</h2>
            <form method="post" action="../../main.php">
                <label for="profesor_id">Profesor:</label>
                <select id="profesor_id" name="profesor_id" required>
                    <option value="">Seleccione un profesor</option>
                    <?php foreach ($profesores as $profesor): ?>
                        <option value="<?= $profesor['id']; ?>"><?= $profesor['nombre'] . ' ' . $profesor['apellido']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="institucion_id">Institución:</label>
                <select id="institucion_id" name="institucion_id" onchange="cargarMateriasProfesor()" required>
                    <option value="">Seleccione una institución</option>
                    <?php foreach ($instituciones as $institucion): ?>
                        <option value="<?= $institucion['id']; ?>"><?= $institucion['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="materia_id">Materia:</label>
                <select id="materia_id" name="materia_id" required>
                    <option value="">Seleccione una materia</option>
                </select>

                <button type="submit" name="asociar_materias_profesor" class="btn-registro">Asociar materia</button>
            </form>
        </div>
    </div>


</body>
<script src="../js/fn.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>