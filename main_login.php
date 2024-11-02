<?php

require "conexion.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = limpiarCadena($_POST["email"]);
    $contrasena = limpiarCadena($_POST["contrasena"]);

    $database = new Database();

    $db = $database->connect();

    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    $query = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    try {
        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario['condicion'] == 'profesor') {
                if (password_verify($contrasena, $usuario['password'])) {
                    echo "Inicio de sesión exitoso.";
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Contraseña incorrecta.";
                }
            }
            if ($usuario['condicion'] == 'admin') {
                if (password_verify($contrasena, $usuario['password'])) {
                    echo "Inicio de sesión exitoso.";
                    header("Location: index_admin.php");
                    exit();
                } else {
                    echo "Contraseña incorrecta.";
                }
            }

        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }

} else {
    echo "Error: No se recibieron los valores por POST.";
}