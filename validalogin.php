<?php
include('conexion.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');
function Limpieza($cadena){
	$patron = array('/<script>.*<\/script>/');
	$cadena = preg_replace($patron, '', $cadena);
	$cadena = htmlspecialchars($cadena);
	return $cadena;
}

foreach ($_POST as $key => $value) {
    $_POST[$key] = Limpieza($value);
}

if (strlen(htmlspecialchars($_POST['usuario']) >= 1) && (strlen(htmlspecialchars($_POST['contraseña']) >= 1)))
{
  $usuario= trim($_POST['usuario']);
  $contraseña= md5(trim($_POST['contraseña']));
  session_start();
  $_SESSION['usuario']=$usuario;
  $consulta="SELECT*FROM usurios where usuario='$usuario' and pass='$contraseña'";
  $resultado=mysqli_query($conex,$consulta);
  $filas=mysqli_num_rows($resultado);

  if($filas)
  {
  $consulta_tel="SELECT telefono FROM usurios WHERE usuario='$usuario'";

    if ($resultado2 = $conex->query($consulta_tel))
    {
      $telefono_final='';
      while ($fila = $resultado2->fetch_row())
      {
          echo $fila[0];
          $telefono_final=$fila[0];
      }
      $resultado2->close();
    } 
                if ($telefono_final)
                {
                  $token=rand(100000, 999999);
                  $_SESSION['token']=$token;
                  $ch=curl_init();
                  $post = array(
                  'account' => '10021652', //número de usuario
                  'apiKey' => 'YFXaYKHmZrsU9ZKY2Vk2mtHQpA342A', //clave API del usuario
                  'token' => 'd468cc4bedfc33a9e4bc0f595093b4b4', // Token de usuario
                  'toNumber' => '57'.$telefono_final, //número de destino
                  'sms' => 'El codigo para ingresar al sistema es: '. $token, // mensaje de texto
                  'flash' => '0', //mensaje tipo flash
                  'sendDate'=> time(), //fecha de envío del mensaje
                  'isPriority' => 1, //mensaje prioritario
                  'sc'=> '899991', //código corto para envío del mensaje de texto
                  'request_dlvr_rcpt' => 0, //mensaje de texto con confirmación de entrega al celular
                  );
                  $url = "https://api101.hablame.co/api/sms/v2.1/send/"; //endPoint: Primario
                  curl_setopt ($ch,CURLOPT_URL,$url) ;
                  curl_setopt ($ch,CURLOPT_POST,1);
                  curl_setopt ($ch,CURLOPT_POSTFIELDS, $post);
                  curl_setopt ($ch,CURLOPT_RETURNTRANSFER, true);
                  curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT ,3);
                  curl_setopt ($ch,CURLOPT_TIMEOUT, 20);
                  $response= curl_exec($ch);
                  curl_close($ch);
                  $response= json_decode($response ,true) ;
                  header("location:validacodigo.php");
              }
}
else{
    ?>
    <?php
    include("index.php");
  ?>
  <script>
  alert("Usuario o contraseña incorrectos");
  </script>
  <?php
}
mysqli_free_result($resultado);
mysqli_close($conex);
}


