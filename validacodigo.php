<?php
include "plantilla/header.php";
ValidarSesion();

<<<<<<< Updated upstream
					</header>
				</div>

			<!-- Banner -->
				<div id="banner-wrapper">
					<div id="banner" class="box container">
                    <ul>
                        <li>Se ha enviado un codigo de confirmación al número de telefono registrado</li>
                    </ul>
							<form action="validacodigoexitoso.php" method="post">							
								<table class="inicio" style="width:100%">
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
=======
?>
<!-- Banner -->
<div id="banner-wrapper">
	<div id="banner" class="box container">
		<ul>
			<li>Se ha enviado un codigo de confirmación al número de telefono registrado</li>
		</ul>
		<form id="FormCodigo" method="post">
			<table class="inicio">
				<tr>
					<th> </th>
					<th>Codigo: <input type="text" id="Codigo" name="Codigo" placeholder="introduza el codigo" pattern="[0-9]+" minlength="6" maxlength="6" required><br></th>
					<th> </th>
				</tr>
			</table>
			<div style="text-align:center;">
				<input type="submit" value="Continuar">
>>>>>>> Stashed changes
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$('#FormCodigo').submit(function (e) {
		e.preventDefault();
		if($('#Codigo').val() != '') {
			$.ajax({
				url: 'core/validacion-codigo.php',
				data: $('#FormCodigo').serialize(),
				type: 'post',
				dataType: 'json',
				success: function(resultado) {
					if(resultado) {
						location.href = "home.php";
					} else {
						PrintError("Código incorrecto")	
					}
				},
				error: function() {
					PrintError("Ocurrió un error al validar el código, inténtelo de nuevo.")
				}
			});
		} else {
			PrintError("Debe completar todos los campos para continuar.")
		}
	});
</script>
<?php
include "plantilla/footer.php";
?>