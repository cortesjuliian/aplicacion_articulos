<?php

include "plantilla/header.php";
require "core/obtener-usuario.php";
?>

<div id="banner-wrapper">
    <div id="banner" class="box container">
        <form method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <th> <input type="submit" name="update" value="Actulizar información">
                    </th>
                    <th> <input type="submit" name="passw" value="Cambiar contraseña">
                    </th>
                    <th> <input type="submit" name="foto" value="Cambiar foto">
                    </th>
                </tr>
            </table>
            <br>
            <br>
        </form>
        <?php
        //relizar el update en la bd
        if (isset($_POST) && isset($_POST['update'])) {
        ?>
            <form id="FormActualizar" method="post" enctype="multipart/form-data">
                <table class="default" style="width: 100%;">

                    <tr>
                        <th>Nombre: <input type="text" value="<?php echo $perfil['nombre']; ?>" id="Nombre" name="Nombre" placeholder="introduza su nombre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br></th>
                        <th>Apellido: <input type="text" value="<?php echo $perfil['apellido']; ?>" id="Apellido" name="Apellido" placeholder="introduza su apellido" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br></th>
                        <th>Email: <input type="email" value="<?php echo $perfil['email']; ?>" id="Email" name="Email" placeholder="introduza su email" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" required><br></th>
                    </tr>
                    <tr>
                        <th>Fecha de nacimiento: <br><input type="date" value="<?php echo $perfil['fechanacimiento']; ?>" id="Fecha" name="Fecha" required><br></th>

                        <th>Tipo de documento: <select id="Tipo" name="Tipo" value="<?php echo $perfil['tipodocumento']; ?>" required>
                                <option value="CC">Cedula de ciudadania</option>
                                <option value="TI">Tarjeta de Identidad</option>
                                <option value="NIT">NIT</option>
                            </select><br></th>

                        <th>Numero de documento: <input type="text" value="<?php echo $perfil['numerodocumento']; ?>" id="Documento" name="Documento" placeholder="introduza su número de documento" pattern="[0-9]+" required onkeypress="return numeros(event)"><br></th>
                    </tr>
                    <tr>
                        <th>Numero de telefono: <input type="tel" value="<?php echo $perfil['telefono']; ?>" id="Telefono" name="Telefono" placeholder="introduza su número de telefono" pattern="[0-9]+" minlength="10" maxlength="10"><br></th>

                        <th>Cantidad de Hijos: <select id="Hijos" name="Hijos" value="<?php echo $perfil['cantidadhijos']; ?>" required>
                                <option value="Ninguno">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="5+">Más de 5</option>
                            </select><br></th>
                        <th>
                            Estado civil: <select id="Estadocivil" name="Estadocivil" value="<?php echo $perfil['estadocivil']; ?>" required>
                                <option value="Soltero">Soltero(a)</option>
                                <option value="Casado">Casado(a)</option>
                            </select><br>
                        </th>
                    </tr>
                </table>
                <input type="submit" name="Actualizar" value="Actualizar">
            </form>
        <?php
        }
        ?>


        <?php
        //Realiza el cambio de contraseña en la bd
        if (isset($_POST) && isset($_POST['passw'])) {
        ?>
            <form id="FormClave">
                <table class="default">
                    <tr>
                        <th>Contraseña actual: <input type="password" id="ClaveActual" name="ClaveActual" placeholder="introduza su contraseña" pattern="[A-Za-z0-9!?-]{8,12}" minlength="8" maxlength="12" required></th>
                    </tr>
                    <tr>
                        <th>Contraseña Nueva: <input type="password" id="NuevaClave" name="NuevaClave" placeholder="introduza su contraseña" pattern="[A-Za-z0-9!?-]{8,12}" minlength="8" maxlength="12" required></th>
                    </tr>
                    <tr>
                        <th>Repita la contraseña: <input type="password" id="ConfirmNuevaClave" name="ConfirmNuevaClave" placeholder="introduza su contraseña" pattern="[A-Za-z0-9!?-]{8,12}" minlength="8" maxlength="12" required></th>
                    </tr>
                </table>
                <input type="submit" name="Updatepass" value="Actualizar">
            </form>
        <?php

        }
        ?>


        <?php
        //Realiza el cambio de la foto
        if (isset($_POST) && isset($_POST['foto']) || isset($_FILES['foto'])) {
        ?>
            <form id="FormFoto">
                <table class="default">
                    <tr>
                        <th>
                            <img width="50" src="data:<?php echo $perfil['tipofoto']; ?>;base64,<?php echo base64_encode($perfil['foto']); ?>">
                        <th>
                    </tr>
                    <tr>
                        <th>Foto de perfil:<br>
                            <input type="file" name="Foto" id="Foto" accept="image/png,image/jpeg" /><br>
                        <th>
                    </tr>
                </table>
                <input type="submit" name="ActualizarFoto" value="Actualizar Foto">
            </form>
        <?php

        }
        ?>


    </div>
</div>


<script type="text/javascript">
    $('#FormActualizar').submit(function(e) {
        e.preventDefault();
        if (
            $('#Nombre').val() != '' &&
            $('#Apellido').val() != '' &&
            $('#Email').val() != '' &&
            $('#Fecha').val() != '' &&
            $('#Tipo').val() != '' &&
            $('#Documento').val() != '' &&
            $('#Hijos').val() != '' &&
            $('#Telefono').val() != '' &&
            $('#Estadocivil').val() != ''
        ) {

            $.ajax({
                url: 'core/actualizar-usuario.php',
                data: $('#FormActualizar').serialize(),
                type: 'post',
                dataType: 'json',
                success: function(resultado) {
                    PrintOk("Usuario actualizado exitosamente")
                },
                error: function() {
                    PrintError("Ocurrió un error al actualizar el usuario, inténtelo de nuevo.")
                }
            });
        } else {
            PrintError("Debe completar todos los campos para continuar.")
        }
    });

    $('#FormFoto').submit(function(e) {
        e.preventDefault();
        if (
            $('#Foto').val() != ''
        ) {

            var files = $('#Foto')[0].files;

            var formData = new FormData();
            formData.append("Foto", files[0]);

            $.ajax({
                url: 'core/actualizar-foto.php',
                data: formData,
                type: 'post',
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(resultado) {
                    location.reload();
                },
                error: function() {
                    PrintError("Ocurrió un error al actualizar la foto, inténtelo de nuevo.")
                }
            });
        } else {
            PrintError("Debe completar todos los campos para continuar.")
        }
    });

    $('#FormClave').submit(function(e) {
        e.preventDefault();
        if (
            $('#ClaveActual').val() != '' &&
            $('#NuevaClave').val() != '' &&
            $('#ConfirmNuevaClave').val() != ''
        ) {

            $.ajax({
                url: 'core/actualizar-clave.php',
                data: $('#FormClave').serialize(),
                type: 'post',
                dataType: 'json',
                success: function(resultado) {
                    if (resultado) {
                        PrintOk("Contraseña actualizada exitosamente.");
                        $('#FormClave')[0].reset();
                    } else {
                        PrintError("La contraseña actual es incorrecta.")
                    }
                },
                error: function() {
                    PrintError("Ocurrió un error al actualizar la contraseña, inténtelo de nuevo.")
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