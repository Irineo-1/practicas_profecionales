<?php

    if( $_POST["action"] == "subir_constancia" )
    {
        $constancia = $_FILES["file"];
        $extension = preg_replace('/^.*\.([^.]+)$/D', "$1", $constancia["name"]);

        if(!is_dir("../archivosGuardados")) mkdir("../archivosGuardados");

        move_uploaded_file($constancia["tmp_name"], "../archivosGuardados/".v4().".".$extension);

        echo 0;
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