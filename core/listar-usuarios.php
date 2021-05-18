<?php

require('../config.php');
ValidarSesionAjax();
require('conexion.php');

use Core\Conexion;

$conexion = new Conexion();
try {
    $conexion->OpenConnection();
    $usuario = UsuarioSesion();
    
    $query = $conexion->dao->prepare("select id, nombre, apellido, usuario from usurios order by nombre");
    
    $query->execute();

    if ($query->rowCount() > 0) {
        $resultado = $query->fetchAll();
        echo json_encode($resultado);
    } else {
        echo json_encode(null);
    }
} catch (\PDOException $e) {
    throw new Exception("Ocurrió un error al listar los usuarios");
}