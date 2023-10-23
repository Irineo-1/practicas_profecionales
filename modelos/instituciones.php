<?php

require_once("conexion.php");


class Instituciones
{
    private static $Tabla = "instituciones";

    public static function getInstituciones()
    {
        $cnn = DBConecction::getConnection();

        $sql = "SELECT id, nombre_empresa, entidad_federativa, tipo_empresa, tipo_institucion FROM ".self::$Tabla."";

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