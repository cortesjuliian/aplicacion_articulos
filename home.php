<?php
include "plantilla/header.php";
ValidarSesion();
?>


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