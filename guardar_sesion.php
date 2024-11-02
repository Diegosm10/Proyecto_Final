<?php
session_start();

if (isset($_POST['institucion_id']) && isset($_POST['materia_id'])) {
    $_SESSION['institucion_id'] = $_POST['institucion_id'];
    $_SESSION['materia_id'] = $_POST['materia_id'];
    echo "Datos de sesión guardados correctamente.";
} else {
    echo "Faltan datos para guardar en sesión.";
}
?>