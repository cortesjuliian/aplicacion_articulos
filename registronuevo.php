

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
								<?php
								include("registrar.php");

								?>
							</div>
							
						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li class=""><a href="registronuevo.php">Registro</a></li>
									<a class="button" href="index.php">Volver</a>
								</ul>
							</nav>

					</header>
				</div>
			
			<!-- Banner -->
		
				<div id="banner-wrapper">
				
					<div id="banner" class="box container">
					
							<form  method="post" enctype="multipart/form-data">
								<table  style="width:100%">
									<tr>							  
										  <th>Nombre: <input type="text" name="nombre" placeholder="introduza su nombre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br></th>									  
										  <th>Apellido: <input type="text" name="apellido" placeholder="introduza su apellido" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br></th>
										  <th>Email: <input type="email" name="email" placeholder="introduza su email" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" required><br></th>	
									</tr>	
									<tr>
										<th>Fecha de nacimiento: <br><input type="date" name="fecha" required><br></th>	

										<th>Tipo de documento: <select name="tipo" required> 
											<option value="CC">Cedula de ciudadania</option> 
											<option value="TI">Tarjeta de Identidad</option> 
											<option value="NIT">NIT</option>
										</select><br></th>		

										<th>Numero de documento: <input type="text" name="documento" placeholder="introduza su número de documento" pattern="[0-9]+" required onkeypress="return numeros(event)"><br></th>
								 	</tr>
									<tr>
									<th>Numero de telefono: <input type="text" name="telefono" placeholder="introduza su número de telefono" pattern="[0-9]+" minlength="10" maxlength="10"  ><br></th>

										<th>Cantidad de Hijos: <select name="hijos" required>
											<option value="Ninguno">0</option> 
											<option value="1">1</option> 
											<option value="2">2</option>
											<option value="3">3</option> 
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="5+">Más de 5</option>
										</select><br></th>
										<th>
											Estado civil: <select name="estadocivil" required>
												<option value="Soltero">Soltero(a)</option> 
												<option value="Casado">Casado(a)</option> 											
											</select><br>
										</th>
									</tr>		
									<tr>										
											<th>Foto de perfil:<br>
											 <input  type	="file" name="foto" accept="image/png,image/jpeg"/><br></th>	
									</tr>
									<tr>										
											<th>Usuario: <input type="text" name="usuario" placeholder="introduza su usuario" pattern="[a-zA-Z0-9]+" required><br></th>	
											<th>Contraseña: <input type="password" id="identificador"  name="contraseña" placeholder="introduza su contraseña" pattern="[A-Za-z0-9!?-]{8,12}" required></th>
									</tr>	
								</table>
							  <input type="submit" name="registrar" value="Enviar">
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