<?php

require_once("conexion.php");
require_once(dirname(dirname(__FILE__))."/controladores/passwordEncriptado.php");

session_start();

class Alumno
{
    private static $Tabla = "alumnos";

    public static function registrarUsuario( $numero_control, $nombre, $password )
    {
        $hashPassword = password::hashPassword($password);

        $cnn = DBConecction::getConnection();

        $sql = "INSERT INTO ".self::$Tabla."(numero_control, nombre_completo, password) VALUES('$numero_control', '$nombre', '$hashPassword')";

        $cnn->query($sql);

        $cnn->close();

        $_SESSION["NControl"] = $numero_control;

        return 0;
    }

    public static function iniciarsecion($numero_control, $password)
    {
        $cnn = DBConecction::getConnection();

        $sql = "SELECT numero_control, password from ".self::$Tabla." where '$numero_control' = numero_control";

        $resunt = $cnn->query($sql);
        $pastORnot = 0;
        
        while($row = $resunt->fetch_assoc())
        {
            if(password::verificarPassword($password,$row["password"]))
            {
                $pastORnot = 1;
                $_SESSION["NControl"] = $numero_control;
            }
            else
            {
                $pastORnot = 0;
            }
        }
        
        return $pastORnot;
    }



    public static function getAlumno()
    {
        $cnn = DBConecction::getConnection();

        $NCONTROL = $_SESSION["NControl"];

        $sql = "SELECT nombre_completo, numero_proceso FROM ".self::$Tabla." WHERE numero_control = '$NCONTROL'";

        $res = $cnn->query($sql);

        $data = [];

        while($row = $res->fetch_assoc())
        {
            array_push($data, $row);
        }

        return $data;
    }
}



?>