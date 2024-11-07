<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Alumno.php';

$alumnoId = $_GET['id'];


if ($alumnoId) {
    $alumno = Alumno::obtenerAlumnoPorId($alumnoId);
    if (!$alumno) {
        echo "Alumno no encontrado.";
        exit;
    }
} else {
    echo "ID de alumno no especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumno</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <a href="mostrar_alumnos.php" class="home-btn">Volver</a>
    <div class="container">
        <div class="menu-card">
            <h2>Editar Alumno</h2>
            <form method="POST" action="../../main.php" id="formulario_editar_alumno">
                <input type="hidden" name="id" value="<?php echo $alumno['id']; ?>">

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($alumno['nombre']); ?>"
                    required>

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido"
                    value="<?php echo htmlspecialchars($alumno['apellido']); ?>" required>

                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni" value="<?php echo htmlspecialchars($alumno['dni']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($alumno['email']); ?>"
                    required>

                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                    value="<?php echo htmlspecialchars($alumno['fecha_nacimiento']); ?>" required>

                <button type="submit" class="btn-registro" name="editar_alumno">Guardar
                    Cambios</button>
            </form>
        </div>
    </div>
</body>
<script src="../js/fn.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>