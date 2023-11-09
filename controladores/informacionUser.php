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

    if( $_POST["action"] == "update_estatus_documento" )
    {
        $id = $_POST["id"];
        $estatus = $_POST["estatus"];

        Documentos::updateStatusDocumentos($id, $estatus);
    }

    if( $_POST["action"] == "get_maestro" )
    {
        $res = Maestro::getMaestro();
        echo json_encode($res);
    }

    if( $_POST["action"] == "get_informes" )
    {
        $res = Documentos::getInformes($_SESSION["NControl"]);
        echo json_encode($res);
    }

    if( $_POST["action"] == "get_directores" )
    {
        $res = Maestro::getDirectores();
        echo json_encode($res);
    }

    if( $_POST["action"] == "get_users" )
    {
        $res = Alumno::getAlumnos();
        echo json_encode($res);
    }

    if( $_POST["action"] == "get_documents" )
    {
        if( $_POST["numeroControl"] != "desdeAlumno" )
        {
            $nControl = $_POST["numeroControl"];
        }
        else
        {
            $nControl = $_SESSION["NControl"];
        }
        $res = Documentos::getDocumentos( $nControl );
        echo json_encode($res);
    }

?>