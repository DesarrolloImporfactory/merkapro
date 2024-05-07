<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Categorias";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$title     = "Categorias";
$pacientes = 1;
?>


<?php require 'includes/header_start.php'; ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<style>
    .left-column {
        width: 50%;
        padding: 20px;
        padding-top: 60px;
        position: -webkit-sticky;
        /* Para compatibilidad con Safari */
        position: sticky;
        top: 0;
        /* Ajusta esto a la altura de cualquier cabecera o menú que tengas */
        height: 100%;
        /* O la altura que quieras que tenga */
    }

    .right-column {
        width: 50%;
        padding: 20px;
        padding-top: 60px;
    }

    /* Seccion Hidden */
    .list-group-item {
        display: flex;
        flex-direction: column;
        /* Asegura que el contenido fluya de arriba hacia abajo */
    }

    .edit-section {
        width: 100%;
        /* Ocupa todo el ancho disponible */
        /* Otros estilos que desees aplicar */
    }

    .hidden {
        display: none;
        /* Oculta la sección */
    }

    /* Este estilo se aplica cuando se muestra la sección */
    .edit-section:not(.hidden) {
        display: block;
        /* O 'flex' si necesitas más control sobre el contenido interior */
    }

    .caja_transparente {
        border-radius: 0.5rem;
        border: 1px solid #ccc;
        padding: 10px;
    }

    .caja_variable {
        padding-top: 10px;
        padding-right: 10px !important;
        padding-left: 10px !important;
        border-radius: 0.5rem;
        background-color: #dedbdb;
    }

    .discount-code-container {
        max-width: 300px;
        /* O el ancho que prefieras */
        padding-top: 10px;
    }

    .applied-discount {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
        padding: 5px 10px;
        background: #f2f2f2;
        /* Fondo gris claro para destacar */
        border-radius: 5px;
    }

    .discount-tag {
        font-weight: bold;
    }

    .close {
        font-size: 20px;
        color: #000;
        opacity: 0.6;
    }

    .close:hover {
        opacity: 1;
    }

    .sub_titulos {
        font-size: 17px;
        font-weight: 700;
    }

    hr {
        border: none;
        /* Quita el borde predeterminado */
        height: 2px;
        /* Ajusta el grosor de la línea */
        background-color: #000;
        /* Ajusta el color de la línea */
        margin: 20px 0;
        /* Ajusta el espaciado vertical de la línea */
    }

    .input-group-text {
        background: transparent;
        padding-right: 0;
        /* Remover el espacio a la derecha del ícono si es necesario */
    }

    .form-group .input-group .form-control {
        border: 1px solid #ced4da;
        /* Ajusta al color de borde deseado */
        border-left: none;
        /* Remueve el borde izquierdo donde se unen el ícono y el input */
    }

    /* Ajusta el tamaño y el color del icono según sea necesario */
    .bx {
        font-size: 1.5rem;
        /* Tamaño del icono */
        color: #757575;
        /* Color del icono */
    }

    .icon-btn.active i {
        color: white;
        /* O puedes usar #FFFFFF */
    }
</style>
<?php require 'includes/header_end.php'; ?>

<!-- Begin page -->
<div id="wrapper">

    <?php require 'includes/menu.php'; ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container d-flex flex-row">
                <div class="left-column">
                    <div class="container mt-5">
                        <!-- Instrucciones -->
                        <div class="alert alert-secondary">
                            <ul>
                                <li>Los bloques rojos están desactivados en tu formulario. Usa el botón del ojo para habilitarlos.</li>
                                <li>Los bloques blancos están activos en tu formulario.</li>
                                <li>Clica en el botón lápiz para editar un bloque.</li>
                                <li>Clica en los botones de flechas para cambiar la posición de un bloque.</li>
                            </ul>
                        </div>

                        <!-- Lista de componentes del formulario -->
                        <div class="list-group">
                            <!-- Elemento del formulario -->
                            <!-- TÍTULO DEL FORMULARIO -->
                            <div class="list-group-item" id="tituloFormulario">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        TÍTULO DEL FORMULARIO
                                    </div>
                                    <div>
                                        <span>
                                            <button class="btn btn-secondary btn-sm edit-btn"><i class="fas fa-pencil-alt"></i></button>
                                            <button class="btn btn-secondary btn-sm move-up"><i class="fas fa-arrow-up"></i></button>
                                            <button class="btn btn-secondary btn-sm move-down"><i class="fas fa-arrow-down"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Sección oculta que se mostrará al hacer clic en editar -->
                                <div class="edit-section hidden">
                                    <form>
                                        <div class="form-group">
                                            <label for="texto_titulo">Texto</label>
                                            <input type="text" class="form-control" id="texto_titulo" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 col-form-label">Alineacion</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="alineacion_titulo" id="alineacion_titulo">
                                                    <option value="1">Izquierda </option>
                                                    <option value="2">Centro </option>
                                                    <option value="3">Derecha </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="colorTxt_titulo">Color texto titulo</label>
                                            <input class="colores input-change" type="color" id="colorTxt_titulo" name="colorTxt_titulo" value="">
                                        </div>
                                        <!-- Añade más campos según sea necesario -->
                                    </form>
                                </div>
                            </div>
                            <!-- Fin TÍTULO DEL FORMULARIO -->

                            <!-- Resumen Total... -->
                            <div class="list-group-item" id="resumenTotal">
                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn btn-secondary btn-sm toggle-visibility"><i class="fas fa-eye"></i></button>
                                    RESUMEN TOTAL
                                    <span>
                                        <button class="btn btn-secondary btn-sm edit-btn"><i class="fas fa-pencil-alt"></i></button>
                                        <button class="btn btn-secondary btn-sm move-up"><i class="fas fa-arrow-up"></i></button>
                                        <button class="btn btn-secondary btn-sm move-down"><i class="fas fa-arrow-down"></i></button>
                                    </span>
                                </div>
                                <!-- Sección oculta que se mostrará al hacer clic en editar -->
                                <div class="edit-section hidden">
                                    <form>
                                        <div class="form-group">
                                            <label for="subtotal">Texto subtotal</label>
                                            <input type="text" class="form-control" id="subtotal" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="envio">Texto envío</label>
                                            <input type="text" class="form-control" id="envio" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="total">Texto total</label>
                                            <input type="text" class="form-control" id="total" placeholder="">
                                        </div>
                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" id="impuestos">
                                            <label class="form-check-label" for="impuestos">Mostrar mensaje adicional sobre impuestos</label>
                                        </div>
                                        <!-- Añade más campos según sea necesario -->
                                    </form>
                                    <small class="form-text text-muted">
                                        Importante: cambiar el color de fondo de este bloque podría afectar negativamente a su tasa de conversión.
                                    </small>
                                </div>
                            </div>
                            <!-- Fin Resumen Total... -->
                            <!-- TARIFAS DE ENVIO. -->
                            <div class="list-group-item" id="tarifasEnvio">
                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn btn-secondary btn-sm toggle-visibility"><i class="fas fa-eye"></i></button>
                                    TARIFAS DE ENVIO
                                    <span>
                                        <button class="btn btn-secondary btn-sm edit-btn"><i class="fas fa-pencil-alt"></i></button>
                                        <button class="btn btn-secondary btn-sm move-up"><i class="fas fa-arrow-up"></i></button>
                                        <button class="btn btn-secondary btn-sm move-down"><i class="fas fa-arrow-down"></i></button>
                                    </span>
                                </div>
                                <!-- Sección oculta que se mostrará al hacer clic en editar -->
                                <div class="edit-section hidden">
                                    <form>
                                        <div class="form-group">
                                            <label for="titulo_tarifa">Título</label>
                                            <input type="text" class="form-control" id="titulo_tarifa" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="envio">Gratis</label>
                                            <input type="text" class="form-control" id="gratis" placeholder="">
                                        </div>
                                        <!-- Añade más campos según sea necesario -->
                                    </form>
                                </div>
                            </div>
                            <!-- Fin TARIFAS DE ENVIO -->
                            <!-- CODIGOS DE DESCUENTO -->
                            <div class="list-group-item" id="codigosDescuento">
                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn btn-secondary btn-sm toggle-visibility"><i class="fas fa-eye"></i></button>
                                    CODIGOS DE DESCUENTO
                                    <span>
                                        <button class="btn btn-secondary btn-sm edit-btn"><i class="fas fa-pencil-alt"></i></button>
                                        <button class="btn btn-secondary btn-sm move-up"><i class="fas fa-arrow-up"></i></button>
                                        <button class="btn btn-secondary btn-sm move-down"><i class="fas fa-arrow-down"></i></button>
                                    </span>
                                </div>
                                <!-- Sección oculta que se mostrará al hacer clic en editar -->
                                <div class="edit-section hidden">
                                    <form>
                                        <div class="form-group">
                                            <label for="descuentos">Texto de línea de descuentos</label>
                                            <input type="text" class="form-control" id="descuentos" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="etiqueta_descuento">Etiqueta de campo de Código de descuento</label>
                                            <input type="text" class="form-control" id="etiqueta_descuento" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="textoBtn_aplicar">Texto del botón Aplicar</label>
                                            <input type="text" class="form-control" id="textoBtn_aplicar" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="colorBtn_aplicar">Color boton aplicar</label>
                                            <input class="colores input-change" type="color" id="colorBtn_aplicar" name="colorBtn_aplicar" value="">
                                        </div>
                                        <!-- Añade más campos según sea necesario -->
                                    </form>
                                </div>
                            </div>
                            <!-- Fin CODIGOS DE DESCUENTO -->
                            <!-- NOMBRES Y APELLIDOS -->
                            <div class="list-group-item" id="nombresApellidos">
                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn btn-secondary btn-sm toggle-visibility"><i class="fas fa-eye"></i></button>
                                    NOMBRES Y APELLIDOS
                                    <span>
                                        <button class="btn btn-secondary btn-sm edit-btn"><i class="fas fa-pencil-alt"></i></button>
                                        <button class="btn btn-secondary btn-sm move-up"><i class="fas fa-arrow-up"></i></button>
                                        <button class="btn btn-secondary btn-sm move-down"><i class="fas fa-arrow-down"></i></button>
                                    </span>
                                </div>
                                <!-- Sección oculta que se mostrará al hacer clic en editar -->
                                <div class="edit-section hidden">
                                    <form>
                                        <div class="form-group">
                                            <label for="txt_nombresApellidos">Texto Interno</label>
                                            <input type="text" class="form-control" id="txt_nombresApellidos" placeholder="">
                                        </div>
                                        <!-- 
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" value="" id="mostrarIcon_nombresApellidos" checked>
                                            <label class="form-check-label" for="mostrarIcon_nombresApellidos">
                                                Mostrar ícono de campo
                                            </label>
                                        </div>
                                        -->
                                        <div class="btn-group" id="icono_nombresApellidos">
                                            <button class="btn btn-secondary icon-btn active" data-value="bxs-user"><i class='bx bxs-user'></i></button>
                                            <button class="btn btn-secondary icon-btn" data-value="bx-user"><i class='bx bx-user'></i></button>
                                            <button class="btn btn-secondary icon-btn" data-value="bxs-user-detail"><i class='bx bxs-user-detail'></i></button>
                                        </div>

                                        <!-- Añade más campos según sea necesario -->
                                    </form>
                                </div>
                            </div>
                            <!-- Fin NOMBRES Y APELLIDOS -->
                            <!-- TELÉFONO -->
                            <div class="list-group-item" id="telefono">
                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn btn-secondary btn-sm toggle-visibility"><i class="fas fa-eye"></i></button>
                                    TELÉFONO
                                    <span>
                                        <button class="btn btn-secondary btn-sm edit-btn"><i class="fas fa-pencil-alt"></i></button>
                                        <button class="btn btn-secondary btn-sm move-up"><i class="fas fa-arrow-up"></i></button>
                                        <button class="btn btn-secondary btn-sm move-down"><i class="fas fa-arrow-down"></i></button>
                                    </span>
                                </div>
                                <!-- Sección oculta que se mostrará al hacer clic en editar -->
                                <div class="edit-section hidden">
                                    <form>
                                        <div class="form-group">
                                            <label for="txt_telefono">Texto Interno</label>
                                            <input type="text" class="form-control" id="txt_telefono" placeholder="">
                                        </div>

                                        <div class="btn-group" id="icono_telefono">
                                            <button class="btn btn-secondary icon-btn active" data-value="bxs-user"><i class='bx bxs-phone-call'></i></button>
                                            <button class="btn btn-secondary icon-btn" data-value="bx-user"><i class='bx bxl-whatsapp'></i></button>
                                            <button class="btn btn-secondary icon-btn" data-value="bxs-user-detail"><i class='bx bx-phone-call'></i></button>
                                        </div>

                                        <!-- Añade más campos según sea necesario -->
                                    </form>
                                </div>
                            </div>
                            <!-- Fin TELÉFONO -->
                        </div>
                    </div>
                </div>

                <div class="right-column">
                    <div class="col-md-8 caja" style="background-color: white;">
                        <div id="previewContainer" class="p-3">

                            <div id="tituloFormularioPreview">
                                <h4 id="texto_tituloPreview">PAGA AL RECIBIR EN CASA!</h4>
                            </div>
                            <div id="resumenTotalPreview" class="caja_variable">
                                <div class="d-flex flex-row">
                                    <p id="subtotalPreview">Subtotal</p>
                                    <span style="width: 100%; text-align: end;">$19.99</span>
                                </div>
                                <div class="d-flex flex-row">
                                    <p>Envío</p>
                                    <span id="envioPreview" style="width: 100%; text-align: end; font-weight:bold;">Gratis</span>
                                </div>

                                <div class="d-flex flex-row">
                                    <p id="descuentosPreview">Descuento</p>
                                    <span style="width: 100%; text-align: end; font-weight:bold; color: red;">- $4.00</span>
                                </div>
                                <hr />
                                <div class="d-flex flex-row">
                                    <p id="totalPreview">Total</p>
                                    <span style="width: 100%; text-align: end;">$19.99</span>
                                </div>
                            </div>
                            <div id="tarifasEnvioPreview">
                                <p id="titulo_tarifaPreview" style="font-weight:bold;">Método de envío</p>
                                <div class="caja_transparente d-flex flex-row">
                                    <input type="radio" name="metodoEnvio" checked>
                                    <label for="envioGratisPreview"> Envío gratis</label>
                                    <label id="gratisPreview" style="width: 60%; text-align: end; font-weight:bold;">Gratis</label>
                                </div>
                            </div>
                            <div class="discount-code-container" id="codigosDescuentoPreview">
                                <!-- Campo de entrada para el código de descuento -->
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Código de descuento" id="etiqueta_descuentoPreview" aria-label="Código de descuento">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark" id="textoBtn_aplicarPreview" type="button">Aplicar</button>
                                    </div>
                                </div>

                                <!-- Código de descuento aplicado -->
                                <div class="applied-discount">
                                    <span class="discount-tag">4SALE $4.00</span>
                                    <button type="button" class="close" aria-label="Eliminar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <!-- Nombre y apellidos -->
                            <div class="form-group" id="nombresApellidosPreview" style="position: relative; padding-top: 10px;">
                                <hr />
                                <label class="sub_titulos">Nombres y Apellidos</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="icono_nombresApellidosPreview"><i class='bx bxs-user'></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="txt_nombresApellidosPreview" placeholder="Nombre y Apellido">
                                </div>
                            </div>
                            <!-- Fin Nombre y apellidos -->
                            <!-- Telefono -->
                            <div class="form-group" id="telefonoPreview" style="position: relative; padding-top: 10px;">
                                <label class="sub_titulos">Teléfono</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="icono_telefonoPreview"><i class='bx bxs-phone-call'></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="txt_telefonoPreview" placeholder="Teléfono">
                                </div>
                            </div>
                            <!-- Fin Telefono -->
                        </div>
                    </div>
                </div>
                <!-- end container -->
                <div class="save-button-container">
                    <button id="saveFormState" class="btn btn-success">Guardar Cambios</button>
                </div>
            </div>
            <!-- end content -->

            <?php require 'includes/pie.php'; ?>

        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <?php require 'includes/footer_start.php'
    ?>
    <!-- ============================================================== -->
    <!-- Todo el codigo js aqui -->
    <!-- ============================================================== -->

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".UpperCase").on("keypress", function() {
                $input = $(this);
                setTimeout(function() {
                    $input.val($input.val().toUpperCase());
                }, 50);
            })
        })


        // Espera a que el documento esté listo
        $(document).ready(function() {
            // Maneja el evento clic del botón de editar
            $('.edit-btn').click(function() {
                // Encuentra la sección de edición más cercana y alterna la clase 'hidden'
                $(this).closest('.list-group-item').find('.edit-section').toggleClass('hidden');
            });
        });

        // dejar de visualizar o no un codigo
        $(document).ready(function() {
            $('.toggle-visibility').click(function() {
                var listItem = $(this).closest('.list-group-item');
                var listItemID = listItem.attr('id');
                var previewItem = $('#previewContainer').find('#' + listItemID + 'Preview');

                // Toggle de visibilidad en la vista previa
                previewItem.toggle();

                // Cambio del estado y actualización en JSON
                var estadoActual = previewItem.is(':visible') ? '1' : '0';
                listItem.data('estado', estadoActual); // Guardar el estado como data attribute
            });
        });

        //Flechas de arriba y abajo
        $(document).ready(function() {
            // Mover elemento hacia arriba
            $('.move-up').click(function() {
                var listItem = $(this).closest('.list-group-item');
                var listItemID = listItem.attr('id'); // Asegúrate de que cada list-group-item tenga un id único.

                // Mueve el elemento en la columna de la izquierda
                listItem.prev().before(listItem);

                // Ahora mueve el elemento correspondiente en la columna de la derecha
                var previewItem = $('#previewContainer').find('#' + listItemID + 'Preview');
                previewItem.prev().before(previewItem);
            });

            // Mover elemento hacia abajo
            $('.move-down').click(function() {
                var listItem = $(this).closest('.list-group-item');
                var listItemID = listItem.attr('id'); // Asegúrate de que cada list-group-item tenga un id único.

                // Mueve el elemento en la columna de la izquierda
                listItem.next().after(listItem);

                // Ahora mueve el elemento correspondiente en la columna de la derecha
                var previewItem = $('#previewContainer').find('#' + listItemID + 'Preview');
                previewItem.next().after(previewItem);
            });
        });
        //PREVIEW
        document.addEventListener('DOMContentLoaded', () => {
            // Asumiendo que tienes un input con id='texto_titulo'
            const tituloInput = document.getElementById('texto_titulo');
            tituloInput.addEventListener('input', function() {
                document.getElementById('texto_tituloPreview').textContent = this.value;
            });

            // Asume que tienes otro input para la descripción con id='subtotal'
            const subtotalInput = document.getElementById('subtotal');
            subtotalInput.addEventListener('input', function() {
                document.getElementById('subtotalPreview').textContent = this.value;
            });

            // Repite el proceso para otros campos de entrada
            const envioInput = document.getElementById('envio');
            envioInput.addEventListener('input', function() {
                document.getElementById('envioPreview').textContent = this.value;
            });

            const totalInput = document.getElementById('total');
            totalInput.addEventListener('input', function() {
                document.getElementById('totalPreview').textContent = this.value;
            });

            const titulo_tarifaInput = document.getElementById('titulo_tarifa');
            titulo_tarifaInput.addEventListener('input', function() {
                document.getElementById('titulo_tarifaPreview').textContent = this.value;
            });

            const gratisInput = document.getElementById('gratis');
            gratisInput.addEventListener('input', function() {
                document.getElementById('gratisPreview').textContent = this.value;
            });

            const descuentosInput = document.getElementById('descuentos');
            descuentosInput.addEventListener('input', function() {
                document.getElementById('descuentosPreview').textContent = this.value;
            });

            // Asegurarse que los elementos están correctamente enlazados con los eventos de actualización
            const etiqueta_descuentoInput = document.getElementById('etiqueta_descuento');
            const textoBtn_aplicarInput = document.getElementById('textoBtn_aplicar');

            etiqueta_descuentoInput.addEventListener('input', function() {
                var previewInput = document.getElementById('etiqueta_descuentoPreview');
                previewInput.placeholder = this.value; // Cambiando el placeholder en lugar de textContent
            });

            textoBtn_aplicarInput.addEventListener('input', function() {
                document.getElementById('textoBtn_aplicarPreview').textContent = this.value;
            });

            const txt_nombresApellidosInput = document.getElementById('txt_nombresApellidos');
            txt_nombresApellidosInput.addEventListener('input', function() {
                var previewInput = document.getElementById('txt_nombresApellidosPreview');
                previewInput.placeholder = this.value; // Cambiando el placeholder en lugar de textContent
            });

            const txt_telefonoInput = document.getElementById('txt_telefono');
            txt_telefonoInput.addEventListener('input', function() {
                var previewInput = document.getElementById('txt_telefonoPreview');
                previewInput.placeholder = this.value; // Cambiando el placeholder en lugar de textContent
            });

        });

        // Funcion para que consuma los datos de checkout.json y los utilice

        document.addEventListener('DOMContentLoaded', function() {
            loadAndSetInitialData();
        });

        function loadAndSetInitialData() {
            $.getJSON('../json/checkout.json', function(data) {
                data.forEach(item => {
                    processItem(item);
                });
            }).fail(handleLoadingError);
        }

        function processItem(item) {
            Object.keys(item.content).forEach(key => {
                updateFieldAndPreview(key, item.content[key], item.id_elemento);
            });
            toggleVisibility(item.estado, item.id_elemento);
            reorderElements(item.id_elemento, item.posicion);
        }

        function updateFieldAndPreview(key, value, id_elemento) {
            const field = $('#' + key);
            const previewField = $('#' + key + 'Preview');

            updateFieldValue(field, value);
            updatePreviewField(key, previewField, value);

            if (key === 'alineacion_titulo') {
                updateTextAlignment(value);
            } else if (key.startsWith('color')) {
                updateColor(key, value);
            }
        }

        function updateFieldValue(field, value) {
            if (field.is(':checkbox')) {
                field.prop('checked', value === 'on');
            } else {
                field.val(value).change(); // Trigger change for preview updates
            }
        }

        function updatePreviewField(key, previewField, value) {
            if (!previewField.length) {
                console.warn('No preview field found for', key);
                return;
            }

            if (key.includes('txt_')) {
                previewField.attr('placeholder', value);
            } else if (key.includes('icono')) {
                previewField.html("<i class='" + value + "'></i>");
            } else {
                previewField.text(value);
            }
        }

        function toggleVisibility(state, id_elemento) {
            const preview = $('#' + id_elemento + 'Preview');
            state === '0' ? preview.hide() : preview.show();
        }

        function reorderElements(id_elemento, position) {
            const element = $('#' + id_elemento);
            const preview = $('#' + id_elemento + 'Preview');
            reorderElement(element, position, '.list-group');
            reorderElement(preview, position, '#previewContainer');
        }

        function reorderElement(element, position, containerSelector) {
            if (element.index() !== position) {
                element.detach();
                position === 0 ? $(containerSelector).prepend(element) : $(containerSelector).children().eq(position - 1).after(element);
            }
        }

        function updateTextAlignment(value) {
            const textAlign = value === '1' ? 'left' : value === '2' ? 'center' : 'right';
            $('#tituloFormularioPreview').css('text-align', textAlign);
        }

        function updateColor(key, value) {
            if (key === 'colorTxt_titulo') {
                $('#texto_tituloPreview').css('color', value);
            } else if (key === 'colorBtn_aplicar') {
                $('#textoBtn_aplicarPreview').css('background-color', value);
            }
        }

        function handleLoadingError(jqXHR, textStatus, errorThrown) {
            console.error('Error loading JSON:', textStatus, errorThrown);
        }


        // Funcion para boton guardar

        function saveFormState() {
            var itemList = [];
            $('.list-group-item').each(function(index) {
                var item = {
                    id_elemento: $(this).attr('id'),
                    posicion: index,
                    estado: $(this).data('estado') || '1', // Usar '1' como valor por defecto
                    content: {}
                };

                // Capturar valores de inputs, selects, y checkboxes
                $(this).find('input, select').each(function() {
                    var key = this.id;
                    var value = $(this).is(':checkbox') ? ($(this).is(':checked') ? 'on' : 'off') : $(this).val();
                    item.content[key] = value;
                });

                // Generalización para capturar íconos activos
                $(this).find('.icon-btn.active i').each(function() {
                    var iconKey = $(this).closest('.btn-group').attr('id'); // Asume que el btn-group tiene un ID
                    var iconClass = $(this).attr('class');
                    item.content[iconKey] = iconClass;
                });

                itemList.push(item);
            });

            // Enviar la información al servidor
            $.ajax({
                url: '../ajax/actualizar_checkout.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(itemList),
                success: function(response) {
                    alert('Los cambios han sido guardados.');
                },
                error: function(xhr, status, error) {
                    alert('Ha ocurrido un error al guardar los cambios.');
                }
            });
        }

        $(document).ready(function() {
            $('#saveFormState').click(saveFormState);
        });

        // accion del select
        document.addEventListener('DOMContentLoaded', function() {
            // Asumiendo que el select ya existe cuando carga la página
            const alineacionTituloSelect = document.getElementById('alineacion_titulo');
            alineacionTituloSelect.addEventListener('change', function() {
                const tituloPreview = document.getElementById('tituloFormularioPreview');
                switch (this.value) {
                    case '1': // Izquierda
                        tituloPreview.style.textAlign = 'left';
                        break;
                    case '2': // Centro
                        tituloPreview.style.textAlign = 'center';
                        break;
                    case '3': // Derecha
                        tituloPreview.style.textAlign = 'right';
                        break;
                }
            });
            // Evento para cambiar el color del texto del título
            $('#colorTxt_titulo').on('change', function() {
                $('#texto_tituloPreview').css('color', $(this).val());
            });

            // Cambiar el color del botón Aplicar en tiempo real
            $('#colorBtn_aplicar').on('change', function() {
                $('#textoBtn_aplicarPreview').css('background-color', $(this).val());
            });

        });
        //boton de inconos
        $(document).ready(function() {
            /*
            // Cambiar la visibilidad del grupo de botones basado en el checkbox
            $('#mostrarIcon_nombresApellidos').change(function() {
                if ($(this).is(':checked')) {
                    $('#icono_nombresApellidos').show();
                } else {
                    $('#icono_nombresApellidos').hide();
                }
            });
            */

            // Evento de clic en cada botón de íconos
            setupIconButtons('icono_nombresApellidos', 'icono_nombresApellidosPreview');
            setupIconButtons('icono_telefono', 'icono_telefonoPreview');
        });
        // funcion generalizada para iconos
        function setupIconButtons(containerId, previewId) {
            // Agrega evento de clic a cada botón de ícono dentro del contenedor especificado
            $('#' + containerId + ' .icon-btn').click(function(event) {
                event.preventDefault();
                // Elimina la clase 'active' de todos los botones y la añade al botón actualmente clickeado
                $('#' + containerId + ' .icon-btn').removeClass('active');
                $(this).addClass('active');
                // Obtiene el valor del ícono seleccionado y actualiza el ícono en la vista previa
                var iconClass = $(this).find('i').attr('class');
                $('#' + previewId).html("<i class='" + iconClass + "'></i>");
            });
        }
    </script>
    <?php require 'includes/footer_end.php'
    ?>