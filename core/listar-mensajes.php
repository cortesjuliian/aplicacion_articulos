<?php

require('../config.php');
ValidarSesionAjax();
require('conexion.php');

use Core\Conexion;

$conexion = new Conexion();
try {
    $conexion->OpenConnection();
    $usuario = UsuarioSesion();
    if (isset($_POST["recibidos"])) {
        $query = $conexion->dao->prepare("select m.*, ur.nombre, ur.apellido, ud.nombre, ud.apellido  from mensajes m
        join usurios ur on ur.id = m.id_rtente 
        join usurios ud on ud.id = m.id_dnatario 
        where  ud.usuario = :Usuario 
        order by m.id_mensaje desc");
        
    } else {
        $query = $conexion->dao->prepare("select m.*, ur.nombre, ur.apellido, ud.nombre, ud.apellido  from mensajes m
        join usurios ur on ur.id = m.id_rtente 
        join usurios ud on ud.id = m.id_dnatario 
        where  ur.usuario = :Usuario 
        order by m.id_mensaje desc");
    }
    $query->bindParam(":Usuario", $usuario, \PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $resultado = $query->fetchAll();
        echo json_encode($resultado);
    } else {
        echo json_encode(null);
    }
} catch (\PDOException $e) {
    throw new Exception("Ocurrió un error al listar los mensajes". $e);
}
