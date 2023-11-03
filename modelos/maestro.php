<?php

require_once("conexion.php");
require_once(dirname(dirname(__FILE__))."/controladores/passwordEncriptado.php");

class Maestro
{
    private static $tabla = "maestros";

    public static function registrarMaestro( $nombre, $puesto, $turno, $password )
    {
        $cnn = DBConecction::getConnection();

        $passEncripted = password::hashPassword($password);

        $sql = "INSERT INTO " . self::$tabla . "(nombre, puesto, turno, password) VALUES('$nombre', '$puesto', '$turno', '$passEncripted')";

        $cnn->query($sql);

        $cnn->close();

        return 1;
    }

    public static function iniciarSecion( $email, $password )
    {
        $cnn = DBConecction::getConnection();

        $sql = "SELECT nombre, puesto, turno, password FROM " . self::$tabla . " WHERE email = '$email'";

        $res = $cnn->query($sql);

        $out = 0;

        while($row = $res->fetch_assoc())
        {
            if(password::verificarPassword($password, $row["password"]))
            {
                $_SESSION["nombreMaestro"] = $row["nombre"];
                $_SESSION["puestoMaestro"] = $row["puesto"];
                $_SESSION["turnoMaestro"] = $row["turno"];
                $_SESSION["emailMaestro"] = $email;
                $out = 1;
            }
            else
            {
                $out = 0;
            }
        }

        $cnn->close();

        return $out;
    }

    public static function getMaestro()
    {
        $cnn = DBConecction::getConnection();

        $email = $_SESSION["emailMaestro"];

        $sql = "SELECT nombre, puesto, turno FROM " . self::$tabla . " WHERE email = '$email'";

        $res = $cnn->query($sql);

        $data = [];

        while($row = $res->fetch_assoc())
        {
            array_push($data, $row);
        }

        $cnn->close();

        return $data;
    }
}

?>