<?php

require('../config.php');
ValidarSesionAjax();
require('conexion.php');

use Core\Conexion;


if (
	isset($_POST['Titulo']) && !empty($_POST['Titulo']) &&
	isset($_POST['Articulo']) && !empty($_POST['Articulo']) &&
	isset($_POST['Publico']) && !empty($_POST['Publico'])
) {
	$titulo = trim($_POST['Titulo']);
	$articulo = trim($_POST['Articulo']);
	$publico = trim($_POST['Publico']);
	$usuario = UsuarioSesion();
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
			$query = $conexion->dao->prepare("INSERT INTO articulos (id_usuario, titulo, articulo, publico, fecha) VALUES (:IdUsuario, :Titulo, :Articulo, :Publico, now())");

			$query->bindParam(":IdUsuario", $idUsuario, \PDO::PARAM_INT);
			$query->bindParam(":Titulo", $titulo, \PDO::PARAM_STR);
			$query->bindParam(":Articulo", $articulo, \PDO::PARAM_STR);
			$query->bindParam(":Publico", $publico, \PDO::PARAM_STR);
			$query->execute();

			echo json_encode(true);
		} else {
			throw new Exception("Ocurrió un error al crear el artículo" );
		}
	} catch (\PDOException $e) {
		throw new Exception("Ocurrió un error al crear el artículo");
	}
} else {
	throw new Exception("Información incompleta");
}
