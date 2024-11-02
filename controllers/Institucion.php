<?php

require_once 'Materia.php';
class Institucion
{

    private $conn;
    private $table = 'instituciones';
    public $cue;
    public $nombre;
    public $direccion;
    public $telefono;
    public $email;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table . " (cue, nombre, direccion, telefono, email) 
                                                    VALUES (:cue, :nombre, :direccion, :telefono, :email)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':cue', $this->cue);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':email', $this->email);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            throw new Exception("Email inválido.");
        }
    }

    public static function obtenerInstituciones()
    {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT id, nombre FROM instituciones";
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

    public static function obtenerParametrosRam($institucionId)
    {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT * FROM ram WHERE $institucionId = :institucion_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':institucion_id', $institucionId);
        $stmt->execute();

        $ram = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $ram;
    }
}
