<?php
    session_start();

    if(!isset($_SESSION["NControl"]))
    {
        include('src/vistas/loginAlumno.php'); // pal login papa
    }
    else
    {
        include('src/vistas/paginaPrincipal.php'); // inicia secion en automatico
    }
?>