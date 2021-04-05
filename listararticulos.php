<?php
include("conexion.php");
$consulta = "select a.*, u.nombre, u.apellido from articulos a 
    join usurios u on u.Id = a.id_usuario
where ";
if(isset($_POST["id_usuario"])) {
    $consulta .= " a.id_usuario = " . $_POST["id_usuario"];
} else {
    $consulta .= " a.publico = 1 ";
}

$res = mysqli_query($conex, $consulta);
$rows = mysqli_fetch_all($res);

echo json_encode($rows);