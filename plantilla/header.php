<?php
require "config.php";
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Sistema</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/sitio.css" />
    <script type="text/javascript" src="assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="assets/js/sitio.js"></script>
</head>

<body class="is-preload homepage">
    <div id="page-wrapper">
        <!-- Header -->
        <div id="header-wrapper">
            <header id="header" class="container">
                <!-- Logo -->
                <div id="logo">
                    <h1><a href="home.php">Sistema</a></h1>
                    <span>UdeC</span>
                </div>
                <!-- Nav -->
                <nav id="nav">
                    <?php
                    if (isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"]) && isset($_SESSION['tokenvalido']) && $_SESSION['tokenvalido']) { ?>
                        <ul>
                            <li>
                                
                                <img width="10" height="10" style="max-width: 100px;    max-height: 100px;" src="data:<?php echo $_SESSION["tipofoto"]; ?>;base64,<?php echo $_SESSION["foto"]; ?>">

                            </li>
                            <li>
                                <abbr title="Ir a Mi Cuenta"><a href="perfil.php"><?php echo $_SESSION["usuario"]; ?></a></abbr>.


                                <ul>
                                    <li><a href="perfil.php">Mi cuenta</a></li>
                                </ul>
                            </li>
                            <li><a> | </a></li>
                            <li class="current"><a href="home.php">Home</a></li>
                            <li class=""><a href="logout.php">salir</a></li>
                        </ul>

                    <?php  } else { ?>
                        <ul>
                            <li class=""><a href="index.php">Bienvenido</a></li>
                            <li class=""><a href="registronuevo.php">Registrar</a></li>
                        </ul>
                    <?php  } ?>
                </nav>
            </header>
        </div>
        <div id="MsgContainer">
            <!--<h3 class="bad"></h3>-->
            <!--<h3 class="ok"></h3>-->
        </div>