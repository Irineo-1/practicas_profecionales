<?php

require_once("conexion.php");


class Instituciones
{
    private static $Tabla = "instituciones";

    public static function getInstituciones()
    {
        $cnn = DBConecction::getConnection();

        $sql = "SELECT id, nombre_empresa, entidad_federativa, tipo_institucion FROM ".self::$Tabla."";

        $res = $cnn->query($sql);

        $data = [];

        while( $row = $res->fetch_assoc() )
        {
            array_push($data, $row);
        }

        return $data;
    }

    public static function getInstitucion( $id )
    {
        $cnn = DBConecction::getConnection();

        $sql = "SELECT nombre_empresa, nombre_titular, direccion, telefono, nombre_testigo, puesto_testigo FROM ".self::$Tabla."";

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