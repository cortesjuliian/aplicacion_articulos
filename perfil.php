<?php
include("conexion.php");
session_start();
$usuario=$_SESSION['usuario'];
     if ($_SESSION['usuario']) {	 

        
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


//realizar la validacion para actualizar
        if (isset($_POST['Actualizar']))
        { 
            if 	((strlen(htmlspecialchars($_POST['nombre']) >= 1)) &&
                (strlen(htmlspecialchars($_POST['apellido']) >= 1)) &&
                (strlen(htmlspecialchars($_POST['email']) >= 1)) &&
                (strlen(htmlspecialchars($_POST['fecha']) >= 1)) &&
                (strlen(htmlspecialchars($_POST['tipo']) >= 1)) &&
                (strlen(htmlspecialchars($_POST['documento'])) >= 1) &&
                (strlen(htmlspecialchars($_POST['telefono']) >= 1)) &&
                (strlen(htmlspecialchars($_POST['hijos']) >= 1)) &&
                (strlen(htmlspecialchars($_POST['estadocivil']) >= 1)))
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
                    //obtener el id de la variable $usuario para completar el update de la info
                    $consulta="UPDATE usurios set (nombre, apellido, email, fechanacimiento, tipodocumento, numerodocumento, telefono, cantidadhijos,
                    estadocivil) VALUES ('$nombre','$apellido','$email','$fecha','$tipo','$documento','$telefono','$hijos','$estadocivil')
                    WHERE usuario='$usuario';";
                    	
                    $resultado1=mysqli_query($conex,$consulta);                            
                        
                            if ($resultado1)
                            {
                            ?>
                            <h3 class="ok">¡Registro Exitoso!</h3>
                            <?php
                            }
                            else
                            {
                            ?>
                            <h3 class="bad">¡Error en la actualizacion!</h3>
                            <?php
                            	
                    }
                }
                else
                {	
                    ?>
                <h3 class="bad">¡Complete todos los campos!</h3>
                <?php
                }
            }

//realizar la validacion para cambiar la contraseña
if (isset($_POST['Updatepass']))
{ 
    if 	((strlen(htmlspecialchars($_POST['contraseña1']) >= 1)) &&
        (strlen(htmlspecialchars($_POST['contraseña2']) >= 1)) &&
        (strlen(htmlspecialchars($_POST['contraseña3']) >= 1)))
        {
            $contraseña1= trim($_POST['contraseña1']);
            $contraseña2= trim($_POST['contraseña2']);
            $pass= trim($_POST['contraseña3']);
            //falta validar que las contraseñas coincidan y procedera a hacer el update
            $consulta="INSERT INTO usurios(nombre, apellido, email, fechanacimiento, tipodocumento, numerodocumento, telefono, cantidadhijos,
            estadocivil, nombrefoto, foto, tipofoto, usuario, pass) VALUES ('$nombre','$apellido','$email','$fecha','$tipo','$documento','$telefono','$hijos','$estadocivil', '$newfilename', '$binariosimagen', '$tipoarchivo','$usuario','$pass')";	
            $resultado=mysqli_query($conex,$consulta);
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
                    <h3 class="bad">¡Error en la actulizacion!</h3>
                    <?php
                    }	
                        
                    }
                    else
                    {	
                        ?>
                    <!-- <h3 class="bad">¡Complete todos los campos!</h3> -->
                    <?php
                    }
                
//hacer el update en la Bd de la foto
if (isset($_POST['foto']))
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
                    //CONSEGUIR EL ID DE LA VARIABLE $USUARIO PARA TERMINAR EL UPDATE
					$consulta="UPDATE usurios SET(nombrefoto, foto, tipofoto) VALUES ('$newfilename', '$binariosimagen', '$tipoarchivo')";	
					$resultado=mysqli_query($conex,$consulta);
				}
			}
            if ($resultado)
            {
            ?>
            <h3 class="ok">¡Registro Exitoso!</h3>            
            <?php
            header("location:perfil.php");
            }
                else
                    {
                    ?>
            <h3 class="bad">¡Error en el registro!</h3>
            <?php
                    }
                }
                    ?>               
                   



<!DOCTYPE HTML>

<html>

<head>
    <title>Sistema</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body class="is-preload homepage">
    <div id="page-wrapper">

        <!-- Header -->
        <div id="header-wrapper">
            <header id="header" class="container">

                <!-- Logo -->
                <div id="logo">
                    <h1><a href="home.php">Sistema</a></h1>
                </div>

                <!-- Nav -->
                <nav id="nav">
                    <ul>
                        <li>
                            <?php							
									$query = "SELECT nombrefoto,foto,tipofoto FROM usurios WHERE usuario='$usuario';";
									$res = mysqli_query($conex, $query);
									$row = mysqli_fetch_assoc($res)
									?>
                            <img width="50"
                                src="data:<?php echo $row['tipofoto']; ?>;base64,<?php echo  base64_encode($row['foto']); ?>">
                        </li>
                        <li>
                            <abbr title="Ir a Mi Cuenta"><a href="perfil.php"><?php echo $usuario;?></a></abbr>
                            <ul>
                                <li><a href="#">Mi cuenta</a></li>
                            </ul>
                        </li>
                        <li><a> | </a></li>
                        <li class="current"><a href="home.php">Home</a></li>
                        <li class=""><a href="logout.php">salir</a></li>
                    </ul>
                </nav>

            </header>
        </div>

        <!-- Banner -->

        <div id="banner-wrapper">

            <div id="banner" class="box container">

                <form method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <th> <input type="submit" name="update" value="Actulizar información">
                            </th>
                            <th> <input type="submit" name="passw" value="Cambiar contraseña">
                            </th>
                            <th> <input type="submit" name="foto" value="Cambiar foto">
                            </th>
                        </tr>
                    </table>
                    <br>
                    <br>
                </form>



                <?php
                //relizar el update en la bd
                if (isset($_POST) && isset($_POST['update'])) {
                    ?>
                <form method="post" enctype="multipart/form-data">
                    <table class="default">
                    <?php
                    $query = "SELECT * FROM usurios WHERE usuario='$usuario';";
                    $res = mysqli_query($conex, $query);
                    $row = mysqli_fetch_assoc($res)
                    ?>
                        <tr>
                            <th>Nombre: <input type="text" value="<?php echo $row['nombre']; ?>" name="nombre" placeholder="introduza su nombre"
                                    pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br></th>
                            <th>Apellido: <input type="text" value="<?php echo $row['apellido']; ?>" name="apellido" placeholder="introduza su apellido"
                                    pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br></th>
                            <th>Email: <input type="email" value="<?php echo $row['email']; ?>" name="email" placeholder="introduza su email"
                                    pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
                                    required><br></th>
                        </tr>
                        <tr>
                            <th>Fecha de nacimiento: <br><input type="date" value="<?php echo $row['fechanacimiento']; ?>" name="fecha" required><br></th>

                            <th>Tipo de documento: <select name="tipo" value="<?php echo $row['tipodocumento']; ?>" required>
                                    <option value="CC">Cedula de ciudadania</option>
                                    <option value="TI">Tarjeta de Identidad</option>
                                    <option value="NIT">NIT</option>
                                </select><br></th>

                            <th>Numero de documento: <input type="text" value="<?php echo $row['numerodocumento']; ?>" name="documento"
                                    placeholder="introduza su número de documento" pattern="[0-9]+" required
                                    onkeypress="return numeros(event)"><br></th>
                        </tr>
                        <tr>
                            <th>Numero de telefono: <input type="tel" value="<?php echo $row['telefono']; ?>" name="telefono"
                                    placeholder="introduza su número de telefono" pattern="[0-9]+" minlength="10"
                                    maxlength="10"><br></th>

                            <th>Cantidad de Hijos: <select name="hijos"  value="<?php echo $row['cantidadhijos']; ?>" required>
                                    <option value="Ninguno">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="5+">Más de 5</option>
                                </select><br></th>
                            <th>
                                Estado civil: <select name="estadocivil" value="<?php echo $row['estadocivil']; ?>" required>
                                    <option value="Soltero">Soltero(a)</option>
                                    <option value="Casado">Casado(a)</option>
                                </select><br>
                            </th>
                        </tr>                       
                        <!-- para posible cambio de usuario y contraseña -->
                        <!-- <tr>										
											<th>Usuario: <input type="text" name="usuario" placeholder="introduza su usuario" pattern="[a-zA-Z0-9]+" required><br></th>	
											<th>Contraseña: <input type="password" id="identificador"  name="contraseña" placeholder="introduza su contraseña" pattern="[A-Za-z0-9!?-]{8,12}" required></th>
									</tr> -->
                    </table>
                    <input type="submit" name="Actualizar" value="Actualizar">
                </form>
                <?php
		        }
                ?>


                <?php
                //Realiza el cambio de contraseña en la bd
                if (isset($_POST) && isset($_POST['passw'])) {
                ?>
                <form method="post">
                    <table class="default">
                        <tr>
                            <th>Contraseña actual: <input type="password1" id="identificador" name="contraseña1"
                                    placeholder="introduza su contraseña" pattern="[A-Za-z0-9!?-]{8,12}" required></th>
                        </tr>
                        <tr>
                            <th>Contraseña Nueva: <input type="password2" id="identificador" name="contraseña2"
                                    placeholder="introduza su contraseña" pattern="[A-Za-z0-9!?-]{8,12}" required></th>
                        </tr>
                        <tr>
                            <th>Repita la contraseña: <input type="password3" id="identificador" name="contraseña3"
                                    placeholder="introduza su contraseña" pattern="[A-Za-z0-9!?-]{8,12}" required></th>
                        </tr>
                    </table>
                    <input type="submit" name="Updatepass" value="Updatepass">
                </form>
                <?php

                }
                    ?>


                <?php
                //Realiza el cambio de la foto
                if (isset($_POST) && isset($_POST['foto'])) {
                ?>
                <form method="post" enctype="multipart/form-data">
                    <table class="default">
                        <tr>
                        <th>
                        <?php							
									$query = "SELECT nombrefoto,foto,tipofoto FROM usurios WHERE usuario='$usuario';";
									$res = mysqli_query($conex, $query);
									$row = mysqli_fetch_assoc($res)
									?>
                            <img width="50"
                                src="data:<?php echo $row['tipofoto']; ?>;base64,<?php echo  base64_encode($row['foto']); ?>">
                        <th>
                        </tr>
                        <tr>
                        <th>Foto de perfil:<br>
                            <input type="file" name="foto" accept="image/png,image/jpeg" /><br>
                            <th>
                        </tr>
                    </table>
                    <input type="submit" name="foto" value="Actualizar foto">
                </form>
                <?php

                }
                    ?>


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="copyright">
                <ul class="menu">
                    <li>&copy; Julian Cortes</li>
                    <li></li>
                </ul>
            </div>
        </div>
    </div>
    </footer>
    </div>
    </div>
</body>

</html>
<?php
	 }
	 else {
		 header("location:index.php");
	 }
?>