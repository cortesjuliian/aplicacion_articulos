<?php

require('../config.php');
ValidarSesionAjax();

if (isset($_POST['Codigo']) && !empty($_POST['Codigo'])) {
	$_SESSION['tokenvalido'] = true;
	echo json_encode($_POST['Codigo'] == $_SESSION['token']);
} else {	
	throw new Exception("Información incompleta");
}
