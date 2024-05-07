<?php
// Establecer la conexión a la base de datos
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
$modulo = "Bodegas";
permisos($modulo, $cadena_permisos);
$sql = "SELECT * FROM bodega where id_empresa=$user_id";
$resultado = $conexion->query($sql);

$bodegas = [];
if ($resultado->num_rows > 0) {
  while ($fila = $resultado->fetch_assoc()) {
    $bodegas[] = $fila;
  }
}


?>
<?php require 'includes/header_start.php';?>

<?php require 'includes/header_end.php';?>
<!DOCTYPE html>


  <title>Mapa de Bodegas</title>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAj-OWe4vKRnRiHQEx2ANZqxIGBT8z6Fo0"></script>
  <style>
    #mapa {
      height: 600px;
    }
  </style>

  <div id="wrapper">
      <?php require 'includes/menu.php';?>
      <div class="content-page">
		<!-- Start content -->
		<div class="content">
			<div class="container">
                            <h3 class="portlet-title">
							Direcciones
							</h3>
  <div id="mapa"></div>
  </div>
                    </div>
                </div>
      </div>
  	<?php require 'includes/footer_start.php'
?>
  <script>
    function initMap() {
      var map = new google.maps.Map(document.getElementById('mapa'), {
        center: { lat: 0, lng: -78 },
        zoom: 8
      });

      var bodegas = <?php echo json_encode($bodegas); ?>;

      bodegas.forEach(function(bodega) {
        var marker = new google.maps.Marker({
          position: { lat: parseFloat(bodega.latitud), lng: parseFloat(bodega.longitud) },
          map: map
        });
        var contenidoInfoWindow = '<div id="content">' +
      '<div id="siteNotice">' +
      '</div>' +
      '<h4 id="firstHeading" class="firstHeading">'+ bodega.nombre +'</h4>' +
      '<div id="bodyContent">' +
      
      '<p><strong>Dirección: </strong>' + bodega.direccion + '</br>' +
      '<strong>Responsable: </strong>' + bodega.responsable + '</br>' +
      '<strong>Contacto: </strong>' + bodega.contacto + '</p>' +
      '</div>' +
      '</div>';

    var infowindow = new google.maps.InfoWindow({
      content: contenidoInfoWindow
    });
    
      // Evento de clic en el marcador para abrir el InfoWindow
    marker.addListener('click', function() {
      infowindow.open(map, marker);
    });
    
      });
    }
  </script>
  <script>
    google.maps.event.addDomListener(window, 'load', initMap);
  </script>
<?php require 'includes/footer_end.php'
?>