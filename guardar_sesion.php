<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email']) || trim($_SESSION['email']) == '') {
    header("Location: views/content/login.php");
    exit();
}
$correo = $_SESSION['email'];

if (isset($_POST['institucion_id']) && isset($_POST['materia_id'])) {
    $_SESSION['institucion_id'] = $_POST['institucion_id'];
    $_SESSION['materia_id'] = $_POST['materia_id'];
}
?>