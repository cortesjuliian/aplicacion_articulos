<?php
include("conexion.php");
$consulta = "select m.*, ur.nombre, ur.apellido, ud.nombre, ud.apellido  from mensajes m
join usurios ur on ur.id = m.id_rtente 
join usurios ud on ud.id = m.id_dnatario 
where ";
if(isset($_POST["id_remitente"])) {
    $consulta .= " id_rtente = " . $_POST["id_remitente"];
} else if(isset($_POST["id_destinatario"])) {
    $consulta .= " id_dnatario = " . $_POST["id_destinatario"];
}

$res = mysqli_query($conex, $consulta);

$rows = mysqli_fetch_all($res);

echo json_encode($rows);