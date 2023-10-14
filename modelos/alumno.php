<?php

require_once("conexion.php");
require_once("passwordEncriptado.php");

session_start();

class Alumno
{
    public static function registrarUsuario( $numero_control, $nombre, $password )
    {
        $conexion = new DBConecction();
        $passworEncrip = new password();

        $hashPassword = $passworEncrip->hashPassword($password);

        $cnn = $conexion->getConnection();

        $sql = "INSERT INTO alumnos(numero_control, nombre_completo, password) VALUES('$numero_control', '$nombre', '$hashPassword')";

        $cnn->query($sql);

        $cnn->close();

        $_SESSION["NControl"] = $numero_control;

        return 0;
    }

    public static function getAlumno()
    {
        $conexion = new DBConecction();

        $cnn = $conexion->getConnection();

        $NCONTROL = $_SESSION["NControl"];

        $sql = "SELECT nombre_completo, numero_proceso FROM alumnos WHERE numero_control = '$NCONTROL'";

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