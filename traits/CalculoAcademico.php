<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Alumno.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Institucion.php';
trait CalculoAcademico
{
    public static function obtenerPromedioNotas($materiaId)
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

    public static function obtenerPromedioAsistencias($materiaId, $dias_totales)
    {
        $asistencias = Alumno::obtenerAsistencias($materiaId);
        $promedio_asistencia = [];

        foreach ($asistencias as $alumnoId => $cantidadPresente) {
            $promedio_asistencia[$alumnoId] = $dias_totales > 0
                ? ($cantidadPresente / $dias_totales) * 100
                : 0;
            if ($promedio_asistencia[$alumnoId] > 100) {
                $promedio_asistencia[$alumnoId] = 100;
            }
        }

        return $promedio_asistencia;
    }

    public static function obtenerCondicionAlumnos($promedio_asistencia, $promedio_notas, $institucionId)
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
            $promedioAsistencia = isset($promedio_asistencia[$alumnoId]) ? $promedio_asistencia[$alumnoId] : 0;

            // Verificar si el alumno cumple con los requisitos para "Promoción"
            if ($promedioNota >= $nota_promocion && $promedioAsistencia >= $asistencia_promocion) {
                $condiciones[$alumnoId] = 'Promoción';
            }
            // Si no, verificar si cumple con los requisitos para "Regular"
            elseif ($promedioNota >= $nota_regular && $promedioAsistencia >= $asistencia_regular) {
                $condiciones[$alumnoId] = 'Regular';
            }
            // Si no cumple con los dos anteriores, asignar "Libre"
            else {
                $condiciones[$alumnoId] = 'Libre';
            }
        }

        return $condiciones;
    }
}