<?php

    require_once(dirname(dirname(__FILE__))."/modelos/alumno.php");

    $alumno = new Alumno();
    
    if($_POST["action"] == "registrar_usuario")
    {
        $numero_control = $_POST['numero_control'];
        $nombre = $_POST['nombre'];
        $password = $_POST['password'];

        $res = $alumno->registrarUsuario( $numero_control, $nombre, $password );
        echo $res;
    }
?>