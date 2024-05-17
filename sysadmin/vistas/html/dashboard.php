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
$modulo = "Inicio";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$title  = "Inicio";
$Inicio = 1;
//Archivo de funciones PHP
// dominio mas protocolo
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';

$dominio_completo =     $protocol . $_SERVER['HTTP_HOST'];

$conexion_marketplace = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');

require_once "../funciones.php";
$usu            = $_SESSION['id_users'];
$users_users    = get_row('users', 'usuario_users', 'id_users', $usu);
$cargo_users    = get_row('users', 'cargo_users', 'id_users', $usu);
$nombre_users   = get_row('users', 'nombre_users', 'id_users', $usu);
$apellido_users = get_row('users', 'apellido_users', 'id_users', $usu);
$email_users    = get_row('users', 'email_users', 'id_users', $usu);


// Consulta ciudades con mayor despacho
$ciudades_despacho = [];


// Realizamos la consulta
$query_ciudades_despacho = mysqli_query($conexion, "SELECT ciudad, SUM(total_envios) AS total_envios, MAX(ciudad_codigo) AS ciudad_codigo FROM (
    SELECT COUNT(gl.ciudadD) AS total_envios, gl.ciudadD AS ciudad_codigo, cc.ciudad, 
    CASE 
        WHEN LENGTH(gl.ciudadD) = 3 THEN 'Sí' 
        ELSE 'No' 
    END AS es_otra_ciudad 
    FROM guia_laar gl 
    JOIN ciudad_cotizacion cc ON (LENGTH(gl.ciudadD) = 3 AND gl.ciudadD = cc.id_cotizacion) OR (LENGTH(gl.ciudadD) > 3 AND gl.ciudadD = cc.codigo_ciudad_laar) 
    WHERE gl.estado_guia NOT IN (9, 500, 501, 502, 503) 
      AND gl.ciudadO IS NOT NULL 
      AND gl.ciudadD != '' 
    GROUP BY gl.ciudadD, cc.ciudad, es_otra_ciudad 
) AS subquery 
GROUP BY ciudad 
ORDER BY total_envios DESC 
LIMIT 5");

// Verificamos si la consulta fue exitosa
if ($query_ciudades_despacho) {
    // Iteramos sobre cada fila del resultado
    while ($row = mysqli_fetch_assoc($query_ciudades_despacho)) {
        // Agregamos cada fila al array
        $ciudades_despacho[] = $row;
    }
} else {
    // Manejo de error en caso de que la consulta falle
    echo "Error: " . mysqli_error($conexion);
}



?>
<?php require 'includes/header_start.php'; ?>
<!-- grafico -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>
<style>
    .card-box {
        border-radius: 0.5rem !important;
    }

    .carousel-item {
        position: relative;
        width: 100%;
        height: 400px;
        /* o la altura que prefieras */
    }

    .carousel-item img {
        position: absolute;
        top: 50%;
        left: 50%;
        width: auto;
        /* Esto mantendrá la relación de aspecto de la imagen */
        height: auto;
        /* Esto mantendrá la relación de aspecto de la imagen */
        min-height: 100%;
        min-width: 100%;
        transform: translate(-50%, -50%);
        object-fit: cover;
        /* Esto cortará la parte extra de las imágenes */
    }

    canvas {
        height: auto;
        max-height: 100%;
        /* Asegúrate de que el canvas no sobrepase el tamaño del portlet-body */
    }

    .portlet-body {
        max-height: 400px;
        /* Ajusta este valor según lo que necesites */
        overflow-y: auto;
        /* Crea un desplazamiento vertical si el contenido supera el alto máximo */
    }

    /* Opcional: para asegurarse de que todas las cajas 'portlet' tengan el mismo tamaño */
    .portlet {
        display: flex;
        flex-direction: column;
    }

    .portlet-heading {
        flex-shrink: 0;
        /* Esto evita que el encabezado se contraiga */
    }

    .portlet-body {
        flex-grow: 1;
        /* Esto permite que el cuerpo de la caja crezca para ocupar el espacio disponible */
    }

    .portlet-fixed-height {
        height: 240px;
        /* Establece la altura deseada */
        display: flex;
        flex-direction: column;
    }

    .portlet-body-fixed-height {
        flex-grow: 1;
        /* Asegura que el cuerpo se expanda para llenar la caja */
        overflow-y: auto;
        /* Permite desplazamiento vertical si es necesario */
    }

    /* slider */
    .carousel-item::before {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0);
        /* Cambia el color y la opacidad según necesites */
        z-index: 1;
    }

    .carousel-item img {
        width: 100%;
        height: auto;
        display: block;
    }

    .carousel-caption {
        z-index: 2;
        /* Asegura que el texto está sobre la capa oscura */
        position: relative;
    }

    .carousel-item img {
        width: 100%;
        height: auto;
        /* mantiene la relación de aspecto */
        display: block;
        object-fit: cover;
        /* Asegura que la imagen cubra el área sin distorsionarse */
        max-height: 500px;
        /* Puedes ajustar esto según tus necesidades */
    }

    .carousel-caption h5 {
        font-size: 1.5rem;
        /* Tamaño por defecto */
    }

    .carousel-caption p {
        font-size: 1rem;
        /* Tamaño por defecto */
    }

    @media (max-width: 768px) {
        .carousel-caption h5 {
            font-size: 1rem;
            /* Más pequeño en dispositivos móviles */
        }

        .carousel-caption p {
            font-size: 0.8rem;
            /* Más pequeño en dispositivos móviles */
        }
    }

    #chart_div2 {
        min-width: 550px;
        /* Asegura un mínimo de ancho */
        min-height: 300px;
        /* Asegura un mínimo de altura */
    }

    /* reponsive*/
    body,
    html {
        margin: 0;
        padding: 0;
        width: 100%;
        overflow-x: hidden;
        /* Evita desbordamiento horizontal */
    }

    /* Estilo para la sección de información para que ocupe todo el ancho */
    .seccion_informacion {
        display: flex;
        flex-direction: row;
        width: 100%;
        /* Asegura que ocupe todo el ancho */
    }

    .fecha {
        width: 20% !important;
    }

    .seccion_cuadros_dashboard {
        display: flex;
        flex-direction: column;
        width: 40%;
    }

    .seccion_slider {
        width: 60%;
    }

    @media (max-width: 768px) {
        .seccion_informacion {
            flex-direction: column;
        }

        .fecha {
            width: 100% !important;
        }

        .seccion_cuadros_dashboard {
            width: 100%;
        }

        .seccion_slider {
            width: 100%;
        }
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
            <div class="container">
                <?php if ($permisos_ver == 1) {
                ?>
                    <div class="input-group fecha">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" onchange="cambiar()" class="form-control daterange pull-right" value="<?php echo  date('d/m/Y') . ' - ' . date('d/m/Y'); ?>" id="range" readonly>

                    </div>
                    <br>
                    <div class="seccion_informacion">
                        <div class="seccion_cuadros_dashboard">
                            <div class="d-flex flex-row">
                                <div class="col">

                                    <div class="widget-bg-color-icon card-box">
                                        <div class="bg-icon bg-icon-success pull-left">
                                            <i class="ti-receipt text-success"></i>
                                        </div>
                                        <div class="text-right">
                                            <?php
                                            $query = mysqli_query($conexion, "SELECT COUNT(*) as count FROM facturas_cot");
                                            $rw = mysqli_fetch_array($query);
                                            $total_ventas = $rw['count'];
                                            ?>
                                            <h5 class="text-dark"><b id="total_ventas" class="counter text-success"><?php echo $total_ventas; ?></b></h5>
                                            <p class="text-muted mb-0">Total Ventas</p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>

                                <div class="col">
                                    <a href="cxp.php">
                                        <div class="widget-bg-color-icon card-box">
                                            <div class="bg-icon bg-icon-success pull-left">
                                                <i class="ti-calendar text-success"></i>
                                            </div>
                                            <div class="text-right">
                                                <h5 class="text-dark text-center"><b id="total_pedido_filtro" class="counter text-success"><?php total_pedidos(date('d/m/Y'), date('d/m/Y')); ?></b></h5>
                                                <p class="text-muted mb-0">Total Pedidos</p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>



                            </div>


                            <div class="d-flex flex-row">

                                <div class="col">

                                    <div class="widget-bg-color-icon card-box">
                                        <div class="bg-icon bg-icon-warning pull-left">
                                            <i class="bx bx-receipt text-warning"></i>
                                        </div>
                                        <div class="text-right">
                                            <?php
                                            $query = mysqli_query($conexion, "SELECT COUNT(*) as count FROM guia_laar");
                                            $rw = mysqli_fetch_array($query);
                                            $total_guias = $rw['count'];
                                            ?>
                                            <h5 class="text-dark"><b id="total_guias" class="counter text-warning"><?php echo $total_guias; ?></b></h5>
                                            <p class="text-muted mb-0">Total Guias</p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>

                                <div class="col">

                                    <div class="widget-bg-color-icon card-box fadeInDown animated">
                                        <div class="bg-icon bg-icon-primary pull-left">
                                            <i class=" ti-wallet text-info"></i>
                                        </div>
                                        <div class="text-right">
                                            <?php
                                            $query = mysqli_query($conexion_marketplace, "SELECT 
                                        SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.total_venta ELSE 0 END) AS total_ventas,
                                        SUM(subquery.total_pendiente) AS total_pendiente, -- Se incluyen todas las facturas
                                        SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.total_cobrado ELSE 0 END) AS total_cobrado,
                                        SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.monto_recibir ELSE 0 END) AS monto_recibir
                                    FROM (
                                        SELECT 
                                            numero_factura, 
                                            MAX(total_venta) AS total_venta, 
                                            MAX(valor_pendiente) AS total_pendiente, 
                                            MAX(valor_cobrado) AS total_cobrado, 
                                            MAX(monto_recibir) AS monto_recibir
                                        FROM cabecera_cuenta_pagar 
                                        WHERE tienda = '$dominio_completo' 
                                            AND visto = '1'
                                        GROUP BY numero_factura
                                    ) AS subquery;");
                                            $rw = mysqli_fetch_array($query);
                                            $monto_ventas = $rw['total_ventas'];


                                            $query2 = mysqli_query($conexion_marketplace, "SELECT * FROM cabecera_cuenta_pagar WHERE visto = '1' and tienda like '$dominio_completo%' and numero_factura like 'Proveedor%'");
                                            $rw2 = mysqli_fetch_array($query2);


                                            if ($rw2) { // Verifica si hay al menos una fila
                                                $ganancias_proveedor = $rw2['monto_recibir'];
                                            } else {
                                                $ganancias_proveedor = 0; // Ajusta a 0 si no hay resultados
                                            }

                                            $total_recaudo = $monto_ventas + $ganancias_proveedor;
                                            $total_recaudo_formateado = number_format($total_recaudo, 2, '.', ',');
                                            ?>
                                            <h5 class="text-dark"><b id="total_recaudo" class="counter text-info">$ <?php echo $total_recaudo_formateado; ?></b></h5>
                                            <p class="text-muted mb-0">Total Recaudo</p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>


                            </div>

                            <div class="d-flex flex-row">
                                <div class="col">

                                    <div class="widget-bg-color-icon card-box">
                                        <div class="bg-icon bg-icon-purple pull-left">
                                            <i class="ti-truck text-purple"></i>
                                        </div>
                                        <div class="text-right">
                                            <?php
                                            $query = mysqli_query($conexion_marketplace, "SELECT 
                                            SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.total_venta ELSE 0 END) AS total_ventas,
                                            SUM(subquery.total_pendiente) AS total_pendiente, -- Se incluyen todas las facturas
                                            SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.total_cobrado ELSE 0 END) AS total_cobrado,
                                            SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.total_cobrado ELSE 0 END) AS total_cobrado,
                                            SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.monto_recibir ELSE 0 END) AS monto_recibir,
                                            (SELECT SUM(precio_envio) as total_fletes from cabecera_cuenta_pagar where visto =1 and tienda = '$dominio_completo') as total_fletes
                                            FROM (
                                                SELECT 
                                                numero_factura, 
                                                MAX(total_venta) AS total_venta, 
                                                MAX(valor_pendiente) AS total_pendiente, 
                                                MAX(valor_cobrado) AS total_cobrado, 
                                                MAX(monto_recibir) AS monto_recibir 
                                                FROM cabecera_cuenta_pagar 
                                                WHERE tienda = '$dominio_completo' 
                                                AND visto = '1'
                                                GROUP BY numero_factura
                                                ) AS subquery;");
                                            $rw = mysqli_fetch_array($query);
                                            $total_fletes = $rw['total_fletes'];
                                            $total_fletes_formateado = number_format($total_fletes, 2, '.', ',');
                                            ?>
                                            <h5 class="text-dark"><b id="total_fletes" class="counter text-purple">$ <?php echo $total_fletes_formateado; ?></b></h5>
                                            <p class="text-muted mb-0">Total Fletes</p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>

                                <div class="col">

                                    <div class="widget-bg-color-icon card-box fadeInDown animated">
                                        <div class="bg-icon bg-icon-danger pull-left">
                                            <i class=" ti-back-left text-danger"></i>
                                        </div>
                                        <div class="text-right">
                                            <?php
                                            $query = mysqli_query($conexion_marketplace, "SELECT 
                                             SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.total_venta ELSE 0 END) AS total_ventas,
                                             SUM(subquery.total_pendiente) AS total_pendiente, -- Se incluyen todas las facturas
                                             SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.total_cobrado ELSE 0 END) AS total_cobrado,
                                             SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.total_cobrado ELSE 0 END) AS total_cobrado,
                                             SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.monto_recibir ELSE 0 END) AS monto_recibir,
                                             (SELECT SUM(monto_recibir) as devolucion from cabecera_cuenta_pagar where visto =1 and estado_guia = 9 and tienda = '$dominio_completo') as devolucion
                                             FROM (
                                                SELECT 
                                                numero_factura, 
                                                MAX(total_venta) AS total_venta, 
                                                MAX(valor_pendiente) AS total_pendiente, 
                                                MAX(valor_cobrado) AS total_cobrado, 
                                                MAX(monto_recibir) AS monto_recibir 
                                                FROM cabecera_cuenta_pagar 
                                                WHERE tienda = '$dominio_completo' 
                                                AND visto = '1'
                                            GROUP BY numero_factura
                                             ) AS subquery;");
                                            $rw = mysqli_fetch_array($query);
                                            $total_devoluciones = $rw['devolucion'];
                                            $total_devoluciones_formateado = number_format($total_devoluciones, 2, '.', ',');
                                            ?>
                                            <h5 class="text-dark"><b id="devoluciones" class="counter text-danger">$ <?php echo $total_devoluciones_formateado; ?></b></h5>
                                            <p class="text-muted mb-0">Devoluciones</p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <!-- Slider infinito -->
                        <div class="slider seccion_slider" style="margin-bottom:20px; background-color:white;">
                            <div id="miSlider" class="carousel slide" data-ride="carousel">
                                <!-- Indicadores -->
                                <ol class="carousel-indicators">
                                    <?php
                                    $sql = "SELECT * FROM banner_marketplace";
                                    $result = $conexion_marketplace->query($sql);
                                    $i = 0;
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<li data-target="#miSlider" data-slide-to="' . $i . '"' . ($i == 0 ? ' class="active"' : '') . '></li>';
                                        $i++;
                                    }
                                    ?>
                                </ol>

                                <!-- Slides -->
                                <div class="carousel-inner">
                                    <?php
                                    $first = true;
                                    $result = $conexion_marketplace->query($sql); // Volver a ejecutar la consulta
                                    while ($row = $result->fetch_assoc()) {
                                        $banner = $row['fondo_banner'];
                                        $banner = "https://merkapro.ec/sysadmin/" . str_replace("../../", "", $banner);

                                        $alignment = ['1' => 'text-left', '2' => 'text-center', '3' => 'text-right'][$row['alineacion']] ?? 'text-center';
                                        echo '<div class="carousel-item' . ($first ? ' active' : '') . '">';
                                        echo '<img src="' . $banner . '" class="d-block w-100" alt="...">';
                                        echo '<div class="carousel-caption d-none d-md-block ' . $alignment . '">';
                                        echo '<h5 style="color: white;">' . $row['titulo'] . '</h5>';
                                        echo '<p style="color: white;">' . $row['texto_banner'] . '</p>';
                                        if (!empty($row['texto_boton'])) {
                                            echo '<a style="color: white; background-color: #171931; border-color: #171931;" href="' . $row['enlace_boton'] . '" class="btn btn-primary">' . $row['texto_boton'] . '</a>';
                                        }
                                        echo '</div></div>';
                                        $first = false;
                                    }
                                    ?>
                                </div>

                                <!-- Controles -->
                                <a class="carousel-control-prev" href="#miSlider" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Anterior</span>
                                </a>
                                <a class="carousel-control-next" href="#miSlider" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Siguiente</span>
                                </a>
                            </div>
                        </div>

                        <!-- Fin de Slider infinito -->
                    </div>
                    <!-- end row -->

                    <div class="seccion_informacion" style="padding-bottom: 50px;">

                        <div class="col-lg-4">
                            <div class="portlet portlet-fixed-height">
                                <div class="portlet-heading bg-purple">
                                    <h3 class="portlet-title">
                                        Ultimos Pedidos
                                    </h3>
                                    <div class="portlet-widgets">
                                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                        <span class="divider"></span>
                                        <a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary"><i class="ion-minus-round"></i></a>
                                        <span class="divider"></span>
                                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div id="bg-primary" class="panel-collapse collapse show">
                                    <div class="portlet-body portlet-fixed-height">
                                        <div class="table-responsive">
                                            <table class="table table-sm no-margin table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No. Pedido</th>
                                                        <th>Fecha</th>
                                                        <th class="text-center">Monto</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    ultimos_pedidos();
                                                    ?>
                                                </tbody>
                                                <div id="modal_cot"></div>
                                            </table>
                                        </div><!-- /.table-responsive -->
                                        <div class="box-footer clearfix">
                                            <a href="bitacora_cotizacion_new.php" class="btn btn-sm btn-danger btn-flat pull-right">Ver todas las Ventas</a>
                                        </div><!-- /.box-footer -->
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="card-box widget-user">
                                <div>
                                    <img src="../../assets/images/users/avatar-1.jpg" class="rounded-circle" alt="user">
                                    <div class="wid-u-info">
                                        <h5 class="mt-0 m-b-5 font-16">Mis Ventas del día</h5>
                                        <p class="text-muted m-b-5 font-16"><?php venta_users(); ?></p>
                                        <small class="text-warning"><b><?php echo $nombre_users . ' ' . $apellido_users ?></b></small>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div class="col-lg-4">
                            <div class="portlet portlet-fixed-height">
                                <div class="portlet-heading bg-purple">
                                    <h3 class="portlet-title">
                                        Ventas del ultimo Mes
                                    </h3>
                                    <div class="portlet-widgets">
                                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                        <span class="divider"></span>
                                        <a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary"><i class="ion-minus-round"></i></a>
                                        <span class="divider"></span>
                                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div id="bg-primary" class="panel-collapse collapse show">
                                    <div class="portlet-body portlet-fixed-height">
                                        <canvas id="salesChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4">
                            <div class="portlet portlet-fixed-height">
                                <div class="portlet-heading bg-purple">
                                    <h3 class="portlet-title">
                                        Visitas
                                    </h3>
                                    <div class="portlet-widgets">
                                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                        <span class="divider"></span>
                                        <a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary"><i class="ion-minus-round"></i></a>
                                        <span class="divider"></span>
                                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div id="bg-primary" class="panel-collapse collapse show">
                                    <div class="portlet-body portlet-fixed-height">
                                        <div class="table-responsive">
                                            <table class="table table-sm no-margin table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Pagina</th>

                                                        <th class="text-center">Visitas</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    visitas();
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div><!-- /.table-responsive -->

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="seccion_informacion">
                        <div class="d-flex flex-column" style="width: 35%;">
                            <div class="d-flex flex-row">
                                <div class="col">

                                    <div class="widget-bg-color-icon card-box">
                                        <div class="bg-icon bg-icon-success pull-left">
                                            <i class="ti-receipt text-success"></i>
                                        </div>
                                        <div class="text-right">
                                            <?php
                                            $query = mysqli_query($conexion_marketplace, "SELECT 
                                            SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.total_venta ELSE 0 END) AS total_ventas,
                                            SUM(subquery.total_pendiente) AS total_pendiente, -- Se incluyen todas las facturas
                                            SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.total_cobrado ELSE 0 END) AS total_cobrado,
                                            SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.total_cobrado ELSE 0 END) AS total_cobrado,
                                            SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.monto_recibir ELSE 0 END) AS monto_recibir,
                                            (SELECT SUM(total_venta) as ticket from cabecera_cuenta_pagar where visto =1 and estado_guia = 7 and tienda = '$dominio_completo') as ticket
                                            FROM (
                                               SELECT 
                                               numero_factura, 
                                               MAX(total_venta) AS total_venta, 
                                               MAX(valor_pendiente) AS total_pendiente, 
                                               MAX(valor_cobrado) AS total_cobrado, 
                                               MAX(monto_recibir) AS monto_recibir 
                                               FROM cabecera_cuenta_pagar 
                                               WHERE tienda = '$dominio_completo' 
                                               AND visto = '1'
                                           GROUP BY numero_factura
                                            ) AS subquery;");
                                            $rw = mysqli_fetch_array($query);
                                            $total_ventas = $rw['total_ventas'];
                                            $ticket_promedio = $rw['ticket'];

                                            // Calcular el porcentaje del ticket promedio del total de ventas
                                            if ($total_ventas > 0) {  // Asegurar que no haya división por cero
                                                $porcentaje_ticket = ($ticket_promedio / $total_ventas) * 100;
                                            } else {
                                                $porcentaje_ticket = 0; // Si total_ventas es 0, el porcentaje no puede calcularse
                                            }
                                            ?>
                                            <h5 class="text-dark"><b id="total_pedido_filtro" class="counter text-success"><?php echo  number_format($porcentaje_ticket, 2); ?> %</b></h5>
                                            <p class="text-muted mb-0">Ticket promedio</p>
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>

                                </div>
                                <div class="col">

                                    <div class="widget-bg-color-icon card-box">
                                        <div class="bg-icon bg-icon-purple pull-left">
                                            <i class="ti-dashboard text-purple"></i>
                                        </div>
                                        <div class="text-right">
                                            <h5 class="text-dark"><b class="counter text-purple"><?php total_cxc(); ?></b></h5>
                                            <p class="text-muted mb-0"> Fulfillment</p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>
                            </div>

                            <div class="d-flex flex-row" style="justify-content: center; height:95%;">
                                <div class="card-box" style="width: 95%;">
                                    <canvas id="ciudad_mas_despacho" style="height:200px !important; width:450px !important;"></canvas>
                                </div>

                            </div>
                        </div>


                        <div style="width: 65%;">
                            <div class="card-box" style="height: 95%;">
                                <h5 class="text-dark  header-title m-t-0 m-b-30">Grafica</h5>
                                <div class="d-flex flex-row">
                                    <div class="widget-chart text-center">
                                        <div class='row'>
                                            <div class='col-md-4'>

                                            </div>
                                        </div>
                                        <div id="chart_div3" style="height: 300px;"></div>
                                    </div>
                                    <div class="widget-chart text-center" style="width: 100%;">
                                        <div class='row'>
                                            <div class='col'>
                                                <select class="form-control" id="periodo2" onchange="drawVisualization2();">
                                                    <?php
                                                    for ($anio = (date("Y")); 2016 <= $anio; $anio--) {
                                                        echo "<option value=" . $anio . ">Período:" . $anio . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="chart_div2" style="height: 300px; width:55%"></div>

                                    </div>
                                    <!-- <div class="card-box" style="width: 95%;">
                                        <canvas id="productos_mas_salida" style="height:200px !important; width:450px !important;"></canvas>
                                    </div> -->
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Cambio de correo</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body mb-3 px-4">
                                    <span class="text-muted">
                                        <p class="text-justify">Estimado usuario, estamos transicionando hacia una nueva version, por lo cual hemos detectado que nos faltan algunos datos de tu empresa, recomandamos llenar los datos.</p>
                                    </span>
                                </div>
                                <div class="px-3">
                                    <form class="" onsubmit="modificar_email(event)">
                                        <div class="mb-3">
                                            <label for="email">Correo</label>
                                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                                        </div>
                                        <div class="mb-3">
                                            <label for="cedula">Cédula</label>
                                            <input type="text" class="form-control" id="cedula" aria-describedby="cedulaHelp">
                                        </div>
                                        <div class="mb-3">
                                            <label for="direccion">Dirección</label>
                                            <input type="text" class="form-control" id="direccion" aria-describedby="direccionHelp">
                                        </div>
                                        <div class="mb-3 d-grid">
                                            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDataLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modalDataLabel">Cambio de correo</h1>
                                </div>
                                <div class="modal-body mb-3 px-4">
                                    <span class="text-muted">
                                        <p class="text-justify">Estimado usuario, estamos transicionando hacia una nueva version, por lo cual hemos detectado que nos hace falta información de tu tienda.</p>
                                    </span>
                                </div>
                                <div class="px-3">
                                    <form class="" onsubmit="modificar_info(event)">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title">Información de la tienda</h5>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nombre">Nombre</label>
                                                            <input type="text" class="form-control" id="nombre">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="telefono">Teléfono</label>
                                                            <input type="text" class="form-control" id="telefono">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="correo">Correo</label>
                                                    <input type="text" class="form-control" id="correo">
                                                </div>
                                                <div class="form-group">
                                                    <label for="enlace">Enlace</label>
                                                    <input type="text" class="form-control" id="enlace">
                                                </div>
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>


                                </div>

                            </div>
                        </div>
                    </div>


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
            <!-- end container -->
        </div>
        <!-- end content -->

        <?php require 'includes/pie.php'; ?>

    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->


<?php require 'includes/footer_start.php'; ?>
<!-- ============================================================== -->
<!-- Todo el codigo js aqui-->
<!-- ============================================================== -->


<script>
    $(function() {
        load(1);

        //Date range picker
        $('.daterange').daterangepicker({
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-success',
            cancelClass: 'btn-default',
            locale: {
                format: "DD/MM/YYYY",
                separator: " - ",
                applyLabel: "Aplicar",
                cancelLabel: "Cancelar",
                fromLabel: "Desde",
                toLabel: "Hasta",
                customRangeLabel: "Custom",
                daysOfWeek: [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                monthNames: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                firstDay: 1
            },
            opens: "right"

        });
    });

    function load() {}



    function modificar_info(e) {
        e.preventDefault();
        var nombre = $("#nombre").val();
        var telefono = $("#telefono").val();
        var correo = $("#correo").val();
        var enlace = $("#enlace").val();
        $.ajax({
            type: 'POST',
            url: '../ajax/actualizar_info_tienda.php',
            contentType: 'application/json', // Especifica el tipo de contenido
            data: JSON.stringify({ // Convierte los datos a una cadena JSON
                nombre: nombre,
                telefono: telefono,
                correo: correo,
                enlace: enlace,
                action: 'ajax'
            }),
            dataType: 'json',
            async: false,
            success: function(response) {
                if (response.status == "actualizado") {
                    Swal.fire({
                        title: "¡Datos actualizados!",
                        text: "Se ha actualizado correctamente, por favor inicia sesión nuevamente.",
                        icon: "success",
                        textConfirm: "Aceptar",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = "../../login.php?logout";
                        }
                    })
                } else {
                    Swal.fire({
                        title: "¡Error!",
                        text: "No se ha podido actualizar los datos, por favor intente nuevamente.",
                        icon: "error",
                        textConfirm: "Aceptar",
                    })
                }
            }
        })
    }

    function cambiar() {
        var range = $("#range").val(); // Obtén el valor del input de rango de fechas
        var parametros = {
            "action": "ajax",
            'range': range
        };
        $("#loader").fadeIn('slow');
        $.ajax({
            url: '../ajax/rep_dashboard.php',
            data: parametros,
            beforeSend: function(objeto) {
                $("#loader").html("<img src='../../img/ajax-loader.gif'>");
            },
            success: function(data) {
                try {
                    var results = JSON.parse(data);
                    $("#total_pedido_filtro").html(results.total_pedidos);
                    $("#total_ventas").html(results.total_ventas);
                    $("#total_guias").html(results.total_guias);
                    $("#total_recaudo").html(results.total_recaudo);
                    $("#total_fletes").html(results.total_fletes);
                    $("#devoluciones").html(results.devoluciones);
                } catch (e) {
                    console.error("Error parsing response:", e);
                    console.log("Response data:", data);
                }
            }

        });
    }
</script>
<script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawVisualization2);
    google.charts.setOnLoadCallback(drawVisualization);

    function errorHandler(errorMessage) {
        //curisosity, check out the error in the console
        console.log(errorMessage);
        //simply remove the error, the user never see it
        google.visualization.errors.removeError(errorMessage.id);
    }

    function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var periodo = $("#periodo").val(); //Datos que enviaremos para generar una consulta en la base de datos
        var jsonData = $.ajax({
            url: 'chart.php',
            data: {
                'periodo': periodo,
                'action': 'ajax'
            },
            dataType: 'json',
            async: false
        }).responseText;

        var obj = jQuery.parseJSON(jsonData);
        var data = google.visualization.arrayToDataTable(obj);



        var options = {
            title: 'VENTAS VS COMPRAS' + periodo,
            vAxis: {
                title: 'Monto'
            },
            hAxis: {
                title: 'Meses'
            },
            seriesType: 'bars',
            series: {
                5: {
                    type: 'line'
                }
            }
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        google.visualization.events.addListener(chart, 'error', errorHandler);
        chart.draw(data, options);
    }

    // Haciendo los graficos responsivos
    jQuery(document).ready(function() {
        jQuery(window).resize(function() {
            drawVisualization();
        });
    });

    function drawVisualization2() {
        // Obtener datos del periodo
        var periodo = $("#periodo2").val(); // Datos que enviaremos para generar una consulta en la base de datos
        var jsonData = $.ajax({
            url: 'comparativa2.php',
            data: {
                'periodo': periodo,
                'action': 'ajax'
            },
            dataType: 'json',
            async: false
        }).responseText;

        // Convertir datos JSON a un objeto
        var obj = jQuery.parseJSON(jsonData);
        var data = google.visualization.arrayToDataTable(obj);

        // Opciones de configuración del gráfico
        var options = {
            title: 'PEDIDOS VS VENTAS ' + periodo, // Asegúrate de añadir un espacio después de 'VENTAS'
            vAxis: {
                title: 'Monto'
            },
            hAxis: {
                title: 'Meses'
            },
            seriesType: 'bars',
            series: {
                5: {
                    type: 'line'
                }
            },
            height: 300, // Altura en píxeles
            width: '55%' // Ancho como porcentaje
        };

        // Crear y dibujar el gráfico
        var chart = new google.visualization.ComboChart(document.getElementById('chart_div2'));
        google.visualization.events.addListener(chart, 'error', errorHandler);
        chart.draw(data, options);
    }




    function drawVisualization3() {
        $.ajax({
            url: 'comparativa3.php',
            data: {
                'action': 'ajax'
            },
            dataType: 'json',
            async: false,
            success: function(response) {
                // Carga la librería de Google Charts
                google.charts.load('current', {
                    'packages': ['corechart']
                });

                // Llama a la función para dibujar el gráfico de pastel cuando la librería esté lista
                google.charts.setOnLoadCallback(function() {
                    // Convierte los datos a un objeto DataTable
                    var data = google.visualization.arrayToDataTable(response);

                    // Opciones del gráfico de pastel
                    var options = {
                        title: 'Distribución de estados de guías de envío',
                    };

                    // Crea y dibuja el gráfico de pastel en el elemento con ID 'chart_div3'
                    var chart = new google.visualization.PieChart(document.getElementById('chart_div3'));
                    chart.draw(data, options);
                });
            }
        });
    }

    drawVisualization3();
</script>

<script>
    //dashboard ventan mensuales
    <?php
    $query_fecha = "SELECT fecha_factura, SUM(monto_factura) AS total_venta FROM facturas_cot WHERE fecha_factura >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) GROUP BY fecha_factura ORDER BY fecha_factura ASC";
    $result = mysqli_query($conexion, $query_fecha);

    $fechas = [];
    $ventas = [];
    while ($row_fecha = mysqli_fetch_assoc($result)) {
        $fechas[] = date('j M', strtotime($row_fecha['fecha_factura'])); // Formatea la fecha como '1 Nov'
        $ventas[] = $row_fecha['total_venta'];
    }
    ?>
    var fechas = <?php echo json_encode($fechas); ?>;
    var ventas = <?php echo json_encode($ventas); ?>;

    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: fechas, // Tus etiquetas de fecha aquí
            datasets: [{
                label: 'Ventas este mes',
                data: ventas, // Tus datos de ventas aquí
                fill: true, // Habilita el sombreado debajo de la línea
                backgroundColor: 'rgba(0, 123, 255, 0.2)', // Color de fondo con transparencia para el sombreado
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 2,
                tension: 0.3 // Suaviza las curvas de la línea
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Asegura que el gráfico se adapte al contenedor
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                zoom: {
                    pan: {
                        enabled: true,
                        mode: 'xy'
                    },
                    zoom: {
                        wheel: {
                            enabled: true
                        },
                        pinch: {
                            enabled: true
                        },
                        mode: 'xy'
                    }
                }
            }
        }
    });

    function ver_detalle_cot(numero_factura) {
        // alert(numero_factura)
        var parametros = {
            action: "ajax",
            numero_factura: numero_factura,
        };
        $.ajax({
            type: "POST",
            url: "../ajax/ver_detalle_cot.php",

            data: parametros,
            beforeSend: function(objeto) {
                $("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
            },
            success: function(data) {
                $("#loader").html("");
                $("#modal_cot").html(data);
                $("#Modal").modal("show");
            },
        });
    }

    // grafica mas despacho 

    var datosCiudades = <?php echo json_encode($ciudades_despacho); ?>;

    // Preparar arrays para labels y datos
    var labels = datosCiudades.map(function(item) {
        return item.ciudad;
    });
    var datos = datosCiudades.map(function(item) {
        return item.total_envios;
    });

    // Inicializamos el gráfico
    var canvas = document.getElementById('ciudad_mas_despacho');
    var ctx = canvas.getContext('2d');
    var ciudad_mas_despacho = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels, // Usamos las ciudades como etiquetas
            datasets: [{
                label: 'Ciudad con mas despacho',
                data: datos, // Usamos los totales de envíos como datos
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    //productos_mas_salida
    var canvas2 = document.getElementById('productos_mas_salida');
    canvas2.style.width = '350px';
    canvas2.style.height = '200px';
    canvas2.width = 350;
    canvas2.height = 200;

    var ctx2 = canvas2.getContext('2d');
    var productos_mas_salida = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Corn Flakes', 'Cheerios', 'Life', 'Kix'],
            datasets: [{
                label: 'Productos mas solicitados',
                data: [3, 5, 2, 6],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Define la escala de los ticks en el eje Y
                    }
                }
            }
        }
    });
</script>


<?php require 'includes/footer_end.php'
?>