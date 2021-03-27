<?php
include("conexion.php");
session_start();
$usuario=$_SESSION['usuario'];
     if ($_SESSION['usuario']) {	  
?>

<!DOCTYPE HTML>
<!-- para los tabs de los articulos -->
<style>
body {font-family: Arial;}

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
</style>


<html>
	<head>
		<title>Sistema</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css"/>
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
								<abbr title="Ir a Mi Cuenta"><a href="perfil.php"><?php echo $usuario;?></a></abbr>					
										<ul>
											<li><a href="#">Mi cuenta</a></li>
										</ul>
								</li>
								<li ><a> | </a></li>
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
					<h3>Posible titulo</h3>
					<p>Aca ira la consulta de todos los articulos.</p>
					</div>

					<div id="propios" class="tabcontent">
					<h3>Posible titulo</h3>
					<p>Aca ira los articulos del usuario.</p> 				
					</div>

					<div id="crear" class="tabcontent">
					<h3>Posible titulo</h3>
                    <tr>
                    <form  method="post">					
                        <th>Titulo: <input type="text" name="titulo" placeholder="Introduza titulo del artículo" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br></th>
                        <th>Articulo: <textarea name="articulo" placeholder="Introduza su artículo" rows="10" cols="40" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required></textarea><br></th>
                        <th>¿Artículo publico?: <input type="checkbox" name="publico" value="1"></th><br>
						<th></th>		
                    </tr>
					<br>                    
                    <input type="submit" name="registrar" value="Subir">
					</form>
					</div>
						
					</div>
				</div>
			
			<!-- -->
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
</script>

	</body>
</html>
<?php
	 }
	 else {
		 header("location:index.php");
	 }
?>