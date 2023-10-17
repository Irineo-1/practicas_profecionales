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

     if($_POST['action'] == "iniciar_Secion"){

        $numero_usuario = $_POST["Numero_usuario"];
        $password = $_POST["Contrasena"];

        $catchresp = $alumno->iniciarsecion($numero_usuario,$password);
        echo $catchresp;

     }

     if($_POST['action'] == "CerrarSesion"){
     $cerrar = $_POST['CerrarSesion'];
     session_start();
     session_destroy();
     echo "EntroAlif";

        
     }

     
?>