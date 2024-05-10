<?php
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
session_start();
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
//echo $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Configuracion";
permisos($modulo, $cadena_permisos);
$conexion_marketplace = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');

$query_empresa = mysqli_query($conexion_marketplace, "select * from perfil where id_perfil=1");
$row           = mysqli_fetch_array($query_empresa);

$favicon = $row['favicon'];


if (
    isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
) {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}
$currentUrl = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// URL base local (por ejemplo, localhost)
$localBaseUrl = 'localhost'; // Puedes modificar esto según tu configuración
// Comprobar si la URL actual contiene la URL base local
if (strpos($currentUrl, $localBaseUrl) !== false) {
    $sistema_url = '/imporsuitv01';
} else {
    $sistema_url = '';
}

?>
<?php require 'includes/header_start.php'; ?>

<?php require 'includes/header_end.php'; ?>
<style>
    .colores {
        width: 100px;
        height: 100px;
    }

    .panel-heading {
        padding-left: 20px;
        background-color: #171931;
        border-style: solid;
        border-color: white;
        color: white;
        border-radius: 45px;

    }

    .floating-buttons {
        position: fixed;
        right: -100px;
        /* Asegúrate de que esté fuera de la vista */
        top: 50%;
        transform: translateY(-50%);
        z-index: 1050;
        transition: right 0.3s;
        /* Transición suave para el deslizamiento */
    }

    .floating-buttons.active {
        right: 0;
        /* Muestra los botones cuando está activo */
    }

    .toggle-button {
        position: fixed;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1051;
        transition: transform 0.3s;
        /* Transición suave para la rotación de la flecha */
    }

    .toggle-button.active .fa {
        transform: rotate(180deg);
        /* Rota la flecha cuando está activo */
    }

    .modal-pc {
        max-width: 90%;
    }

    .modal-movil {
        max-width: 800;
    }

    /* CSS */
    .fixed-buttons {
        position: fixed;
        left: 10px;
        /* Ajusta la distancia desde la izquierda según necesites */
        bottom: 10px;
        /* Ajusta la distancia desde la parte inferior según necesites */
        z-index: 1000;
        /* Asegúrate de que esté sobre los otros elementos */
    }

    /* Define una animación para que el botón aparezca con un efecto de fade-in */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Agrega la animación al botón cuando tiene la clase 'visible' */
    .btn-visible {
        animation: fadeIn 1s;
    }

    .formulario {
        border-radius: 55px;
    }

    .panel-body {
        padding-top: 40px;
        padding-bottom: 40px;
        padding-left: 80px;
        padding-right: 80px;
        background-color: white;
        border-radius: 10px;
        -webkit-box-shadow: -2px 2px 5px 0px rgba(0, 0, 0, 0.23);
        -moz-box-shadow: -2px 2px 5px 0px rgba(0, 0, 0, 0.23);
        box-shadow: -2px 2px 5px 0px rgba(0, 0, 0, 0.23);
    }

    .caja {
        padding: 20px !important;
        border-radius: 25px;
        -webkit-box-shadow: -2px 2px 5px 0px rgba(0, 0, 0, 0.23);
        -moz-box-shadow: -2px 2px 5px 0px rgba(0, 0, 0, 0.23);
        box-shadow: -2px 2px 5px 0px rgba(0, 0, 0, 0.23);
    }
</style>
<!-- Begin page -->
<div id="wrapper">

    <?php require 'includes/menu.php'; ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <?php if ($permisos_ver == 1) {
                    include '../modal/registro_horizontal.php';
                    include '../modal/eliminar_horizontal.php';
                    include '../modal/registro_banner_marketplace.php';
                    include '../modal/editar_banner_marketplace.php';
                    include '../modal/editar_caracteristica.php';
                    include '../modal/editar_testimonio.php';
                    include "../modal/imagen_testimonio.php";
                    include "../modal/editar_horizontal.php";
                    include "../modal/registro_testimonio.php";
                ?>

                    <form class="form-horizontal" role="form" id="perfil" enctype="multipart/form-data">

                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <h1 style="color: white; font-size: 20px; font-weight: bold;"> BANNER </h1>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body" style="padding-left: 20px; padding-right: 20px;">
                                        <div class="row">
                                            <div class="col">
                                                <div class="card-box caja">

                                                    <!-- <div class="row ">
                                                        <div class="col-sm-6">
                                                            <div class="form-group row">
                                                                <label for="inputPassword3" class="col-sm-2 col-form-label">Filtro</label>
                                                                <div class="col-sm-10">
                                                                    <input type="range" class="input-change" id="banner_opacidad" name="banner_opacidad" min="0" max="1" step="0.1" value="<?php // echo $row["banner_opacidad"]; ?>" oninput="valorRango.value = banner_opacidad.value">
                                                                    <output id="valorRango"><?php // echo $row["banner_opacidad"]; ?></output>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">

                                                            <div class="form-group row">
                                                                <label for="inputPassword3" class="col-sm-2 col-form-label">Color</label>
                                                                <div class="col-sm-10">
                                                                    <input style="width: 100px; height: 40px;" class="input-change" type="color" name="banner_color_filtro" value="<?php // echo $row["banner_color_filtro"]; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="btn-group pull-right">
                                                        <button type="button" class="btn btn-success waves-effect waves-light formulario" data-toggle="modal" data-target="#nuevoBanner"><i class="fa fa-plus"></i> </button>
                                                    </div>
                                                    <div class='outer_div_banner'></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="col-lg-12">
                        <div class="portlet">

                            <div id="bg-primary" class="panel-collapse collapse show">

                            <?php
                        } else {
                            ?>
                                <section class="content">
                                    <div class="alert alert-danger" align="center">
                                        <h3>Acceso denegado! </h3>
                                        <p>No cuentas con los permisos necesario para acceder a este módulo.</p>
                                    </div>
                                </section>
                            <?php
                        }
                            ?>


                            </div>
                        </div>

                    </div>
            </div>


        </div>
        <!-- end container -->
    </div>
    <!-- end content -->

    <?php require 'includes/pie.php'; ?>


    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->



    <!-- END wrapper -->

    <?php require 'includes/footer_start.php'
    ?>
    <!-- ============================================================== -->
    <!-- Todo el codigo js aqui-->
    <!-- ============================================================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            load_horizontal(1);
            load_banner(1);
            load_iconos(1);
            load_testimonios(1);
        });

        function handleChange(event) {
            mostrarBotonActualizar();
        }

        function mostrarBotonActualizar() {
            const boton = document.getElementById('actualizarDatosBtn');
            boton.style.display = 'block'; // Hace visible el botón
            boton.classList.add('btn-visible'); // Aplica la animación de fade-in
        }
        var inputs = document.querySelectorAll('.input-change');

        inputs.forEach(function(input) {
            input.addEventListener('input', handleChange);
        });

        document.getElementById('toggleButton').addEventListener('click', function() {
            var buttons = document.getElementById('floatingButtons');
            buttons.classList.toggle('active');

            // Aquí también rotamos el ícono de la flecha
            var icon = this.querySelector('.fa');
            if (buttons.classList.contains('active')) {
                icon.style.transform = 'rotate(180deg)';
            } else {
                icon.style.transform = 'rotate(0deg)';
            }
        });

        $("#perfil").submit(function(event) {
            $('.guardar_datos').attr("disabled", true);

            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../ajax/editar_perfil_web.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                },
                success: function(datos) {
                    $("#resultados_ajax").html(datos);
                    $('.guardar_datos').attr("disabled", false);
                    recargarIframe();
                    const boton = document.getElementById('actualizarDatosBtn');
                    boton.style.display = 'none'; // Hace visible el botón
                    //desaparecer la alerta
                    $(".alert-success").delay(400).show(10, function() {
                        $(this).delay(2000).hide(10, function() {
                            $(this).remove();
                        });
                    }); // /.alert

                }
            });
            event.preventDefault();
        })


        $(document).on('change', 'input[type="checkbox"]', function(e) {
            if (this.id === "proveedor") {
                if (this.checked) {
                    id = 1;
                } else {
                    id = 0;
                }
                $.ajax({
                    type: "GET",
                    url: "../ajax/habilitaproveedor.php",
                    data: "id=" + id,
                    beforeSend: function(objeto) {
                        $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                    },
                    success: function(datos) {
                        //alert(datos)
                        if (datos == '0') {
                            Swal.fire({
                                title: 'Espera',
                                text: 'Para ser proveedor de la plataforma debes configurar los datos para la logística de envío',
                                icon: 'error',
                                confirmButtonText: 'ok',
                                showCancelButton: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Redirigir a otra página
                                    window.location.href = 'origen_laar.php';
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Bien Hecho',
                                text: 'Ahora eres parte de nuestros porveedores, puedes subir productos a nuestro marketplace para que otras tiendas puedan venderlo ',
                                icon: 'succes',
                                confirmButtonText: 'ok'
                            });
                        }
                        $("#resultados").html(datos);

                    }
                });

            }
            if (this.id === "flotar") {
                if (this.checked) {
                    id = 1;
                } else {
                    id = 0;
                }
                $.ajax({
                    type: "GET",
                    url: "../ajax/habilitaflotante.php",
                    data: "id=" + id,
                    beforeSend: function(objeto) {
                        $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                    },
                    success: function(datos) {
                        $("#resultados").html(datos);
                    }
                });

            }

            if (this.id === "flotar_ws") {
                if (this.checked) {
                    id = 1;
                } else {
                    id = 0;
                }
                $.ajax({
                    type: "GET",
                    url: "../ajax/habilitar_ws_flotante.php",
                    data: "id=" + id,
                    beforeSend: function(objeto) {
                        $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                    },
                    success: function(datos) {
                        $("#resultados").html(datos);
                    }
                });

            }

            if (this.id === "flotar_comprar_ahora") {
                if (this.checked) {
                    id = 1;
                } else {
                    id = 0;
                }
                $.ajax({
                    type: "GET",
                    url: "../ajax/habilitar_btnComprar_flotante.php",
                    data: "id=" + id,
                    beforeSend: function(objeto) {
                        $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                    },
                    success: function(datos) {
                        $("#resultados").html(datos);
                    }
                });

            }

        });
    </script>

    <script>
        function upload_image() {

            var inputFileImage = document.getElementById("imagefile");
            var file = inputFileImage.files[0];
            if ((typeof file === "object") && (file !== null)) {
                $("#load_img").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                var data = new FormData();
                data.append('imagefile', file);


                $.ajax({
                    url: "../ajax/imagen_ajax.php", // Url to which the request is send
                    type: "POST", // Type of request to be send, called as method
                    data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file it is set to false
                    success: function(data) // A function to be called if request succeeds
                    {
                        $("#load_img").html(data);

                    }
                });
            }


        }

        function upload_image_banner() {

            var inputFileImage = document.getElementById("imagefile2");
            var file = inputFileImage.files[0];
            if ((typeof file === "object") && (file !== null)) {
                $("#load_img2").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                var data = new FormData();
                data.append('imagefile2', file);


                $.ajax({
                    url: "../ajax/imagen_ajax_banner.php", // Url to which the request is send
                    type: "POST", // Type of request to be send, called as method
                    data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file it is set to false
                    success: function(data) // A function to be called if request succeeds
                    {
                        $("#load_img2").html(data);

                    }
                });
            }


        }

        function upload_image_favicon() {

            var inputFileImage = document.getElementById("imagefile3");
            var file = inputFileImage.files[0];
            console.log(file);
            if ((typeof file === "object") && (file !== null)) {
                $("#load_img3").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                var data = new FormData();
                data.append('imagefile3', file);

            }
            $.ajax({
                url: "../ajax/imagen_ajax_favicon.php", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                success: function(data) // A function to be called if request succeeds
                {
                    $("#load_img3").html(data);

                }
            });

        }
    </script>
    <script>
        $(document).ready(function() {
            $(".UpperCase").on("keypress", function() {
                $input = $(this);
                setTimeout(function() {
                    $input.val($input.val().toUpperCase());
                }, 50);
            })
        })

        function load_testimonios(page) {
            var q = $("#q").val();
            $("#loader").fadeIn('slow');
            $.ajax({
                url: '../ajax/buscar_testimonio.php?action=ajax&page=' + page + '&q=' + q,
                beforeSend: function(objeto) {
                    $('#loader').html('<img src="../../img/ajax-loader.gif"> Cargando...');
                },
                success: function(data) {
                    $(".outer_div_testimoinio").html(data).fadeIn('slow');
                    $('#loader').html('');
                    $('[data-toggle="tooltip"]').tooltip({
                        html: true
                    });
                }
            })
        }

        function load_horizontal(page) {
            var q = $("#q").val();
            $("#loader").fadeIn('slow');
            $.ajax({
                url: '../ajax/buscar_horizontal.php?action=ajax&page=' + page + '&q=' + q,
                beforeSend: function(objeto) {
                    $('#loader').html('<img src="../../img/ajax-loader.gif"> Cargando...');
                },
                success: function(data) {
                    $(".outer_div_flotante").html(data).fadeIn('slow');
                    $('#loader').html('');
                    $('[data-toggle="tooltip"]').tooltip({
                        html: true
                    });
                }
            })
        }

        function load_banner(page) {
            var q = $("#q").val();
            $("#loader").fadeIn('slow');
            $.ajax({
                url: '../ajax/buscar_banner_marketplace.php?action=ajax&page=' + page + '&q=' + q,
                beforeSend: function(objeto) {
                    $('#loader').html('<img src="../../img/ajax-loader.gif"> Cargando...');
                },
                success: function(data) {
                    $(".outer_div_banner").html(data).fadeIn('slow');
                    $('#loader').html('');
                    $('[data-toggle="tooltip"]').tooltip({
                        html: true
                    });
                }
            })
        }

        function load_iconos(page) {
            var q = $("#q").val();
            $("#loader").fadeIn('slow');
            $.ajax({
                url: '../ajax/buscar_caracteristica.php?action=ajax&page=' + page + '&q=' + q,
                beforeSend: function(objeto) {
                    $('#loader').html('<img src="../../img/ajax-loader.gif"> Cargando...');
                },
                success: function(data) {
                    $(".outer_div_iconos").html(data).fadeIn('slow');
                    $('#loader').html('');
                    $('[data-toggle="tooltip"]').tooltip({
                        html: true
                    });
                }
            })
        }

        $("#guardar_horizontal").submit(function(event) {
            $('#guardar_datos_horizontal').attr("disabled", true);
            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../ajax/nuevo_texto.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                },
                success: function(datos) {

                    $("#resultados_ajax_horizontal").html(datos);
                    $('#guardar_datos_horizontal').attr("disabled", false);
                    load_horizontal(1);
                    recargarIframe();
                    //resetea el formulario
                    $("#guardar_linea")[0].reset();
                    $("#nombre").focus();
                    //desaparecer la alerta
                    window.setTimeout(function() {
                        $(".alert").fadeTo(200, 0).slideUp(200, function() {
                            $(this).remove();
                        });
                    }, 2000);
                }
            });
            event.preventDefault();
        })

        function eliminar(id, tabla, campo_id) {
            //alert()
            $('#id_eliminar').val(id);
            $('#tabla_eliminar').val(tabla);
            $('#campo_id').val(campo_id);
            // alert(campo_id);
        }
        $("#eliminarDatos").submit(function(event) {
            // alert($('#id_eliminar').val());
            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../ajax/eliminar_registro.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $(".datos_ajax_delete").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                },
                success: function(datos) {
                    $(".datos_ajax_delete").html(datos);
                    $('#dataDelete').hide(); // Oculta el modal
                    $('.modal-backdrop').remove(); // Elimina el fondo modal
                    $('body').removeClass('modal-open'); // Elimina la clase que mantiene el scroll fijo
                    load_horizontal(1);
                    load_banner(1);
                    load_testimonios(1);
                    recargarIframe();
                    //desaparecer la alerta
                    window.setTimeout(function() {
                        $(".alert").fadeTo(200, 0).slideUp(200, function() {
                            $(this).remove();
                        });
                    }, 2000);
                }
            });
            event.preventDefault();
        });

        $("#guardar_banner").submit(function(event) {
            $("#guardar_datos2").attr("disabled", true);
            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../ajax/nuevo_banner_marketplace.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#resultados_ajax").html(
                        '<img src="../../img/ajax-loader.gif"> Cargando...'
                    );
                },
                success: function(datos) {
                    $("#resultados_ajax").html(datos);
                    $("#guardar_datos2").attr("disabled", false);
                    load_banner(1);
                    recargarIframe();
                    //resetea el formulario
                    $("#guardar_linea2")[0].reset();
                    //$("#nombre").focus();
                    //desaparecer la alerta
                    window.setTimeout(function() {
                        $(".alert")
                            .fadeTo(200, 0)
                            .slideUp(200, function() {
                                $(this).remove();
                            });
                    }, 2000);
                },
            });
            event.preventDefault();
        });

        function obtener_datos_banner(id) {
            var titulo = $("#titulo" + id).val();
            var texto_banner = $("#texto_banner" + id).val();

            var texto_boton = $("#texto_boton" + id).val();
            var enlace_boton = $("#enlace_boton" + id).val();
            var alineacion = $("#alineacion" + id).val();
            //var posicion = $("#posicion" + id).val();

            // alert(id)

            $("#titulo_slider2").val(titulo);
            // alert(texto_banner)
            $("#texto_slider_edit").val(texto_banner);
            $("#texto_btn_slider2").val(texto_boton);
            $("#enlace_btn_slider2").val(enlace_boton);
            $("#alineacion").val(alineacion);
            //$("#mod_posicion").val(posicion);
            $("#mod_id").val(id);

            // Preparar datos para enviar
            var datosParaEnviar = {
                id: id,
                titulo: titulo,
                texto_banner: texto_banner,
                texto_boton: texto_boton,
                enlace_boton: enlace_boton,
                alineacion: alineacion
            };
            // Llamada AJAX
            $.ajax({
                type: "POST",
                url: "../ajax/editar_banner_marketplace_modal.php", // Asegúrate de reemplazar 'tu_archivo_destino.php' por la ruta correcta a tu archivo PHP
                data: datosParaEnviar,
                success: function(response) {
                    $("#editar_linea").html(response);

                },
                error: function(xhr, status, error) {
                    // Aquí puedes manejar errores durante el envío.
                    console.error("Error al enviar los datos: ", error);
                },
            });
        }

        function upload_image_banner2() {

            var inputFileImage = document.getElementById("imagefile4");
            var file = inputFileImage.files[0];
            if ((typeof file === "object") && (file !== null)) {
                $("#load_img4").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                var data = new FormData();
                data.append('imagefile4', file);
                // Asegúrate de obtener el valor de mod_id y añadirlo a FormData
                var modId = document.getElementById('mod_id').value; // Obtiene el valor
                data.append('mod_id', modId); // Añade mod_id a FormData

                $.ajax({
                    url: "../ajax/imagen_ajax_banner2.php", // Url to which the request is send
                    type: "POST", // Type of request to be send, called as method
                    data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file it is set to false
                    success: function(data) // A function to be called if request succeeds
                    {
                        $("#load_img4").html(data);
                        load_banner(1);
                        recargarIframe();
                    }
                });
            }
        }

        function upload_image_banner_marketplace() {

            var inputFileImage = document.getElementById("imagefile_marketplace");
            var file = inputFileImage.files[0];
            if ((typeof file === "object") && (file !== null)) {
                $("#load_img_marketplace").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                var data = new FormData();
                data.append('imagefile_marketplace', file);
                // Asegúrate de obtener el valor de mod_id y añadirlo a FormData
                var modId = document.getElementById('mod_id').value; // Obtiene el valor
                data.append('mod_id', modId); // Añade mod_id a FormData

                $.ajax({
                    url: "../ajax/imagen_ajax_banner_marketplace.php", // Url to which the request is send
                    type: "POST", // Type of request to be send, called as method
                    data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file it is set to false
                    success: function(data) // A function to be called if request succeeds
                    {
                        $("#load_img_marketplace").html(data);
                        load_banner(1);
                        recargarIframe();
                    }
                });
            }
        }

        $("#editar_linea").submit(function(event) {
            $("#actualizar_datos").attr("disabled", true);
            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../ajax/editar_banner_marketplace.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#resultados_ajax2").html(
                        '<img src="../../img/ajax-loader.gif"> Cargando...'
                    );
                },
                success: function(datos) {
                    $("#resultados_ajax2").html(datos);
                    $("#actualizar_datos").attr("disabled", false);
                    load_banner(1);
                    recargarIframe();
                    //desaparecer la alerta
                    window.setTimeout(function() {
                        $(".alert")
                            .fadeTo(200, 0)
                            .slideUp(200, function() {
                                $(this).remove();
                            });
                    }, 2000);
                },
            });
            event.preventDefault();
        });

        function obtener_datos_icono(id) {
            var texto = $("#texto" + id).val();
            var icono = $("#icono" + id).val();
            var enlace_icon = $("#enlace_icon" + id).val();
            var subtexto_icon = $("#subtexto_icon" + id).val();
            //var posicion = $("#posicion" + id).val();

            // alert(id)
            $("#texto_icon").val(texto);
            $("#icon_select").val(icono);
            $("#enlace_icon").val(enlace_icon);
            $("#subtexto_icon").val(subtexto_icon);
            //$("#mod_posicion").val(posicion);
            $("#mod_id").val(id);


        }

        $("#editar_iconos").submit(function(event) {
            $('#actualizar_datos').attr("disabled", true);
            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../ajax/editar_caracteristica.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#resultados_ajax2").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                },
                success: function(datos) {
                    $("#resultados_ajax2").html(datos);
                    $('#actualizar_datos').attr("disabled", false);
                    load_iconos(1);
                    //desaparecer la alerta
                    window.setTimeout(function() {
                        $(".alert").fadeTo(200, 0).slideUp(200, function() {
                            $(this).remove();
                        });
                    }, 2000);
                }
            });
            event.preventDefault();
        })

        function obtener_datos_testimonio(id) {
            var nombre = $("#nombre" + id).val();
            var descripcion = $("#descripcion" + id).val();
            var estado = $("#estado" + id).val();
            var producto = $("#producto" + id).val();

            //  alert(nombre)

            $("#mod_nombre").val(nombre);
            $("#mod_descripcion").val(descripcion);
            $("#mod_estado").val(estado);
            $("#mod_id_producto").val(producto);
            $("#mod_id_testimonio").val(id);


        }

        $("#editar_testimonio").submit(function(event) {
            //alert($("#mod_id_testimonio").val())
            $('#actualizar_datos').attr("disabled", true);
            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../ajax/editar_testimonio.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#resultados_ajax2").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                },
                success: function(datos) {
                    $("#resultados_ajax2").html(datos);
                    $('#actualizar_datos').attr("disabled", false);
                    load_testimonios(1);
                    //desaparecer la alerta
                    window.setTimeout(function() {
                        $(".alert").fadeTo(200, 0).slideUp(200, function() {
                            $(this).remove();
                        });
                    }, 2000);
                }
            });
            event.preventDefault();
        })

        function carga_img_t(id_producto) {
            //alert(id_producto)
            $(".outer_img").load("../ajax/img_testimonio.php?id_producto=" + id_producto);
            recargarIframe();
        }

        function upload_image_mod(id_producto) {
            $("#load_img_mod").text('Cargando...');
            var inputFileImage = document.getElementById("imagefile_mod");
            var file = inputFileImage.files[0];
            var data = new FormData();
            data.append('imagefile_mod', file);
            data.append('id_producto', id_producto);



            $.ajax({
                url: "../ajax/imagen_testimonio.php", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                success: function(data) // A function to be called if request succeeds
                {
                    $("#load_img_mod").html(data);
                    recargarIframe();
                }
            });

        }


        function obtener_datos_horizontal(id) {
            var texto = $("#texto" + id).val();
            var posicion = $("#posicion" + id).val();

            // alert(id)
            $("#mod_nombre_horizontal").val(texto);
            $("#mod_posicion").val(posicion);
            $("#mod_id_horizontal").val(id);


        }

        $("#editar_horizontal").submit(function(event) {
            $('#actualizar_datos').attr("disabled", true);
            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../ajax/editar_horizontal.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#resultados_ajax2").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                },
                success: function(datos) {
                    $("#resultados_ajax2").html(datos);
                    $('#actualizar_datos').attr("disabled", false);
                    load_horizontal(1);
                    //desaparecer la alerta
                    window.setTimeout(function() {
                        $(".alert").fadeTo(200, 0).slideUp(200, function() {
                            $(this).remove();
                        });
                    }, 2000);
                }
            });
            event.preventDefault();
        })

        function recargarIframe() {
            var iframe = document.getElementById('miIframePc');
            iframe.src = iframe.src;
            var iframe = document.getElementById('miIframeCelular');
            iframe.src = iframe.src;
        }


        $(document).on('click', '.estado-btn-testimonio', function() {

            var userId = $(this).data('id');
            //alert($(this).text().trim());
            var newEstado = $(this).text().trim() === 'SI' ? 1 : 0; // Cambia el estado
            //alert(newEstado);
            $.ajax({
                url: '../ajax/habilita_testimonio.php?id_notificacion', // Ruta al script PHP que cambiará el estado en la base de datos
                type: 'POST',
                data: {
                    id: userId,
                    estado: newEstado
                },
                success: function(response) {
                    // Actualizar el botón según la nueva respuesta de estado
                    if (response.trim() == '1') {
                        $('button[data-id="' + userId + '"]').text('SI').removeClass('btn-danger').addClass('btn-success');
                    } else {
                        $('button[data-id="' + userId + '"]').text('NO').removeClass('btn-success').addClass('btn-danger');
                    }
                }
            });
        });

        $("#guardar_testimonio").submit(function(event) {
            // alert();
            $('#guardar_datos').attr("disabled", true);
            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../ajax/nuevo_testimonio.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                },
                success: function(datos) {
                    $("#resultados_ajax").html(datos);
                    $('#guardar_datos').attr("disabled", false);
                    load_testimonios(1);
                    recargarIframe();
                    //resetea el formulario
                    $("#guardar_linea")[0].reset();
                    $("#nombre").focus();
                    //desaparecer la alerta
                    window.setTimeout(function() {
                        $(".alert").fadeTo(200, 0).slideUp(200, function() {
                            $(this).remove();
                        });
                    }, 2000);
                }
            });
            event.preventDefault();
        })
    </script>

    <?php require 'includes/footer_end.php'
    ?>