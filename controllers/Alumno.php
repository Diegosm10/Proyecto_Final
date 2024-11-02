<?php
require_once "Persona.php";

class Alumno extends Persona
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createAlumno()
    {
        $query = "INSERT INTO alumnos (apellido, nombre, dni, email, fecha_nacimiento) 
        VALUES (:apellido, :nombre, :dni, :email, :fecha_nacimiento)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':dni', $this->dni);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':fecha_nacimiento', $this->fecha_nacimiento);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function matricularAlumno($materiaId, $alumnoId)
    {
        $query = "INSERT INTO calificaciones (alumno_id, materia_id)
        VALUES (:alumno_id, :materia_id)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':alumno_id', $alumnoId);
        $stmt->bindParam(':materia_id', $materiaId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public static function mostrarAlumnosMatriculados($institucionId, $materiaId)
    {
        $database = new Database();
        $db = $database->connect();
        $query = "SELECT alumnos.id, alumnos.nombre, alumnos.apellido, alumnos.dni, alumnos.email 
              FROM (alumnos
              INNER JOIN calificaciones
              ON alumnos.id = calificaciones.alumno_id)
              INNER JOIN materias_institucion
              ON calificaciones.materia_id = materias_institucion.materias_id 
              WHERE materias_institucion.institucion_id = :institucion_id
              AND calificaciones.materia_id = :materia_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':institucion_id', $institucionId);
        $stmt->bindParam(':materia_id', $materiaId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function registrarNotas($alumnoId, $materiaId, $notas)
    {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT * FROM calificaciones WHERE alumno_id = :alumno_id AND materia_id = :materia_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':alumno_id', $alumnoId);
        $stmt->bindParam(':materia_id', $materiaId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $query = "UPDATE calificaciones SET nota_1 = :nota_1, nota_2 = :nota_2, nota_3 = :nota_3 
            WHERE alumno_id = :alumno_id AND materia_id = :materia_id";
            $stmt = $db->prepare($query);
        } else {
            $query = "INSERT INTO calificaciones (alumno_id, materia_id, nota_1, nota_2, nota_3)
            VALUES (:alumno_id, :materia_id, :nota_1, :nota_2, :nota_3)";
            $stmt = $db->prepare($query);
        }

        $stmt->bindParam(':alumno_id', $alumnoId);
        $stmt->bindParam(':materia_id', $materiaId);
        $stmt->bindParam(':nota_1', $notas[0]);
        $stmt->bindParam(':nota_2', $notas[1]);
        $stmt->bindParam(':nota_3', $notas[2]);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public static function registrarAsistencia($alumnoId, $materiaId, $fecha, $asistencia)
    {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT * FROM asistencias WHERE alumno_id = :alumno_id AND materia_id = :materia_id AND fecha = :fecha";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':alumno_id', $alumnoId);
        $stmt->bindParam(':materia_id', $materiaId);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $query = "UPDATE asistencias SET asistencia = :asistencia 
            WHERE alumno_id = :alumno_id AND materia_id = :materia_id AND fecha = :fecha";
            $stmt = $db->prepare($query);
        } else {
            $query = "INSERT INTO asistencias (alumno_id, materia_id, fecha, asistencia) 
            VALUES (:alumno_id, :materia_id, :fecha, :asistencia)";
            $stmt = $db->prepare($query);
        }

        $stmt->bindParam(':alumno_id', $alumnoId);
        $stmt->bindParam(':materia_id', $materiaId);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':asistencia', $asistencia);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public static function obtenerAlumnos()
    {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT * FROM alumnos";
        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerAsistencias($materiaId)
    {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT alumno_id, COUNT(*) AS cantidad_presente 
        FROM asistencias 
        WHERE materia_id = :materia_id AND asistencia = 'presente' 
        GROUP BY alumno_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':materia_id', $materiaId);
        $stmt->execute();

        $asistencias = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $asistencias[$row['alumno_id']] = $row['cantidad_presente'];
        }

        return $asistencias;
    }

    public static function obtenerAsistenciasPorFecha($materiaId, $fecha)
    {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT alumno_id, asistencia FROM asistencias WHERE materia_id = :materia_id AND fecha = :fecha";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':materia_id', $materiaId);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();

        $asistencias = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $asistencias[$row['alumno_id']] = $row['asistencia'];
        }

        return $asistencias;
    }

    public static function obtenerNotas($materiaId)
    {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT alumno_id, nota_1, nota_2, nota_3 FROM calificaciones WHERE materia_id = :materia_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':materia_id', $materiaId);
        $stmt->execute();

        $notas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $notas[$row['alumno_id']] = [
                'nota_1' => $row['nota_1'],
                'nota_2' => $row['nota_2'],
                'nota_3' => $row['nota_3']
            ];
        }
        return $notas;
    }

}