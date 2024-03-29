<?php

    session_start();

    require_once(dirname(dirname(__FILE__))."/modelos/alumno.php");
    require_once(dirname(dirname(__FILE__))."/modelos/maestro.php");

    if($_POST["action"] == "registrar_maestro")
    {
        $nombre = $_POST['nombre']; 
        $puesto = $_POST['puesto'];
        $email = $_POST['email'];
        $turno = $_POST['turno'];
        $password = $_POST['password'];

        $res = Maestro::registrarMaestro( $nombre, $puesto, $email, $turno, $password );
        echo $res;
    }

    if($_POST["action"] == "iniciar_maestro")
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $res = Maestro::iniciarSecion( $email, $password );
        echo $res;
    }

    if($_POST['action'] == "iniciar_Secion")
    {
        $numero_usuario = $_POST["Numero_usuario"];

        $catchresp = Alumno::iniciarsecion($numero_usuario);
        echo $catchresp;
    }

    if($_POST['action'] == "CerrarSesion")
    {
        session_start();
        session_destroy();
        echo 0;
    }

     
?>