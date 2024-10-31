<?php

require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../controllers/Alumno.php';


/*
try {
    if (isset($_GET['fecha']) && isset($_SESSION['institucion_id']) && isset($_SESSION['materia_id'])) {
        $fecha = $_GET['fecha'];
        $institucionId = $_SESSION['institucion_id'];
        $materiaId = $_SESSION['materia_id'];

        $asistencias = Alumno::obtenerAsistenciasPorFecha($materiaId, $fecha);

        echo json_encode($asistencias);
        error_log("Fecha recibida: " . $fecha); // Esto se registrará en el log de PHP
        exit;
    } else {
        // Maneja el caso donde 'fecha' no está presente
        echo json_encode(['error' => 'Fecha no proporcionada']);
        exit;
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
*/
header('Content-Type: application/json');

if (!isset($_GET['fecha']) || empty($_GET['fecha'])) {
    echo json_encode(['error' => 'Fecha no proporcionada']);
    exit;
}

if (isset($_GET['fecha']) && isset($_SESSION['institucion_id']) && isset($_SESSION['materia_id'])) {
    $fecha = $_GET['fecha'];

    $institucionId = $_SESSION['institucion_id'];
    $materiaId = $_SESSION['materia_id'];
    $asistencias = Alumno::obtenerAsistenciasPorFecha($materiaId, $fecha);
    // Si no hay asistencias en la fecha solicitada, devuelve un mensaje claro
    if (empty($asistencias)) {
        echo json_encode(['error' => 'No se encontraron asistencias para esta fecha']);
        exit;
    }

    // Retorna el array de asistencias como JSON
    echo json_encode($asistencias);
    exit;
}






