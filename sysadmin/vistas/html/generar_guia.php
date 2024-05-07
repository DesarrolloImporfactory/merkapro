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
$modulo = "Pedidos";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
?>

<?php require 'includes/header_start.php';?>

<?php require 'includes/header_end.php';?>

<!-- Begin page -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGulcdBtz_Mydtmu432GtzJz82J_yb-rs&libraries=places"></script>
<div id="wrapper">

	<?php require 'includes/menu.php';?>

	<!-- ============================================================== -->
	<!-- Start right Content here -->
	<!-- ============================================================== -->
	<div class="content-page">
		<!-- Start content -->
		<div class="content">
			<div class="container">
                           
<?php if ($permisos_ver == 1) {
    ?>
                             <h3 class="portlet-title">
							Transportadora
                                                        

							</h3>
                             <div class="row">
                            <div class="col-md-3">
                                
                                <form id="formularioDatos" method="post" action="../ajax/guardar_bodega.php">
       
				<div class="form-group row">
										<div class="col-md-12">
                                                                                    <select  class='form-control' name='empresa' id='empresa' required>
												<option value="">-- Selecciona empresa--</option>
												<?php

    $query_categoria = mysqli_query($conexion, "select * from users where cargo_users=7 order by apellido_users;");
    while ($rw = mysqli_fetch_array($query_categoria)) {
        ?>
													<option value="<?php echo $rw['id_users']; ?>"><?php echo $rw['apellido_users']; ?></option>
													<?php
}
    ?>
											</select>
                                                                                  
											<br>
                                                                                            <h3 class="portlet-title">
							Dirección destino
                                                        

							</h3>
                                                                                        <button class="btn btn-danger" onclick="colocarMarcadorUbicacionActual()">Usar ubicación actual</button>
                                                                                        <input id="nombre" name="nombre" class="form-control " type="text" placeholder="Nombre de la bodega" required>
                                                                                            <br>
                                                                                             <input id="direccion" name="direccion" class="form-control " type="text" placeholder="Ingresa una dirección">
                                                                                            <br>
                                                                                           
                                                                                           
                                                                                            <select onchange="cambio_provincia()" class='form-control' name='provincia' id='provincia' required>
												<option value="">-- Selecciona Provincia--</option>
												<?php

    $query_categoria = mysqli_query($conexion, "select distinct provincia, codigo_provincia from localidad order by codigo_parroquia;");
    while ($rw = mysqli_fetch_array($query_categoria)) {
        ?>
													<option value="<?php echo $rw['codigo_provincia']; ?>"><?php echo $rw['provincia']; ?></option>
													<?php
}
    ?>
											</select>
                                                                                          <br> 
                                                                                          <div id="div_canton">
                                                                                              <select   class='form-control' name='canton' id='canton' required>
												<option value="">-- Selecciona Cantón--</option>
												
											</select>   
                                                                                            </div>
                                                                                          <br> 
                                                                                          <div id="div_parroquia">
                                                                                              <select   class='form-control' name='parroquia' id='parroquia' required>
												<option value="">-- Selecciona Parroquia--</option>
												
											</select>   
                                                                                            </div>
                                                                                             <br> 
                                                                                            <input readonly id="direccion_completa" name="direccion_completa" class="form-control" type="text" placeholder="Ingresa una dirección">
                                                                                           
                                                                                            <br> 
                                                                                             <input readonly id="nombre_contacto" name="nombre_contacto" class="form-control " type="text" placeholder="Ingrese Contacto">
                                                                                             <br> 
                                                                                             <input readonly id="telefono" name="telefono" class="form-control " type="text" placeholder="Telefono de contacto">
                                                                                            <br> 
                                                                                            <input readonly id="numero_casa" name="numero_casa" class="form-control " type="text" placeholder="Numeracion">
                                                                                              <br>
                                                                                              <input readonly id="referencia" name="referencia" class="form-control " type="text" placeholder="Ingrese referencia"> 
                                                                                            <div class="input-group">
                                                                                            
													<?php
                                                                                                        //echo '<h2>'. get_row('edificio', 'nombre', 'id_edificio', $id_edificio).'</h2>';
                                                                                                        ?>
												</div>
                                                                                    	</div>
                                    </div>
                                   <div class="form-group row">
										<div class="col-md-12">
											<div class="input-group">
                                                                                           
                                                                                            <input readonly id="latitud" name="latitud" class="form-control" type="text" placeholder="Latitud">
                                                                                            <input readonly id="longitud" name="longitud" class="form-control" type="text" placeholder="Longitud">   
                                                                                    </div>
                                                                                    </div>
                                       </div>
                                                                                   <div class="form-group row">
										<div class="col-md-12">
											<div class="input-group">
                                                                                      
                                                                                               
                                                                                    </div>
											</div>
											
											

										</div>
        <input class="btn btn-primary" type="submit" value="Guardar">
        </form>
                            </div>  
                            <div class="col-md-9">                      
  <div id="mapa" style="height: 100%;"></div>
  <div id="infoDireccion"></div>
</div>  
                                 </div>  
  <script>
    // Inicializar el mapa
    function initMap() {
      var map = new google.maps.Map(document.getElementById('mapa'), {
        center: {lat: 0, lng: -78},
        zoom: 7
      });

      var geocoder = new google.maps.Geocoder();
      var infowindow = new google.maps.InfoWindow();

      // Autocompletado de direcciones
      var input = document.getElementById('direccion');
      //alert(input);
      var autocomplete = new google.maps.places.Autocomplete(input);
      autocomplete.bindTo('bounds', map);

      // Crear un marcador inicial
      var marker = new google.maps.Marker({
        position: {lat: 0, lng: -78},
        map: map,
        draggable: true // Hacer el marcador arrastrable
      });

      // Al seleccionar una dirección, centrar el mapa en esa ubicación y colocar el marcador
      autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
       
        if (!place.geometry) {
          window.alert("No se encontraron detalles de la dirección: '" + place.name + "'");
          return;
        }

        map.setCenter(place.geometry.location);
        map.setZoom(15);

        marker.setPosition(place.geometry.location);

        // Obtener la dirección mediante geocodificación inversa
        geocoder.geocode({'location': place.geometry.location}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
              infowindow.setContent('Dirección: ' + results[0].formatted_address);
              infowindow.open(map, marker);
             
            } else {
              window.alert('No se encontraron resultados');
            }
          } else {
            window.alert('Geocoder falló debido a: ' + status);
          }
        });
      });

      // Al mover el marcador, obtener la nueva dirección
      marker.addListener('dragend', function() {
        var latlng = marker.getPosition();

        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
              infowindow.setContent('Dirección: ' + results[0].formatted_address);
              infowindow.open(map, marker);
               var latitud = results[0].geometry.location.lat();
      var longitud = results[0].geometry.location.lng();
      alert(latlng)
            } else {
              window.alert('No se encontraron resultados');
            }
          } else {
            window.alert('Geocoder falló debido a: ' + status);
          }
        });
      });
    }
  </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGulcdBtz_Mydtmu432GtzJz82J_yb-rs&libraries=places&callback=initMap"></script>

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
    // Inicializar el mapa
    function initMap() {
      var map = new google.maps.Map(document.getElementById('mapa'), {
        center: {lat: 0, lng: -78},
        zoom: 7
      });

      var geocoder = new google.maps.Geocoder();
      var infowindow = new google.maps.InfoWindow();

      // Autocompletado de direcciones
      var input = document.getElementById('direccion');
      var autocomplete = new google.maps.places.Autocomplete(input);
      autocomplete.bindTo('bounds', map);

      // Crear un marcador inicial
      var marker = new google.maps.Marker({
        position: {lat: 0, lng: -78},
        map: map,
        draggable: true // Hacer el marcador arrastrable
      });

      // Al seleccionar una dirección, centrar el mapa en esa ubicación y colocar el marcador
      autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
          window.alert("No se encontraron detalles de la dirección: '" + place.name + "'");
          return;
        }

        map.setCenter(place.geometry.location);
        map.setZoom(15);

        marker.setPosition(place.geometry.location);

        // Obtener la dirección mediante geocodificación inversa
        geocoder.geocode({'location': place.geometry.location}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
              infowindow.setContent('Dirección: ' + results[0].formatted_address);
              infowindow.open(map, marker);
            } else {
              window.alert('No se encontraron resultados');
            }
          } else {
            window.alert('Geocoder falló debido a: ' + status);
          }
        });
      });

      // Al mover el marcador, obtener la nueva dirección
      marker.addListener('dragend', function() {
        var latlng = marker.getPosition();

        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
              infowindow.setContent( results[0].formatted_address);
              infowindow.open(map, marker);
              var latitud = results[0].geometry.location.lat();
      var longitud = results[0].geometry.location.lng();
      $("#latitud").val(latitud);
      $("#longitud").val(longitud);
           direccionCompleta=  results[0].formatted_address
           $("#direccion_completa").val(direccionCompleta);
var addressComponents = direccionCompleta.split(',');

// Obtener la penúltima parte (posiblemente el código postal)
var penultimatePart = addressComponents[addressComponents.length - 2].trim();

// Verificar si la penúltima parte es un código postal (puedes ajustar la expresión regular según el formato)
//var codigoPostal = /^\d{6}$/.test(penultimatePart) ? penultimatePart : '';
let ultimosSeisSubstring = penultimatePart.substring(penultimatePart.length - 6);
// Mostrar el código postal
 $("#localidad").val(ultimosSeisSubstring);
$('#localidad, #direccion_completa, #latitud, #longitud, #referencia, #numero_casa, #nombre_contacto, #telefono').prop('readonly', false);
            } else {
              window.alert('No se encontraron resultados');
            }
          } else {
            window.alert('Geocoder falló debido a: ' + status);
          }
        });
      });
    }
  </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGulcdBtz_Mydtmu432GtzJz82J_yb-rs&libraries=places&callback=initMap"></script>
	<script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="../../js/bodegas.js"></script>
<script>
       $(document).ready( function () {
        $(".UpperCase").on("keypress", function () {
         $input=$(this);
         setTimeout(function () {
          $input.val($input.val().toUpperCase());
         },50);
        })
       })
       function reporte_excel(){
			var q=$("#q").val();
			window.location.replace("../excel/rep_clientes.php?q="+q);
    //VentanaCentrada('../excel/rep_gastos.php?daterange='+daterange+"&employee_id="+employee_id,'Reporte','','500','25','true');+"&tipo="+tipo
}

      </script>
      <script type="text/javascript">
      	function reporte(){
		var q=$("#q").val();
		VentanaCentrada('../pdf/documentos/rep_clientes.php?q='+q,'Reporte','','800','600','true');
	}
        
        function cambio_provincia(){
 
       // alert($("#provincia" ).val());
       id_provincia =$("#provincia" ).val();
    
     //$("#precio_filtro" ).val(valor);
     //precio_bandera=$("#precio_filtro" ).val();

     
     $.ajax({
				url:'../ajax/cargar_canton.php?id_provincia='+id_provincia,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
                                    //alert(data)
					//$('#div_parroquia').html(null)
                                       $('#div_canton').html(data)
                                      // alert('REGISTRO EXITOSO')
					
				}
			})

    }
    
    function cambio_canton(){
 
        
       id_canton =$("#canton" ).val();
    
     //$("#precio_filtro" ).val(valor);
     //precio_bandera=$("#precio_filtro" ).val();

     
     $.ajax({
				url:'../ajax/cargar_parroquia.php?id_canton='+id_canton,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
                                    //alert(data)
					//$('#div_parroquia').html(null)
                                       $('#div_parroquia').html(data)
                                      // alert('REGISTRO EXITOSO')
					
				}
			})

    }
    
    // Función para colocar un marcador en la ubicación actual del usuario
function colocarMarcadorUbicacionActual() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      var map = new google.maps.Map(document.getElementById('mapa'), {
        center: pos,
        zoom: 15
      });

      // Crea el objeto Geocoder
      var geocoder = new google.maps.Geocoder();

      var marker = new google.maps.Marker({
        position: pos,
        map: map,
        title: "Arrástrame para seleccionar una ubicación",
        draggable: true // Hace el marcador arrastrable
      });

      // InfoWindow inicial (vacío hasta que se complete el arrastre)
      var infowindow = new google.maps.InfoWindow();

      // Actualiza la dirección cuando el usuario termine de arrastrar el marcador
          marker.addListener('dragend', function() {
        var latlng = marker.getPosition();

        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
              infowindow.setContent( results[0].formatted_address);
              infowindow.open(map, marker);
              var latitud = results[0].geometry.location.lat();
      var longitud = results[0].geometry.location.lng();
      $("#latitud").val(latitud);
      $("#longitud").val(longitud);
           direccionCompleta=  results[0].formatted_address
           $("#direccion_completa").val(direccionCompleta);
var addressComponents = direccionCompleta.split(',');

// Obtener la penúltima parte (posiblemente el código postal)
var penultimatePart = addressComponents[addressComponents.length - 2].trim();

// Verificar si la penúltima parte es un código postal (puedes ajustar la expresión regular según el formato)
//var codigoPostal = /^\d{6}$/.test(penultimatePart) ? penultimatePart : '';
let ultimosSeisSubstring = penultimatePart.substring(penultimatePart.length - 6);
// Mostrar el código postal
 $("#localidad").val(ultimosSeisSubstring);
$('#localidad, #direccion_completa, #latitud, #longitud, #referencia, #numero_casa, #nombre_contacto, #telefono').prop('readonly', false);
            } else {
              window.alert('No se encontraron resultados');
            }
          } else {
            window.alert('Geocoder falló debido a: ' + status);
          }
        });
      });

      // Evento de clic en el marcador para abrir el InfoWindow con la dirección actual
      marker.addListener('click', function() {
        infowindow.open(map, marker);
      });

      // Geocodificación inversa inicial para obtener y mostrar la dirección
      geocoder.geocode({'location': pos}, function(results, status) {
        if (status === 'OK') {
          if (results[0]) {
            infowindow.setContent('<div><strong>Tu ubicación actual:</strong><br>' + results[0].formatted_address + '</div>');
            infowindow.open(map, marker);
          }
        }
      });

      map.setCenter(pos);
    }, function() {
      handleLocationError(true, map.getCenter());
    });
  } else {
    // El navegador no soporta Geolocalización
    handleLocationError(false, map.getCenter());
  }
}

function handleLocationError(browserHasGeolocation, pos) {
  console.log(browserHasGeolocation ?
                'Error: El servicio de Geolocalización falló.' :
                'Error: Tu navegador no soporta geolocalización.');
}
      </script>

	<?php require 'includes/footer_end.php'
?>

