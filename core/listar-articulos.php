<?php

require('../config.php');
ValidarSesionAjax();
require('conexion.php');

use Core\Conexion;

$conexion = new Conexion();
try {
    $conexion->OpenConnection();
    $usuario = UsuarioSesion();
    if (isset($_POST["propios"])) {
        $query = $conexion->dao->prepare("select a.*, u.nombre, u.apellido from articulos a join usurios u on u.Id = a.id_usuario where u.usuario = :Usuario order by a.id_articulo desc");
        $query->bindParam(":Usuario", $usuario, \PDO::PARAM_STR);
    } else {
        $query = $conexion->dao->prepare("select a.*, u.nombre, u.apellido from articulos a  join usurios u on u.Id = a.id_usuario where a.publico = 1 order by a.id_articulo desc");
    }

    $query->execute();

    if ($query->rowCount() > 0) {
        $resultado = $query->fetchAll();
        echo json_encode($resultado);
    } else {
        echo json_encode(null);
    }
} catch (\PDOException $e) {
    throw new Exception("Ocurrió un error al lsitar los artículos");
}