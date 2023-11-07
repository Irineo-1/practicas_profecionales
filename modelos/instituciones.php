<?php

require_once("conexion.php");


class Instituciones
{
    private static $Tabla = "instituciones";

    public static function addInstitucion( $adNombreInstitucion, $adNombreTitular, $adPuestoTitular, $adRfc, $adDireccion, $adTelefono, $adCorreo, $adNombreTestigo, $adPuestoTestigo, $adEntidadFederativa, $adClaveCentro, $adTipoInstitucion )
    {
        $cnn = DBConecction::getConnection();

        $sql = "INSERT INTO ".self::$Tabla."(nombre_empresa, nombre_titular, puesto_titular, RFC, direccion, telefono, correo, nombre_testigo, puesto_testigo, entidad_federativa, clave_centro, tipo_institucion) 
        VALUES('$adNombreInstitucion', '$adNombreTitular', '$adPuestoTitular', '$adRfc', '$adDireccion', '$adTelefono', '$adCorreo', '$adNombreTestigo', '$adPuestoTestigo', '$adEntidadFederativa', '$adClaveCentro', '$adTipoInstitucion')";

        $cnn->query($sql);

        return 0;
    }

    public static function getInstituciones()
    {
        $cnn = DBConecction::getConnection();

        $sql = "SELECT id, nombre_empresa, entidad_federativa, direccion FROM ".self::$Tabla."";

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

        $sql = "SELECT nombre_empresa, nombre_titular, puesto_titular, direccion, telefono, nombre_testigo FROM ".self::$Tabla." WHERE id = '$id'";

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