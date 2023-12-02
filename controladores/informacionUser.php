<?php

    session_start();

    require_once(dirname(dirname(__FILE__))."/modelos/alumno.php");
    require_once(dirname(dirname(__FILE__))."/modelos/maestro.php");
    require_once(dirname(dirname(__FILE__))."/modelos/documentos.php");
    require_once(dirname(dirname(__FILE__))."/vendor/autoload.php");

    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;

    if( $_POST["action"] == "get_user" )
    {
        $res = Alumno::getAlumno();
        echo json_encode($res);
    }

    if( $_POST["action"] == "update_alumno" )
    {
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $numeroControl = $_POST["numeroControl"];
        
        $res = Alumno::updateAlumno( $id, $nombre, $numeroControl );
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

    if( $_POST["action"] == "generar_reporte_alumnos" )
    {
        $turno = $_POST["turno"];
        $condicion = $_POST["condicion"];
        
        $res = [];

        $ruta = dirname(__DIR__) . '/templatesDocumentos/';

        $noDataFound = true;

        if( $condicion == "Aun no han realizado el servicio social" )
        {
            $res = Alumno::filtrarAlumnos( $turno, "< 2" );
        }
        else if( $condicion == "Aun no se ha seleccionado una institucion" )
        {
            $res = Alumno::filtrarAlumnos( $turno, "= 3" );
        }
        else if( $condicion == "Ya realiza las practicas" )
        {
            $res = Alumno::filtrarAlumnos( $turno, ">= 4" );
        }
        else if( $condicion == "Se culmino con las practicas" )
        {
            $res = Alumno::getAlumnosCartaLiberacion();
        }

        if(count($res) > 0)
        {
            $reader = IOFactory::createReader('Xlsx');
            $spreadsheet = $reader->load($ruta . 'plantilla_reporte.xlsx');
    
            $flag = 2;
    
            foreach($res as $value)
            {
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A' . $flag, $value['numero_control']);
                $sheet->setCellValue('B' . $flag, $value['nombre_completo']);
                $sheet->setCellValue('C' . $flag, $value['especialidad']);
                $sheet->setCellValue('D' . $flag, $value['nombre_empresa']);
    
                $flag ++;
            }
    
            $nameDocument = "reporteGenerado" . rand() . ".xlsx";
    
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save($ruta . $nameDocument);
            
            echo $nameDocument;
        }
        else
        {
            echo 1;
        }

    }

    if( $_POST["action"] == "agregar_alumnos" )
    {
        $file = $_FILES["file"];
        $turno = $_POST["turno"];
        $especialidad = $_POST["especialidad"];

        $temporalNameDocument = v4() . ".xlsx";
        $ruta = "../templatesDocumentos/".$temporalNameDocument;

        move_uploaded_file($file["tmp_name"], $ruta);

        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($ruta);
        
        $endDocument = 1;
        $init = 13;

        while( $endDocument <= 1 )
        {
            $worksheet = $spreadsheet->getActiveSheet();
            $ncontrol = $worksheet->getCell('B'. $init)->getValue();
            $nombre = $worksheet->getCell('C'. $init)->getValue();
            
            if(is_null($ncontrol))
            {
                $endDocument = 2;
            }
            else
            {
                $init ++;
                Alumno::registrarUsuario( $ncontrol, $nombre, $especialidad, $turno );
            }
        }
        
        echo $temporalNameDocument;
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