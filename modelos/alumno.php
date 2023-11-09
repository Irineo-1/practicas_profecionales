<?php

require_once("conexion.php");
require_once(dirname(dirname(__FILE__))."/controladores/passwordEncriptado.php");

class Alumno
{
    private static $Tabla = "alumnos";

    public static function registrarUsuario( $numero_control, $nombre, $especialidad, $turno, $password )
    {
        $hashPassword = password::hashPassword($password);

        $cnn = DBConecction::getConnection();

        $sql = "INSERT INTO ".self::$Tabla."(numero_control, nombre_completo, especialidad, turno, password) VALUES('$numero_control', '$nombre', '$especialidad', '$turno', '$hashPassword')";

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
        
        $cnn->close();

        return $pastORnot;
    }

    public static function updateStep( $step )
    {
        $cnn = DBConecction::getConnection();

        $NCONTROL = $_SESSION["NControl"];

        $sql = "UPDATE ".self::$Tabla." SET numero_proceso = '$step' WHERE numero_control = '$NCONTROL'";

        $cnn->query($sql);

        $cnn->close();

        return 0;
    }

    public static function updateInstitucion( $idInstitucion )
    {
        $cnn = DBConecction::getConnection();

        $NCONTROL = $_SESSION["NControl"];

        $sql = "UPDATE ".self::$Tabla." SET institucion = '$idInstitucion' WHERE numero_control = '$NCONTROL'";

        $cnn->query($sql);

        $cnn->close();

        return 0;
    }

    public static function updateAlumno( $id, $nombre, $pass )
    {
        $cnn = DBConecction::getConnection();

        $hashPassword = password::hashPassword($pass);

        $sql = "UPDATE ".self::$Tabla." SET nombre_completo = '$nombre', password = '$hashPassword' WHERE id = '$id'";

        $cnn->query($sql);

        $cnn->close();

        return 0;
    }

    public static function getAlumno()
    {
        $cnn = DBConecction::getConnection();

        $NCONTROL = $_SESSION["NControl"];

        $sql = "SELECT nombre_completo, numero_proceso, institucion, especialidad FROM ".self::$Tabla." WHERE numero_control = '$NCONTROL'";

        $res = $cnn->query($sql);

        $data = [];

        while($row = $res->fetch_assoc())
        {
            array_push($data, $row);
        }

        $cnn->close();

        return $data;
    }

    public static function getAlumnos()
    {
        $cnn = DBConecction::getConnection();

        $sql = "SELECT id, numero_control, nombre_completo, numero_proceso, turno FROM ".self::$Tabla."";

        $res = $cnn->query($sql);

        $data = [];

        while( $row = $res->fetch_assoc() )
        {
            array_push($data, $row);
        }

        return $data;
    }
}



?>