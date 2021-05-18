<?php

require('../config.php');
ValidarSesionAjax();
require('conexion.php');

use Core\Conexion;


if (
	isset($_POST['IdDestinatario']) && !empty($_POST['IdDestinatario']) &&
	isset($_POST['Asunto']) && !empty($_POST['Asunto']) &&
	isset($_POST['Mensaje']) && !empty($_POST['Mensaje'])
) {
	$idDestinatario = trim($_POST['IdDestinatario']);
	$asunto = trim($_POST['Asunto']);
	$mensaje = trim($_POST['Mensaje']);
	$usuario = UsuarioSesion();

	$nombreAdjunto = "";
	if (isset($_FILES["Adjunto"])) {
		$target_dir = "../adjuntos/";

		$fileType = strtolower(pathinfo(basename($_FILES["Adjunto"]["name"]), PATHINFO_EXTENSION));

		$target_file = $target_dir . md5(time() . $_FILES["Adjunto"]["name"]) . "." . $fileType;
		$uploadOk = 1;

		if ($uploadOk == 0) {
			throw new Exception("Ocurrió un error al adjuntar el anexo.");
		} else {
			if (move_uploaded_file($_FILES["Adjunto"]["tmp_name"], $target_file)) {
				$nombreAdjunto = $target_file;
			} else {
				throw new Exception("Ocurrió un error al adjuntar el anexo.");
			}
		}
	}


	try {

		$conexion = new Conexion();
		$conexion->OpenConnection();
		$query = $conexion->dao->prepare(sprintf("select id from usurios where usuario = :Usuario"));
		$query->bindParam(":Usuario", $usuario, \PDO::PARAM_STR);
		$query->execute();

		if ($query->rowCount() > 0) {

			$idUsuario = $query->fetchColumn(0);
			$conexion = new Conexion();
			$conexion->OpenConnection();
			$query = $conexion->dao->prepare("INSERT INTO mensajes(id_rtente, id_dnatario, asunto, mensaje, adjunto) VALUES (:IdRemitente, :IdDestinatario, :Asunto, :Mensaje, :Adjunto)");

			$query->bindParam(":IdRemitente", $idUsuario, \PDO::PARAM_INT);
			$query->bindParam(":IdDestinatario", $idDestinatario, \PDO::PARAM_INT);
			$query->bindParam(":Asunto", $asunto, \PDO::PARAM_STR);
			$query->bindParam(":Mensaje", $mensaje, \PDO::PARAM_STR);
			$query->bindParam(":Adjunto", $nombreAdjunto, \PDO::PARAM_STR);
			$query->execute();

			echo json_encode(true);
		} else {
			throw new Exception("Ocurrió un error al crear el mensaje" );
		}
	} catch (\PDOException $e) {
		throw new Exception("Ocurrió un error al crear el mensaje");
	}
} else {
	throw new Exception("Información incompleta");
}
