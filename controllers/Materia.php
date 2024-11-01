<?php

class Materia
{

    private $conn;

    public $nombre;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO materias (nombre) VALUES (:nombre)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public static function obtenerMaterias()
    {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT * FROM materias";

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerMateriasPorInstitucion($institucionId)
    {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT materias.id, materias.nombre 
              FROM materias 
              INNER JOIN materias_institucion 
              ON materias.id = materias_institucion.materias_id
              WHERE materias_institucion.institucion_id = :institucion_id";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':institucion_id', $institucionId, PDO::PARAM_INT);
        $stmt->execute();

        $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$materias) {
            return [];
        }
        return $materias;
    }

}