<?php

require('../config.php');
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
	isset($_POST['Estadocivil']) && !empty($_POST['Estadocivil']) &&
	isset($_POST['Usuario']) && !empty($_POST['Usuario']) &&
	isset($_POST['Contrasena']) && !empty($_POST['Contrasena']) &&
	isset($_FILES['Foto'])
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
	$usuario = trim($_POST['Usuario']);
	$pass = md5(trim($_POST['Contrasena']));



	$tipoarchivo = $_FILES['Foto']['type'];
	$nombrearchivo = $_FILES['Foto']['name'];
	$tamanoarchivo = $_FILES['Foto']['size'];
	$imagensubida = fopen($_FILES['Foto']['tmp_name'], 'r');
	$binariosimagen = fread($imagensubida, $tamanoarchivo);
	$filenamecmps = explode(".", $nombrearchivo);
	$fileextension = strtolower(end($filenamecmps));
	$newfilename = md5(time() . $nombrearchivo);
	$allowedfileextensions = array('jpg', 'gif', 'png');

	if (in_array($fileextension, $allowedfileextensions)) {
		try {
			$conexion = new Conexion();
			$conexion->OpenConnection();
			$conexion->dao->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
			$query = $conexion->dao->prepare("select 1 from usurios where usuario = :Usuario");
			$query->bindParam(":Usuario", $usuario, \PDO::PARAM_STR);
			$query->execute();

			if ($query->rowCount() > 0) {
				throw new Exception("El usuario ya existe");
			} else {
				$conexion = new Conexion();
				$conexion->OpenConnection();
				$conexion->dao->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
				$query = $conexion->dao->prepare("INSERT INTO usurios(nombre, apellido, email, fechanacimiento, tipodocumento, numerodocumento, telefono, cantidadhijos, estadocivil, nombrefoto, foto, tipofoto, usuario, pass)
				 VALUES (:Nombre, :Apellido, :Email, :Fechanacimiento, :Tipodocumento, :Numerodocumento, :Telefono, :Cantidadhijos, :Estadocivil, :Nombrefoto, :Foto, :Tipofoto, :Usuario, :Pass)");
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
				$query->bindParam(":Pass", $pass, \PDO::PARAM_STR);
				$query->bindParam(":Nombrefoto", $newfilename, \PDO::PARAM_STR);
				$query->bindParam(":Foto", $binariosimagen, \PDO::PARAM_STR);
				$query->bindParam(":Tipofoto", $tipoarchivo, \PDO::PARAM_STR);
				$query->execute();
				echo json_encode(true);
			}
		} catch (\PDOException $e) {
			throw new Exception("Ocurrió un error al registrar el usuario" . $e);
		}
	} else {
		throw new Exception("El formato de la imagen no está permitido.");
	}
} else {
	throw new Exception("Información incompleta");
}
