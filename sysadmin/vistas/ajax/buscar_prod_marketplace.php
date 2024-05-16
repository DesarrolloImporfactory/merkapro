<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
/*-------------------------
Autor: Eduardo Vega
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
$conexion_marketplace = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');
// Configuracin de la base de datos de destino
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $destino = new mysqli('localhost', 'root', '', 'master');
} else {
    $destino = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');
}


//Archivo de funciones PHP
include "../funciones.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Productos";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {

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
    //$image_path = str_replace('../..', 'sysadmin', $image_path);

    $server_url = $protocol . $_SERVER['HTTP_HOST'];
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q            = mysqli_real_escape_string($destino, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $id_categoria = intval($_REQUEST['categoria']);
    $aColumns     = array('codigo_producto', 'nombre_producto'); //Columnas de busqueda
    $sTable       = "productos";
    $sWhere       = "where estado_producto =1 ";

    if ($id_categoria > 0) {
        $sWhere .= " and id_linea_producto = '" . $id_categoria . "' ";
    }
    if ($_GET['q'] != "") {
        $sWhere .= " and (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    $per_page  = 12; //how much records you want to show
    if (@$_GET['numero'] != "") {
        $per_page = $_GET['numero'];
    }
    if ($_GET['tienda'] !== "") {
        $sWhere .= " and tienda = '" . $_GET['tienda'] . "' ";
    }

    $sWhere .= " order by nombre_producto asc";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;

    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/

    $count_query = mysqli_query($destino, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../html/productos.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    //echo $sql;
    $query = mysqli_query($destino, $sql);
    //loop through fetched data
    if ($numrows > 0) {
        $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
?>
 <style>
.card {
    display: flex;
    flex-direction: column;
    height: 100%;
    margin: 10px;
    border: 1px solid #ccc; /* Opcional: agrega un borde sutil */
    border-radius: 8px; /* Opcional: bordes redondeados para una apariencia más suave */
}

.card-img-top {
    height: 150px;
    object-fit: cover;
    width: 100%;
}

.card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    flex-grow: 1; /* Permite que el cuerpo de la tarjeta crezca para llenar el espacio */
    padding: 10px;
}

.card-title, .card-text {
    font-size: 12px;
    margin-bottom: 5px; /* Espacio entre elementos del texto */
}

/* Mejora el estilo de los botones */
.btn {
    width: 100%; /* Hace que todos los botones ocupen todo el ancho */
    padding: 8px 0; /* Añade padding vertical para más visibilidad */
    margin-top: 5px; /* Espacio encima del primer botón */
    border-radius: 4px; /* Bordes redondeados para los botones */
    text-align: center; /* Asegura que el texto esté centrado */
    background-color: #007bff; /* Color de fondo para botones principales */
    color: white; /* Color de texto para botones principales */
    border: none; /* Elimina el borde predeterminado */
    cursor: pointer;
}

.btn:last-child {
    background-color: #ffc107; /* Color diferente para el último botón, opcional */
}

.card-text {
    overflow: hidden; /* Evita desbordamientos de texto */
    text-overflow: ellipsis; /* Pone puntos suspensivos si el texto es muy largo */
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3; /* Limita el texto a tres líneas */
}

.text-link {
    cursor: pointer; /* Hace el texto clickeable */
    color: #007bff; /* Color para simular un enlace */
}


 </style>
        <div class="row">
            <?php
            while ($row = mysqli_fetch_array($query)) {
                $id_producto          = $row['id_producto'];
                $codigo_producto      = $row['codigo_producto'];
                $nombre_producto      = $row['nombre_producto'];
                $descripcion_producto = $row['descripcion_producto'];
                $linea_producto       = $row['id_linea_producto'];
                $med_producto         = $row['id_med_producto'];
                $id_proveedor         = $row['id_proveedor'];
                $inv_producto         = $row['inv_producto'];
                $impuesto_producto    = $row['iva_producto'];
                $costo_producto       = $row['costo_producto'];
                $utilidad_producto    = $row['utilidad_producto'];
                $precio_producto      = $row['valor1_producto'];
                $precio_mayoreo       = $row['valor2_producto'];
                $precio_especial      = $row['valor3_producto'];
                $precio_normal        = $row['valor4_producto'];
                $stock_producto       = $row['stock_producto'];
                $stock_min_producto   = $row['stock_min_producto'];
                $tienda      = $row['tienda'];

                $id_producto_origen   = $row['id_producto_origen'];


                $online   = $row['pagina_web'];
                $status_producto      = $row['estado_producto'];
                $date_added           = date('d/m/Y', strtotime($row['date_added']));
                $image_path           = $row['image_path'];
                $url_a1          = $row['url_a1'];
                $url_a2           = $row['url_a2'];
                $url_a3           = $row['url_a3'];
                $url_a4          = $row['url_a4'];
                $url_a5          = $row['url_a5'];
                $id_imp_producto      = $row['id_imp_producto'];
                $formato      = $row['formato'];
                $tienda      = $row['tienda'];

                //  $texto_boton1      = $row['texto_boton'];
                // $texto_boton2      = $row['texto_boton2'];

                //  $descripcion1      = $row['descripcion'];
                // $descripcion2      = $row['descripcion2'];

                if ($status_producto == 1) {
                    $estado = "<span class='badge badge-success'>Activo</span>";
                } else {
                    $estado = "<span class='badge badge-danger'>Inactivo</span>";
                }
                //echo $online;
                if ($online == 1) {
                    $estado_online = "<span class='badge badge-success'>SI</span>";
                } else {
                    $estado_online = "<span class='badge badge-danger'>NO</span>";
                }
            ?>


                <div class="col-md-2">
    <div style="padding:10px" align="center" class="card caja">
        <?php
        if ($image_path == null) {
            echo '<img src="../../img_sistema/LOGOS-IMPORSUIT.jpg" class="formulario card-img-top">';
        } else {
            echo '<img src="' . $image_path . '" class="formulario card-img-top">';
        }
        ?>
        <div class="card-body">
            <h5 class="card-title"><strong><?php echo strtoupper($nombre_producto); ?></strong></h5>
            <p class="card-text">
                <strong>Stock:</strong> <?php echo stock($stock_producto); ?><br>
                <strong>Precio Proveedor:</strong> $ <?php echo number_format($costo_producto, 2, '.', ''); ?><br>
                <strong>Precio Sugerido:</strong> $ <?php echo number_format($precio_especial, 2, '.', ''); ?><br>
                <?php 
                $tienda_mostrar = str_replace('https://', '', $tienda);
                $tienda_mostrar = str_replace('http://', '', $tienda_mostrar);
                $tienda_mostrar = str_replace('.imporsuit.com', '', $tienda_mostrar);
                $tienda_mostrar = strtoupper($tienda_mostrar); 

                $server_url_mostrar = str_replace('https://', '', $server_url);
                $server_url_mostrar = str_replace('http://', '', $server_url_mostrar);
                $server_url_mostrar = str_replace('.imporsuit.com', '', $server_url_mostrar);
                $server_url_mostrar = strtoupper($server_url_mostrar);
                ?>
                <strong>Proveedor:</strong> <?php echo $tienda_mostrar ?>
            </p>
            <span style="font-size: 12px" class="text-link" onclick="abrirModalTienda('<?php echo $tienda; ?>')" data-bs-toggle="modal" data-bs-target="#tiendaModal"><strong>Proveedor:</strong> <?php echo $tienda_mostrar ?></span>
            <!-- modal proveedor -->
            <div class="modal fade" id="tiendaModal" tabindex="-1" aria-labelledby="tiendaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tiendaModalLabel">Información de la Tienda</h5>
                            <button type="button" class="btn-close" onclick="cerrarModal()" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="boody">
                            <p id="modalContent">Aquí va la información de la tienda.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="cerrarModal()" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fin modal proveedor -->
            <div class="d-flex gap-3 justify-content-center">
                <a data-toggle="modal" style="width: 100%" data-target="#editarProducto" onclick="obtener_datos('<?php echo $id_producto; ?>');carga_img('<?php echo $id_producto; ?>');" class="btn bg-info text-white formulario">Descripcion</a>
               </div>
            <div class="d-flex gap-3 justify-content-center">
                <?php
                if ($tienda_mostrar != $server_url_mostrar) {
                    echo "<a class='btn btn-primary formulario' style='width: 100%' href='../ajax/importar.php?id=$id_producto' title='Importar' onclick='recibir($id_producto)'>Importar</a>";
                } else {
                    echo "<a class='btn btn-warning formulario' style='width: 100%' target='_blank' href='nueva_cotizacion_1.php?id=local&id_producto=$id_producto_origen&precio_importacion=$precio_especial' title='Guia' onclick='recibir($id_producto)'>Generar Guía</a>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

                <input type="hidden" value="<?php echo $online; ?>" id="online<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $codigo_producto; ?>" id="codigo_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $nombre_producto; ?>" id="nombre_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo @$descripcion_producto; ?>" id="descripcion_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $linea_producto; ?>" id="linea_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $id_proveedor; ?>" id="proveedor_producto<?php echo $id_producto; ?>">
                <!--<input type="hidden" value="<?php echo $med_producto; ?>" id="med_producto<?php echo $id_producto; ?>">-->
                <input type="hidden" value="<?php echo $inv_producto; ?>" id="inv_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $impuesto_producto; ?>" id="impuesto_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $stock_producto; ?>" id="stock_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $stock_min_producto; ?>" id="stock_min_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $status_producto; ?>" id="estado<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo number_format($costo_producto, 2, '.', ''); ?>" id="costo_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $utilidad_producto; ?>" id="utilidad_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo number_format($precio_producto, 2, '.', ''); ?>" id="precio_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo number_format($precio_mayoreo, 2, '.', ''); ?>" id="precio_mayoreo<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo number_format($precio_especial, 2, '.', ''); ?>" id="precio_especial<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo number_format($precio_normal, 2, '.', ''); ?>" id="precio_normal<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $id_imp_producto; ?>" id="id_imp_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $formato; ?>" id="formato<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $url_a1; ?>" id="url_a1<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $url_a2; ?>" id="url_a2<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $url_a3; ?>" id="url_a3<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $url_a4; ?>" id="url_a4<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $url_a5; ?>" id="url_a5<?php echo $id_producto; ?>">

                <input type="hidden" value="<?php echo $url1; ?>" id="url1<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $texto_boton1; ?>" id="texto_boton1<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $descripcion1; ?>" id="descripcion1<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $url2; ?>" id="url2<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $texto_boton2; ?>" id="texto_boton2<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $descripcion2; ?>" id="descripcion2<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $image_path; ?>" id="image_path<?php echo $id_producto; ?>">

                <?php

                $count_tienda = mysqli_query($conexion_marketplace, "SELECT * FROM plataformas WHERE url_imporsuit LIKE '%" . $tienda ."%'");
                $row_tienda         = mysqli_fetch_array($count_tienda);
                $telefono_tienda    = @$row_tienda['whatsapp'];
                $telefonoFormateado = formatPhoneNumber($telefono_tienda);

                ?>

                <input type="hidden" value="<?php echo $telefonoFormateado; ?>" id="telefono_tienda<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $tienda; ?>" id="tienda<?php echo $id_producto; ?>">
            <?php
            }
            ?>
            </br>

        </div>
        <div class="row">
            <div class="col-md-12">
                <table style="width: 100%">
                    <tr>
                        <td colspan="1" style="text-align: right; width: 60%">

                        <td colspan="12" style="text-align: right;">
                            <span>
                                <?php
                                echo paginate($reload, $page, $total_pages, $adjacents);
                                ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="alert alert-warning alert-dismissible" role="alert" align="center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Aviso!</strong> No hay Registro de Producto
        </div>
<?php
    }
    // fin else
}

function formatPhoneNumber($number)
{
    // Eliminar caracteres no numéricos excepto el signo +
    $number = preg_replace('/[^\d+]/', '', $number);

    // Verificar si el número ya tiene el código de país +593
    if (preg_match('/^\+593/', $number)) {
        // El número ya está correctamente formateado con +593
        return $number;
    } elseif (preg_match('/^593/', $number)) {
        // El número tiene 593 al inicio pero le falta el +
        return '+' . $number;
    } else {
        // Si el número comienza con 0, quitarlo
        if (strpos($number, '0') === 0) {
            $number = substr($number, 1);
        }
        // Agregar el código de país +593 al inicio del número
        $number = '+593' . $number;
    }

    return $number;
}


?>