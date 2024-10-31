<?php
require_once __DIR__ . '/../controllers/Alumno.php';
require_once __DIR__ . '/../controllers/Institucion.php';
require_once __DIR__ . '/../controllers/Persona.php';
session_start();

function limpiarCadena($cadena)
{
    $palabras = ["<script>", "</script>", "<script src", "<script type=", "SELECT * FROM", "SELECT ", " SELECT ", "DELETE FROM", "INSERT INTO", "DROP TABLE", "DROP DATABASE", "TRUNCATE TABLE", "SHOW TABLES", "SHOW DATABASES", "<?php", "?>", "--", "^", "<", ">", "==", "=", ";", "::"];

    $cadena = trim($cadena); //Elimina espacios en blanco
    $cadena = stripcslashes($cadena); //Elimina barras invertidas

    // Filtra la cadena de texto buscando palabras que coincidan con el array para evitar inyeccion sql
    foreach ($palabras as $palabra) {
        $cadena = str_ireplace($palabra, "", $cadena); //Reemplaza esas palabras si las encuentra por espacios en blanco
    }

    $cadena = trim($cadena);
    $cadena = stripcslashes($cadena);

    return $cadena;
}


function verificarDatos($filtro, $cadena)
{
    // Verifica que la cadena cumpla con el filtro 
    if (preg_match("/^" . $filtro . "$/", $cadena)) {
        return false;
    } else {
        return true;
    }
}

function obtenerPromedioNotas($materiaId)
{
    $notas = Alumno::obtenerNotas($materiaId);
    $promedio_notas = [];

    foreach ($notas as $alumnoId => $notasArray) {
        if (count($notasArray) > 0) {
            $suma = array_sum($notasArray);
            $promedio = $suma / count($notasArray);
            $promedio_notas[$alumnoId] = $promedio;
        } else {
            $promedio_notas[$alumnoId] = 0;
        }
    }

    return $promedio_notas;
}

function obtenerPromedioAsistencias($materiaId, $dias_totales)
{
    $asistencias = Alumno::obtenerAsistencias($materiaId);
    $promedio_asistencia = [];

    foreach ($asistencias as $alumnoId => $cantidadPresente) {
        $promedio_asistencia[$alumnoId] = $dias_totales > 0
            ? ($cantidadPresente / $dias_totales) * 100
            : 0;
    }

    return $promedio_asistencia;
}

function obtenerCondicionAlumnos($promedio_asistencia, $promedio_notas, $institucionId)
{
    $ram = Institucion::obtenerParametrosRam($institucionId);

    if (!$ram) {
        return [];
    }

    $nota_regular = $ram[0]['nota_regular'];
    $nota_promocion = $ram[0]['nota_promocion'];
    $asistencia_regular = $ram[0]['asistencia_regular'];
    $asistencia_promocion = $ram[0]['asistencia_promocion'];

    $condiciones = [];

    foreach ($promedio_notas as $alumnoId => $promedioNota) {
        $promedioAsistencia = $promedio_asistencia[$alumnoId];

        if ($promedioNota >= $nota_promocion && $promedioAsistencia >= $asistencia_promocion) {
            $condiciones[$alumnoId] = 'Promoción';
        } elseif ($promedioNota >= $nota_regular && $promedioAsistencia >= $asistencia_regular) {
            $condiciones[$alumnoId] = 'Regular';
        } else {
            $condiciones[$alumnoId] = 'Libre';
        }
    }

    return $condiciones;
}
