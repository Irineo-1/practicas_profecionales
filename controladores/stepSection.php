<?php

    session_start();

    require_once(dirname(dirname(__FILE__))."/modelos/documentos.php");
    require_once(dirname(dirname(__FILE__))."/modelos/alumno.php");
    require_once(dirname(dirname(__FILE__))."/modelos/instituciones.php");

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

    if( $_POST["action"] == "get_instituciones" )
    {
        $res = Instituciones::getInstituciones();

        echo json_encode($res);
    }

    if( $_POST["action"] == "get_institucion" )
    {
        $id = $_POST["id"];

        $res = Instituciones::getInstitucion( $id );

        echo json_encode($res);
    }

    if( $_POST["action"] == "generar_solicitud" )
    {
        // PENDIENTE
        $id = $_POST["id"];
        
        $plantilla = file_get_contents(dirname(dirname(__FILE__)) . "/templatesDocumentos/pps.rtf");
        $plantilla = str_replace('#NOMBREINSTITUCION#', 'Texto de ejemplo', $plantilla);
        
        $nombre_def = $_SESSION["NControl"].".docx";
        $route = $_SERVER['DOCUMENT_ROOT']."/practicas_profesionales/templatesDocumentos/";

        file_put_contents( $route . $nombre_def, $plantilla);

        echo "templatesDocumentos/" . $nombre_def;
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