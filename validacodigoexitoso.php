<?php
include("conexion.php");
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
$token=$_SESSION['token'];
        
function Limpieza($cadena){
	$patron = array('/<script>.*<\/script>/');
	$cadena = preg_replace($patron, '', $cadena);
	$cadena = htmlspecialchars($cadena);
	return $cadena;
}

foreach ($_POST as $key => $value) {
    $_POST[$key] = Limpieza($value);
}

if 	(strlen(htmlspecialchars($_POST['codigo']) >= 1))
{
		$codigo= trim($_POST['codigo']);		
		if ($codigo==$token) {
            header("location:home.php");
        }
        else
			{							
				header("location:validacodigo.php");
			}	
}
?> 


