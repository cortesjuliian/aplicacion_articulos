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

if (
	isset($_POST['ClaveActual']) && !empty($_POST['ClaveActual']) &&
	isset($_POST['NuevaClave']) && !empty($_POST['NuevaClave']) &&
	isset($_POST['ConfirmNuevaClave']) && !empty($_POST['ConfirmNuevaClave'])
) {
	$claveActual = md5($_POST['ClaveActual']);
	$nuevaClave = md5($_POST['NuevaClave']);
	$confirmNuevaClave = md5($_POST['ConfirmNuevaClave']);

	if ($nuevaClave == $confirmNuevaClave) {
		$usuario = UsuarioSesion();
		try {

			$conexion = new Conexion();
			$conexion->OpenConnection();
			$query = $conexion->dao->prepare(sprintf("select 1 from usurios where usuario = :Usuario and pass = :Clave"));

			$query->bindParam(":Usuario", $usuario, \PDO::PARAM_STR);
			$query->bindParam(":Clave", $claveActual, \PDO::PARAM_STR);
			$query->execute();

			if ($query->rowCount() > 0) {
				$conexion = new Conexion();
				$conexion->OpenConnection();
				$conexion->dao->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
				$query = $conexion->dao->prepare("update  usurios 
					set Pass = :Pass
					where usuario = :Usuario");
				$query->bindParam(":Pass", $nuevaClave, \PDO::PARAM_STR);
				$query->bindParam(":Usuario", $usuario, \PDO::PARAM_STR);
				$query->execute();
				echo json_encode(true);
			} else {
				echo json_encode(false);
			}
		} catch (\PDOException $e) {
			throw new Exception("Ocurrió un error al actualizar el usuario" . $e);
		}
	} else {
		throw new Exception("Las constraseñas no coinciden.");
	}
} else {
	throw new Exception("Información incompleta");
}
