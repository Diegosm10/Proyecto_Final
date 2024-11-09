<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/traits/LimpiezaDato.php';
class Institucion
{
    use LimpiezaDato;

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

    public static function obtenerTodosParametrosRam()
    {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT * FROM ram";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $ram = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Agrupar los parametros por Institucion
        $parametrosPorInstitucion = [];
        foreach ($ram as $parametro) {
            $parametrosPorInstitucion[$parametro['institucion_id']] = $parametro;
        }

        return $parametrosPorInstitucion;
    }

    public static function insertarParametrosRam($nota_regular, $nota_promocion, $asistencia_regular, $asistencia_promocion, $institucionId)
    {
        $database = new Database();
        $db = $database->connect();

        $query = "INSERT INTO ram (nota_regular, nota_promocion, asistencia_regular, asistencia_promocion, institucion_id) 
        VALUES (:nota_regular, :nota_promocion, :asistencia_regular, :asistencia_promocion, :institucion_id)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':nota_regular', $nota_regular);
        $stmt->bindParam(':nota_promocion', $nota_promocion);
        $stmt->bindParam(':asistencia_regular', $asistencia_regular);
        $stmt->bindParam('asistencia_promocion', $asistencia_promocion);
        $stmt->bindParam(':institucion_id', $institucionId);

        $stmt->execute();
    }
    public static function obtenerParametrosRam($institucionId)
    {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT * FROM ram WHERE institucion_id = :institucion_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':institucion_id', $institucionId);
        $stmt->execute();

        $ram = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $ram;
    }

    public static function actualizarParametros($institucionid, $nota_regular, $nota_promocion, $asistencia_regular, $asistencia_promocion)
    {
        $database = new Database();
        $db = $database->connect();

        $query = "UPDATE ram SET 
        nota_regular = :nota_regular, 
        nota_promocion = :nota_promocion, 
        asistencia_regular = :asistencia_regular, 
        asistencia_promocion = :asistencia_promocion
        WHERE institucion_id = :institucion_id";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':nota_regular', $nota_regular);
        $stmt->bindParam(':nota_promocion', $nota_promocion);
        $stmt->bindParam(':asistencia_regular', $asistencia_regular);
        $stmt->bindParam(':asistencia_promocion', $asistencia_promocion);
        $stmt->bindParam(':institucion_id', $institucionid);
        $stmt->execute();

    }
}
