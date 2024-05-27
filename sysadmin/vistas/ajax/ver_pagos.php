    <?php
    session_start();
    $tienda = $_SERVER['HTTP_REFERER'];
    //obtener &tienda=nombre_tienda
    $tienda = explode('=', $tienda);
    $tienda = $tienda[2];


    require_once "../db.php";
    require_once "../php_conexion.php";
    #require_once "../libraries/inventory.php"; //Contiene funcion que controla stock en el inventario
    //Inicia Control de Permisos
    include "../permisos.php";
    //Archivo de funciones PHP
    require_once "../funciones.php";
    $user_id        = $_SESSION['id_users'];
    $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
    $dominio_actual = $_SERVER['HTTP_HOST'];

    $dominio_actual = str_replace('www.', '', $dominio_actual);
    $dominio_actual = str_replace('.com', '', $dominio_actual);
    $dominio_actual = str_replace('.net', '', $dominio_actual);
    $action         = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
    if ($action == 'ajax' && $dominio_actual == 'merkapro.ec') {
        $tables = "pagos";
        $campos = "*";
        $sWhere = "tienda='" . $tienda . "'";

        $sWhere .= " order by id_pago DESC";

        include 'pagination.php'; //include pagination file
        //pagination variables
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
        $per_page = 10; //how much records you want to show
        $adjacents  = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $tables where $sWhere ");
        if ($row = mysqli_fetch_array($count_query)) {
            $numrows = $row['numrows'];
        } else {
            echo mysqli_error($conexion);
        }
        $total_pages = ceil($numrows / $per_page);
        $reload = '../ver_cxc.php';
        //main query to fetch the data
        $query = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
        //loop through fetched data

        if ($numrows > 0) {
    ?>

            <div class="table-responsive">
                <table class="table-sm table table-condensed table-hover table-striped ">
                    <tr class="text-center">
                        <th>Numero documento</th>
                        <th>Fecha</th>
                        <th>Valor</th>
                        <th>Forma de Pago</th>
                        <th>Recibo</th>
                    </tr>
                    <?php
                    $finales = 0;
                    while ($row = mysqli_fetch_array($query)) {
                        $id_pago = $row['id_pago'];
                        $numero_documento = $row['numero_documento'];
                        $fecha = $row['fecha'];
                        $valor = $row['valor'];
                        $forma_pago = $row['forma_pago'];
                        $url_factura = $row['imagen'];
                        $finales++;
                    ?>
                        <tr>
                            <td><?php echo $numero_documento; ?></td>
                            <td><?php echo $fecha; ?></td>
                            <td><?php echo $simbolo_moneda . ' ' . number_format($valor, 2); ?></td>
                            <td><?php echo $forma_pago; ?></td>
                            <?php if ($url_factura == '') {
                            ?>
                                <td>Sin recibos</td>
                            <?php
                            } else {
                            ?>
                                <td><a href="<?php echo $url_factura; ?>" target="_blank"><i class="fa fa-file-pdf-o"></i></a></td>
                            <?php
                            }
                            ?>

                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td colspan='5'>
                            <?php
                            $inicios = $offset + 1;
                            $finales += $inicios - 1;
                            echo "Mostrando $inicios al $finales de $numrows registros";
                            echo paginate($reload, $page, $total_pages, $adjacents);
                            ?>
                        </td>
                    </tr>
                </table>
            </div>


        <?php
        } else {
            echo "No hay pagos registrados";
        }
    } else {
        $conexion_tienda = mysqli_connect("localhost", "imporsuit_marketplace", "imporsuit_marketplace", "imporsuit_marketplace");
        $tienda = $_SERVER['HTTP_HOST'];
        $tables = "pagos";
        $campos = "*";
        $sWhere = "tienda like '%" . $tienda . "%'";

        $sWhere .= " order by id_pago DESC";

        include 'pagination.php'; //include pagination file
        //pagination variables
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
        $per_page = 10; //how much records you want to show
        $adjacents  = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $count_query = mysqli_query($conexion_tienda, "SELECT count(*) AS numrows FROM $tables where $sWhere ");
        if ($row = mysqli_fetch_array($count_query)) {
            $numrows = $row['numrows'];
        } else {
            echo mysqli_error($conexion_tienda);
        }
        $total_pages = ceil($numrows / $per_page);
        $reload = '../ver_cxc.php';
        //main query to fetch the data
        $query = mysqli_query($conexion_tienda, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
        //loop through fetched data

        if ($numrows > 0) {
        ?>

            <div class="table-responsive">
                <table class="table-sm table table-condensed table-hover table-striped ">
                    <tr class="text-center">
                        <th>Numero documento</th>
                        <th>Fecha</th>
                        <th>Valor</th>
                        <th>Forma de Pago</th>
                        <th>Recibo</th>
                    </tr>
                    <?php
                    $finales = 0;
                    while ($row = mysqli_fetch_array($query)) {
                        $id_pago = $row['id_pago'];
                        $numero_documento = $row['numero_documento'];
                        $fecha = $row['fecha'];
                        $valor = $row['valor'];
                        $forma_pago = $row['forma_pago'];
                        $url_factura = $row['imagen'];
                        $finales++;
                    ?>
                        <tr>
                            <td><?php echo $numero_documento; ?></td>
                            <td><?php echo $fecha; ?></td>
                            <td><?php echo $simbolo_moneda . ' ' . number_format($valor, 2); ?></td>
                            <td><?php echo $forma_pago; ?></td>
                            <?php if ($url_factura == '') {
                            ?>
                                <td>Sin recibos</td>
                            <?php
                            } else {
                            ?>
                                <td><a href="<?php echo $url_factura; ?>" target="_blank"><i class="fa fa-file-pdf-o"></i></a></td>
                            <?php
                            }
                            ?>

                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td colspan='5'>
                            <?php
                            $inicios = $offset + 1;
                            $finales += $inicios - 1;
                            echo "Mostrando $inicios al $finales de $numrows registros";
                            echo paginate($reload, $page, $total_pages, $adjacents);
                            ?>
                        </td>
                    </tr>
                </table>
            </div>


    <?php
        } else {
            echo "No hay pagos registrados";
        }
    }

    ?>