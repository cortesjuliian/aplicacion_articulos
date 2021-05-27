<?php
include "plantilla/header.php";
ValidarSesion();

function Limpieza($cadena){
	$patron = array('/<script>.*<\/script>/');
	$cadena = preg_replace($patron, '', $cadena);
	$cadena = htmlspecialchars($cadena);
	return $cadena;
}

foreach ($_POST as $key => $value) {
	$_POST[$key] = Limpieza($value);
}

?>

<!-- mensajes -->
<div id="banner-wrapper">
    <div id="banner" class="box container">
        <h2>Mensajes</h2>
        <h6>Click en los botones del menu:</h6>

        <div class="tab">
            <button class="tablinks" onclick="openart(event, 'entrada')">Bandeja de entrada</button>
            <button class="tablinks" onclick="openart(event, 'enviados')">Enviados</button>
            <button class="tablinks" onclick="openart(event, 'crear')">Crear Mensaje</button>
        </div>


        <div id="entrada" class="tabcontent">
            <button class="ListarEntradas();">Refrescar</button>
            <div id="ListaEntradas"></div>
        </div>


        <div id="enviados" class="tabcontent">
            <button class="ListarEnviados();">Refrescar</button>
            <div id="ListaEnviados"></div>
        </div>


        <div id="crear" class="tabcontent">

            <form id="FormMensaje" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <th>Para:<select id="IdDestinatario" name="IdDestinatario">
                                <option value="showAll" selected="selected">Seleccione usuario</option>


                            </select><br>
                        Asunto: <input type="text" name="Asunto" id="Asunto" placeholder="Introduza el asunto" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br>
                        Archivo adjunto:<br> <input type="file" name="Adjunto" id="Adjunto" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" /><br>
                        Mensaje: <textarea name="Mensaje" id="Mensaje" placeholder="Introduza su mensaje" rows="10" cols="40" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required></textarea><br>


                            <input type="submit" name="GuardarMensaje" value="Enviar">
                        </th>
                    </tr>
            </form>

            </table>
        </div>

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



    
    function ListarEntradas() {
        $('#ListaEntradas').html("");
        $.ajax({
            url: 'core/listar-mensajes.php',
            data: {
                recibidos: true
            },
            type: 'post',
            dataType: 'json',
            success: function(lista) {
                if (lista != null) {
                    for (var i = 0; i < lista.length; i++) {
                        $('#ListaEntradas').append('<h1>' + lista[i][3] + ' - ' + lista[i][6] + '   ' + lista[i][7] + '</h1><p class="text-articulo">' + lista[i][4] + '</p>');
                        if (lista[i][5] != null && lista[i][5] != "") {
                            $('#ListaEntradas').append('<a target="_blank" href="' + lista[i][5].replace("../", "") + '">Descargar adjunto</a>');
                        }
                        $('#ListaEntradas').append('<hr>');
                    }
                } else {
                    $('#ListaEntradas').html("No hay mensajes");
                }
            },
            error: function() {
                $('#ListaEntradas').html("Ocurrió un error al listar");
            }
        });
    }

    function ListarEnviados() {
        $('#ListaEnviados').html("");
        $.ajax({
            url: 'core/listar-mensajes.php',
            data: {},
            type: 'post',
            dataType: 'json',
            success: function(lista) {
                if (lista != null) {
                    for (var i = 0; i < lista.length; i++) {
                        $('#ListaEnviados').append('<h1>' + lista[i][3] + ' - ' + lista[i][8] + '   ' + lista[i][9] + '</h1><p class="text-articulo">' + lista[i][4] + '</p>');
                        if (lista[i][5] != null && lista[i][5] != "") {
                            $('#ListaEnviados').append('<a target="_blank" href="' + lista[i][5].replace("../", "") + '">Descargar adjunto</a>');
                        }
                        $('#ListaEnviados').append('<hr>');
                    }
                } else {
                    $('#ListaEnviados').html("No hay mensajes");
                }
            },
            error: function() {
                $('#ListaEnviados').html("Ocurrió un error al listar");
            }
        });
    }

    $('#FormMensaje').submit(function(e) {
        e.preventDefault();
        if (
            $('#Asunto').val() != '' &&
            $('#IdDestinatario').val() != '' &&
            $('#Mensaje').val() != ''
        ) {

            var formData = new FormData();
            formData.append("Asunto", $('#Asunto').val());
            formData.append("IdDestinatario", $('#IdDestinatario').val());
            formData.append("Mensaje", $('#Mensaje').val());
            if ($('#Asunto').val() != '') {
                var files = $('#Adjunto')[0].files;
                formData.append("Adjunto", files[0]);
            }

            $.ajax({
                url: 'core/crear-mensaje.php',
                data: formData,
                type: 'post',
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(resultado) {
                    PrintOk("Mensaje enviado")
                    ListarEntradas();
                    ListarEnviados();
                    $('#FormMensaje')[0].reset();
                },
                error: function() {
                    PrintError("Ocurrió un error al enviar el mensaje, inténtelo de nuevo.")
                }
            });
        } else {
            PrintError("Debe completar todos los campos para continuar.")
        }
    });

    $(function() {
        ListarEntradas();
        ListarEnviados();

        $.ajax({
            url: 'core/listar-usuarios.php',
            data: {},
            type: 'post',
            dataType: 'json',
            success: function(lista) {
                if (lista != null) {
                    for (var i = 0; i < lista.length; i++) {
                        $('#IdDestinatario').append('<option value="' +lista[i]["id"] + '">' +lista[i]["nombre"] + " " + lista[i]["apellido"] + '</option>')

                    }
                }
            },
            error: function() {
                PrintError("Ocurrió un error al listar destinatarios, inténtelo de nuevo.")
            }
        });
    });
</script>