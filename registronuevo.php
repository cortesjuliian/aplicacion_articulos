<?php
include "plantilla/header.php";
?>

<div id="banner-wrapper">
	<div id="banner" class="box container">
		<form id="FormRegistro" method="post" enctype="multipart/form-data">
			<table class="default" style="width: 100%;">
				<tr>
					<th>Nombre: <input type="text" id="Nombre" name="nombre" placeholder="introduza su nombre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br></th>
					<th>Apellido: <input type="text" id="Apellido" name="apellido" placeholder="introduza su apellido" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br></th>
					<th>Email: <input type="email" id="Email" name="email" placeholder="introduza su email" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" required><br></th>
				</tr>
				<tr>
					<th>Fecha de nacimiento: <br><input type="date" id="Fecha" name="fecha" required><br></th>
					<th>Tipo de documento: <select  id="Tipo" name="tipo" required>
							<option value="CC">Cedula de ciudadania</option>
							<option value="TI">Tarjeta de Identidad</option>
							<option value="NIT">NIT</option>
						</select><br></th>
					<th>Numero de documento: <input type="text" id="Documento" name="documento" placeholder="introduza su número de documento" pattern="[0-9]+" required><br></th>
				</tr>
				<tr>
					<th>Numero de telefono: <input type="text" id="Telefono" name="telefono" placeholder="introduza su número de telefono" pattern="[0-9]+" minlength="10" maxlength="10"><br></th>

					<th>Cantidad de Hijos: <select  id="Hijos"name="hijos" required>
							<option value="Ninguno">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="5+">Más de 5</option>
						</select><br></th>
					<th>
						Estado civil: <select  id="Estadocivil"name="estadocivil" required>
							<option value="Soltero">Soltero(a)</option>
							<option value="Casado">Casado(a)</option>
						</select><br>
					</th>
				</tr>
				<tr>
					<th>Foto de perfil:<br>
						<input type="file" id="Foto" name="foto" accept="image/png,image/jpeg" /><br>
					</th>
				</tr>
				<tr>
					<th>Usuario: <input type="text" id="Usuario" name="usuario" placeholder="introduza su usuario" pattern="[a-zA-Z0-9]+" required><br></th>
					<th>Contraseña: <input type="password" id="Contrasena" name="Contrasena" placeholder="introduza su contraseña" pattern="[A-Za-z0-9!?-]{8,12}" required></th>
				</tr>
			</table>
			<input type="submit" name="registrar" value="Enviar">
		</form>
	</div>
</div>

<script type="text/javascript">
	$('#FormRegistro').submit(function (e) {
		e.preventDefault();
		if(
			$('#Nombre').val() != '' && 
			$('#Apellido').val() != '' &&
			$('#Email').val() != '' &&
			$('#Fecha').val() != '' &&
			$('#Tipo').val() != '' &&
			$('#Documento').val() != '' &&
			$('#Hijos').val() != '' &&
			$('#Telefono').val() != '' &&
			$('#Estadocivil').val() != '' &&
			$('#Foto').val() != '' &&
			$('#Usuario').val() != '' &&
			$('#Contrasena').val() != ''
		) {

			var files = $('#Foto')[0].files;

			var formData = new FormData();
			formData.append("Nombre", $('#Nombre').val());
			formData.append("Apellido", $('#Apellido').val());
			formData.append("Email", $('#Email').val());
			formData.append("Fecha", $('#Fecha').val());
			formData.append("Tipo", $('#Tipo').val());
			formData.append("Documento", $('#Documento').val());
			formData.append("Telefono", $('#Telefono').val());
			formData.append("Estadocivil", $('#Estadocivil').val());
			formData.append("Hijos", $('#Hijos').val());
			formData.append("Foto", files[0]);
			formData.append("Usuario", $('#Usuario').val());
			formData.append("Contrasena", $('#Contrasena').val());

			$.ajax({
				url: 'core/registrar-usuario.php',
				data: formData,
				type: 'post',
				dataType: 'json',
				contentType: false,
              	processData: false,
				success: function(resultado) {					
					PrintOk("Usuario registrado exitosamente")	
					location.href = "index.php";					
				},
				error: function() {
					PrintError("Ocurrió un error al registrar el usuario, inténtelo de nuevo.")
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