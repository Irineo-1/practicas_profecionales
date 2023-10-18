<?php

    require_once(dirname(dirname(__FILE__))."/modelos/alumno.php");

    if( $_POST["action"] == "get_user" )
    {
        $res = Alumno::getAlumno();
        echo json_encode($res);
    }

?>