<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
require_once "../funciones.php";
require_once "../funciones_destino.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Ventas";

permisos($modulo, $cadena_permisos);
// obtiene el dominio actual
$dominio = $_SERVER['HTTP_HOST'];
// se quitan los espacios en blanco 
$dominio = str_replace(' ', '', $dominio);

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
$server_url = $protocol . $_SERVER['HTTP_HOST'];
//Finaliza Control de Permisos
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q      = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $sTable = "empresa_envio, trabajadores_envio";
    $sWhere = "";
    $sWhere .= " WHERE trabajadores_envio.empresa=empresa_envio.id";

    if ($_GET['q'] != "") {
        $sWhere .= " and  (trabajadores_envio.nombre like '%$q%' or trabajadores_envio.contacto like '%$q%' or empresa_envio.nombre like '%$q%')";
    }

    if (@$_GET['estado'] != "") {
        $estado    = $_REQUEST['estado'];
        $sWhere .= " and  trabajadores_envio.estado='$estado'";
    }

    $sWhere .= " order by trabajadores_envio.id asc";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 10; //how much records you want to show
    if ($_GET["numero"]) {
        $per_page  = $_GET["numero"]; //how much records you want to show

    }
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;

    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../reportes/facturas.php';
    //main query to fetch the data
    $sql   = "SELECT empresa_envio.nombre as emp_nombre, empresa_envio.id as emp_id, trabajadores_envio.* FROM  $sTable $sWhere LIMIT $offset,$per_page";
    //echo $sql;
    $query = mysqli_query($conexion, $sql);

    $empresas = mysqli_query($conexion, "SELECT * FROM empresa_envio");



    //loop through fetched data0
    if ($numrows > 0) {
        echo mysqli_error($conexion);

?>
        <!-- Crear trabajador modal -->
        <div class="modal fade" id="crearTrabajador" tabindex="-1" role="dialog" aria-labelledby="crearTrabajadorLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" method="post" id="crear_trabajador" name="crear_trabajador">
                        <div class="modal-header">
                            <h5 class="modal-title" id="crearTrabajadorLabel">Crear Trabajador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contacto" class="col-sm-2 control-label">Contacto</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="contacto" name="contacto" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="placa" class="col-sm-2 control-label">Placa</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="placa" name="placa" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="estado" class="col-sm-2 control-label">Estado</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="estado" name="estado" required>
                                        <option value="">-- Seleccione una opcion --</option>
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="empresa" class="col-sm-2 control-label">Empresa</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="empresa" name="empresa" required>
                                        <option value="">-- Seleccione una empresa --</option>

                                        <?php
                                        while ($row = mysqli_fetch_assoc($empresas)) {
                                            $id_empresa = $row['id'];
                                            $nombre     = $row['nombre'];
                                        ?>
                                            <option value="<?php echo $id_empresa; ?>"><?php echo $nombre; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary cerrar" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- nuevo button -->
        <div class="col-md-12">
            <div class="text-right
            ">
                <a href="#" data-target="#crearTrabajador" class="nuevo bg-primary px-2 py-1 text-white rounded" data-toggle="modal" data-id="<?php echo $id_trabajador; ?>" data-empresa="<?php echo $id_empresa; ?>" data-nombre="<?php echo $nombre; ?>" data-contacto="<?php echo $contacto; ?>" data-placa="<?php echo $placa; ?>" data-estado="<?php echo $estado; ?>">
                    <i class='bx bx-plus
                    '></i> Nuevo
                </a>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle">
                <tr class="info">
                    <th class="text-center"># Trabajador</th>
                    <th class="text-center">Empresa</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Contacto</th>
                    <th class="text-center">Placa</th>
                    <th style="text-align: center;">Estado</th>
                    <th colspan="2" class="text-center">Opcion</th>

                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($query)) {
                    $id_trabajador = $row['id'];
                    $nombre        = $row['nombre'];
                    $contacto      = $row['contacto'];
                    $placa         = $row['placa'];
                    $estado        = $row['estado'];
                    $empresa       = $row['emp_nombre'];
                    $id_empresa    = $row['emp_id'];
                    $estado        = ($estado == 1) ? "Activo" : "Inactivo";
                    $estado_val   = ($estado == "Activo") ? 1 : 2;
                    $badge         = ($estado == "Activo") ? "badge-success text-white rounded px-2 py-1" : "badge-danger text-white rounded px-2 py-1";

                ?>
                    <tr>
                        <td class='text-center'><?php echo $id_trabajador; ?></td>
                        <td class='text-center'><?php echo $empresa; ?></td>
                        <td class='text-center'><?php echo $nombre; ?></td>
                        <td class='text-center'><?php echo $contacto; ?></td>
                        <td class='text-center'><?php echo $placa; ?></td>
                        <td class='text-center'><span class="<?php echo $badge; ?>"><?php echo $estado; ?></span></td>
                        <td class='text-center flex gap-2 justify-content-center'>
                            <a href="#" data-target="#editModal" class="edit bg-warning px-2 py-1 text-white rounded" data-toggle="modal" data-id="<?php echo $id_trabajador; ?>" data-empresa="<?php echo $id_empresa; ?>" data-nombre="<?php echo $nombre; ?>" data-contacto="<?php echo $contacto; ?>" data-placa="<?php echo $placa; ?>" data-estado="<?php echo $estado_val; ?>">
                                Editar <i class='bx bx-wrench'></i>
                            </a>

                            <a href="#" id="bo_<?php echo $id_trabajador ?>" data-target="#deleteModal" class="delete bg-danger px-2 py-1 text-white rounded" data-toggle="modal" data-id="<?php echo $id_trabajador; ?>">
                                Borrar<i class='bx bx-trash'></i>
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>

        </div>

        <div class="table-pagination text-center">
            <?php
            echo paginate($reload, $page, $total_pages, $adjacents);
            ?>
        </div>
        <!-- editModal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" method="post" id="edit_trabajador" name="edit_trabajador">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Trabajador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" class="form-control" id="id" name="id">
                            <div class="form-group">
                                <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                                <div class="col">
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contacto" class="col-sm-2 control-label">Contacto</label>
                                <div class="col">
                                    <input type="text" class="form-control" id="contacto" name="contacto" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="placa" class="col-sm-2 control-label">Placa</label>
                                <div class="col">
                                    <input type="text" class="form-control" id="placa" name="placa" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="estado" class="col-sm-2 control-label">Estado</label>
                                <div class="col">
                                    <select class="form-control" id="estado" name="estado" required>
                                        <option value="">-- Seleccione una opcion --</option>
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="empresa" class="col-sm-2 control-label">Empresa</label>
                                <div class="col">
                                    <select class="form-control" id="empresa" name="empresa" required>
                                        <option value="">-- Seleccione una empresa --</option>
                                        <?php
                                        mysqli_data_seek($empresas, 0);
                                        while ($row = mysqli_fetch_assoc($empresas)) {
                                            $id_empresa = $row['id'];
                                            $nombre     = $row['nombre'];
                                        ?>
                                            <option value="<?php echo $id_empresa; ?>"><?php echo $nombre; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary cerrar" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /editModal -->
        <script>
            $(document).on("click", ".edit", function() {
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');
                var contacto = $(this).data('contacto');
                var placa = $(this).data('placa');
                var estado = $(this).data('estado');
                var empresa = $(this).data('empresa');
                $(".modal-body #id").val(id);
                $(".modal-body #nombre").val(nombre);
                $(".modal-body #contacto").val(contacto);
                $(".modal-body #placa").val(placa);
                $(".modal-body #estado").val(estado);
                $(".modal-body #empresa").val(empresa);
            });


            $(document).on("click", ".nuevo", function() {
                var id = $(this).data('id');
                $(".modal-body #id").val(id);
            });

            $(document).on("click", ".delete", function(event) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).data('id');

                        var parametros = {
                            "id": id
                        };
                        $.ajax({
                            type: "POST",
                            url: "../ajax/borrar_trabajador.php",
                            data: parametros,
                            beforeSend: function(objeto) {
                                $("#resultados").html("Mensaje: Cargando...");
                            },
                            success: function(datos) {
                                $("#resultados").html(datos);
                                $('#deleteModal').modal('hide');
                                load(1);
                            }
                        });
                    }
                });
            })



            $("#crear_trabajador").submit(function(event) {
                var parametros = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "../ajax/crear_trabajador.php",
                    data: parametros,
                    beforeSend: function(objeto) {
                        $("#resultados").html("Mensaje: Cargando...");
                    },
                    success: function(datos) {
                        $("#resultados").html(datos);
                        $('#crearTrabajador').modal('hide');
                        load(1);
                    }
                });
                event.preventDefault();
            });

            $("#edit_trabajador").submit(function(event) {
                var parametros = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "../ajax/editar_trabajador.php",
                    data: parametros,
                    beforeSend: function(objeto) {
                        $("#resultados").html("Mensaje: Cargando...");
                    },
                    success: function(datos) {
                        $("#resultados").html(datos);
                        $('#editModal').modal('hide');
                        load(1);
                    }
                });
                event.preventDefault();
            });



            /*  $(document).on('click', '.cerrar', function() {
                 $('#crearTrabajador').modal('hide');
                 $('#editModal').modal('hide');
             }); */

            $(document).on('click', '.cerrar', function() {
                $(this).closest('.modal').modal('hide');
            });
        </script>


    <?php

    } else {
    ?>





        <div class="col-md-12">
            <div class="text-right
            ">
                <a href="#" data-target="#crearTrabajador" class="nuevo bg-primary px-2 py-1 text-white rounded" data-toggle="modal" data-id="<?php echo $id_trabajador; ?>" data-empresa="<?php echo $id_empresa; ?>" data-nombre="<?php echo $nombre; ?>" data-contacto="<?php echo $contacto; ?>" data-placa="<?php echo $placa; ?>" data-estado="<?php echo $estado; ?>">
                    <i class='bx bx-plus
                    '></i> Nuevo
                </a>
            </div>
        </div>
        <div class="modal fade" id="crearTrabajador" tabindex="-1" role="dialog" aria-labelledby="crearTrabajadorLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" method="post" id="crear_trabajador" name="crear_trabajador">
                        <div class="modal-header">
                            <h5 class="modal-title" id="crearTrabajadorLabel">Crear Trabajador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contacto" class="col-sm-2 control-label">Contacto</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="contacto" name="contacto" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="placa" class="col-sm-2 control-label">Placa</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="placa" name="placa" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="estado" class="col-sm-2 control-label">Estado</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="estado" name="estado" required>
                                        <option value="">-- Seleccione una opcion --</option>
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="empresa" class="col-sm-2 control-label">Empresa</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="empresa" name="empresa" required>
                                        <option value="">-- Seleccione una empresa --</option>

                                        <?php
                                        while ($row = mysqli_fetch_assoc($empresas)) {
                                            $id_empresa = $row['id'];
                                            $nombre     = $row['nombre'];
                                        ?>
                                            <option value="<?php echo $id_empresa; ?>"><?php echo $nombre; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary cerrar" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(document).on("click", ".edit", function() {
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');
                var contacto = $(this).data('contacto');
                var placa = $(this).data('placa');
                var estado = $(this).data('estado');
                var empresa = $(this).data('empresa');
                $(".modal-body #id").val(id);
                $(".modal-body #nombre").val(nombre);
                $(".modal-body #contacto").val(contacto);
                $(".modal-body #placa").val(placa);
                $(".modal-body #estado").val(estado);
                $(".modal-body #empresa").val(empresa);
            });


            $(document).on("click", ".nuevo", function() {
                var id = $(this).data('id');
                $(".modal-body #id").val(id);
            });

            $(document).on("click", ".delete", function(event) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).data('id');

                        var parametros = {
                            "id": id
                        };
                        $.ajax({
                            type: "POST",
                            url: "../ajax/borrar_trabajador.php",
                            data: parametros,
                            beforeSend: function(objeto) {
                                $("#resultados").html("Mensaje: Cargando...");
                            },
                            success: function(datos) {
                                $("#resultados").html(datos);
                                $('#deleteModal').modal('hide');
                                load(1);
                            }
                        });
                    }
                });
            })



            $("#crear_trabajador").submit(function(event) {
                var parametros = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "../ajax/crear_trabajador.php",
                    data: parametros,
                    beforeSend: function(objeto) {
                        $("#resultados").html("Mensaje: Cargando...");
                    },
                    success: function(datos) {
                        $("#resultados").html(datos);
                        $('#crearTrabajador').modal('hide');
                        load(1);
                    }
                });
                event.preventDefault();
            });

            $("#edit_trabajador").submit(function(event) {
                var parametros = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "../ajax/editar_trabajador.php",
                    data: parametros,
                    beforeSend: function(objeto) {
                        $("#resultados").html("Mensaje: Cargando...");
                    },
                    success: function(datos) {
                        $("#resultados").html(datos);
                        $('#editModal').modal('hide');
                        load(1);
                    }
                });
                event.preventDefault();
            });
            $(document).on('click', '.cerrar', function() {
                $(this).closest('.modal').modal('hide');
            });
        </script>





        <div class='alert alert-warning'>No se encontraron datos</div>

<?php
    }
}
