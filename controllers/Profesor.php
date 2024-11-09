<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/traits/LimpiezaDato.php';
class Profesor extends Persona
{
    use LimpiezaDato;

    private $conn;
    private $table = 'profesores';
    protected $legajo;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createProfesor()
    {
        $query = "INSERT INTO " . $this->table . " (apellido, nombre, dni, email, fecha_nacimiento, legajo) 
                                                    VALUES (:apellido, :nombre, :dni, :email, :fecha_nacimiento, :legajo)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':dni', $this->dni);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':fecha_nacimiento', $this->fecha_nacimiento);
        $stmt->bindParam(':legajo', $this->legajo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getLegajo()
    {
        return $this->legajo;
    }
    public function setLegajo($legajo)
    {
        return $this->legajo = $legajo;
    }

    public static function obtenerProfesores()
    {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT * FROM profesores";

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}