<?php

require_once("conexion.php");
require_once(dirname(dirname(__FILE__))."/controladores/passwordEncriptado.php");

class Alumno
{
    private static $Tabla = "alumnos";

    public static function registrarUsuario( $numero_control, $nombre, $especialidad, $turno )
    {
        $cnn = DBConecction::getConnection();

        $sql = "INSERT INTO ".self::$Tabla."(numero_control, nombre_completo, especialidad, turno) VALUES('$numero_control', '$nombre', '$especialidad', '$turno')";

        $cnn->query($sql);

        $cnn->close();

        return 0;
    }

    public static function iniciarsecion($numero_control)
    {
        $cnn = DBConecction::getConnection();

        $sql = "SELECT numero_control from ".self::$Tabla." where '$numero_control' = numero_control";

        $resunt = $cnn->query($sql);
        $pastORnot = 0;
        

        while($row = $resunt->fetch_assoc())
        {
            if(count($row) > 0)
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

    public static function updateAlumno( $id, $nombre, $numeroControl )
    {
        $cnn = DBConecction::getConnection();

        $sql = "UPDATE ".self::$Tabla." SET nombre_completo = '$nombre', numero_control = '$numeroControl' WHERE id = '$id'";

        $cnn->query($sql);

        $cnn->close();

        return 0;
    }

    public static function deleteAlumno( $id )
    {
        $cnn = DBConecction::getConnection();

        $sql = "DELETE FROM ".self::$Tabla." WHERE id = '$id'";

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

    public static function filtrarAlumnos( $turno, $condicion )
    {
        $cnn = DBConecction::getConnection();

        $sql = "SELECT al.numero_control, al.nombre_completo, al.especialidad, ies.nombre_empresa FROM ".self::$Tabla." al LEFT JOIN instituciones ies ON al.institucion = ies.id WHERE turno = '$turno' AND numero_proceso $condicion";
        
        $res = $cnn->query($sql);

        $data = [];

        while( $row = $res->fetch_assoc() )
        {
            array_push($data, $row);
        }

        return $data;
    }

    public static function getAlumnosCartaLiberacion()
    {
        $cnn = DBConecction::getConnection();
        
        $sql = "SELECT dc.numero_control, al.nombre_completo, al.especialidad, ies.nombre_empresa FROM ".self::$Tabla." al 
        INNER JOIN documentos dc on dc.numero_control = al.numero_control 
        INNER JOIN instituciones ies ON al.institucion = ies.id
        WHERE proceso = 'carta_liberacion'";

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