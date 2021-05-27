<?php

require('../config.php');
ValidarSesionAjax();
require('conexion.php');

use Core\Conexion;

function Limpieza($cadena){
	$patron = array('/<script>.*<\/script>/');
	$cadena = preg_replace($patron, '', $cadena);
	$cadena = htmlspecialchars($cadena);
	return $cadena;
}

foreach ($_POST as $key => $value) {
	$_POST[$key] = Limpieza($value);
}

if (isset($_FILES['Foto'])) {
	$tipoarchivo = $_FILES['Foto']['type'];
	$nombrearchivo = $_FILES['Foto']['name'];
	$tamanoarchivo = $_FILES['Foto']['size'];
	$imagensubida = fopen($_FILES['Foto']['tmp_name'], 'r');
	$binariosimagen = fread($imagensubida, $tamanoarchivo);
	$filenamecmps = explode(".", $nombrearchivo);
	$fileextension = strtolower(end($filenamecmps));
	$newfilename = md5(time() . $nombrearchivo);
	$allowedfileextensions = array('jpg', 'gif', 'png');

	$usuario = UsuarioSesion();
	if (in_array($fileextension, $allowedfileextensions)) {

		$conexion = new Conexion();
		$conexion->OpenConnection();
		$conexion->dao->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
		$query = $conexion->dao->prepare("update  usurios 
			set nombreFoto = :Nombrefoto, Foto = :Foto, tipoFoto = :Tipofoto
			where usuario = :Usuario");
		$query->bindParam(":Nombrefoto", $newfilename, \PDO::PARAM_STR);
		$query->bindParam(":Foto", $binariosimagen, \PDO::PARAM_STR);
		$query->bindParam(":Tipofoto", $tipoarchivo, \PDO::PARAM_STR);
		$query->bindParam(":Usuario", $usuario, \PDO::PARAM_STR);
		$query->execute();

		$_SESSION['foto'] = base64_encode($binariosimagen);
        $_SESSION['tipofoto'] = $tipoarchivo;

		echo json_encode(true);
	} else {
		throw new Exception("El formato de la imagen no está permitido.");
	}
} else {
	throw new Exception("Información incompleta");
}
