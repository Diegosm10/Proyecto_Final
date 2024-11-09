<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/traits/LimpiezaDato.php';
class Persona
{
    use LimpiezaDato;

    protected $nombre;
    protected $apellido;
    protected $dni;
    protected $fecha_nacimiento;
    protected $email;

    public function __construct($apellido, $nombre, $dni, $email, $fecha_nacimiento)
    {
        $this->apellido = $apellido;
        $this->nombre = $nombre;
        $this->dni = $dni;
        $this->email = $email;
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setNombre($nombre)
    {
        return $this->nombre = $nombre;
    }

    public function setApellido($apellido)
    {
        return $this->apellido = $apellido;
    }

    public function setDni($dni)
    {
        return $this->dni = $dni;
    }

    public function setFechaNacimiento($fecha_nacimiento)
    {
        return $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            throw new Exception("Email inválido.");
        }
    }
}