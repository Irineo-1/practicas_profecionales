<?php

    require_once(dirname(dirname(__FILE__))."/modelos/alumno.php");

    $alumno = new Alumno();
    
    if($_POST["action"] == "registrar_usuario")
    {
        $aver = $alumno->registrarUsuario();
        echo $aver;
    }
?>