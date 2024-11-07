<?php

class Usuario
{

    private $conn;
    private $table = 'usuarios';
    public $nombre;
    public $apellido;
    private $email;
    private $password;
    public $condicion;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table . " (nombre, apellido, email, password, condicion) 
                                                    VALUES (:nombre, :apellido, :email, :password, :condicion)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam('condicion', $this->condicion);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public static function obtenerUsuario($correo)
    {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT * FROM usuarios WHERE email = :email";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $correo);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }



}