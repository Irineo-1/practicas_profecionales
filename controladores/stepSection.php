<?php

    require_once(dirname(dirname(__FILE__))."/modelos/documentos.php");
    require_once(dirname(dirname(__FILE__))."/modelos/alumno.php");

    if( $_POST["action"] == "subir_constancia" )
    {
        $constancia = $_FILES["file"];
        $step = $_POST["step"];
        $extension = preg_replace('/^.*\.([^.]+)$/D', "$1", $constancia["name"]);

        if(!is_dir("../archivosGuardados")) mkdir("../archivosGuardados");

        $final_name = v4().".".$extension;

        $id_file = Documentos::addDocument( $final_name, "constancia_termino" );
        
        Alumno::updateStep( $step );

        move_uploaded_file($constancia["tmp_name"], "../archivosGuardados/".$final_name);

        echo $id_file;
    }

    function v4() {
        return sprintf('%04x%04x_%04x_%04x_%04x_%04x%04x%04x',
          mt_rand(0, 0xffff), mt_rand(0, 0xffff),
          mt_rand(0, 0x0fff) | 0x4000,
          mt_rand(0, 0x3fff) | 0x8000,
          mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

?>