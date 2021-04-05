<?php
include("conexion.php");
if(isset($_POST["id_articulo"]) && isset($_POST["estado"])) {

    $idArticulo = $_POST["id_articulo"];
    $estado = $_POST["estado"];
    $consulta = "update articulos set publico = $estado where id_articulo = $idArticulo";
    
    $res = mysqli_query($conex, $consulta);
    if($res) {
        echo json_encode(true);    
    } else {
        echo json_encode(false);    
    }    
} else {
    echo json_encode(false);
}
