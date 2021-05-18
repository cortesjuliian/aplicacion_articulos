<?php

require('../config.php');
require('conexion.php');
use Core\Conexion;

if (
  isset($_POST['Usuario']) && !empty($_POST['Usuario']) &&
  isset($_POST['Contrasena']) && !empty($_POST['Contrasena'])
) {
  
  $usuario = trim($_POST['Usuario']);
  $clave = md5(trim($_POST['Contrasena']));
  $conexion = new Conexion();
  try {
    $conexion->OpenConnection();
    $query = $conexion->dao->prepare(sprintf("select telefono, foto, tipofoto from usurios where usuario = :Usuario and pass = :Clave"));
  
    $query->bindParam(":Usuario", $usuario, \PDO::PARAM_STR);
    $query->bindParam(":Clave", $clave, \PDO::PARAM_STR);
    $query->execute();

    if($query->rowCount() > 0) {
      $resultado = $query->fetchAll()[0];

      $telefono_final = $resultado["telefono"];
      if (!is_null($telefono_final) && !empty($telefono_final)) {
        $token = rand(100000, 999999);
        $_SESSION['token'] = $token;
        $_SESSION['usuario'] = $_POST["Usuario"];
        $_SESSION['foto'] = base64_encode($resultado["foto"]);
        $_SESSION['tipofoto'] = $resultado["tipofoto"];
        $ch = curl_init();
        $post = array(
          'account' => '10021652', //número de usuario
          'apiKey' => 'YFXaYKHmZrsU9ZKY2Vk2mtHQpA342A', //clave API del usuario
          'token' => 'd468cc4bedfc33a9e4bc0f595093b4b4', // Token de usuario
          'toNumber' => '57' . $telefono_final, //número de destino
          'sms' => 'Hola, el codigo para ingresar al sistema es: ' . $token .' Gracias por utilizar nuestros servicios.', // mensaje de texto
          'flash' => '0', //mensaje tipo flash
          'sendDate' => time(), //fecha de envío del mensaje
          'isPriority' => 1, //mensaje prioritario
          'sc' => '899991', //código corto para envío del mensaje de texto
          'request_dlvr_rcpt' => 0, //mensaje de texto con confirmación de entrega al celular
        );
        $url = "https://api101.hablame.co/api/sms/v2.1/send/"; //endPoint: Primario
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        echo json_encode(true);
      }
    } else {
      echo json_encode(false);
    }    
  } catch (\PDOException $e) {
    throw new Exception("Ocurrió un error al validar el login");
  }
} else {
  throw new Exception("Información incompleta");
}