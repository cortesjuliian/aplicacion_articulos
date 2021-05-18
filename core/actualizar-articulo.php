<?php

require('../config.php');
ValidarSesionAjax();
require('conexion.php');

use Core\Conexion;


if (
    isset($_POST['IdArticulo']) && !empty($_POST['IdArticulo']) &&
    isset($_POST['Estado'])
  ) {
	
	$usuario = UsuarioSesion();
    try {

		$conexion = new Conexion();
		$conexion->OpenConnection();
		$query = $conexion->dao->prepare(sprintf("select 1 from articulos a join usurios u on a.id_usuario = u.id where a.id_articulo = :IdArticulo and u.usuario = :Usuario"));
		$query->bindParam(":Usuario", $usuario, \PDO::PARAM_STR);
        $query->bindParam(":IdArticulo", $_POST['IdArticulo'], \PDO::PARAM_INT);
		$query->execute();

		if ($query->rowCount() > 0) {

			$conexion = new Conexion();
			$conexion->OpenConnection();
			$query = $conexion->dao->prepare("update articulos set publico = :Publico where id_articulo = :IdArticulo");

			$query->bindParam(":IdArticulo", $_POST['IdArticulo'], \PDO::PARAM_INT);
			$query->bindParam(":Publico", $_POST['Estado'], \PDO::PARAM_BOOL);
			$query->execute();
			echo json_encode(true);
		} else {
			throw new Exception("No autorizado");
		}
	} catch (\PDOException $e) {
		throw new Exception("Ocurrió un error al actualizar el artículo");
	}
} else {
	throw new Exception("Información incompleta");
}
