<?php

require('Core/conexion.php');

use Core\Conexion;

$perfil = array();
$conexion = new Conexion();
try {
    $conexion->OpenConnection();
    $query = $conexion->dao->prepare("select id, nombre, apellido, email, fechanacimiento, tipodocumento, numerodocumento, telefono, cantidadhijos, estadocivil, nombrefoto, foto, tipofoto, usuario from usurios where usuario = :Usuario");
    $usuario = UsuarioSesion();

    $query->bindParam(":Usuario", $usuario, \PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $resultado = $query->fetchAll()[0];
        $perfil = array(
            "id" => $resultado["id"],
            "nombre" => $resultado["nombre"],
            "apellido" => $resultado["apellido"],
            "email" => $resultado["email"],
            "fechanacimiento" => $resultado["fechanacimiento"],
            "tipodocumento" => $resultado["tipodocumento"],
            "numerodocumento" => $resultado["numerodocumento"],
            "telefono" => $resultado["telefono"],
            "cantidadhijos" => $resultado["cantidadhijos"],
            "estadocivil" => $resultado["estadocivil"],
            "nombrefoto" => $resultado["nombrefoto"],
            "foto" => $resultado["foto"],
            "tipofoto" => $resultado["tipofoto"],
            "usuario" => $resultado["usuario"]
        );
    }
} catch (\PDOException $e) {
    throw new Exception("Ocurrió un error al validar el login");
}
