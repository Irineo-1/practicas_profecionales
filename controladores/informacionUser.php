<?php

    session_start();

    require_once(dirname(dirname(__FILE__))."/modelos/alumno.php");
    require_once(dirname(dirname(__FILE__))."/modelos/maestro.php");
    require_once(dirname(dirname(__FILE__))."/modelos/documentos.php");

    if( $_POST["action"] == "get_user" )
    {
        $res = Alumno::getAlumno();
        echo json_encode($res);
    }

    if( $_POST["action"] == "update_alumno" )
    {
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $pass = $_POST["pass"];
        
        $res = Alumno::updateAlumno( $id, $nombre, $pass );
        echo $res;
    }

    if( $_POST["action"] == "get_maestro" )
    {
        $res = Maestro::getMaestro();
        echo json_encode($res);
    }

    if( $_POST["action"] == "get_users" )
    {
        $res = Alumno::getAlumnos();
        echo json_encode($res);
    }

    if( $_POST["action"] == "get_documents" )
    {
        $nControl = $_POST["numeroControl"];
        $res = Documentos::getDocumentos( $nControl );
        echo json_encode($res);
    }

?>