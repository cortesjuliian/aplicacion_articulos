<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');


if(!isset($_SESSION)) {
    session_start();
}

//Para la conexión a la BD
define('DB_HOST', 'localhost');
define('DB_NAME', 'Prueba_2');
define('DB_USER', 'root');
define('DB_PASS', '');


function UsuarioSesion()
{
    if(!isset($_SESSION["usuario"]) || empty($_SESSION["usuario"])) {        
        return null;
    } else {
        return $_SESSION["usuario"];
    }
}

function ValidarSesion()
{
    if(!isset($_SESSION["usuario"]) || empty($_SESSION["usuario"])) {
        header("location:index.php");
    }
}


function ValidarSesionAjax()
{
    if(!isset($_SESSION["usuario"]) || empty($_SESSION["usuario"])) {
        throw new Exception("No autorizado");
    }
}