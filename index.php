<?php

    require('controlador/Routing.php');

    Route::add('/', function() {
        return "hola mundo";
    }, "get");

    Route::run('/');
?>