<?php
/* session_start();
session_destroy(); */
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
								<h1><a href="index.php">Sistema</a></h1>
								<span>UdeC</span>								
							</div>

						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li class=""><a href="index.php">Bienvenido</a></li>
									<li class=""><a href="registronuevo.php">Registrar</a></li>
								
								</ul>
							</nav>

					</header>
				</div>

			<!-- Banner -->
				<div id="banner-wrapper">
					<div id="banner" class="box container">
						
							<form action="validalogin.php" method="post">
								<table class="inicio">
									<tr>
										<th>  </th>						  
										<th>Usuario: <input type="text" name="usuario" placeholder="introduza su usuario" required><br></th>	
										  <th>  </th>.
									</tr>	
									<tr>
										<th>  </th>	
										<th>Contraseña: <input type="password" id="identificador"  name="contraseña" placeholder="introduza su contraseña" required></th>
										<th>  </th>	
									</tr>
									
								</table>
								<div style="text-align:center;">
							  <input type="submit" value="Ingresar">
								</div>
							</form>
						
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