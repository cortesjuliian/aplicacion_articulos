<?php
include("conexion.php");
session_start();
$usuario = $_SESSION['usuario'];

$queryUsuario = "SELECT * FROM usurios WHERE usuario='$usuario';";
$resUsuario = mysqli_query($conex, $queryUsuario);
$infoUsuario = mysqli_fetch_assoc($resUsuario);


if ($_SESSION['usuario']) {

    //Guardar Artículo
    if (isset($_POST["GuardarArticulo"])) {
        if (
            isset($_POST['titulo']) && !empty($_POST['titulo']) &&
            isset($_POST['articulo']) && !empty($_POST['articulo']) &&
            isset($_POST['publico']) && is_numeric($_POST['publico'])
        ) {
            $titulo = $_POST['titulo'];
            $articulo = $_POST['articulo'];
            $publico = $_POST['publico'];
            $idUsuario = $infoUsuario["id"];

            $consulta = "INSERT INTO `articulos`(`id_usuario`, `titulo`, `articulo`, `publico`, `fecha`) VALUES
                                    ('$idUsuario', '$titulo', '$articulo', $publico, now())";
            $resultado = mysqli_query($conex, $consulta);
            if ($resultado) {
?>
                <h3 class="ok">¡Artículo creado!</h3>
            <?php
            } else {
            ?>
                <h3 class="bad">¡Error al crear el artículo!</h3>
    <?php
            }
        }
    }


    //codigo para validar el articulo


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

        .btn-publicar {
            font-size: 13px !important;
            padding: 3px !important;
            display: inline-block !important;
        }

        .btn-ocultar {
            background-color: indianred !important;
            font-size: 13px !important;
            padding: 3px !important;
            display: inline-block !important;
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

            <!-- articulos -->
            <div id="banner-wrapper">
                <div id="banner" class="box container">
                    <h2>Artículos</h2>
                    <h6>Click en los botones del menu:</h6>

                    <div class="tab">
                        <button class="tablinks" onclick="openart(event, 'todos')">Todos los artículos</button>
                        <button class="tablinks" onclick="openart(event, 'propios')">Mis artículos</button>
                        <button class="tablinks" onclick="openart(event, 'crear')">Crear artículos</button>
                    </div>

                    <div id="todos" class="tabcontent">
                        <button class="ListaTodos();">Refrescar</button>
                        <div id="ListaTodos"></div>
                    </div>


                    <!-- Aca va el codigo para mostrar los articulos propios-->

                    <div id="propios" class="tabcontent">
                        <button class="ListaPropios();">Refrescar</button>
                        <div id="ListaPropios"></div>
                    </div>


                    <!-- Aca va el codigo para mostrar la creacion de aritculos-->
                    <div id="crear" class="tabcontent">
                      
                        <tr>
                            <form method="post">
                                <th>Titulo: <input type="text" name="titulo" placeholder="Introduza titulo del artículo" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br></th>
                                <th>Articulo: <textarea name="articulo" placeholder="Introduza su artículo" rows="10" cols="40" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required></textarea><br></th>
                                <th>¿Artículo publico?: <select name="publico" id="publico">
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    </select></th><br>
                                <th></th>
                        </tr>
                        <br>
                        <input type="submit" name="GuardarArticulo" value="Subir">
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

            function ListarTodos() {
                $('#ListaTodos').html("");
                $.ajax({
                    url: 'listararticulos.php',
                    data: {},
                    type: 'post',
                    dataType: 'json',
                    success: function(lista) {
                        if (lista != null) {
                            for (var i = 0; i < lista.length; i++) {
                                $('#ListaTodos').append('<h1>' + lista[i][2] + ' <small> - ' + lista[i][6] + ' ' +lista[i][7] + '</small></h1>'  + lista[i][5] + ' <br><p class="text-articulo">' + lista[i][3] + '</p><hr>');
                            }
                        }
                    },
                    error: function() {
                        $('#ListaTodos').html("Ocurrió un error al listar");
                    }
                });
            }

            function ListarPropios() {
                $('#ListaPropios').html("");
                $.ajax({
                    url: 'listararticulos.php',
                    data: {
                        id_usuario: '<?php echo $infoUsuario["id"]; ?>'
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function(lista) {
                        if (lista != null) {
                            for (var i = 0; i < lista.length; i++) {

                                var $botonPublicar = $('<button>', {
                                    'data-id': lista[i][0],
                                    click: function() {
                                        PublicarArticulo($(this).data('id'));
                                    },
                                    class: 'btn-publicar',
                                    html: 'Publicar'
                                });

                                var $botonOcultar = $('<button>', {
                                    'data-id': lista[i][0],
                                    click: function() {
                                        OcultarArticulo($(this).data('id'));
                                    },
                                    class: 'btn-ocultar',
                                    html: 'Ocultar'
                                });

                                $('#ListaPropios').append('<h1>' + lista[i][2] + ' <small> - ' + lista[i][6] + ' ' +lista[i][7] + '</small></h1>'  + lista[i][5] + ' <br>');
                                if (lista[i][4] == "0") {
                                    $('#ListaPropios').append("Oculto - ");
                                    $('#ListaPropios').append($botonPublicar);
                                } else {
                                    $('#ListaPropios').append("Público - ");
                                    $('#ListaPropios').append($botonOcultar);
                                }
                                $('#ListaPropios').append('<p class="text-articulo">' + lista[i][3] + '</p><hr>');
                            }
                        }
                    },
                    error: function() {
                        $('#propios').html("Ocurrió un error al listar");
                    }
                });
            }

            function PublicarArticulo(id) {
                $.ajax({
                    url: 'cambiarestadoarticulo.php',
                    data: {
                        id_articulo: id,
                        estado: 1
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function() {
                        ListarPropios();
                        ListarTodos();
                    },
                    error: function() {
                        alert("Ocurrió un error al cambiar el estado.");
                    }
                });
            }

            function OcultarArticulo(id) {
                $.ajax({
                    url: 'cambiarestadoarticulo.php',
                    data: {
                        id_articulo: id,
                        estado: 0
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function() {
                        ListarPropios();
                        ListarTodos();
                    },
                    error: function() {
                        alert("Ocurrió un error al cambiar el estado.");
                    }
                });
            }

            $(function() {
                ListarPropios();
                ListarTodos();
            });
        </script>

    </body>

    </html>
<?php
} else {
    header("location:index.php");
}
?>