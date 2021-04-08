<?php
include("conexion.php");
session_start();


$usuario = $_SESSION['usuario'];
if ($_SESSION['usuario']) {



    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    function Limpieza($cadena)
    {
        $patron = array('/<script>.*<\/script>/');
        $cadena = preg_replace($patron, '', $cadena);
        $cadena = htmlspecialchars($cadena);
        return $cadena;
    }

    foreach ($_POST as $key => $value) {
        $_POST[$key] = Limpieza($value);
    }

    $resultado = '';


    //realizar la validacion para actualizar
    if (isset($_POST['Actualizar'])) {
        if ((strlen(htmlspecialchars($_POST['nombre']) >= 1)) &&
            (strlen(htmlspecialchars($_POST['apellido']) >= 1)) &&
            (strlen(htmlspecialchars($_POST['email']) >= 1)) &&
            (strlen(htmlspecialchars($_POST['fecha']) >= 1)) &&
            (strlen(htmlspecialchars($_POST['tipo']) >= 1)) &&
            (strlen(htmlspecialchars($_POST['documento'])) >= 1) &&
            (strlen(htmlspecialchars($_POST['telefono']) >= 1)) &&
            (strlen(htmlspecialchars($_POST['hijos']) >= 1)) &&
            (strlen(htmlspecialchars($_POST['estadocivil']) >= 1))
        ) {
            $nombre = trim($_POST['nombre']);
            $apellido = trim($_POST['apellido']);
            $email = trim($_POST['email']);
            $fecha = trim($_POST['fecha']);
            $tipo = trim($_POST['tipo']);
            $documento = trim($_POST['documento']);
            $telefono = trim($_POST['telefono']);
            $hijos = trim($_POST['hijos']);
            $estadocivil = trim($_POST['estadocivil']);
            //obtener el id de la variable $usuario para completar el update de la info
            $consulta = "UPDATE usurios 
                    set nombre = '$nombre', apellido = '$apellido', email = '$email', fechanacimiento = '$fecha', tipodocumento = '$tipo', numerodocumento = '$documento', telefono = '$telefono', cantidadhijos = '$hijos', estadocivil = '$estadocivil'
                    WHERE usuario='$usuario';";

            $resultado1 = mysqli_query($conex, $consulta);

            if ($resultado1) {
?>
                <h3 class="ok">¡Registro Exitoso!</h3>
            <?php
            } else {
            ?>
                <h3 class="bad">¡Error en la actualizacion!</h3>
            <?php

            }
        } else {
            ?>
            <h3 class="bad">¡Complete todos los campos!</h3>
            <?php
        }
    }



    if (isset($_POST['ActualizarFoto'])) {
        if (isset($_FILES['foto']['name'])) {
            $tipoarchivo = $_FILES['foto']['type'];
            $nombrearchivo = $_FILES['foto']['name'];
            $tamanoarchivo = $_FILES['foto']['size'];
            $imagensubida = fopen($_FILES['foto']['tmp_name'], 'r');
            $binariosimagen = fread($imagensubida, $tamanoarchivo);
            $binariosimagen = mysqli_escape_string($conex, $binariosimagen);
            $filenamecmps = explode(".", $nombrearchivo);
            $fileextension = strtolower(end($filenamecmps));
            $newfilename = md5(time() . $nombrearchivo);
            $allowedfileextensions = array('jpg', 'jpeg', 'gif', 'png');

            if (in_array($fileextension, $allowedfileextensions)) {
                $consulta = "UPDATE usurios set nombrefoto = '$newfilename', foto = '$binariosimagen', tipofoto = '$tipoarchivo' 
                    where usuario = '$usuario'";


                $resultadoFoto = mysqli_query($conex, $consulta);
                if ($resultadoFoto) {
            ?>
                    <h3 class="ok">¡Cambio imagen exitoso!</h3>
                <?php
                } else {
                ?>
                    <h3 class="bad">¡Error en la actualizacion!</h3>
                    <?php

                }
            }
        }
    }

    //realizar la validacion para cambiar la contraseña
    if (isset($_POST['Updatepass'])) {
        if ((strlen(htmlspecialchars($_POST['contrasena1']) >= 1)) &&
            (strlen(htmlspecialchars($_POST['contrasena2']) >= 1)) &&
            (strlen(htmlspecialchars($_POST['contrasena3']) >= 1))
        ) {
            $contrasena1 = md5(trim($_POST['contrasena1']));
            $contrasena2 = md5(trim($_POST['contrasena2']));
            $contrasena3 = md5(trim($_POST['contrasena3']));
            if ($contrasena2 == $contrasena3) {
                $query = "SELECT pass FROM usurios WHERE usuario='$usuario';";
                $res = mysqli_query($conex, $query);
                $row = mysqli_fetch_assoc($res);

                if ($row["pass"] == $contrasena1) {
                    $consultaPass = "UPDATE usurios set pass = '$contrasena2' WHERE usuario='$usuario';";
                    $resultadoPass = mysqli_query($conex, $consultaPass);
                    if ($resultadoPass) {
                    ?>
                        <h3 class="ok">¡Cambio de contraseña exitoso!</h3>
                    <?php
                    } else {
                    ?>
                        <h3 class="bad">¡Error en la actualizacion!</h3>
                    <?php

                    }
                } else {
                    ?>
                    <h3 class="bad">Las constraseña actual es incorrecta</h3>
                <?php
                }
            } else {
                ?>
                <h3 class="bad">Las constraseñas no coinciden</h3>
            <?php
            }
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
                                <img width="50" src="data:<?php echo $row['tipofoto']; ?>;base64,<?php echo  base64_encode($row['foto']); ?>">
                            </li>
                            <li>
                                <abbr title="Ir a Mi Cuenta"><a href="perfil.php"><?php echo $usuario; ?></a></abbr>
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
                            <table class="default"  style="width:100%">
                                <?php
                                $query = "SELECT * FROM usurios WHERE usuario='$usuario';";
                                $res = mysqli_query($conex, $query);
                                $row = mysqli_fetch_assoc($res)
                                ?>
                                <tr>
                                    <th>Nombre: <input type="text" value="<?php echo $row['nombre']; ?>" name="nombre" placeholder="introduza su nombre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br></th>
                                    <th>Apellido: <input type="text" value="<?php echo $row['apellido']; ?>" name="apellido" placeholder="introduza su apellido" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br></th>
                                    <th>Email: <input type="email" value="<?php echo $row['email']; ?>" name="email" placeholder="introduza su email" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" required><br></th>
                                </tr>
                                <tr>
                                    <th>Fecha de nacimiento: <br><input type="date" value="<?php echo $row['fechanacimiento']; ?>" name="fecha" required><br></th>

                                    <th>Tipo de documento: <select name="tipo" value="<?php echo $row['tipodocumento']; ?>" required>
                                            <option value="CC">Cedula de ciudadania</option>
                                            <option value="TI">Tarjeta de Identidad</option>
                                            <option value="NIT">NIT</option>
                                        </select><br></th>

                                    <th>Numero de documento: <input type="text" value="<?php echo $row['numerodocumento']; ?>" name="documento" placeholder="introduza su número de documento" pattern="[0-9]+" required onkeypress="return numeros(event)"><br></th>
                                </tr>
                                <tr>
                                    <th>Numero de telefono: <input type="tel" value="<?php echo $row['telefono']; ?>" name="telefono" placeholder="introduza su número de telefono" pattern="[0-9]+" minlength="10" maxlength="10"><br></th>

                                    <th>Cantidad de Hijos: <select name="hijos" value="<?php echo $row['cantidadhijos']; ?>" required>
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
                            <table class="default" style="width:100%">
                                <tr>
                                    <th>Contraseña actual: <input type="password" id="identificador" name="contrasena1" placeholder="introduza su contraseña" pattern="[A-Za-z0-9!?-]{8,12}" minlength="8" maxlength="12" required></th>
                                </tr>
                                <tr>
                                    <th>Contraseña Nueva: <input type="password" id="identificador" name="contrasena2" placeholder="introduza su contraseña" pattern="[A-Za-z0-9!?-]{8,12}" minlength="8" maxlength="12" required></th>
                                </tr>
                                <tr>
                                    <th>Repita la contraseña: <input type="password" id="identificador" name="contrasena3" placeholder="introduza su contraseña" pattern="[A-Za-z0-9!?-]{8,12}" minlength="8" maxlength="12" required></th>
                                </tr>
                            </table>
                            <input type="submit" name="Updatepass" value="Actualizar">
                        </form>
                    <?php

                    }
                    ?>


                    <?php
                    //Realiza el cambio de la foto
                    if (isset($_POST) && isset($_POST['foto']) || isset($_FILES['foto'])) {
                    ?>
                        <form method="post" enctype="multipart/form-data">
                            <table class="default" style="width:100%">
                                <tr>
                                    <th>
                                        <?php
                                        $query = "SELECT nombrefoto,foto,tipofoto FROM usurios WHERE usuario='$usuario';";
                                        $res = mysqli_query($conex, $query);
                                        $row = mysqli_fetch_assoc($res)
                                        ?>
                                        <img width="50" src="data:<?php echo $row['tipofoto']; ?>;base64,<?php echo  base64_encode($row['foto']); ?>">
                                    <th>
                                </tr>
                                <tr>
                                    <th>Foto de perfil:<br>
                                        <input type="file" name="foto" accept="image/png,image/jpeg" /><br>
                                    <th>
                                </tr>
                            </table>
                            <input type="submit" name="ActualizarFoto" value="Actualizar Foto">
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
                        <li></li>
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
} else {
    header("location:index.php");
}
?>