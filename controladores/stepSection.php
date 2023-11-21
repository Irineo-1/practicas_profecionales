<?php

    session_start();

    require_once(dirname(dirname(__FILE__))."/modelos/documentos.php");
    require_once(dirname(dirname(__FILE__))."/modelos/alumno.php");
    require_once(dirname(dirname(__FILE__))."/modelos/instituciones.php");
    require_once(dirname(dirname(__FILE__))."/vendor/autoload.php");

    use PhpOffice\PhpWord\TemplateProcessor;

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

        $ruta_file = dirname(__DIR__) . '/templatesDocumentos/solicitud_practicas.docx';
        
        $template = new TemplateProcessor($ruta_file);
        
        Alumno::updateStep( $step );
        Alumno::updateInstitucion( $id );
        $res = Instituciones::getInstitucion( $id );
        
        $template->setValue('NOMBREINSTITUCION', $res[0]["nombre_empresa"]);
        $template->setValue('DOMICILIO', $res[0]["direccion"]);
        $template->setValue('TELEFONO', $res[0]["telefono"]);
        $template->setValue('TITULARDELADEPENDENCIA', $res[0]["nombre_titular"]);
        $template->setValue('CARGO', $res[0]["puesto_titular"]);
        $template->setValue('NOMBREDELASESOR', $res[0]["nombre_testigo"]);
        
        $nombre_def = $_SESSION["NControl"] . '.docx';

        $template->saveAs(dirname(__DIR__) . '/templatesDocumentos/' . $nombre_def);

        echo $nombre_def;
    }

    if( $_POST["action"] == "generar_carta_presentacion" )
    {
        $resAlumno = Alumno::getAlumno();
        $res = Instituciones::getInstitucion($resAlumno[0]["institucion"]);

        $ruta_file = dirname(__DIR__) . '/templatesDocumentos/carta_presentacion.docx';
        $template = new TemplateProcessor($ruta_file);

        $template->setValue('FECHAACTUAL', $_POST["hoy"]);
        $template->setValue('TITULARDELADEPENDENCIA', $res[0]["nombre_titular"]);
        $template->setValue('CARGO', $res[0]["puesto_titular"]);
        $template->setValue('NOMBREALUMNO', $_POST["nombreAlumno"]);
        $template->setValue('ESPECIALIDAD', $resAlumno[0]["especialidad"]);
        $template->setValue('NUMEROCONTROL', $_SESSION["NControl"]);
        $template->setValue('FECHAINICIO', $_POST["inicio"]);
        $template->setValue('FECHATERMINO', $_POST["fin"]);
        $template->setValue('NOMBREDIRECTOR', $_POST["director"]);
        
        $nombre_def = $_SESSION["NControl"] . '.docx';

        $template->saveAs(dirname(__DIR__) . '/templatesDocumentos/' . $nombre_def);

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
        
        $ruta_file = dirname(__DIR__) . '/templatesDocumentos/convenio.docx';
        $template = new TemplateProcessor($ruta_file);

        $template->setValue('NOMBREEMPRESA', $adNombreInstitucion);
        $template->setValue('TITULARDELADEPENDENCIA', $adNombreTitular);
        $template->setValue('RFC', $adRfc);
        $template->setValue('DOMICILIO', $adDireccion);
        $template->setValue('TELEFONO', $adTelefono);
        $template->setValue('CORREO', $adCorreo);
        
        $nombre_def = $_SESSION["NControl"] . '.docx';

        $template->saveAs(dirname(__DIR__) . '/templatesDocumentos/' . $nombre_def);

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