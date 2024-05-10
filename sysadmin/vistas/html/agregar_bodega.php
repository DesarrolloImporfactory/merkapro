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
$rol = $_SESSION['cargo_users'];
//$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Productos";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
?>

<?php require 'includes/header_start.php'; ?>

<?php require 'includes/header_end.php'; ?>

<!-- Begin page -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGulcdBtz_Mydtmu432GtzJz82J_yb-rs&libraries=places"></script>
<div id="wrapper">

  <?php require 'includes/menu.php'; ?>

  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
  <div class="content-page">
    <!-- Start content -->
    <div class="content">
      <div class="container">
        <h3 class="portlet-title">
          Agregar Dirección
          <button class="btn btn-danger" onclick="colocarMarcadorUbicacionActual()">Usar ubicación actual</button>

        </h3>
        <?php if ($permisos_ver == 1) {
        ?>
          <div class="row">
            <div class="col-md-3">
              <form id="formularioDatos" method="post" action="../ajax/guardar_bodega.php">

                <div class="form-group row">
                  <div class="col-md-12">
                    <?php if ($rol == 1) {


                    ?>
                      <select class='form-control' name='empresa' id='empresa' required>
                        <option value="">-- Selecciona cliente--</option>
                        <?php

                        $query_categoria = mysqli_query($conexion, "select * from users where cargo_users=4 order by apellido_users;");
                        while ($rw = mysqli_fetch_array($query_categoria)) {
                        ?>
                          <option value="<?php echo $rw['id_users']; ?>"><?php echo $rw['apellido_users']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    <?php

                    } else {
                    ?>
                      <input id="empresa" name="empresa" class="form-control " type="hidden" value="<?php echo $user_id; ?>">
                    <?php

                    }
                    ?>
                    <br>
                    <input id="nombre" name="nombre" class="form-control " type="text" placeholder="Nombre de la Bodega" required>
                    <br>
                    <input id="direccion" name="direccion" class="form-control " type="text" placeholder="Ingresa una dirección">
                    <br>


                    <div>
                      <span class="help-block">Provincia </span>
                      <select class="datos form-control " onchange="cargar_provincia_pedido()" id="provinica" name="provinica" required>
                        <option value="">Provincia *</option>
                        <?php
                        $sql2 = "select * from provincia_laar where id_pais = $pais";

                        $query2 = mysqli_query($conexion, $sql2);
                        while ($row2 = mysqli_fetch_array($query2)) {

                          $id_prov = $row2['id_prov'];

                          $provincia = $row2['provincia'];
                          $cod_provincia = $row2['codigo_provincia'];

                          // Imprimir la opción con la marca de "selected" si es el valor almacenado
                          echo '<option value="' . $cod_provincia . '">' . $provincia . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                    <br>
                    <div>
                      <span class="help-block">Ciudad </span>
                      <div id="div_ciudad" onclick="verify()">
                        <select class="datos form-control" id="ciudad_entrega" name="ciudad_entrega" onchange="seleccionarProvincia()" required disabled>
                          <option value="">Ciudad *</option>
                          <?php
                          $sql2 = "select * from ciudad_cotizacion where id_pais='$pais' ";
                          $query2 = mysqli_query($conexion, $sql2);
                          $rowcount = mysqli_num_rows($query2);
                          $i = 1;
                          while ($row2 = mysqli_fetch_array($query2)) {
                            $id_ciudad = $row2['id_cotizacion'];
                            $nombre = $row2['ciudad'];
                            $cod_ciudad = $row2['codigo_ciudad_laar'];
                            $valor_seleccionado = $ciudaddestino;
                            $selected = ($valor_seleccionado == $cod_ciudad) ? 'selected' : '';
                            echo '<option value="' . $cod_ciudad . '>' . $nombre . '</option>';
                          ?>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <br>
                    <input readonly id="direccion_completa" name="direccion_completa" class="form-control" type="text" placeholder="Ingresa una dirección">

                    <br>
                    <input id="nombre_contacto" name="nombre_contacto" class="form-control " type="text" placeholder="Ingrese Contacto">
                    <br>
                    <input id="telefono" name="telefono" class="form-control " type="text" placeholder="Telefono de contacto">
                    <br>
                    <input id="numero_casa" name="numero_casa" class="form-control " type="text" placeholder="Numero de Casa">
                    <br>
                    <input id="referencia" name="referencia" class="form-control " type="text" placeholder="Ingrese referencia">
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
                center: {
                  lat: 0,
                  lng: -78
                },
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
                position: {
                  lat: 0,
                  lng: -78
                },
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

                // Centrar el mapa en la ubicación seleccionada
                map.setCenter(place.geometry.location);
                map.setZoom(15);

                // Posicionar el marcador en la ubicación seleccionada
                marker.setPosition(place.geometry.location);

                // Actualizar campos del formulario con la información de la dirección seleccionada
                infowindow.setContent('Dirección: ' + place.formatted_address);
                infowindow.open(map, marker);
                $("#latitud").val(place.geometry.location.lat());
                $("#longitud").val(place.geometry.location.lng());
                $("#direccion_completa").val(place.formatted_address);


                // Obtener la dirección mediante geocodificación inversa
                geocoder.geocode({
                  'location': place.geometry.location
                }, function(results, status) {
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

                geocoder.geocode({
                  'location': latlng
                }, function(results, status) {
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAj-OWe4vKRnRiHQEx2ANZqxIGBT8z6Fo0&libraries=places&callback=initMap"></script>
<script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
<script type="text/javascript" src="../../js/bodegas.js"></script>

<script>
  // Define variables globales para el mapa y el marcador
  var map;
  var marker;
  var geocoder = new google.maps.Geocoder();
  var infowindow = new google.maps.InfoWindow();

  function initMap() {
    geocoder = new google.maps.Geocoder();
    infowindow = new google.maps.InfoWindow();

    // Inicializa el mapa
    map = new google.maps.Map(document.getElementById('mapa'), {
      center: {
        lat: -0.1806532,
        lng: -78.4678382
      }, // Coordenadas de ejemplo, puedes poner las que quieras
      zoom: 15
    });

    // Crea un marcador arrastrable en el mapa
    marker = new google.maps.Marker({
      map: map,
      position: {
        lat: -0.1806532,
        lng: -78.4678382
      }, // Coordenadas de ejemplo
      draggable: true,
      title: "Arrástrame para seleccionar una ubicación"
    });

    // Autocompletado de direcciones
    var input = document.getElementById('direccion');
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    // Evento de autocompletado: actualiza el mapa y el marcador con la nueva ubicación
    autocomplete.addListener('place_changed', function() {
      var place = autocomplete.getPlace();
      if (!place.geometry) {
        window.alert("No se encontraron detalles de la dirección: '" + place.name + "'");
        return;
      }
      actualizarMapaYMarcador(place.geometry.location, place.formatted_address);
    });

    // Evento de arrastre del marcador: actualiza los campos del formulario con la nueva ubicación
    marker.addListener('dragend', function() {
      actualizarDireccionDesdeLatLng(marker.getPosition());
    });
  }

  function actualizarMapaYMarcador(location, address) {
    map.setCenter(location);
    marker.setPosition(location);
    infowindow.setContent(address);
    infowindow.open(map, marker);
    $("#latitud").val(location.lat());
    $("#longitud").val(location.lng());
    $("#direccion_completa").val(address);
    // Resto de la lógica para actualizar otros campos del formulario
  }

  function actualizarDireccionDesdeLatLng(latlng) {
    geocoder.geocode({
      'location': latlng
    }, function(results, status) {
      if (status === 'OK' && results[0]) {
        actualizarMapaYMarcador(latlng, results[0].formatted_address);
      } else {
        window.alert('Geocoder falló debido a: ' + status);
      }
    });
  }

  function colocarMarcadorUbicacionActual() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        console.log(pos);
        actualizarMapaYMarcador(pos, 'Tu ubicación actual');
      }, function() {
        handleLocationError(true, map.getCenter());
      });
    } else {
      handleLocationError(false, map.getCenter());
    }
  }

  function handleLocationError(browserHasGeolocation, pos) {
    infowindow.setPosition(pos);
    infowindow.setContent(browserHasGeolocation ?
      'Error: El servicio de Geolocalización falló.' :
      'Error: Tu navegador no soporta geolocalización.');
    infowindow.open(map);
  }

  // Asegúrate de reemplazar la clave de la API en la URL del script de Google Maps al final del archivo


  //Provincias y Ciudades
  function cargar_provincia_pedido() {
    var id_provincia = $('#provinica option:selected').text();
    $.ajax({
      url: "../ajax/cargar_ciudad_pedido.php",
      type: "POST",
      data: {
        provinica: id_provincia,
      },
      dataType: 'text',
      success: function(data) {
        $('#div_ciudad').html(data);
        actualizarSelect();
      }
    });
  }

  function actualizarSelect() {
    $('#ciudad_entrega').select2('destroy');
    $('#ciudad_entrega').select2({
      placeholder: "Selecciona una opción",
      allowClear: true
    });
  }

  function seleccionarProvincia() {
    var id_provincia = $('#ciudad_entrega').val();
    let recaudo = $('#cod').val();

    calcular_guia(recaudo);
    calcular_servi(id_provincia, recaudo);
    //calcular_gintra($("#ciudad_entrega option:selected").text(), recaudo);
    /*  $.ajax({
            url: "../ajax/cargar_provincia_pedido.php",
            type: "POST",
            data: {
                ciudad: id_provincia,
            },
            dataType: 'text',
            success: function(data) {
                $('#provinica').val(data).trigger('change');
                $('#provinica option[value=' + data + ']').attr({
                    selected: true
                });
                let precio_total = $('#precio_total').val();


            }
        })
    } */
  }

  $("#ciudad_entrega").select2({
    placeholder: "Selecciona una opción",
    allowClear: true,
  });
</script>

<?php require 'includes/footer_end.php'
?>