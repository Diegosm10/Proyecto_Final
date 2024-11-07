<?php

require "conexion.php";
require "funciones.php";


session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = limpiarCadena($_POST["email"]);
    $contrasena = limpiarCadena($_POST["contrasena"]);

    $database = new Database();
    $db = $database->connect();

    $query = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($contrasena, $usuario['password'])) {
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['condicion'] = $usuario['condicion'];

            if ($usuario['condicion'] == 'profesor') {
                header("Location: index.php");
            } else if ($usuario['condicion'] == 'admin') {
                header("Location: index_admin.php");
            }
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No existe un usuario con ese email.";
    }
} else {
    echo "Error: No se recibieron los valores por POST.";
}