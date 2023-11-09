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

        $sql = "SELECT id, nombre_documento, proceso, estatus FROM " . self::$Tabla . " WHERE numero_control = '$nControl'";

        $res = $cnn->query($sql);

        $data = [];

        while( $row = $res->fetch_assoc() )
        {
            array_push($data, $row);
        }

        $cnn->close();

        return $data;
    }

    public static function getStatusDocumentos( $proceso, $nControl )
    {
        $cnn = DBConecction::getConnection();

        $sql = "SELECT id, estatus, nombre_documento FROM " . self::$Tabla . " WHERE proceso = '$proceso' AND numero_control = '$nControl'";

        $res = $cnn->query($sql);

        $data = [];

        while( $row = $res->fetch_assoc() )
        {
            array_push($data, $row);
        }

        $cnn->close();

        return $data;
    }

    public static function deleteDocument( $proceso, $NCONTROL )
    {
        $cnn = DBConecction::getConnection();
        
        $sql = "DELETE FROM ".self::$Tabla." WHERE proceso = '$proceso' AND numero_control = '$NCONTROL'";

        $cnn->query($sql);

        $cnn->close();

        return 0;
    }

    public static function updateStatusDocumentos( $id, $estatus )
    {
        $cnn = DBConecction::getConnection();

        $sql = "UPDATE " . self::$Tabla . " SET estatus = '$estatus' WHERE id = '$id'";

        $cnn->query($sql);

        $cnn->close();

        return 0;
    }

    public static function getInformes( $nControl )
    {
        $cnn = DBConecction::getConnection();

        $sql = "SELECT * FROM " . self::$Tabla . " WHERE proceso LIKE '%firmado%' AND numero_control = '$nControl'";

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