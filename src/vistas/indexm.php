<?php
    session_start();

    if(!isset($_SESSION["emailMaestro"]))
    {
        include('loginMaestros.php'); // pal login papa
    }
    else
    {
        include('gestion.php'); // inicia secion en automatico
    }
?>