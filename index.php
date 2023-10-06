<?php
    session_start();

    if(!isset($_SESSION["NControl"]))
    {
        include('src/vistas/login.php'); // pal login papa
    }
    else
    {
        // inicia secion en automatico
    }
?>