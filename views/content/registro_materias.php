<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <a href="../../index_admin.php" class="home-btn">Inicio</a>
    <div class="container">
        <div class="menu-card">
            <h2>Registrar materias</h2>
            <form action="main.php" method="post">

                <label for="nombre_materia">Nombre</label>
                <input type="text" name="nombre_materia" id="nombre_materia" required>

                <button type="submit" name="materia">Registrar materia</button>

            </form>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>l