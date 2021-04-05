<?php
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
                                <a class="button" href="index.php">Volver</a>							
								</ul>
							</nav>

					</header>
				</div>

			<!-- Banner -->
				<div id="banner-wrapper">
					<div id="banner" class="box container">
                    <ul>
                        <li>Se ha enviado un codigo de confirmación al número de telefono registrado</li>
                    </ul>
							<form action="validacodigoexitoso.php" method="post">							
								<table class="inicio">
									<tr>
										<th>  </th>						  
										  <th>Codigo: <input type="text" name="codigo" placeholder="introduza el codigo" pattern="[0-9]+" minlength="6" maxlength="6" required><br></th>									  
										<th>  </th>
									</tr>
								</table>
								<div style="text-align:center;">
							  <input type="submit" value="Continuar">
								</div>
							</form>						
					</div>
				</div>			
				</div>
						<div class="row">
							<div class="col-12">
								<div id="copyright">
									<ul class="menu">
										<li></li><li></li>
									</ul>
								</div>
							</div>
						</div>
					</footer>
				</div>
			</div>
	</body>
</html>