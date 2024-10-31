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
        $consulta = "INSERT INTO materias (nombre) VALUES (:nombre)";

        $stmt = $this->conn->prepare($consulta);

        $stmt->bindParam(':nombre', $this->nombre);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

}