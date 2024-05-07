<?php
/*-------------------------
Autor: Eduardo Vega
---------------------------*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
require_once "../funciones.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Datos";
// dominio mas protocolo
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';

$dominio_completo =     $protocol . $_SERVER['HTTP_HOST'];

$dominio_actual = $_SERVER['HTTP_HOST'];

$dominio_actual = str_replace('www.', '', $dominio_actual);
$dominio_actual = str_replace('.com', '', $dominio_actual);
$dominio_actual = str_replace('.net', '', $dominio_actual);

permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($dominio_actual == 'marketplace.imporsuit') {

    if ($action == "ajax") {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $sDominio = 'imporsuit_marketplace';
        $conexion_db = mysqli_connect('localhost', $sDominio, $sDominio, $sDominio);
        $q = mysqli_real_escape_string($conexion_db, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
        $sTable = "datos_banco_usuarios";
        $sWhere = "";
        $sWhere .= "";
        if ($_GET['q'] != "") {
            $sWhere .= "";
        }
        $sWhere .= "";
        include 'pagination.php'; //include pagination file
        //pagination variables
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
        $per_page = 10; //how much records you want to show
        $adjacents  = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $count_query   = mysqli_query($conexion_db, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
        $row = mysqli_fetch_array($count_query);
        $numrows = $row['numrows'];
        $total_pages = ceil($numrows / $per_page);
        $reload = '../reportes/wallet.php';
        //main query to fetch the data

        $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
        $query = mysqli_query($conexion_db, $sql);
        $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
        //loop through fetched data

        if ($numrows > 0 && $dominio_actual == 'marketplace.imporsuit') {
?>
            <form id="filter-form">
                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" id="fecha">

                <label for="estado">Estado de Pedido:</label>
                <select name="estado" id="estado">
                    <option value="0">Todos</option>
                    <option value="1">Confirmar</option>
                    <option value="2">Pick y Pack</option>
                    <!-- Agrega más opciones según tus estados de pedido -->
                </select>

                <button class="btn btn-outline-primary" type="button" onclick="filterData()">Filtrar</button>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr class="info">
                            <th class="text-center">Banco </th>
                            <th class="text-center">Tipo de cuenta </th>
                            <th class="text-center">Numero de cuenta</th>
                            <th class="text-center">Nombre del titular</th>
                            <th class="text-center">Cedula del titular</th>
                            <th class="text-center">Correo del titular</th>
                            <th class="text-center">Telefono del titular</th>
                            <th class="text-center">Estado</th>

                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody id="resultados">

                        <?php
                        while ($row = mysqli_fetch_array($query)) {
                            $banco = $row['banco'];
                            $tipo_cuenta = $row['tipo_cuenta'];
                            $numero_cuenta = $row['numero_cuenta'];
                            $nombre_titular = $row['nombre'];
                            $cedula_titular = $row['cedula'];
                            $correo_titular = $row['correo'];
                            $telefono_titular = $row['telefono'];
                            $estado = $row['estado'];
                            $tienda = $row['tienda'];
                            $estado = ($estado == 1) ? 'Activo' : 'Inactivo';
                            $badge_estado = ($estado == 1) ? 'badge-success' : 'badge-danger';
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $banco; ?></td>
                                <td class="text-center"><?php echo $tipo_cuenta; ?></td>
                                <td class="text-center"><?php echo $numero_cuenta; ?></td>
                                <td class="text-center"><?php echo $nombre_titular; ?></td>
                                <td class="text-center"><?php echo $cedula_titular; ?></td>
                                <td class="text-center"><?php echo $correo_titular; ?></td>
                                <td class="text-center"><?php echo $telefono_titular; ?></td>
                                <td class="text-center"><?php echo $tienda; ?></td>
                                <td class="text-center"><span class="badge <?php echo $badge_estado; ?>"><?php echo $estado; ?></span></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tr>
                        <td colspan=10><span class="pull-right">
                                <?php
                                echo paginate($reload, $page, $total_pages, $adjacents);
                                ?></span></td>
                    </tr>

                </table>
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-warning alert-dismissible" role="alert" align="center">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Aviso!</strong> No hay Registro de datos bancarios
            </div>
            <?php
        }
    }
} else {
    if ($action == "ajax") {
        // escaping, additionally removing everything that could be (html/javascript-) code
        // escaping, additionally removing everything that could be (html/javascript-) code
        $sDominio = 'imporsuit_marketplace';
        $conexion_db = mysqli_connect('localhost', $sDominio, $sDominio, $sDominio);
        $q = mysqli_real_escape_string($conexion_db, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
        $sTable = "datos_banco_usuarios";
        $sWhere = "";
        $sWhere .= " WHERE tienda = '$dominio_completo'";

        if ($_GET['q'] != "") {
            $sWhere .= "";
        }
        $sWhere .= "";

        //main query to fetch the data

        $sql = "SELECT * FROM  $sTable $sWhere";
        $query = mysqli_query($conexion_db, $sql);
        $rows = mysqli_num_rows($query);
        //loop through fetched data

        if ($rows > 0) { {
            ?>
                <div class="mb-3 text-right">
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#solicitar">
                        Solicitar Pago
                    </button>
                </div>
                <div class="modal fade" id="solicitar" tabindex="-1" role="dialog" aria-labelledby="solicitarLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="solicitarLabel">Solicitar Pago</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="mb-3" method="post" onsubmit="solicitar_pago(event)">
                                    <input type="hidden" name="tienda" value="<?php echo $dominio_completo  ?>">
                                    <div class="form-group">
                                        <label for="dinero" class="form-label">Cantidad:</label>
                                        <input type="text" class="form-control" id="dinero" placeholder="Cantidad" autofocus>
                                    </div>

                                    <input class="btn btn-outline-success w-100" type="submit" value="Solicitar pago">
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr class="info">
                                <th class="text-center">Banco </th>
                                <th class="text-center">Tipo de cuenta </th>
                                <th class="text-center">Numero de cuenta</th>
                                <th class="text-center">Nombre del titular</th>
                                <th class="text-center">Cedula del titular</th>
                                <th class="text-center">Correo del titular</th>
                                <th class="text-center">Telefono del titular</th>
                                <th class="text-center">Tienda</th>
                                <th class="text-center">Estado</th>

                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody id="resultados">

                            <?php
                            while ($row = mysqli_fetch_array($query)) {
                                $banco = $row['banco'];
                                $tipo_cuenta = $row['tipo_cuenta'];
                                $numero_cuenta = $row['numero_cuenta'];
                                $nombre_titular = $row['nombre'];
                                $cedula_titular = $row['cedula'];
                                $correo_titular = $row['correo'];
                                $telefono_titular = $row['telefono'];
                                $estado = $row['estado'];
                                $tienda = $row['tienda'];
                                $estado = ($estado == 1) ? 'Activo' : 'Inactivo';
                                $badge_estado = ($estado == 1) ? 'badge-success' : 'badge-danger';
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $banco; ?></td>
                                    <td class="text-center"><?php echo $tipo_cuenta; ?></td>
                                    <td class="text-center"><?php echo $numero_cuenta; ?></td>
                                    <td class="text-center"><?php echo $nombre_titular; ?></td>
                                    <td class="text-center"><?php echo $cedula_titular; ?></td>
                                    <td class="text-center"><?php echo $correo_titular; ?></td>
                                    <td class="text-center"><?php echo $telefono_titular; ?></td>
                                    <td class="text-center"><?php echo $tienda; ?></td>
                                    <td class="text-center"><span class="badge <?php echo $badge_estado; ?>"><?php echo $estado; ?></span></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>


                    <?php
                }
            } else {
                    ?>
                    <div class="row">
                        <div class="col-md-4">

                            <form method="post" onsubmit="enviar_datos_b(event)">
                                <div class="mb-3 form-group">
                                    <label for="banco" class="form-label">Banco</label>
                                    <select class="form-select" name="banco" id="banco" required>
                                        <option value="0">-- Seleccione un banco --</option>
                                        <option value="Pichincha">Banco Pichincha</option>
                                        <option value="Guayaquil">Banco Guayaquil</option>
                                        <option value="Produbanco">Banco Produbanco</option>
                                        <option value="Bolivariano">Banco Bolivariano</option>
                                        <option value="Pacifico">Banco Pacifico</option>
                                        <option value="Solidario">Banco Solidario</option>
                                    </select>

                                </div>
                                <div class="mb-3 form-group">
                                    <label for="tipo_cuenta" class="form-label">Tipo de cuenta</label>
                                    <select name="tipo_cuenta" class="form-select" id="tipo_cuenta" required>
                                        <option value="0">-- Seleccione un tipo de cuenta --</option>
                                        <option value="Ahorros">Ahorros</option>
                                        <option value="Corriente">Corriente</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="numero_cuenta" class="form-label">Numero de cuenta</label>
                                    <input type="text" class="form-control" id="numero_cuenta" name="numero_cuenta" placeholder="Numero de cuenta" required>
                                </div>

                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre del Titular</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del titular" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cedula" class="form-label">Cédula del Titular </label>
                                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cédula del titular" required>
                                </div>
                                <div class="mb-3">
                                    <label for="correo" class="form-label">Correo del Titular</label>
                                    <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo del titular" required>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono del Titular</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono del titular" required>
                                </div>
                                <div class="mb-3 d-flex">
                                    <input type="submit" class="btn w-100 btn-outline-success" value="Enviar datos">
                                </div>


                            </form>
                        </div>
                        <div class="col-md-8 px-5">
                            <div class="alert alert-warning alert-dismissible" role="alert" align="center">
                                <strong>Aviso!</strong> No hay Registro de datos bancarios para esta tienda


                            </div>
                        </div>
                    </div>
        <?php
            }
        }
    }


        ?>

        <script>
            function filterData() {
                var fecha = document.getElementById('fecha').value;
                var estado = document.getElementById('estado').value;

                var url = '../ajax/filtro_input.php?fecha_inicio=' + fecha + '&fecha_fin=' + fecha + '&estado=' + estado;
                var ajax = new XMLHttpRequest();
                ajax.open('GET', url, true);
                ajax.onreadystatechange = function() {
                    if (ajax.readyState == 4 && ajax.status == 200) {
                        document.getElementById('resultados').innerHTML = ajax.responseText;
                    }
                }
                ajax.send();
            }
        </script>