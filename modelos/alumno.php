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

    public static function getAlumno($numero_control)
    {

    }
}

?>