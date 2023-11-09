<?php

    session_start();

    require_once(dirname(dirname(__FILE__))."/modelos/documentos.php");
    require_once(dirname(dirname(__FILE__))."/modelos/alumno.php");
    require_once(dirname(dirname(__FILE__))."/modelos/instituciones.php");

    if( $_POST["action"] == "subir_archivo" )
    {
        $constancia = $_FILES["file"];
        $step = $_POST["step"];
        $proceso = $_POST["proceso"];
        $extension = preg_replace('/^.*\.([^.]+)$/D', "$1", $constancia["name"]);

        if(!is_dir("../archivosGuardados")) mkdir("../archivosGuardados");

        $final_name = v4().".".$extension;

        $id_file = Documentos::addDocument( $final_name, $proceso );
        
        if( $proceso != "solicitud" && $proceso != "carta_aceptacion" )
        {
            Alumno::updateStep( $step );
        }

        move_uploaded_file($constancia["tmp_name"], "../archivosGuardados/".$final_name);

        echo $id_file;
    }

    if( $_POST["action"] == "get_status_document" )
    {
        $process = $_POST["process"];

        $res = Documentos::getStatusDocumentos( $process, $_SESSION["NControl"] );

        echo json_encode($res);
    }
    
    if( $_POST["action"] == "update_step" )
    {
        $step = $_POST["step"];
        Alumno::updateStep( $step );
    }

    if( $_POST["action"] == "clean_process" )
    {
        $proceso = $_POST["proceso"];

        $route = $_SERVER['DOCUMENT_ROOT']."/practicas_profesionales/archivosGuardados/";
        if (file_exists($route . $_POST["nombreArchivo"]))
        {
            unlink($route . $_POST["nombreArchivo"]);
        }

        Documentos::deleteDocument( $proceso, $_SESSION["NControl"] );
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
        $id = $_POST["id"];
        $step = $_POST["step"];

        Alumno::updateStep( $step );
        Alumno::updateInstitucion( $id );
        $res = Instituciones::getInstitucion( $id );

        $plantilla = file_get_contents(dirname(dirname(__FILE__)) . "/templatesDocumentos/pps.rtf");
        $plantilla = str_replace('#NOMBREINSTITUCION#', $res[0]["nombre_empresa"], $plantilla);
        $plantilla = str_replace('#DOMICILIO#', $res[0]["direccion"], $plantilla);
        $plantilla = str_replace('#TELEFONO#', $res[0]["telefono"], $plantilla);
        $plantilla = str_replace('#TITULARDELADEPENDENCIA#', $res[0]["nombre_titular"], $plantilla);
        $plantilla = str_replace('#CARGO#', $res[0]["puesto_titular"], $plantilla);
        $plantilla = str_replace('#NOMBREDELASESOR#', $res[0]["nombre_testigo"], $plantilla);
        
        $nombre_def = $_SESSION["NControl"].".doc";
        $route = $_SERVER['DOCUMENT_ROOT']."/practicas_profesionales/templatesDocumentos/";

        file_put_contents( $route . $nombre_def, $plantilla);

        echo $nombre_def;
    }

    if( $_POST["action"] == "generar_carta_presentacion" )
    {
        $resAlumno = Alumno::getAlumno();
        $res = Instituciones::getInstitucion($resAlumno[0]["institucion"]);

        $plantilla = file_get_contents(dirname(dirname(__FILE__)) . "/templatesDocumentos/cp.rtf");
        $plantilla = str_replace('#FECHAACTUAL#', $_POST["hoy"], $plantilla);
        $plantilla = str_replace('#TITULARDELADEPENDENCIA#', $res[0]["nombre_titular"], $plantilla);
        $plantilla = str_replace('#CARGO#', $res[0]["puesto_titular"], $plantilla);
        $plantilla = str_replace('#NOMBREALUMNO#', $_POST["nombreAlumno"], $plantilla);
        $plantilla = str_replace('#ESPECIALIDAD#', $resAlumno[0]["especialidad"], $plantilla);
        $plantilla = str_replace('#NUMEROCONTROL#', $_SESSION["NControl"], $plantilla);
        $plantilla = str_replace('#FECHAINICIO#', $_POST["inicio"], $plantilla);
        $plantilla = str_replace('#AFECHAFIN#', $_POST["fin"], $plantilla);
        $plantilla = str_replace('#NOMBREDIRECTOR#', $_POST["director"], $plantilla);
        
        $nombre_def = $_SESSION["NControl"].".doc";
        $route = $_SERVER['DOCUMENT_ROOT']."/practicas_profesionales/templatesDocumentos/";

        file_put_contents( $route . $nombre_def, $plantilla);

        echo $nombre_def;
    }

    if( $_POST["action"] == "generar_convenio" )
    {
        $adNombreInstitucion = $_POST["adNombreInstitucion"];
        $adNombreTitular = $_POST["adNombreTitular"];
        $adPuestoTitular = $_POST["adPuestoTitular"];
        $adRfc = $_POST["adRfc"];
        $adDireccion = $_POST["adDireccion"];
        $adTelefono = $_POST["adTelefono"];
        $adCorreo = $_POST["adCorreo"];
        $adNombreTestigo = $_POST["adNombreTestigo"];
        $adPuestoTestigo = $_POST["adPuestoTestigo"];
        $adEntidadFederativa = $_POST["adEntidadFederativa"];
        $adClaveCentro = $_POST["adClaveCentro"];
        $adTipoInstitucion = $_POST["adTipoInstitucion"];

        Instituciones::addInstitucion($adNombreInstitucion, $adNombreTitular, $adPuestoTitular, $adRfc, $adDireccion, $adTelefono, $adCorreo, $adNombreTestigo, $adPuestoTestigo, $adEntidadFederativa, $adClaveCentro, $adTipoInstitucion);

        $plantilla = file_get_contents(dirname(dirname(__FILE__)) . "/templatesDocumentos/cpa.rtf");
        $plantilla = str_replace('#NOMBREEMPRESA#', $adNombreInstitucion, $plantilla);
        $plantilla = str_replace('#TITULARDELADEPENDENCIA#', $adNombreTitular, $plantilla);
        $plantilla = str_replace('#RFC#', $adRfc, $plantilla);
        $plantilla = str_replace('#DOMICILIO#', $adDireccion, $plantilla);
        $plantilla = str_replace('#TELEFONO#', $adTelefono, $plantilla);
        $plantilla = str_replace('##correo##', $adCorreo, $plantilla);
        
        $nombre_def = $_SESSION["NControl"].".doc";
        $route = $_SERVER['DOCUMENT_ROOT']."/practicas_profesionales/templatesDocumentos/";

        file_put_contents( $route . $nombre_def, $plantilla);

        echo $nombre_def;
    }

    if( $_POST["action"] == "guardar_institucion" )
    {
        $adNombreInstitucion = $_POST["adNombreInstitucion"];
        $adNombreTitular = $_POST["adNombreTitular"];
        $adPuestoTitular = $_POST["adPuestoTitular"];
        $adRfc = $_POST["adRfc"];
        $adDireccion = $_POST["adDireccion"];
        $adTelefono = $_POST["adTelefono"];
        $adCorreo = $_POST["adCorreo"];
        $adNombreTestigo = $_POST["adNombreTestigo"];
        $adPuestoTestigo = $_POST["adPuestoTestigo"];
        $adEntidadFederativa = $_POST["adEntidadFederativa"];
        $adClaveCentro = $_POST["adClaveCentro"];
        $adTipoInstitucion = $_POST["adTipoInstitucion"];

        Instituciones::addInstitucion($adNombreInstitucion, $adNombreTitular, $adPuestoTitular, $adRfc, $adDireccion, $adTelefono, $adCorreo, $adNombreTestigo, $adPuestoTestigo, $adEntidadFederativa, $adClaveCentro, $adTipoInstitucion);

        echo 0;
    }

    if( $_POST["action"] == "eliminar_documento" )
    {
        $route = $_SERVER['DOCUMENT_ROOT']."/practicas_profesionales/templatesDocumentos/";
        if (file_exists($route . $_POST["archivo"]))
        {
            unlink($route . $_POST["archivo"]);
        }
    }

    if( $_POST["action"] == "reemplasar_plantilla" )
    {
        $constancia = $_FILES["file"];
        $nameFile = $_POST["nameFile"];

        if(!is_dir("../archivosGuardados")) mkdir("../archivosGuardados");

        move_uploaded_file($constancia["tmp_name"], "../templatesDocumentos/".$nameFile);
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