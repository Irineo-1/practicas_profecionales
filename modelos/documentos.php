<?php

require_once("conexion.php");

session_start();

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
}

?>