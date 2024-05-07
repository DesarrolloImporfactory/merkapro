<?php
session_start();
if (!isset($_SESSION["comprar"])) {
  $session_id = 'user_' . mt_rand();
  $_SESSION["comprar"] = $session_id;
} else {
  $session_id = $_SESSION["comprar"];
}
//echo $session_id;
require_once "sysadmin/vistas/db.php";
require_once "sysadmin/vistas/php_conexion.php";
require_once "sysadmin/vistas/funciones.php";

$id_producto = $_GET['id'];

$pagina = 'PRODUCTO';
include './auditoria.php';
include './includes/style.php';



$aColumns     = array('codigo_producto', 'nombre_producto'); //Columnas de busqueda
$sTable       = "productos";
$sWhere       = "where id_producto=$id_producto ";
$sql   = "SELECT * FROM  $sTable $sWhere ";
$query = mysqli_query($conexion, $sql);
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
  $stock_producto       = $row['stock_producto'];
  $stock_min_producto   = $row['stock_min_producto'];
  $precio_normal      = $row['valor4_producto'];



  $online   = $row['pagina_web'];
  $status_producto      = $row['estado_producto'];
  $date_added           = date('d/m/Y', strtotime($row['date_added']));
  $image_path           = $row['image_path'];
  $url_a1            = $row['url_a1'];
  $url_a2            = $row['url_a2'];
  $url_a3            = $row['url_a3'];
  $url_a4            = $row['url_a4'];
  $url_a5            = $row['url_a5'];


  $id_imp_producto      = $row['id_imp_producto'];
  $formato      = $row['formato'];
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    #main-image {
      /* Añade una sombra o borde si es necesario */
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      border-radius: 1rem;
      /* Ejemplo de sombra */
    }

    .iconos_producto {
      display: flex;
      flex-direction: row;
    }

    @media (max-width: 480px) {
      .iconos_producto {
        flex-direction: column;
      }
    }

    .list-group-item {
      background-color: transparent;
      /* Esto hará que el fondo sea transparente */
      border: none;
      /* Esto elimina el borde si lo hay */
    }

    .list-group-item img {
      opacity: 0.6;
      /* Esto hará que las miniaturas no seleccionadas sean un poco transparentes */
    }

    .list-group-item.active img {
      opacity: 1;
      /* Esto hará que la miniatura seleccionada sea completamente opaca */
      border: 2px solid grey;
      /* Esto añadirá un borde gris alrededor de la miniatura seleccionada */
    }

    .list-group-item {
      background-color: white !important;
      /* Esto hará que el fondo sea transparente */
      border-color: white !important;
      /* Esto elimina el borde si lo hay */
    }

    #list-tab .list-group-item img.img-thumbnail {
      width: 150px;
      /* El ancho deseado para las miniaturas */
      height: 65px;
      /* Para mantener la proporción de aspecto */
    }

    /* Estilos para miniaturas */
    .list-group-item img.img-thumbnail {
      width: 100px;
      /* Ancho que desees para las miniaturas */
      height: 100px;
      /* Altura que desees para las miniaturas */
      object-fit: cover;
      /* cover recortará la imagen para ajustarla al tamaño */
    }

    /* Estilos para imagen principal */
    #main-image {
      width: 500px;
      /* Ancho que desees para la imagen principal */
      height: 500px;
      /* Altura que desees para la imagen principal */
      object-fit: cover;
      /* contain asegurará que la imagen se ajuste dentro de este espacio sin recortarse */
    }


    @media (max-width: 768px) {

      /* Estilos para imagen principal */
      #main-image {
        width: 300px;
        /* Ancho que desees para la imagen principal */
        height: 300px;
        /* Altura que desees para la imagen principal */
        object-fit: cover;
        /* contain asegurará que la imagen se ajuste dentro de este espacio sin recortarse */
      }
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
    }

    .left-column {
      width: 50%;
      padding: 20px;
      padding-top: 60px;
      position: -webkit-sticky;
      /* Para compatibilidad con Safari */
      position: sticky;
      top: 0;
      /* Ajusta esto a la altura de cualquier cabecera o menú que tengas */
      height: 100%;
      /* O la altura que quieras que tenga */
    }

    .right-column {
      width: 50%;
      padding: 20px;
      padding-top: 60px;
    }

    .product-image {
      max-width: 100%;
    }

    .product-price {
      font-size: 28px;
      color: #333;
    }

    .product-title {
      font-size: 24px;
    }

    .color-options {
      list-style: none;
      padding: 0;
    }

    .color-option {
      display: inline-block;
      width: 24px;
      height: 24px;
      margin-right: 10px;
    }

    .color-option input[type="radio"] {
      display: none;
    }

    .color-option label {
      display: block;
      width: 100%;
      height: 100%;
      border: 1px solid #ccc;
      cursor: pointer;
    }

    .color-option input[type="radio"]:checked+label {
      border: 2px solid blue;
    }

    .iframe-container {
      position: relative;
      width: 100%;
      padding-bottom: 56.25%;
      /* Aspect ratio 16:9 */
      height: 0;
    }

    .iframe-container iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    .button {
      background-color: red;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
    }

    @keyframes jump {
      0% {
        transform: translateY(0);
        /* Sin desplazamiento vertical */
      }

      50% {
        transform: translateY(-5px);
        /* Desplazamiento hacia arriba */
      }

      100% {
        transform: translateY(0);
        /* Volver a la posición original */
      }
    }

    /* Aplicar la animación al botón */
    .jump-button {
      animation: jump 3s ease infinite;
      /* Animación llamada 'jump' que dura 3 segundos y se repite infinitamente */
    }

    .content_left_right {
      display: flex;
    }

    .ahorra {
      font-size: 20px;
    }

    /* Añade más estilos según sea necesario */

    /* Para dispositivos con un ancho de 768px o menos */
    .precios_producto {
      display: flex;
      flex-direction: row;
    }

    @media (max-width: 768px) {
      .content_left_right {
        display: flex;
        flex-direction: column;
        max-width: 100%;
        margin: 0 auto;
      }

      .left-column,
      .right-column {
        width: 100%;
        padding: 10px;
      }

      .precios_producto {
        flex-direction: column;
      }

      .ahorra {
        font-size: 15px;
      }

      .container {
        flex-direction: column;
      }

      #navbarLogo {
        height: 60px;
        width: 60px;
      }

      .container {
        align-items: flex-end !important;
      }

      .navbar-brand_1 {
        top: 0;
        padding-left: 20px;
      }

      .left-column {
        position: static;
        /* Para compatibilidad con Safari */
      }

      .list-group {
        flex-direction: row !important;
        padding-top: 10px;
      }

      /* Otros ajustes responsivos */
    }

    /* Para dispositivos con un ancho de 480px o menos */
    @media (max-width: 480px) {
      .navbar-brand img {
        height: 50px;
        width: 50px;
      }

      /* Ajustes adicionales para dispositivos más pequeños */
    }
  </style>
  <?php
  include './includes/head_1.php';
  ?>
  <link href="css_nuevo/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

  <meta name="theme-color" content="#7952b3">



  <link href="css_nuevo/carousel.css" rel="stylesheet" type="text/css" />
  <!-- Custom styles for this template -->

</head>
<?php
if ($formato == 3) {
  $imporsuit_db = mysqli_connect("194.163.183.231", 'administrador', '69635201d674bcb6f0897604c7c97cf8', 'suit-imporcomex');
  $url_site = $_SERVER['HTTP_HOST'];
  $sql_usuario = "SELECT * FROM users WHERE url like '%" . $url_site . "%'";
  $query_usuario = mysqli_query($imporsuit_db, $sql_usuario);
  $rw_usuario = mysqli_fetch_array($query_usuario);
  echo mysqli_error($imporsuit_db);
  $users = $rw_usuario['id'];
  $pagina = $nombre_producto . "_" . $users;


  echo '
<frameset>
<frame src="https://drag.imporsuit.com/' . $pagina . '">
</frameset>
    
';
  exit;
}
?>

<body class="main-content">
  <?php
  include 'modal/comprar.php';
  ?>
  <header>
    <nav id="navbarId" style="height: 100px" class="navbar navbar-expand-lg  fixed-top superior ">
      <div class="container">
        <div>
          <ul class="navbar-nav mr-auto menu_izquierda" style="padding-right: 15px;">
            <li class="nav-item active">
              <a class="nav-link texto_cabecera" href="<?php echo $protocol ?>://<?php echo $domain ?>">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link texto_cabecera" href="<?php echo $protocol ?>://<?php echo $domain ?>/categoria_1.php">Catálogo</a>
            </li>
          </ul>
        </div>
        <!-- Logo en el centro para todas las vistas -->
        <a class="navbar-brand" href="#"><a class="navbar-brand_1" href="<?php echo $protocol ?>://<?php echo $domain ?>"><img id="navbarLogo" class="" style="vertical-align: top; height: 100px; width: 100px;" src="<?php
                                                                                                                                                                                                                        if (empty(get_row('perfil', 'logo_url', 'id_perfil', '1'))) {
                                                                                                                                                                                                                          echo "assets/img/imporsuit.png";
                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                          echo "sysadmin" . str_replace("../..", "", get_row('perfil', 'logo_url', 'id_perfil', '1'));
                                                                                                                                                                                                                        }
                                                                                                                                                                                                                        ?>" alt="Imagen" /></a></a>

        <button class="navbar-toggler" id="menuButton">
          <i class="fas fa-bars" style="color: white; text-shadow: 0px 0px 3px #fff;"></i>
        </button>
      </div>
      <div class="collapse navbar-collapse" id="navbarResponsive" style="padding-left: 10px; padding-right: 10px; justify-content: flex-end;">
        <!-- Elementos a la izquierda -->
        <ul class="navbar-nav mr-auto menu_derecha" style="padding-right: 15px;">
          <li class="nav-item active">
            <a class="nav-link texto_cabecera" href="<?php echo $protocol ?>://<?php echo $domain ?>">Inicio <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link texto_cabecera" href="<?php echo $protocol ?>://<?php echo $domain ?>/categoria_1.php">Catálogo</a>
          </li>

        </ul>
        <!-- Elementos a la derecha -->
        <ul class="navbar-nav">
          <form id="searchForm">
            <div class="search-box">
              <input type="text" id="searchInput" class="search-input" placeholder="Buscar" required>
              <button type="submit" class="search-button">
                <i class="fas fa-search"></i>
              </button>
            </div>
            <div id="suggestions" class="suggestions-dropdown" style="display: none; background-color: white; border-radius: 0.5rem; padding-left:10px;">
              <!-- Las sugerencias se insertarán aquí -->
            </div>
          </form>

          <script>
            // Autocompletar sugerencias
            document.getElementById('searchInput').addEventListener('input', function() {
              var inputVal = this.value;

              // Ocultar sugerencias si no hay valor
              if (inputVal.length === 0) {
                document.getElementById('suggestions').style.display = 'none';
                return;
              }

              // Realizar la solicitud AJAX al script PHP para obtener sugerencias
              fetch('/sysadmin/vistas/ajax/search_index.php', {
                  method: 'POST',
                  body: new URLSearchParams('query=' + inputVal)
                })
                .then(response => response.json())
                .then(data => {
                  var suggestionsContainer = document.getElementById('suggestions');
                  suggestionsContainer.innerHTML = '';
                  suggestionsContainer.style.display = 'block';

                  // Agregar las sugerencias al contenedor
                  data.forEach(function(item) {
                    var div = document.createElement('div');
                    div.innerHTML = item.nombre_producto; // Asumiendo que 'nombre_producto' es lo que quieres mostrar
                    div.onclick = function() {
                      // Al hacer clic, se actualiza el input y se redirige
                      document.getElementById('searchInput').value = this.innerText;
                      window.location.href = 'producto_1.php?id=' + item.id_producto;
                    };
                    suggestionsContainer.appendChild(div);
                  });
                })
                .catch(error => console.error('Error:', error));
            });

            // Evento submit del formulario
            document.getElementById('searchForm').addEventListener('submit', function(event) {
              event.preventDefault();
              var searchQuery = document.getElementById('searchInput').value;
              // Aquí puedes manejar la búsqueda, por ejemplo, redirigir a una página de resultados
              window.location.href = '/busqueda.php?query=' + encodeURIComponent(searchQuery);
            });
          </script>
        </ul>
      </div>

      <script>
        // Obtener el botón y el menú
        var menuButton = document.getElementById('menuButton');
        var menu = document.getElementById('navbarResponsive');

        // Función para alternar la visibilidad del menú
        function toggleMenu() {
          if (menu.classList.contains('show')) {
            menu.classList.remove('show');
          } else {
            menu.classList.add('show');
          }
        }

        // Evento click para el botón del menú
        menuButton.onclick = function() {
          toggleMenu();
        };

        // Opcional: cerrar el menú si se hace clic fuera de él
        window.onclick = function(event) {
          if (!menu.contains(event.target) && !menuButton.contains(event.target)) {
            menu.classList.remove('visible');
          }
        };
      </script>

    </nav>
  </header>

  <main style="background-color: #f9f9f9;">
    <?php $banner = get_row('perfil', 'banner', 'id_perfil', 1);
    if ($banner != "") {
      $texto_slider = get_row('perfil', 'texto_slider', 'id_perfil', 1);
      $text_btn_slider = get_row('perfil', 'texto_btn_slider', 'id_perfil', 1);
      $enlace_btn_slider = get_row('perfil', 'enlace_btn_slider', 'id_perfil', 1);
      $titulo_slider = get_row('perfil', 'titulo_slider', 'id_perfil', 1);
      $alineacion_slider = get_row('perfil', 'alineacion_slider', 'id_perfil', 1);

      $resultado = $conexion->query("SELECT banner FROM perfil WHERE id_perfil = 1");
      $slidePrincipal = $resultado->fetch_assoc();


      if ($alineacion_slider == 1 or $alineacion_slider == 0 or $alineacion_slider == "") {
        $alineacion = "text-start";
      }
      if ($alineacion_slider == 2) {
        $alineacion = "";
      }
      if ($alineacion_slider == 3) {
        $alineacion = "text-end";
      }
      // Consulta para slides adicionales
      $resultadoAdicionales = $conexion->query("SELECT fondo_banner, texto_banner, titulo, texto_boton, enlace_boton, alineacion FROM banner_adicional");

    ?>



    <?php
    } ?>

    <div class="marquee-container">
      <div class="marquee">
        <p style="font-size: 22px;">
          -
          <?php

          $sql   = "SELECT * FROM  horizontal  where posicion=1 or posicion is null";
          $query = mysqli_query($conexion, $sql);
          while ($row = mysqli_fetch_array($query)) {
            $texto       = $row['texto'];
            echo $texto . ' - ';
          } ?>
        </p>

      </div>
    </div>
    <!-- Marketing messaging and featurettes
  ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container flex-column" style="align-items: center !important;">
      <div class="content_left_right">
        <div class="left-column">

          <div class="slider_producto">
            <div class="d-flex flex-column" style="width: 100%;;">
              <!-- Indicadores del carrusel para las miniaturas -->
              <div class="list-group"  id="list-tab" role="tablist">

                <a class="list-group-item list-group-item-action active" style="max-width: 100px !important; max-height: 100px !important; padding:0;" id="list-image1-list" data-toggle="list" href="#list-image1" role="tab" aria-controls="image1">
                  <img src="<?php
                            $subcadena = "http";
                            if (strpos(strtolower($image_path), strtolower($subcadena)) === 0) {
                            ?>
                <?php echo  $image_path . '"'; ?>
                <?php } else { ?>
                  sysadmin/<?php echo str_replace("../..", "", $image_path) ?>" <?php } ?> class="img-thumbnail">
                </a>
                <!-- condiciones para imagenes adicionales -->
                <!-- url1 -->
                <?php
                $subcadena = "http";
                // Verifica si la URL es una dirección externa
                if (strpos(strtolower($url_a1), strtolower($subcadena)) === 0) {
                  // Es una URL externa, asumimos que la imagen existe
                  if (!empty($url_a1)) { ?>
                    <a class="list-group-item list-group-item-action active" style="max-width: 100px !important; max-height: 100px !important; padding:0;" id="list-image1-list" data-toggle="list" href="#list-image1" role="tab" aria-controls="image1">
                      <img src="<?php echo $url_a1; ?>" class="img-thumbnail">
                    </a>
                  <?php }
                } else {
                  // Es una ruta local, verificamos si el archivo existe
                  $rutaLocal = 'sysadmin/' . str_replace("../..", "", $url_a1);
                  if (!empty($url_a1) && file_exists($rutaLocal)) { ?>
                    <a class="list-group-item list-group-item-action active" style="max-width: 100px !important; max-height: 100px !important; padding:0;" id="list-image1-list" data-toggle="list" href="#list-image1" role="tab" aria-controls="image1">
                      <img src="<?php echo $rutaLocal; ?>" class="img-thumbnail">
                    </a>
                <?php }
                }
                ?>

                <!-- url2 -->
                <?php
                $subcadena = "http";
                // Verifica si la URL es una dirección externa
                if (strpos(strtolower($url_a2), strtolower($subcadena)) === 0) {
                  // Es una URL externa, asumimos que la imagen existe
                  if (!empty($url_a2)) { ?>
                    <a class="list-group-item list-group-item-action active" style="max-width: 100px !important; max-height: 100px !important; padding:0;" id="list-image1-list" data-toggle="list" href="#list-image1" role="tab" aria-controls="image1">
                      <img src="<?php echo $url_a2; ?>" class="img-thumbnail">
                    </a>
                  <?php }
                } else {
                  // Es una ruta local, verificamos si el archivo existe
                  $rutaLocal = 'sysadmin/' . str_replace("../..", "", $url_a2);
                  if (!empty($url_a2) && file_exists($rutaLocal)) { ?>
                    <a class="list-group-item list-group-item-action active" style="max-width: 100px !important; max-height: 100px !important; padding:0;" id="list-image1-list" data-toggle="list" href="#list-image1" role="tab" aria-controls="image1">
                      <img src="<?php echo $rutaLocal; ?>" class="img-thumbnail">
                    </a>
                <?php }
                }
                ?>

                <!-- url3 -->
                <?php
                $subcadena = "http";
                // Verifica si la URL es una dirección externa
                if (strpos(strtolower($url_a3), strtolower($subcadena)) === 0) {
                  // Es una URL externa, asumimos que la imagen existe
                  if (!empty($url_a3)) { ?>
                    <a class="list-group-item list-group-item-action active" style="max-width: 100px !important; max-height: 100px !important; padding:0;" id="list-image1-list" data-toggle="list" href="#list-image1" role="tab" aria-controls="image1">
                      <img src="<?php echo $url_a3; ?>" class="img-thumbnail">
                    </a>
                  <?php }
                } else {
                  // Es una ruta local, verificamos si el archivo existe
                  $rutaLocal = 'sysadmin/' . str_replace("../..", "", $url_a3);
                  if (!empty($url_a3) && file_exists($rutaLocal)) { ?>
                    <a class="list-group-item list-group-item-action active" style="max-width: 100px !important; max-height: 100px !important; padding:0;" id="list-image1-list" data-toggle="list" href="#list-image1" role="tab" aria-controls="image1">
                      <img src="<?php echo $rutaLocal; ?>" class="img-thumbnail">
                    </a>
                <?php }
                }
                ?>

                <!-- url4 -->
                <?php
                $subcadena = "http";
                // Verifica si la URL es una dirección externa
                if (strpos(strtolower($url_a4), strtolower($subcadena)) === 0) {
                  // Es una URL externa, asumimos que la imagen existe
                  if (!empty($url_a4)) { ?>
                    <a class="list-group-item list-group-item-action active" style="max-width: 100px !important; max-height: 100px !important; padding:0;" id="list-image1-list" data-toggle="list" href="#list-image1" role="tab" aria-controls="image1">
                      <img src="<?php echo $url_a4; ?>" class="img-thumbnail">
                    </a>
                  <?php }
                } else {
                  // Es una ruta local, verificamos si el archivo existe
                  $rutaLocal = 'sysadmin/' . str_replace("../..", "", $url_a4);
                  if (!empty($url_a4) && file_exists($rutaLocal)) { ?>
                    <a class="list-group-item list-group-item-action active" style="max-width: 100px !important; max-height: 100px !important; padding:0;" id="list-image1-list" data-toggle="list" href="#list-image1" role="tab" aria-controls="image1">
                      <img src="<?php echo $rutaLocal; ?>" class="img-thumbnail">
                    </a>
                <?php }
                }
                ?>

                <!-- url5 -->
                <?php
                $subcadena = "http";
                // Verifica si la URL es una dirección externa
                if (strpos(strtolower($url_a5), strtolower($subcadena)) === 0) {
                  // Es una URL externa, asumimos que la imagen existe
                  if (!empty($url_a5)) { ?>
                    <a class="list-group-item list-group-item-action active" style="max-width: 100px !important; max-height: 100px !important; padding:0;" id="list-image1-list" data-toggle="list" href="#list-image1" role="tab" aria-controls="image1">
                      <img src="<?php echo $url_a5; ?>" class="img-thumbnail">
                    </a>
                  <?php }
                } else {
                  // Es una ruta local, verificamos si el archivo existe
                  $rutaLocal = 'sysadmin/' . str_replace("../..", "", $url_a5);
                  if (!empty($url_a5) && file_exists($rutaLocal)) { ?>
                    <a class="list-group-item list-group-item-action active" style="max-width: 100px !important; max-height: 100px !important; padding:0;" id="list-image1-list" data-toggle="list" href="#list-image1" role="tab" aria-controls="image1">
                      <img src="<?php echo $rutaLocal; ?>" class="img-thumbnail">
                    </a>
                <?php }
                }
                ?>
                <!-- Final de condiciones -->
                <!-- Repite para otras miniaturas -->
              </div>
            </div>
            <div class="col-lg-10" style="max-width: 600px !important;">
              <!-- Área principal de visualización de imagen -->
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-image1" role="tabpanel" aria-labelledby="list-image1-list">
                  <img id="main-image" src="<?php
                                            $subcadena = "http";
                                            if (strpos(strtolower($image_path), strtolower($subcadena)) === 0) {
                                            ?>
                      <?php echo  $image_path . '"'; ?>
                      <?php } else { ?>
                        sysadmin/<?php echo str_replace("../..", "", $image_path) ?>" <?php } ?> class="img-fluid" alt="Responsive image" data-toggle="modal" data-target="#imagenModal">
                </div>
                <!-- Repite para otras imágenes -->
              </div>
            </div>
          </div>

        </div>

        <div class="right-column">
          <div class="caja px-5" style="width:100%" ;>
            <div class="product-title"><?php echo $nombre_producto ?></div>
            <br>
            <div class="precios_producto">
              <div>
                <span style="font-size: 20px; color:#4461ed; padding-right: 10px;">
                  <strong><?php echo get_row('perfil', 'moneda', 'id_perfil', 1) . number_format($precio_especial, 2); ?></strong>
                </span>
              </div>
              <div>
                <?php if ($precio_normal > 0) { ?>
                  <span class="tachado" style="font-size: 20px; padding-right: 10px;">
                    <strong><?php echo get_row('perfil', 'moneda', 'id_perfil', 1) . number_format($precio_normal, 2); ?></strong>
                  </span>
                <?php
                }
                ?>
              </div>
              <?php if ($precio_normal > 0) { ?>
                <div class="px-2" style="background-color: #4464ec; color:white; border-radius: 0.3rem;">


                  <span class="ahorra"><i class="bx bxs-purchase-tag"></i>
                    <strong>AHORRA UN <?php echo number_format(100 - ($precio_especial * 100 / $precio_normal)); ?>%</strong>
                  </span>

                </div>
              <?php } ?>
            </div>
            <div class="container" style="margin-bottom: 20px;">


            </div>
            <!-- Inicio de Iconos-->
            <div class="d-flex flex-column">
              <?php
              include './auditoria.php';
              $sql = "SELECT * FROM caracteristicas_tienda WHERE accion=1 or accion=2 or accion=3";
              $query = mysqli_query($conexion, $sql);
              while ($row = mysqli_fetch_array($query)) {
                $texto = $row['texto'];
                $icon_text = $row['icon_text'];
                $enlace_icon = $row['enlace_icon'];
                $subtexto_icon = $row['subtexto_icon'];

                if ($enlace_icon == '') {
                  $enlace_icon = '';
                } else {
                  $enlace_icon = 'href="' . $enlace_icon . '" target="_blank" style="text-decoration: none; color: inherit;"';
                }
                //$image_path = 'https://cdn.icon-icons.com/icons2/2633/PNG/512/office_gallery_image_picture_icon_159182.png';
              ?>
                <div class="col-md-8">
                  <div class="icon_pequeno d-flex flex-row">
                    <div style="margin-right: 15px;">
                      <i class="fas <?php echo $icon_text ?>"></i> <!-- Cambia el icono según corresponda -->
                    </div>
                    <div>
                      <h5 class="card-title card-title_icon"><?php echo $texto ?></h5>
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
            <!-- Fin Iconos -->
            <!-- Otras opciones del producto -->
            <a style="height: 50px; font-size: 26px; width: 100%; border-radius: 15px" class="jump-button btn boton texto_boton " href="#" onclick="agregar_tmp(<?php echo $id_producto; ?>, <?php echo $precio_especial; ?>)" data-bs-toggle="modal" data-bs-target="#exampleModal">
              <span style="margin-top: 10px">COMPRAR AHORA </span></a><!-- comment -->


            <br><br>

            <br><br>
            <div class="contenedor-landing">
              <?php


              $rutaArchivo = 'sysadmin/vistas/ajax/' . get_row('landing', 'contenido', 'id_producto', $id_producto); // Reemplaza con la ruta correcta

              // Verifica si el archivo existe
              if (file_exists($rutaArchivo)) {
                // Carga y muestra el contenido del archivo HTML
                $rutaArchivo = file_get_contents($rutaArchivo);
                echo $rutaArchivo;
              } else {

                //echo $rutaArchivo;
                $contenido = get_row('landing', 'contenido', 'id_producto', $id_producto);
                if (strpos($contenido, 'http') !== false) {
                  //echo 'si';
                  $rutaArchivo = $contenido;
                  $rutaArchivo = file_get_contents($rutaArchivo);
                  echo $rutaArchivo;
                } else {
                  $rutaArchivo = '../ajax/' . $contenido; // Reemplaza con la ruta correcta   
                  // Verifica si el archivo existe
                  if (file_exists($rutaArchivo)) {
                    // Carga y muestra el contenido del archivo HTML
                    $rutaArchivo = file_get_contents($rutaArchivo);
                    echo $rutaArchivo;
                  } else {

                    //echo $rutaArchivo;
                    echo $contenido;
                  }
                }
              }
              ?>

            </div>
          </div>
        </div>
      </div>
      <!-- Inicio de Iconos-->
      <div class="iconos_producto col-md-12" style="padding-bottom: 75px;">
        <?php
        include './auditoria.php';
        $sql = "SELECT * FROM caracteristicas_tienda WHERE accion=1 or accion=2 or accion=3";
        $query = mysqli_query($conexion, $sql);
        while ($row = mysqli_fetch_array($query)) {
          $texto = $row['texto'];
          $icon_text = $row['icon_text'];
          $enlace_icon = $row['enlace_icon'];
          $subtexto_icon = $row['subtexto_icon'];

          if ($enlace_icon == '') {
            $enlace_icon = '';
          } else {
            $enlace_icon = 'href="' . $enlace_icon . '" target="_blank" style="text-decoration: none; color: inherit;"';
          }
          //$image_path = 'https://cdn.icon-icons.com/icons2/2633/PNG/512/office_gallery_image_picture_icon_159182.png';
        ?>
          <div class="col-md-4" style="padding-bottom: 20px;">
            <a <?php echo $enlace_icon ?>>
              <div class="card card_icon text-center">
                <div class="card-body card-body_icon d-flex flex-column">
                  <div>
                    <i class="fas <?php echo $icon_text ?> fa-2x"></i> <!-- Cambia el icono según corresponda -->
                  </div>
                  <div>
                    <h5 class="card-title card-title_icon"><?php echo $texto ?></h5>
                    <p class="card-text card-text_icon"><?php echo $subtexto_icon ?></p>
                  </div>
                </div>
              </div>
            </a>
          </div>
        <?php
        }
        ?>
      </div>
      <!-- Fin Iconos -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="imagenModal" tabindex="-1" aria-labelledby="imagenModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="imagenModalLabel">Visualización de Imagen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <img src="" id="imagenEnModal" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <!-- Botón flotante para WhatsApp -->
  <?php
  /*
  $ws_flotante = get_row('perfil', 'boton_compra_flotante', 'id_perfil', 1);
  if ($ws_flotante == 1) { ?>
    <a style="" class="btn-flotante-producto texto_boton" href="#" onclick="agregar_tmp(<?php echo $id_producto; ?>, <?php echo $precio_especial; ?>)" data-bs-toggle="modal" data-bs-target="#exampleModal">
      <span style="margin-top: 10px">COMPRAR AHORA </span></a>
  <?php } */?>

  <a style="" class="btn-flotante-producto texto_boton" href="#" onclick="agregar_tmp(<?php echo $id_producto; ?>, <?php echo $precio_especial; ?>)" data-bs-toggle="modal" data-bs-target="#exampleModal">
      <span style="margin-top: 10px">COMPRAR AHORA </span></a>

  <footer class="footer-contenedor">
    <?php
    $sql   = "SELECT * FROM  perfil  where id_perfil=1";
    $query = mysqli_query($conexion, $sql);
    while ($row = mysqli_fetch_array($query)) {
      $nombre_empresa       = $row['nombre_empresa'];
      $giro_empresa       = $row['giro_empresa'];
      $telefono       = $row['telefono'];
      $email       = $row['email'];
      $logo_url       = $row['logo_url'];
      $facebook       = $row['facebook'];
      $instagram       = $row['instagram'];
      $tiktok       = $row['tiktok'];

    ?>
      <div class="footer-contenido div-alineado-izquierda">
        <h4>Acerca de <?php echo $nombre_empresa ?></h4>
        <img id="navbarLogo" src="sysadmin/<?php echo str_replace("../..", "", $logo_url)
                                            ?>">
        <span class="descripcion">
          <?php echo $giro_empresa ?>
        </span>
      </div>
      <div class="footer-contenido">
        <h5>Legal</h5>
        <ul class="lista_legal">
          <?php
          $sql   = "SELECT * FROM  politicas_empresa";
          $query = mysqli_query($conexion, $sql);
          while ($row = mysqli_fetch_array($query)) {
            $nombre_politica       = $row['nombre'];
            $id_politica       = $row['id_politica'];
          ?>
            <li><a style="text-decoration: none; color:#5a5a5a" href="<?php echo $protocol ?>://<?php echo $domain ?>/politicas.php?id=<?php echo $id_politica ?>" target="_blank"><?php echo $nombre_politica; ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <div class="footer-contenido">
        <h5>Siguenos</h5>
        <div class="redes">
          <?php if ($facebook  !== "") { ?>
            <a class="icon-redes" href="<?php echo $facebook ?>">
              <img src="https://img.icons8.com/color/48/000000/facebook.png" alt="facebook">
            </a>
          <?php } ?>
          <?php if ($instagram  !== "") { ?>
            <a class="icon-redes" href="<?php echo $instagram ?>">
              <img src="https://img.icons8.com/color/48/000000/instagram-new.png" alt="instagram">
            </a>
          <?php } ?>
          <?php if ($tiktok  !== "") { ?>
            <a class="icon-redes" href="<?php echo $tiktok ?>">
              <img src="https://img.icons8.com/color/48/000000/tiktok.png" alt="tiktok">
            </a>
          <?php } ?>
        </div>
      </div>
      <div class="footer-contenido">
        <h5>
          Información de contacto
        </h5>
        <span class="descripcion">
          <span class="icons">
            <i class='bx bxl-whatsapp ws'></i> <?php echo $telefono ?>
          </span>
          <span class="icons">
            <i class='bx bx-mail-send send'></i><?php echo $email ?>
          </span>
        </span>
      </div>
    <?php } ?>

  </footer>
  <div class="text-center p-4 derechos-autor">© 2024 IMPORSUIT S.A. | Todos los derechos reservados.
  </div>


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script><!-- comment -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="js_nuevo/bootstrap.bundle.min.js" type="text/javascript"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="assets/js/custom_1.js"></script>
  <script>
    window.onscroll = function() {
      var nav = document.getElementById('navbarId'); // Asegúrate de que el ID coincida con el ID de tu navbar
      var logo = document.getElementById("navbarLogo");
      logo.style.maxHeight = "60px"; // o el tamaño que desees para el logo
      logo.style.maxWidth = "60px"; // o el tamaño que desees para el logo
      if (window.pageYOffset > 100) {
        nav.style.height = "70px";
        // Aquí también puedes cambiar otros estilos si es necesario, como el tamaño del logo o de la fuente
      } else {
        nav.style.height = "100px";
        logo.style.maxHeight = "100px"; // tamaño original del logo
        logo.style.maxWidth = "100px"; // tamaño original del logo
        // Restablece los estilos si el usuario vuelve a la parte superior de la página
      }
    };

    $('#imagenModal').on('show.bs.modal', function(event) {
      var imageSrc = $('#main-image').attr('src'); // Obtiene la fuente de la imagen principal
      $('#imagenEnModal').attr('src', imageSrc); // Establece la fuente en la imagen dentro del modal
    });
  </script>

  <script>
    $(document).ready(function() {
      // Actualiza la imagen principal cuando se hace clic en un enlace de la lista
      $('#list-tab a').on('click', function(e) {
        e.preventDefault();

        $('#list-tab a').removeClass('active'); // Remueve la clase 'active' de todos los enlaces
        $(this).addClass('active'); // Añade la clase 'active' al enlace clickeado

        var newSrc = $(this).find('img').attr('src');
        $('#main-image').attr('src', newSrc);
      });
    });
  </script>

  <script>
    // Función llamada si la imagen no puede cargarse
    function imagenError(image) {
      console.log("La imagen no pudo cargarse.");
      // Aquí puedes realizar una acción, como cargar una imagen de respaldo
      image.src = 'ruta/a/tu/imagen/por/defecto.jpg';
    }

    // Función llamada cuando la imagen se ha cargado correctamente
    function imagenCargada(image) {
      console.log("La imagen se cargó correctamente.");
      // Aquí puedes realizar acciones después de que la imagen haya cargado
      // Por ejemplo, podrías agregar una clase al elemento
      image.classList.add("cargada-correctamente");
    }
  </script>

</body>

</html>