<?php
$dbhost = 'localhost';
$dbname = 'prueba_2';
$dbuser = 'root';
$dbpass = '';

try {
    $dbcon = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
    $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {

    die($ex->getMessage());
}


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


include("conexion.php");
session_start();
$usuario = $_SESSION['usuario'];

$queryUsuario = "SELECT * FROM usurios WHERE usuario='$usuario';";
$resUsuario = mysqli_query($conex, $queryUsuario);
$infoUsuario = mysqli_fetch_assoc($resUsuario);


if ($_SESSION['usuario']) {

    //Guardar Mensaje
    if (isset($_POST["GuardarMensaje"])) {
        if (
            isset($_POST['usuarioquerecibe']) && is_numeric($_POST['usuarioquerecibe']) &&
            isset($_POST['asunto']) && !empty($_POST['asunto']) &&
            isset($_POST['mensaje']) && !empty($_POST['mensaje'])
        ) {
            $nombreAdjunto = "";
            if (isset($_FILES["adjunto"])) {
                $target_dir = "adjuntos/";

                $fileType = strtolower(pathinfo(basename($_FILES["adjunto"]["name"]), PATHINFO_EXTENSION));

                $target_file = $target_dir . md5(time() . $_FILES["adjunto"]["name"]) . "." . $fileType;
                $uploadOk = 1;

                if ($uploadOk == 0) {
?>
                    <h3 class="bad">¡Error al adjuntar el archivo!</h3>
                    <?php
                } else {
                    if (move_uploaded_file($_FILES["adjunto"]["tmp_name"], $target_file)) {
                        $nombreAdjunto = $target_file;
                    } else {
                    ?>
                        <h3 class="ok">¡Mensaje enviado sin adjunto!</h3>
                <?php
                    }
                }
            }

            $usuarioquerecibe = $_POST['usuarioquerecibe'];
            $asunto = $_POST['asunto'];
            $mensaje = $_POST['mensaje'];
            $idUsuario = $infoUsuario["id"];

            $consulta = "INSERT INTO `mensajes`(`id_rtente`, `id_dnatario`, `asunto`, `mensaje`, `adjunto`) 
                        VALUES ($idUsuario,$usuarioquerecibe,'$asunto','$mensaje','$nombreAdjunto')";


            $resultado = mysqli_query($conex, $consulta);
            if ($resultado) {
                ?>
                <h3 class="ok">¡Mensaje creado!</h3>
            <?php
            } else {
            ?>
                <h3 class="bad">¡Error al crear el mensaje!</h3>
    <?php
            }
        }
    }
    ?>

    <!DOCTYPE HTML>
    <!-- para los tabs de los articulos -->
    <style>
        body {
            font-family: Arial;
        }

        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #0090c5;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #111111;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #111111;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }
        .text-articulo {
            font-size: 14px !important;
        }
    </style>


    <html>

    <head>
        <title>Sistema</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <script type="text/javascript" src="assets/js/jquery-3.6.0.min.js"></script>
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

            <!-- mensajes -->
            <div id="banner-wrapper">
                <div id="banner" class="box container">
                    <h2>Mensajes</h2>
                    <h6>Click en los botones del menu:</h6>

                    <div class="tab">
                        <button class="tablinks" onclick="openart(event, 'entrada')">Bandeja de entrada</button>
                        <button class="tablinks" onclick="openart(event, 'enviados')">Enviados</button>
                        <button class="tablinks" onclick="openart(event, 'crear')">Crear Mensaje</button>
                    </div>


                    <div id="entrada" class="tabcontent">
                        <button class="ListarEntradas();">Refrescar</button>
                        <div id="ListaEntradas"></div>
                    </div>


                    <div id="enviados" class="tabcontent">
                        <button class="ListarEnviados();">Refrescar</button>
                        <div id="ListaEnviados"></div>
                    </div>


                    <div id="crear" class="tabcontent">

                        <tr>
                            <form method="post" enctype="multipart/form-data">
                                <th>Para:<select name="usuarioquerecibe">
                                        <option value="showAll" selected="selected">Seleccione usuario</option>
                                        <?php
                                        $stmt = $dbcon->prepare('SELECT * FROM usurios');
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            extract($row);
                                        ?>
                                            <option value="<?php echo $id; ?>"><?php echo $nombre . " " . $apellido . " (" . $usuario . ")"; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select><br></th>
                                <th>Asunto: <input type="text" name="asunto" placeholder="Introduza el asunto" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br></th>
                                <th>Archivo adjunto:<br> <input type="file" name="adjunto" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" /><br></th>
                                <th>Mensaje: <textarea name="mensaje" placeholder="Introduza su mensaje" rows="10" cols="40" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required></textarea><br></th>

                        </tr>
                        <input type="submit" name="GuardarMensaje" value="Enviar">
                        </form>
                    </div>

                </div>
            </div>

            <!-- -->
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

        <script>
            function openart(evt, artName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(artName).style.display = "block";
                evt.currentTarget.className += " active";
            }


            function ListarEntradas() {
                $('#ListaEntradas').html("");
                $.ajax({
                    url: 'listarmensajes.php',
                    data: {
                        id_destinatario: '<?php echo $infoUsuario["id"]?>'
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function(lista) {
                        if (lista != null) {
                            for (var i = 0; i < lista.length; i++) {
                                $('#ListaEntradas').append('<h1>' + lista[i][3] + ' - '+ lista[i][6] + '   ' + lista[i][7] + '</h1><p class="text-articulo">' + lista[i][4] + '</p>');
                                if(lista[i][5] != null && lista[i][5] != "") {
                                    $('#ListaEntradas').append('<a target="_blank" href="' + lista[i][5] + '">Descargar adjunto</a>');
                                }
                                $('#ListaEntradas').append('<hr>');
                            }
                        }
                    },
                    error: function() {
                        $('#ListaEntradas').html("Ocurrió un error al listar");
                    }
                });
            }

            function ListarEnviados() {
                $('#ListaEnviados').html("");
                $.ajax({
                    url: 'listarmensajes.php',
                    data: {
                        id_remitente: '<?php echo $infoUsuario["id"]?>'
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function(lista) {
                        if (lista != null) {
                            for (var i = 0; i < lista.length; i++) {
                                $('#ListaEnviados').append('<h1>' + lista[i][3] + ' - '+ lista[i][8] + '   ' + lista[i][9]+ '</h1><p class="text-articulo">' + lista[i][4] + '</p>');
                                if(lista[i][5] != null && lista[i][5] != "") {
                                    $('#ListaEnviados').append('<a target="_blank" href="' + lista[i][5] + '">Descargar adjunto</a>');
                                }
                                $('#ListaEnviados').append('<hr>');
                            }
                        }
                    },
                    error: function() {
                        $('#ListaEnviados').html("Ocurrió un error al listar");
                    }
                });
            }

            $(function () {
                ListarEntradas();
                ListarEnviados();
            });
        </script>



    </body>

    </html>
<?php
} else {
    header("location:index.php");
}
?>