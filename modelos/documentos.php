<?php

require_once("conexion.php");

class Documentos
{

    private static $Tabla = "documentos";

    public static function addDocument( $nombre, $proceso )
    {
        $cnn = DBConecction::getConnection();
        $numero_control = $_SESSION["NControl"];

        $sql = "INSERT INTO ".self::$Tabla."( numero_control, nombre_documento, proceso ) VALUES('$numero_control', '$nombre', '$proceso')";

        $cnn->query($sql);

        $id = $cnn->insert_id;

        $cnn->close();

        return $id;
    }

    public static function getDocumentos( $nControl )
    {
        $cnn = DBConecction::getConnection();

        $sql = "SELECT id, nombre_documento, proceso FROM " . self::$Tabla . " WHERE numero_control = '$nControl'";

        $res = $cnn->query($sql);

        $data = [];

        while( $row = $res->fetch_assoc() )
        {
            array_push($data, $row);
        }

        $cnn->close();

        return $data;
    }
}

?>