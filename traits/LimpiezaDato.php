<?php

trait LimpiezaDato
{
    public static function limpiarCadena($cadena)
    {
        $palabras = [
            "<script>",
            "</script>",
            "<script src",
            "<script type=",
            "SELECT * FROM",
            "SELECT ",
            " SELECT ",
            "DELETE FROM",
            "INSERT INTO",
            "DROP TABLE",
            "DROP DATABASE",
            "TRUNCATE TABLE",
            "SHOW TABLES",
            "SHOW DATABASES",
            "<?php",
            "?>",
            "--",
            "^",
            "<",
            ">",
            "==",
            "=",
            ";",
            "::"
        ];

        $cadena = trim($cadena);
        $cadena = stripcslashes($cadena);

        foreach ($palabras as $palabra) {
            $cadena = str_ireplace($palabra, "", $cadena);
        }

        $cadena = trim($cadena);
        $cadena = stripcslashes($cadena);

        return $cadena;
    }

    public static function verificarDatos($filtro, $cadena)
    {
        return !preg_match("/^" . $filtro . "$/", $cadena);
    }
}
