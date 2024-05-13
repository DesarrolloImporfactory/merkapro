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
$modulo = "Integraciones";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
/*$count      = mysqli_query($conexion, "select MAX(codigo_producto) as codigo from productos");
$rw         = mysqli_fetch_array($count);
$product_id = $rw['codigo'] + 1;
//consulta para elegir el impuesto en la modal
$query    = $conexion->query("select * from impuestos");
$impuesto = array();
while ($r = $query->fetch_object()) {
    $impuesto[] = $r;
}
*/

$query_empresa = mysqli_query($conexion, "select * from perfil where id_perfil=1");
$row_perfil           = mysqli_fetch_array($query_empresa);

$obtener_conexion_dropi = "SELECT * FROM dropi";
$respuesta = mysqli_query($conexion, $obtener_conexion_dropi);
$respuesta = mysqli_fetch_row($respuesta);
?>
<?php require 'includes/header_start.php'; ?>

<?php require 'includes/header_end.php'; ?>

<!-- Begin page -->
<div id="wrapper" class="forced enlarged"> <!-- DESACTIVA EL MENU -->

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
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="row">
                                <div class="col bg-white rounded-5 shadow-xl m-3 py-3 px-4">
                                    <div class="grid items-center">

                                        <img src="https://cdn.icon-icons.com/icons2/836/PNG/512/Shopify_icon-icons.com_66757.png" width="30px" alt="img">
                                        <h3 class="text-left font-bold">Shopify
                                    </div>

                                    </h3>
                                    <p>Añade automaticamente tus pedidos de shopify con nuestra api.</p>
                                    <div class="d-flex flex-column gap-1">
                                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#Shopify">
                                            Conectar
                                        </button>
                                        
                                    </div>
                                </div>
                                <div class="col bg-white rounded-5 shadow-xl m-3 py-3 px-4">
                                    <div class="d-flex flex-row items-center">
                                        <img src="https://cdn.icon-icons.com/icons2/2429/PNG/512/facebook_logo_icon_147291.png" width="30px" alt="img">
                                        <h3 class="text-left font-bold">Facebook</h3>
                                        <div class="ml-auto d-flex">
                                            <?php
                                            $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM pixel  where id_pixel=1");
                                            $row         = mysqli_fetch_array($count_query);
                                            $numrows     = $row['numrows'];

                                            if ($numrows == 0) {
                                            ?>
                                                <div class="items-center d-flex flex-column justify-content-end">
                                                    <div class="items-center d-flex flex-column">
                                                        <img src="https://cdn.icon-icons.com/icons2/259/PNG/128/ic_remove_circle_outline_128_28748.png" class="justify-content-center" width="20px" alt="img">
                                                        <p class="text-right font-bold fs-9">Desconectado</p>
                                                    </div>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="items-center d-flex flex-column justify-content-end">
                                                    <div class="items-center d-flex flex-column">
                                                        <img src="https://cdn.icon-icons.com/icons2/894/PNG/512/Tick_Mark_Circle_icon-icons.com_69145.png" class="justify-content-center" width="20px" alt="img">
                                                        <p class="text-right font-bold fs-9 text-success">Conectado</p>
                                                    </div>
                                                </div>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                    <p>Manten actualizadas tus campañas con nuestra api.</p>
                                    <div class="d-flex flex-column gap-1">
                                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#facebook">
                                            Conectar
                                        </button>
                                        <!-- <a href="#" class="btn btn-outline-danger">Ver Video</a> -->
                                    </div>
                                </div>
                                <div class="col bg-white rounded-5 shadow-xl m-3 py-3 px-4">
                                    <div class="d-flex flex-row">
                                        <div class="grid items-center">
                                            <img src="https://marketplace.imporsuit.com/sysadmin/img/dropi.jpeg" width="30px" alt="img">
                                            <h3 class="text-left font-bold">Dropi
                                        </div>
                                        <?php
                                        if (empty($respuesta)) {
                                        ?>
                                            <div class="items-rigth d-flex flex-row">
                                                <div class="items-center d-flex flex-column">
                                                    <img src="https://cdn.icon-icons.com/icons2/259/PNG/128/ic_remove_circle_outline_128_28748.png" class="justify-content-center" width="20px" alt="img">
                                                    <p class="text-right font-bold fs-9">Desconectado</p>
                                                </div>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="items-rigth d-flex flex-row">
                                                <div class="items-center d-flex flex-column">
                                                    <img src="https://cdn.icon-icons.com/icons2/894/PNG/512/Tick_Mark_Circle_icon-icons.com_69145.png" class="justify-content-center" width="20px" alt="img">
                                                    <p class="text-right font-bold fs-9 text-success">Conectado</p>
                                                </div>
                                            </div>
                                        <?php
                                        } ?>
                                    </div>
                                    </h3>
                                    <p>Mantente informado y actualizado de tus productos en Dropi con nuestra api.</p>
                                    <div class="d-flex flex-column gap-1">
                                        <?php
                                        if (empty($respuesta)) {
                                        ?>
                                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#Dropi">
                                                Conectar
                                            </button>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="marketplace_dropi.php" class="btn btn-outline-primary">Productos</a>

                                            <button type="button" class="btn btn-outline-danger" id="Dropi_cerrar_sesion">
                                                Cerrar Sesión
                                            </button>
                                        <?php
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col bg-white rounded-5 shadow-xl m-3 py-3 px-4">
                                    <div class="d-flex flex-row">
                                        <div class="grid items-center">
                                            <img src="https://www.gob.ec/sites/default/files/styles/medium/public/2023-05/logo.png?itok=PpIW0csl" width="65px" alt="img">
                                            <h5 class="text-left font-bold">Facturación Electrónica
                                        </div>
                                        <?php
                                        if ((empty($row_perfil[19]))) {
                                        ?>
                                            <div class="items-rigth d-flex flex-row">
                                                <div class="items-center d-flex flex-column">
                                                    <img src="https://cdn.icon-icons.com/icons2/259/PNG/128/ic_remove_circle_outline_128_28748.png" class="justify-content-center" width="20px" alt="img">
                                                    <p class="text-right font-bold fs-9">Firma</p>
                                                </div>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="items-rigth d-flex flex-row">
                                                <div class="items-center d-flex flex-column">
                                                    <img src="https://cdn.icon-icons.com/icons2/894/PNG/512/Tick_Mark_Circle_icon-icons.com_69145.png" class="justify-content-center" width="20px" alt="img">
                                                    <p class="text-right font-bold fs-9 text-success">Firma</p>
                                                </div>
                                            </div>
                                        <?php
                                        } ?>
                                    </div>
                                    </h3>
                                    <p>Configura los datos de tu empresa para la facturación electrónica con el SRI.</p>
                                    <div class="d-flex flex-column gap-1">
                                        <a href="../html/empresa.php" class="btn btn-outline-primary">Editar Perfil</a>
                                    </div>
                                </div>
                                <div class="col bg-white rounded-5 shadow-xl m-3 py-3 px-4">
                                    <div class="d-flex flex-row items-center">

                                        <img src="https://extensions.vtexassets.com/arquivos/ids/156903-800-auto?v=637443260613970000&width=800&height=auto&aspect=true" width="50px" alt="img">
                                        <h3 class="text-left font-bold">Google Tag Manager</h3>
                                        <div class="ml-auto d-flex">
                                            <?php
                                            $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM pixel  where id_pixel=2");
                                            $row         = mysqli_fetch_array($count_query);
                                            $numrows     = $row['numrows'];

                                            if ($numrows == 0) {
                                            ?>
                                                <div class="items-center d-flex flex-column justify-content-end">
                                                    <div class="items-center d-flex flex-column">
                                                        <img src="https://cdn.icon-icons.com/icons2/259/PNG/128/ic_remove_circle_outline_128_28748.png" class="justify-content-center" width="20px" alt="img">
                                                        <p class="text-right font-bold fs-9">Desconectado</p>
                                                    </div>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="items-center d-flex flex-column justify-content-end">
                                                    <div class="items-center d-flex flex-column">
                                                        <img src="https://cdn.icon-icons.com/icons2/894/PNG/512/Tick_Mark_Circle_icon-icons.com_69145.png" class="justify-content-center" width="20px" alt="img">
                                                        <p class="text-right font-bold fs-9 text-success">Conectado</p>
                                                    </div>
                                                </div>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                    <p>Manten actualizadas tus campañas con nuestra api.</p>
                                    <div class="d-flex flex-column gap-1">
                                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#google_tag">
                                            Conectar
                                        </button>

                                    </div>
                                </div>
                                <div class="col bg-white rounded-5 shadow-xl m-3 py-3 px-4">
                                    <div class="d-flex flex-row items-center">

                                        <img src="https://fineproxy.org/wp-content/uploads/2023/07/analytics.google.com_logo.png" width="50px" alt="img">
                                        <h3 class="text-left font-bold">Google Analytics</h3>
                                        <div class="ml-auto d-flex">
                                            <?php
                                            $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM pixel  where id_pixel=3");
                                            $row         = mysqli_fetch_array($count_query);
                                            $numrows     = $row['numrows'];

                                            if ($numrows == 0) {
                                            ?>
                                                <div class="items-center d-flex flex-column justify-content-end">
                                                    <div class="items-center d-flex flex-column">
                                                        <img src="https://cdn.icon-icons.com/icons2/259/PNG/128/ic_remove_circle_outline_128_28748.png" class="justify-content-center" width="20px" alt="img">
                                                        <p class="text-right font-bold fs-9">Desconectado</p>
                                                    </div>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="items-center d-flex flex-column justify-content-end">
                                                    <div class="items-center d-flex flex-column">
                                                        <img src="https://cdn.icon-icons.com/icons2/894/PNG/512/Tick_Mark_Circle_icon-icons.com_69145.png" class="justify-content-center" width="20px" alt="img">
                                                        <p class="text-right font-bold fs-9 text-success">Conectado</p>
                                                    </div>
                                                </div>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                    <p>Manten actualizadas tus campañas con nuestra api.</p>
                                    <div class="d-flex flex-column gap-1">
                                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#google_analytics">
                                            Conectar
                                        </button>

                                    </div>
                                </div>

                            </div>
                            <div class="row" style="width: 100%;">
                                <div class="col bg-white rounded-5 shadow-xl m-3 py-3 px-4">
                                    <div class="d-flex flex-row items-center">

                                        <img src="https://cdn.pixabay.com/photo/2021/06/15/12/28/tiktok-6338432_640.png" width="40px" alt="img">
                                        <h3 class="text-left font-bold">Tiktok</h3>
                                        <div class="ml-auto d-flex">
                                            <?php
                                            $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM pixel  where id_pixel=4");
                                            $row         = mysqli_fetch_array($count_query);
                                            $numrows     = $row['numrows'];

                                            if ($numrows == 0) {
                                            ?>
                                                <div class="items-center d-flex flex-column justify-content-end">
                                                    <div class="items-center d-flex flex-column">
                                                        <img src="https://cdn.icon-icons.com/icons2/259/PNG/128/ic_remove_circle_outline_128_28748.png" class="justify-content-center" width="20px" alt="img">
                                                        <p class="text-right font-bold fs-9">Desconectado</p>
                                                    </div>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="items-center d-flex flex-column justify-content-end">
                                                    <div class="items-center d-flex flex-column">
                                                        <img src="https://cdn.icon-icons.com/icons2/894/PNG/512/Tick_Mark_Circle_icon-icons.com_69145.png" class="justify-content-center" width="20px" alt="img">
                                                        <p class="text-right font-bold fs-9 text-success">Conectado</p>
                                                    </div>
                                                </div>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                    <p>Manten actualizadas tus campañas con nuestra api.</p>
                                    <div class="d-flex flex-column gap-1">
                                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#tiktok">
                                            Conectar
                                        </button>

                                    </div>
                                </div>

                                <div class="col bg-white rounded-5 shadow-xl m-3 py-3 px-4">
                                    <div class="d-flex flex-row items-center">

                                        <img src="https://static.vecteezy.com/system/resources/previews/031/737/215/non_2x/twitter-new-logo-twitter-icons-new-twitter-logo-x-2023-x-social-media-icon-free-png.png" width="50px" alt="img">
                                        <h3 class="text-left font-bold">X</h3>
                                        <div class="ml-auto d-flex">
                                            <?php
                                            $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM pixel  where id_pixel=5");
                                            $row         = mysqli_fetch_array($count_query);
                                            $numrows     = $row['numrows'];

                                            if ($numrows == 0) {
                                            ?>
                                                <div class="items-center d-flex flex-column justify-content-end">
                                                    <div class="items-center d-flex flex-column">
                                                        <img src="https://cdn.icon-icons.com/icons2/259/PNG/128/ic_remove_circle_outline_128_28748.png" class="justify-content-center" width="20px" alt="img">
                                                        <p class="text-right font-bold fs-9">Desconectado</p>
                                                    </div>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="items-center d-flex flex-column justify-content-end">
                                                    <div class="items-center d-flex flex-column">
                                                        <img src="https://cdn.icon-icons.com/icons2/894/PNG/512/Tick_Mark_Circle_icon-icons.com_69145.png" class="justify-content-center" width="20px" alt="img">
                                                        <p class="text-right font-bold fs-9 text-success">Conectado</p>
                                                    </div>
                                                </div>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                    <p>Manten actualizadas tus campañas con nuestra api.</p>
                                    <div class="d-flex flex-column gap-1">
                                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#X">
                                            Conectar
                                        </button>

                                    </div>
                                </div>

                                <div class="col bg-white rounded-5 shadow-xl m-3 py-3 px-4">
                                    <div class="d-flex flex-row items-center">

                                        <img src="https://clarity.microsoft.com/blog/wp-content/uploads/2022/02/256X256.png" width="50px" alt="img">
                                        <h3 class="text-left font-bold">Clarity</h3>
                                        <div class="ml-auto d-flex">
                                            <?php
                                            $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM pixel  where id_pixel=6");
                                            $row         = mysqli_fetch_array($count_query);
                                            $numrows     = $row['numrows'];

                                            if ($numrows == 0) {
                                            ?>
                                                <div class="items-center d-flex flex-column justify-content-end">
                                                    <div class="items-center d-flex flex-column">
                                                        <img src="https://cdn.icon-icons.com/icons2/259/PNG/128/ic_remove_circle_outline_128_28748.png" class="justify-content-center" width="20px" alt="img">
                                                        <p class="text-right font-bold fs-9">Desconectado</p>
                                                    </div>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="items-center d-flex flex-column justify-content-end">
                                                    <div class="items-center d-flex flex-column">
                                                        <img src="https://cdn.icon-icons.com/icons2/894/PNG/512/Tick_Mark_Circle_icon-icons.com_69145.png" class="justify-content-center" width="20px" alt="img">
                                                        <p class="text-right font-bold fs-9 text-success">Conectado</p>
                                                    </div>
                                                </div>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                    <p>Manten actualizadas tus campañas con nuestra api.</p>
                                    <div class="d-flex flex-column gap-1">
                                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#clarity">
                                            Conectar
                                        </button>

                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="facebook" tabindex="-1" role="dialog" aria-labelledby="facebookLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center" id="facebookLabel">Conectar con Facebook</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="mb-3" onsubmit="conectar_pixel(event)">

                                                <span class="mb-5">
                                                    Introduce tu ID de píxel de Facebook para hacer un seguimiento de las acciones que tus clientes realizan mientras visitan tu sitio web
                                                </span>
                                                <span class="mb-5 font-bold"> <br> Facebook Pixel ID</span>
                                                <div class="form-group mb-3">

                                                    <input type="text" id="pixel" name="pixel" class="form-control" placeholder="ID de píxel de Facebook">
                                                </div>
                                                <span class="mb-2">
                                                    <a href="https://www.facebook.com/business/help/952192354843755?id=1205376682832142" target="_blank">¿Dónde puedo encontrar mi ID de píxel de Facebook?</a>

                                                </span>
                                                <span class="mb-5 d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-success mt-5">
                                                        Conectar
                                                    </button>
                                                </span>

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="Shopify" tabindex="-1" role="dialog" aria-labelledby="ShopifyLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ShopifyLabel">Conectar con Shopify</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            $url_actual = "https://" . $_SERVER["HTTP_HOST"];

                                            ?>
                                            Ingresa la siguiente url en tu tienda de shopify: <br>
                                            <input type="text" class="form-control" value="<?php echo $url_actual; ?>/sysadmin/api/integracion/Shopify" readonly>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Dropi-->
                            <div class="modal fade" id="Dropi" tabindex="-1" role="dialog" aria-labelledby="ShopifyLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row d-flex justify-content-center align-items-center">
                                                <div class="col">
                                                    <div class="card" style="border-radius: 1rem;">
                                                        <div class="align-items-center">
                                                            <div class="card-body p-4 p-lg-5 text-black">
                                                                <form id="login_dropi">
                                                                    <select class="form-select" id="select_pais" style="width:75px" name="owner" aria-label="Default select example">
                                                                        <option selected="selected" value="EC">🇪🇨</option>
                                                                        <option value="CO">🇨🇴</option>
                                                                        <option value="MX">🇲🇽</option> <!-- Mexico-->
                                                                        <option value="CL">🇨🇱</option> <!-- Chile-->
                                                                        <option value="PA">🇵🇦</option> <!-- Panama-->
                                                                        <option value="PE">🇵🇪</option> <!-- Peru-->
                                                                        <option value="ES">🇪🇸</option> <!-- España-->
                                                                        <option value="PT">🇵🇹</option> <!-- Portugal-->
                                                                    </select> 
                                                                    <div class="d-flex justify-content-center mb-3 pb-1">
                                                                        <img src="https://marketplace.imporsuit.com/sysadmin/img/dropi.jpeg" width="50px" alt="img">
                                                                        <span class="h1 fw-bold mb-0"> Dropi</span>
                                                                    </div>

                                                                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Iniciar sesión</h5>

                                                                    <div class="form-outline mb-4">
                                                                        <label class="form-label" for="correo">Email</label>
                                                                        <input type="email" id="correo" name="correo" class="form-control form-control-lg" />

                                                                    </div>

                                                                    <div class="form-outline mb-4">
                                                                        <label class="form-label" for="contrasena">Contraseña</label>
                                                                        <input type="password" id="contrasena" name="contrasena" class="form-control form-control-lg" />

                                                                    </div>

                                                                    <div class="pt-1 mb-4">
                                                                        <button class="btn btn-dark btn-lg btn-block" type="submit">Iniciar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Final Modal Dropi-->
                            </div>
                            <!-- Modal Google Tag-->
                            <div class="modal fade" id="google_tag" tabindex="-1" role="dialog" aria-labelledby="google_tagLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center" id="google_tagLabel">Conectar con Google Tag Manager</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="googleTagForm" class="mb-3 pixelForm">

                                                <span class="mb-5">
                                                    Introduce tu Script de píxel de Google Tag Manager
                                                </span>
                                                <span class="mb-5 font-bold"> <br> Google Tag Manager Pixel</span>
                                                <div class="form-group mb-3">
                                                    <?php
                                                    $count_query = mysqli_query($conexion, "SELECT pixel, count(*) AS numrows FROM pixel  where id_pixel=2");
                                                    $row         = mysqli_fetch_array($count_query);
                                                    $numrows     = $row['numrows'];
                                                    $pixel       = htmlspecialchars($row['pixel']); // Escapa el contenido para hacerlo seguro en HTML

                                                    if ($numrows == 0) {
                                                    ?>
                                                        <textarea class="form-control" id="pixel_googleTag" name="pixel_googleTag" autocomplete="off" style="height: 110px;">Script de píxel de Google Tag Manager</textarea>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <textarea class="form-control" id="pixel_googleTag" name="pixel_googleTag" autocomplete="off" style="height: 110px;"><?php echo $pixel; ?></textarea>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <span class="mb-5 d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-success mt-5">
                                                        Conectar
                                                    </button>
                                                </span>

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Modal Google Tag-->

                            <!-- Modal Google Analytics-->
                            <div class="modal fade" id="google_analytics" tabindex="-1" role="dialog" aria-labelledby="google_analyticsLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center" id="google_analyticsLabel">Conectar con Google Analytics</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="googleAnalyticsForm" class="mb-3 pixelForm">

                                                <span class="mb-5">
                                                    Introduce tu Script de píxel de Google Analytics
                                                </span>
                                                <span class="mb-5 font-bold"> <br> Google Analytics Pixel</span>
                                                <div class="form-group mb-3">
                                                    <?php
                                                    $count_query = mysqli_query($conexion, "SELECT pixel, count(*) AS numrows FROM pixel  where id_pixel=3");
                                                    $row         = mysqli_fetch_array($count_query);
                                                    $numrows     = $row['numrows'];
                                                    $pixel       = htmlspecialchars($row['pixel']); // Escapa el contenido para hacerlo seguro en HTML

                                                    if ($numrows == 0) {
                                                    ?>
                                                        <textarea class="form-control" id="pixel_googleTag" name="pixel_googleTag" autocomplete="off" style="height: 110px;">Script de píxel de Google Analytics</textarea>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <textarea class="form-control" id="pixel_googleTag" name="pixel_googleTag" autocomplete="off" style="height: 110px;"><?php echo $pixel; ?></textarea>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <span class="mb-5 d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-success mt-5">
                                                        Conectar
                                                    </button>
                                                </span>

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Modal Google Analytics-->
                            <!-- Modal Tiktok-->
                            <div class="modal fade" id="tiktok" tabindex="-1" role="dialog" aria-labelledby="tiktokLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center" id="tiktokLabel">Conectar con Tiktok</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="tiktokForm" class="mb-3 pixelForm">

                                                <span class="mb-5">
                                                    Introduce tu Script de píxel de Tiktok
                                                </span>
                                                <span class="mb-5 font-bold"> <br> Tiktok Pixel</span>
                                                <div class="form-group mb-3">
                                                    <?php
                                                    $count_query = mysqli_query($conexion, "SELECT pixel, count(*) AS numrows FROM pixel  where id_pixel=4");
                                                    $row         = mysqli_fetch_array($count_query);
                                                    $numrows     = $row['numrows'];
                                                    $pixel       = htmlspecialchars($row['pixel']); // Escapa el contenido para hacerlo seguro en HTML

                                                    if ($numrows == 0) {
                                                    ?>
                                                        <textarea class="form-control" id="pixel_googleTag" name="pixel_googleTag" autocomplete="off" style="height: 110px;">Script de píxel de Tiktok</textarea>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <textarea class="form-control" id="pixel_googleTag" name="pixel_googleTag" autocomplete="off" style="height: 110px;"><?php echo $pixel; ?></textarea>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <span class="mb-5 d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-success mt-5">
                                                        Conectar
                                                    </button>
                                                </span>

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Modal Tiktok-->
                            <!-- Modal X-->
                            <div class="modal fade" id="X" tabindex="-1" role="dialog" aria-labelledby="XLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center" id="XLabel">Conectar con X</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="XForm" class="mb-3 pixelForm">

                                                <span class="mb-5">
                                                    Introduce tu Script de píxel de X
                                                </span>
                                                <span class="mb-5 font-bold"> <br> X Pixel</span>
                                                <div class="form-group mb-3">
                                                    <?php
                                                    $count_query = mysqli_query($conexion, "SELECT pixel, count(*) AS numrows FROM pixel  where id_pixel=5");
                                                    $row         = mysqli_fetch_array($count_query);
                                                    $numrows     = $row['numrows'];
                                                    $pixel       = htmlspecialchars($row['pixel']); // Escapa el contenido para hacerlo seguro en HTML

                                                    if ($numrows == 0) {
                                                    ?>
                                                        <textarea class="form-control" id="pixel_googleTag" name="pixel_googleTag" autocomplete="off" style="height: 110px;">Script de píxel de X</textarea>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <textarea class="form-control" id="pixel_googleTag" name="pixel_googleTag" autocomplete="off" style="height: 110px;"><?php echo $pixel; ?></textarea>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <span class="mb-5 d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-success mt-5">
                                                        Conectar
                                                    </button>
                                                </span>

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Modal X-->
                            <!-- Modal clarity-->
                            <div class="modal fade" id="clarity" tabindex="-1" role="dialog" aria-labelledby="clarityLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center" id="clarityLabel">Conectar con Clarity</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="clarityForm" class="mb-3 pixelForm">

                                                <span class="mb-5">
                                                    Introduce tu Script de píxel de Clarity
                                                </span>
                                                <span class="mb-5 font-bold"> <br> Clarity Pixel</span>
                                                <div class="form-group mb-3">
                                                <?php
                                                    $count_query = mysqli_query($conexion, "SELECT pixel, count(*) AS numrows FROM pixel  where id_pixel=6");
                                                    $row         = mysqli_fetch_array($count_query);
                                                    $numrows     = $row['numrows'];
                                                    $pixel       = htmlspecialchars($row['pixel']); // Escapa el contenido para hacerlo seguro en HTML

                                                    if ($numrows == 0) {
                                                    ?>
                                                        <textarea class="form-control" id="pixel_googleTag" name="pixel_googleTag" autocomplete="off" style="height: 110px;">Script de píxel de Clarity</textarea>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <textarea class="form-control" id="pixel_googleTag" name="pixel_googleTag" autocomplete="off" style="height: 110px;"><?php echo $pixel; ?></textarea>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <span class="mb-5 d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-success mt-5">
                                                        Conectar
                                                    </button>
                                                </span>

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Modal clarity-->
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

    <?php require 'includes/footer_start.php'
    ?>
    <!-- ============================================================== -->
    <!-- Todo el codigo js aqui-->
    <!-- ============================================================== -->
    <script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
    <script>
        $(document).ready(function() {
            $('.pixelForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize(); // Esto recogerá todos los campos de texto del formulario actual.

                $.ajax({
                    type: "POST",
                    url: "../ajax/guardar_pixel.php", // Esta es la URL del script PHP para guardar los datos
                    data: formData,
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: data.title,
                                text: data.message,
                                confirmButtonText: 'Cerrar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#' + data.modalId).modal('hide'); // Usa el ID del modal devuelto por PHP para cerrar el modal correspondiente
                                    location.reload(); // Recargar la página
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message,
                                confirmButtonText: 'Cerrar'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de comunicación',
                            text: 'Hubo un problema al comunicarse con el servidor. Inténtelo de nuevo más tarde.',
                            confirmButtonText: 'Cerrar'
                        });
                    }
                });
            });
        });



        function conectar_pixel(e) {
            e.preventDefault();
            const pixel_id = document.getElementById('pixel').value;
            if (pixel_id == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debes ingresar un ID de pixel',
                })
                return false;
            }
            $.ajax({
                type: 'POST',
                url: '../ajax/conectar_pixel.php',
                data: JSON.stringify({
                    pixel: pixel_id
                }),
                success: function(response) {
                    response = JSON.parse(response);
                    if (response == 'oki') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Conectado',
                            text: 'Se ha conectado correctamente',
                        })
                    } else
                    if (response == "oku") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Conectado',
                            text: 'Se ha actualizado correctamente',
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Ha ocurrido un error al conectar',
                        })
                    }
                }
            });
        }
        $("#login_dropi").submit(function(event) {
            event.preventDefault();
            var formdata = new FormData(this);
            var url_tienda = location.origin + "/sysadmin/api/integracion/Dropi/login";
            var url_tienda2 = location.origin + "/sysadmin/api/integracion/Dropi/enviar_datos";

            document.getElementById('select_pais').addEventListener('change', function() {
                const selectedCountry = this.value;
                // Ahora puedes llamar a cualquier función definida en tu archivo .js externo
                console.log(selectedCountry)
            });
            $.ajax({
                url: url_tienda,
                type: "POST",
                data: formdata,
                contentType: false,
                processData: false,
                success: function(data) {
                    data = JSON.parse(data);
                    if (data["status"] == false) {
                        Swal.fire({
                            icon: "error",
                            title: "Fallo al logear",
                            text: data["msg"]
                        })
                    } else if (data["status"] == true) {
                        $.ajax({
                            url: url_tienda2,
                            type: "POST",
                            data: formdata,
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                console.log(data);
                            }
                        })
                        Swal.fire({
                            icon: "success",
                            title: "Usuario correcto",
                            text: data["msg"]
                        }).then((result) => {
                            if (result.isConfirmed == true) {
                                location.reload();
                            }
                        })
                    }
                }
            })
        });
        $("#Dropi_cerrar_sesion").click(function(event) {
            event.preventDefault();
            $.ajax({
                url: "../ajax/desconectar_dropi.php",
                type: "POST",
                success: function(data) {
                    location.reload();
                }
            })
        });
    </script>
    <?php require 'includes/footer_end.php'
    ?>