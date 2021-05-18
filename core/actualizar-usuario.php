<?php

require('../config.php');
ValidarSesionAjax();
require('conexion.php');

use Core\Conexion;


if (
	isset($_POST['Nombre']) && !empty($_POST['Nombre']) &&
	isset($_POST['Apellido']) && !empty($_POST['Apellido']) &&
	isset($_POST['Email']) && !empty($_POST['Email']) &&
	isset($_POST['Fecha']) && !empty($_POST['Fecha']) &&
	isset($_POST['Tipo']) && !empty($_POST['Tipo']) &&
	isset($_POST['Documento']) && !empty($_POST['Documento']) &&
	isset($_POST['Telefono']) && !empty($_POST['Telefono']) &&
	isset($_POST['Hijos']) &&
	isset($_POST['Estadocivil']) && !empty($_POST['Estadocivil'])
) {
	$nombre = trim($_POST['Nombre']);
	$apellido = trim($_POST['Apellido']);
	$email = trim($_POST['Email']);
	$fecha = trim($_POST['Fecha']);
	$tipo = trim($_POST['Tipo']);
	$documento = trim($_POST['Documento']);
	$telefono = trim($_POST['Telefono']);
	$hijos = trim($_POST['Hijos']);
	$estadocivil = trim($_POST['Estadocivil']);

	$usuario = UsuarioSesion();
	try {

		$conexion = new Conexion();
		$conexion->OpenConnection();
		$conexion->dao->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
		$query = $conexion->dao->prepare("update  usurios 
		set nombre = :Nombre, apellido = :Apellido, email = :Email, fechanacimiento = :Fechanacimiento, tipodocumento = :Tipodocumento, numerodocumento = :Numerodocumento, telefono = :Telefono, cantidadhijos = :Cantidadhijos, estadocivil = :Estadocivil
		where usuario = :Usuario");
		$query->bindParam(":Nombre", $nombre, \PDO::PARAM_STR);
		$query->bindParam(":Apellido", $apellido, \PDO::PARAM_STR);
		$query->bindParam(":Email", $email, \PDO::PARAM_STR);
		$query->bindParam(":Fechanacimiento", $fecha, \PDO::PARAM_STR);
		$query->bindParam(":Tipodocumento", $tipo, \PDO::PARAM_STR);
		$query->bindParam(":Numerodocumento", $documento, \PDO::PARAM_INT);
		$query->bindParam(":Telefono", $telefono, \PDO::PARAM_STR);
		$query->bindParam(":Cantidadhijos", $hijos, \PDO::PARAM_STR);
		$query->bindParam(":Estadocivil", $estadocivil, \PDO::PARAM_STR);
		$query->bindParam(":Usuario", $usuario, \PDO::PARAM_STR);
		$query->execute();
		echo json_encode(true);
	} catch (\PDOException $e) {
		throw new Exception("Ocurrió un error al actualizar el usuario" . $e);
	}
} else {
	throw new Exception("Información incompleta");
}
