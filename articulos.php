<?php
include "plantilla/header.php";
ValidarSesion();
?>
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
            <button class="ListaTodos();">Refrescar</button>
            <div id="ListaTodos"></div>
        </div>


        <!-- Aca va el codigo para mostrar los articulos propios-->

        <div id="propios" class="tabcontent">
            <button class="ListaPropios();">Refrescar</button>
            <div id="ListaPropios"></div>
        </div>


        <!-- Aca va el codigo para mostrar la creacion de aritculos-->
        <div id="crear" class="tabcontent">


            <form id="FormArticulo" method="post">
                <table>
                    <tr>
                        <th>Titulo: <input type="text" id="Titulo" name="Titulo" placeholder="Introduza titulo del artículo" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required><br></th>
                    </tr>
                    <tr>
                        <th>Articulo: <textarea id="Articulo" name="Articulo" placeholder="Introduza su artículo" rows="10" cols="40" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+" required></textarea><br></th>
                    </tr>
                    <tr>
                        <th>¿Artículo publico?: <select name="Publico" id="Publico">
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                        </th>
                    </tr>
                </table>
                <br>
                <input type="submit" name="GuardarArticulo" value="Subir">
            </form>
        </div>

    </div>
</div>


<script type="text/javascript">
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

    function ListarTodos() {
        $('#ListaTodos').html("");
        $.ajax({
            url: 'core/listar-articulos.php',
            data: {},
            type: 'post',
            dataType: 'json',
            success: function(lista) {
                if (lista != null) {
                    for (var i = 0; i < lista.length; i++) {
                        $('#ListaTodos').append('<h1>' + lista[i]["titulo"] + ' <small> - ' + lista[i]["nombre"] + ' ' + lista[i]["apellido"] + '</small></h1>' + lista[i]["fecha"] + ' <br><p class="text-articulo">' + lista[i]["articulo"] + '</p><hr>');
                    }
                } else {
                    $('#propios').html("No se ha publicado artículos");
                }
            },
            error: function() {
                $('#ListaTodos').html("Ocurrió un error al listar");
            }
        });
    }

    function ListarPropios() {
        $('#ListaPropios').html("");
        $.ajax({
            url: 'core/listar-articulos.php',
            data: {
                propios: true
            },
            type: 'post',
            dataType: 'json',
            success: function(lista) {
                if (lista != null) {
                    for (var i = 0; i < lista.length; i++) {

                        var $botonPublicar = $('<button>', {
                            'data-id': lista[i]["id_articulo"],
                            click: function() {
                                PublicarArticulo($(this).data('id'));
                            },
                            class: 'btn-publicar',
                            html: 'Publicar'
                        });

                        var $botonOcultar = $('<button>', {
                            'data-id': lista[i]["id_articulo"],
                            click: function() {
                                OcultarArticulo($(this).data('id'));
                            },
                            class: 'btn-ocultar',
                            html: 'Ocultar'
                        });
                        var $botonEliminar = $('<button>', {
                            'data-id': lista[i]["id_articulo"],
                            click: function() {
                                EliminarArticulo($(this).data('id'));
                            },
                            class: 'btn-ocultar',
                            html: 'Eliminar'
                        });

                        $('#ListaPropios').append('<h1>' + lista[i]["titulo"] + ' <small> - ' + lista[i]["nombre"] + ' ' + lista[i]["apellido"] + '</small></h1>' + lista[i]["fecha"] + ' <br>');
                        if (lista[i]["publico"] == "0") {
                            $('#ListaPropios').append("Oculto - ");
                            $('#ListaPropios').append($botonPublicar);
                        } else {
                            $('#ListaPropios').append("Público - ");
                            $('#ListaPropios').append($botonOcultar);
                        }
                        $('#ListaPropios').append(' - ', $botonEliminar);
                        $('#ListaPropios').append('<p class="text-articulo">' + lista[i]["articulo"] + '</p><hr>');
                    }
                } else {
                    $('#propios').html("No ha publicado artículos");
                }
            },
            error: function() {
                $('#propios').html("Ocurrió un error al listar");
            }
        });
    }

    function PublicarArticulo(id) {
        $.ajax({
            url: 'core/actualizar-articulo.php',
            data: {
                IdArticulo: id,
                Estado: 1
            },
            type: 'post',
            dataType: 'json',
            success: function() {
                ListarPropios();
                ListarTodos();
            },
            error: function() {
                PrintError("Ocurrió un error al cambiar el estado.");
            }
        });
    }

    function OcultarArticulo(id) {
        $.ajax({
            url: 'core/actualizar-articulo.php',
            data: {
                IdArticulo: id,
                Estado: 0
            },
            type: 'post',
            dataType: 'json',
            success: function() {
                ListarPropios();
                ListarTodos();
            },
            error: function() {
                PrintError("Ocurrió un error al cambiar el estado.");
            }
        });
    }

    function EliminarArticulo(id) {
        $.ajax({
            url: 'core/eliminar-articulo.php',
            data: {
                IdArticulo: id
            },
            type: 'post',
            dataType: 'json',
            success: function() {
                ListarPropios();
                ListarTodos();
                PrintOk("Artículo eliminado correctamente");
            },
            error: function() {
                PrintError("Ocurrió un error al eliminar el artículo.");
            }
        });
    }

    $('#FormArticulo').submit(function(e) {
        e.preventDefault();
        if (
            $('#Titulo').val() != '' &&
            $('#Articulo').val() != '' &&
            $('#Publico').val() != '' 
        ) {

            $.ajax({
                url: 'core/crear-articulo.php',
                data: $('#FormArticulo').serialize(),
                type: 'post',
                dataType: 'json',
                success: function(resultado) {
                    PrintOk("Artículo creado exitosamente");
                    $('#FormArticulo')[0].reset();
                    ListarPropios();
                    ListarTodos();
                },
                error: function() {
                    PrintError("Ocurrió un error al crear el artículo, inténtelo de nuevo.")
                }
            });
        } else {
            PrintError("Debe completar todos los campos para continuar.")
        }
    });

    $(function() {
        ListarPropios();
        ListarTodos();
    });
</script>