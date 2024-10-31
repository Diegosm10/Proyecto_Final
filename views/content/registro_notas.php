<?php
require_once __DIR__ . '/../../conexion.php';
require_once __DIR__ . '/../../controllers/Alumno.php';
require_once __DIR__ . '/../../controllers/Persona.php';

session_start();
if (isset($_SESSION['institucion_id']) && isset($_SESSION['materia_id'])) {
    $institucionId = $_SESSION['institucion_id'];
    $materiaId = $_SESSION['materia_id'];

    $alumnos = Alumno::mostrarAlumnosMatriculados($institucionId, $materiaId);
    $notas = Alumno::obtenerNotas($materiaId);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificaciones</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <a href="../../index.php" class="home-btn">Inicio</a>
    <div class="container">
        <div class="menu-card">
            <form method="post" action="../../main.php">
                <h2>Listado de alumnos matriculados</h2>
                <table id="mi-tabla">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>DNI</th>
                            <th>Email</th>
                            <th>Parcial 1</th>
                            <th>Parcial 2</th>
                            <th>Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($alumnos)) {
                            foreach ($alumnos as $alumno): ?>
                                <tr>
                                    <td><input type="hidden" name="alumno_ids[]"
                                            value="<?php echo $alumno['id']; ?>"><?php echo $alumno['id']; ?>
                                    </td>
                                    <td><?php echo $alumno['nombre'] ?></td>
                                    <td><?php echo $alumno['apellido'] ?></td>
                                    <td><?php echo $alumno['dni'] ?></td>
                                    <td><?php echo $alumno['email'] ?></td>
                                    <td>
                                        <input type="number" name="nota1[<?php echo $alumno['id']; ?>]"
                                            value="<?php echo isset($notas[$alumno['id']]['nota_1']) ? $notas[$alumno['id']]['nota_1'] : ''; ?>"
                                            required>
                                    </td>
                                    <td>
                                        <input type="number" name="nota2[<?php echo $alumno['id']; ?>]"
                                            value="<?php echo isset($notas[$alumno['id']]['nota_2']) ? $notas[$alumno['id']]['nota_2'] : ''; ?>"
                                            required>
                                    </td>
                                    <td>
                                        <input type="number" name="nota3[<?php echo $alumno['id']; ?>]"
                                            value="<?php echo isset($notas[$alumno['id']]['nota_3']) ? $notas[$alumno['id']]['nota_3'] : ''; ?>"
                                            required>
                                    </td>
                                </tr>
                            <?php endforeach;
                        } ?>
                    </tbody>
                </table>
                <button type="submit" name="notas">Cargar</button>
            </form>
        </div>
    </div>
</body>

</html>