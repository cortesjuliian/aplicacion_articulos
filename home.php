<?php
include("conexion.php");
session_start();
$usuario=$_SESSION['usuario'];
     if ($_SESSION['usuario']) {	  
?>

<!DOCTYPE HTML>
<!--
	Verti by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
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
								<span>UdeC</span>
								<span><?php echo "Hola ".$usuario;
								?></span>
							</div>

						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li class=""><a href="home.php">Home</a></li>
									<li class=""><a href="logout.php">salir</a></li>		
														
								</ul>
							</nav>

					</header>
				</div>

			<!-- Banner -->
				<div id="banner-wrapper">
					<div id="banner" class="box container">
						
							<p>Bienvenido al sistema...!!!</p>
						
					</div>
				</div>

			
				</div>
						<div class="row">
							<div class="col-12">
								<div id="copyright">
									<ul class="menu">
										<li>&copy; Julian Cortes</li><li></li>
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