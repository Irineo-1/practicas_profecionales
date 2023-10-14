<?php

    require_once(dirname(dirname(__FILE__))."/modelos/alumno.php");

    $alumno = new Alumno();

    if( $_POST["action"] == "get_user" )
    {
        $res = $alumno->getAlumno();
        echo json_encode($res);
    }

?>