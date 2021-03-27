<?php
include("conexion.php");

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

$resultado='';


if (isset($_POST['registrar']))
	{ 
if 	((strlen(htmlspecialchars($_POST['nombre']) >= 1)) &&
	(strlen(htmlspecialchars($_POST['apellido']) >= 1)) &&
	(strlen(htmlspecialchars($_POST['email']) >= 1)) &&
	(strlen(htmlspecialchars($_POST['fecha']) >= 1)) &&
	(strlen(htmlspecialchars($_POST['tipo']) >= 1)) &&
	(strlen(htmlspecialchars($_POST['documento'])) >= 1) &&
	(strlen(htmlspecialchars($_POST['telefono']) >= 1)) &&
	(strlen(htmlspecialchars($_POST['hijos']) >= 1)) &&
	(strlen(htmlspecialchars($_POST['estadocivil']) >= 1)) &&
	(strlen(htmlspecialchars($_POST['usuario']) >= 1)) &&
	(strlen(htmlspecialchars($_POST['contraseña']) >= 1)))
	{
		$nombre= trim($_POST['nombre']);
		$apellido= trim($_POST['apellido']);
		$email= trim($_POST['email']);
		$fecha= trim($_POST['fecha']);
		$tipo= trim($_POST['tipo']);
		$documento= trim($_POST['documento']);
		$telefono= trim($_POST['telefono']);
		$hijos= trim($_POST['hijos']);
		$estadocivil= trim($_POST['estadocivil']); 
		$usuario= trim($_POST['usuario']);
		$pass= trim($_POST['contraseña']);		
		$consultausuario="SELECT * FROM usurios where usuario='$usuario'";
		$nuevousuario=mysqli_query($conex,$consultausuario); 

		if(mysqli_num_rows($nuevousuario)>0)
		{
		?>
			<h3 class="bad">¡Error en el registro! <br>Intentelo nuevamente</h3>
		<?php	
		}
		else
		{
			if (isset($_FILES['foto']['name']))
			 {
				$tipoarchivo = $_FILES['foto']['type'];
				$nombrearchivo = $_FILES['foto']['name'];
				$tamanoarchivo = $_FILES['foto']['size'];
				$imagensubida = fopen($_FILES['foto']['tmp_name'], 'r');
				$binariosimagen = fread($imagensubida, $tamanoarchivo);								
				$binariosimagen = mysqli_escape_string($conex, $binariosimagen);
				$filenamecmps = explode(".", $nombrearchivo);
				$fileextension = strtolower(end($filenamecmps));			
				$newfilename = md5(time() . $nombrearchivo);
				$allowedfileextensions = array('jpg', 'gif', 'png');

				if (in_array($fileextension, $allowedfileextensions)) {
					$consulta="INSERT INTO usurios(nombre, apellido, email, fechanacimiento, tipodocumento, numerodocumento, telefono, cantidadhijos,
					estadocivil, nombrefoto, foto, tipofoto, usuario, pass) VALUES ('$nombre','$apellido','$email','$fecha','$tipo','$documento','$telefono','$hijos','$estadocivil', '$newfilename', '$binariosimagen', '$tipoarchivo','$usuario','$pass')";	
					$resultado=mysqli_query($conex,$consulta);
				}
			}
				if ($resultado)
				{
				?>
				<h3 class="ok">¡Registro Exitoso!</h3>
				<?php
				}
				else
				{
					?>
					<h3 class="bad">¡Error en el registro!</h3>
					<?php
				}	
		}
	}
	else
	{	
		?>
		<h3 class="bad">¡Complete todos los campos!</h3>
		<?php
	}
}
?> 
