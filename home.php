<?php
include "plantilla/header.php";
ValidarSesion();
?>


<<<<<<< Updated upstream
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
                            <img
                                src="data:<?php echo $row['tipofoto']; ?>;base64,<?php echo  base64_encode($row['foto']); ?>">

                        </li>
                        <li>
                            <abbr title="Ir a Mi Cuenta"><a href="perfil.php"><?php echo $usuario;?></a></abbr>.


                            <ul>
                                <li><a href="perfil.php">Mi cuenta</a></li>
                            </ul>
                        </li>
                        <li><a> | </a></li>
                        <li class="current"><a href="home.php">Home</a></li>
                        <li class=""><a href="logout.php">salir</a></li>
                    </ul>
                </nav>

            </header>
        </div>
=======
<!-- Banner -->
<div id="banner-wrapper">
    <div id="banner" class="box container">
        <h3>Bienvenido a su administrador de articulos.</h3>
    </div>
</div>

<!-- Features -->
<div id="features-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-6 col-12-medium">

                <!-- Box -->
                <section class="box feature">
                    <div class="inner">
                        <header>
                            <h2>Artículos</h2>
                            <p>Visualice y gestione artículos</p>
                        </header>
                        <a class="button" href="articulos.php">Ir a Artículos</a>
                    </div>
                </section>
>>>>>>> Stashed changes

            </div>
            <div class="col-6 col-12-medium">

                <!-- Box -->
                <section class="box feature">
                    <div class="inner">
                        <header>
                            <h2>Mensajes</h2>
                            <p>Gestione su centro de mensajes</p>
                        </header>
                        <a class="button" href="mensajes.php">Ir a Mensajes</a>
                    </div>
                </section>

            </div>
            <div class="col-4 col-12-medium">



            </div>
        </div>
    </div>
</div>

<?php
include "plantilla/footer.php";
?>