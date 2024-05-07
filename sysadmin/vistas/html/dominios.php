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
$modulo = "Dominios";
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
                    <div class="col ">
                        <div>
                            <a href="" class=""></a>
                            <a href="https://www.youtube.com/watch?v=xTL5WQDhBOM" target="_blank" class='bx bx-play-circle youtube '><span class="texto">ver video</span></a>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="bg-white p-5">
                                <p class="text-muted fs-s">PASO 1:</p>
                                <h4 class="text-center font-bold">Gestiona tu dominio</h4>

                                <p>
                                    Instrucciones: <br>
                                    1.- En su proveedor de dominio agregar dos records: <br>
                                    a) Un record "A" con el valor 158.220.107.176. <br>
                                    b) Un record "CNAME" con el valor www <br>
                                    2.- Una vez que se hayan propagado los Records agregados en el paso anterior rellenar el formulario a continuación. <br>
                                    Para asegurarse que los records se hayan propagado corectamente puede verificar su dominio <a href="https://www.whatsmydns.net/">aquí</a>
                                </p>
                                <div>

                                    <form class="d-flex gap-2" method="post" id="dominioForm">
                                        <input class="form-control" name="dominio" id="dominio" type="text" placeholder="Dominio" />

                                        <input class="form-control" name="nombre" id="nombre" type="text" placeholder="Nombre de la tienda" />

                                        <button class="btn btn-outline-info">Configurar</button>

                                    </form>
                                </div>

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

<?php require 'includes/footer_start.php'
?>
<!-- ============================================================== -->
<!-- Todo el codigo js aqui-->
<!-- ============================================================== -->
<script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
<script src="./js/dominio.js"></script>

<?php require 'includes/footer_end.php'
?>