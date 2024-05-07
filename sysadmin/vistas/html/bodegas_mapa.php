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
//$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Productos";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$sql = "SELECT latitud, longitud FROM bodega";
$resultado = $conexion->query($sql);

$bodegas = [];
if ($resultado->num_rows > 0) {
  while ($fila = $resultado->fetch_assoc()) {
    $bodegas[] = $fila;
  }
}

$conexion->close();
?>

<?php require 'includes/header_start.php';?>

<?php require 'includes/header_end.php';?>

<!-- Begin page -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGulcdBtz_Mydtmu432GtzJz82J_yb-rs"></script>
<div id="wrapper">

	<?php require 'includes/menu.php';?>

	<!-- ============================================================== -->
	<!-- Start right Content here -->
	<!-- ============================================================== -->
	<div class="content-page">
		<!-- Start content -->
		<div class="content">
			<div class="container">
                            <h3 class="portlet-title">
							Agregar	Bodega
							</h3>
<?php if ($permisos_ver == 1) {
    ?>
                            
  <div id="mapa"></div>

  

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

			<?php require 'includes/pie.php';?>

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
        <script>
    function initMap() {
      var map = new google.maps.Map(document.getElementById('mapa'), {
        center: { lat: 0, lng: 0 },
        zoom: 3
      });

      var bodegas = <?php echo json_encode($bodegas); ?>;

      bodegas.forEach(function(bodega) {
        var marker = new google.maps.Marker({
          position: { lat: parseFloat(bodega.latitud), lng: parseFloat(bodega.longitud) },
          map: map
        });
      });
    }
  </script>
  <script>
    google.maps.event.addDomListener(window, 'load', initMap);
  </script>

	<?php require 'includes/footer_end.php'
?>

