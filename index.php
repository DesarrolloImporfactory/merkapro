<?php
session_start();
require_once "sysadmin/vistas/db.php";
require_once "sysadmin/vistas/php_conexion.php";
require_once "sysadmin/vistas/funciones.php";
// echo 'sysadmin/vistas/ajax/banner/'.get_row('perfil', 'banner', 'id_perfil', 1);
$id_producto = 0;
$pagina = 'INICIO';
//include './includes/style.php';
include './includes/style.php';

// Obtener el protocolo (http o https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Obtener el dominio (nombre de host)
$domain = $_SERVER['HTTP_HOST'];

//comprobacion de destacados
$consultaDestacados = "SELECT COUNT(*) AS total FROM productos WHERE destacado = '1'";
$resultadoDestacados = mysqli_query($conexion, $consultaDestacados);
$filaDestacados = mysqli_fetch_assoc($resultadoDestacados);

if ($filaDestacados['total'] == 0) {
   // No hay productos destacados, así que actualizamos 3 productos aleatoriamente
   $actualizarDestacados = "UPDATE productos SET destacado = '1' ORDER BY RAND() LIMIT 3";
   $resultadoActualizacion = mysqli_query($conexion, $actualizarDestacados);
}

?>
<!doctype html>
<html lang="es">

<head>



   <?php
   include './includes/head_1.php';
   ?>
   <link href="css_nuevo/bootstrap.min.css" rel="stylesheet" type="text/css" />
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
   <!-- librerias para el carrusel-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
   <!-- Fin librerias para el carrusel-->

   <meta name="theme-color" content="#7952b3">



   <link href="css_nuevo/carousel.css" rel="stylesheet" type="text/css" />
</head>

<body>

   <header>
      <nav id="navbarId" style="height: 100px" class="navbar navbar-expand-lg  fixed-top superior ">

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
         <div class="container">
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

         <div id="myCarousel" style="margin-top: 52px" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicadores dinámicos -->
            <div class="carousel-indicators">
               <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
               <?php for ($i = 1; $i <= $resultadoAdicionales->num_rows; $i++) : ?>
                  <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="<?php echo $i; ?>" aria-label="Slide <?php echo $i + 1; ?>"></button>
               <?php endfor; ?>
            </div>

            <div class="carousel-inner">
               <!-- Slide principal -->
               <div class="carousel-item active" style="background-image: url('<?php echo 'sysadmin/vistas/ajax/' . $banner; ?>');">
                  <div class="container">
                     <?php

                     ?>
                     <div class="carousel-caption <?php echo $alineacion; ?>">
                        <h1><?php echo $titulo_slider; ?></h1>
                        <p><?php echo $texto_slider; ?></p>
                        <?php if (!empty($text_btn_slider)) { ?>
                           <p><a class="btn btn-lg btn-primary boton texto_boton" href="<?php echo $enlace_btn_slider; ?>"><?php echo $text_btn_slider; ?></a></p>
                        <?php } ?>
                     </div>
                  </div>
               </div>

               <!-- Slides adicionales -->
               <?php while ($slide = $resultadoAdicionales->fetch_assoc()) :

                  $alineacion_slider_adicional = $slide['alineacion'];

                  if ($alineacion_slider_adicional == 1 or $alineacion_slider_adicional == 0 or $alineacion_slider_adicional == "") {
                     $alineacion_adicional = "text-start";
                  }
                  if ($alineacion_slider_adicional == 2) {
                     $alineacion_adicional = "";
                  }
                  if ($alineacion_slider_adicional == 3) {
                     $alineacion_adicional = "text-end";
                  } ?>
                  <div class="carousel-item" style="background-image: url('<?php echo 'sysadmin/vistas/ajax/' . $slide['fondo_banner']; ?>'); object-fit: fill;">
                     <div class="container">
                        <div class="carousel-caption <?php echo $alineacion_adicional; ?>">
                           <h1><?php echo $slide['titulo']; ?></h1>
                           <p><?php echo $slide['texto_banner']; ?></p>
                           <?php if (!empty($slide['texto_boton'])) { ?>
                              <p><a class="btn btn-lg btn-primary boton texto_boton" href="<?php echo $slide['enlace_boton']; ?>"><?php echo $slide['texto_boton']; ?></a></p>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               <?php endwhile; ?>
            </div>


            <!-- Controles -->
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
               <span class="carousel-control-prev-icon" aria-hidden="true"></span>
               <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
               <span class="carousel-control-next-icon" aria-hidden="true"></span>
               <span class="visually-hidden">Next</span>
            </button>
         </div>

      <?php
      } ?>

      <?php

      $sql   = "SELECT * FROM  perfil  where id_perfil=1";
      $query = mysqli_query($conexion, $sql);
      $estado = "";
      while ($row = mysqli_fetch_array($query)) {
         $estado = $row['flotante'];
      }

      if ($estado == 1) {
         $animacion = "padding-left: 100%; display: inline-block; animation: marqueeAnimation 40s linear infinite;";
      } else {
         $animacion = "text-align: center; justify-content: center; align-items: center;";
      } ?>

      <style>
         .marquee p {
            font-size: 18px;
            <?php echo $animacion ?>
         }
      </style>

      <div class="marquee-container">

         </p>
         <div class="marquee">
            <p style="font-size: 25px;">
               - <?php $sql   = "SELECT * FROM  horizontal  where posicion=1 or posicion is null";
                  $query = mysqli_query($conexion, $sql);
                  while ($row = mysqli_fetch_array($query)) {
                     $texto       = $row['texto'];
                  }
                  echo $texto . ' - '; ?>
         </div>
      </div>


      <!-- Marketing messaging and featurettes
  ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->
      <div class="container mt-4">
         <h1 style="text-align: center">Categorías</h1>
         <br>

         <!-- Categoria -->
         <div class="caja" style="margin-bottom: 50px" ;>
            <div class="owl-carousel owl-theme">
               <?php
               include './auditoria.php';
               $sql = "SELECT * FROM lineas WHERE tipo='1' AND online=1";
               $query = mysqli_query($conexion, $sql);
               while ($row = mysqli_fetch_array($query)) {
                  $id_linea = $row['id_linea'];
                  $nombre_linea = $row['nombre_linea'];
                  $image_path = $row['imagen'];
                  //$image_path = 'https://cdn.icon-icons.com/icons2/2633/PNG/512/office_gallery_image_picture_icon_159182.png';
               ?>
                  <div class="item">
                     <div class="category-container d-flex flex-column align-items-center">
                        <!-- <div class="category-image" style="background-image: url('sysadmin/<?php //echo str_replace("../..", "", $image_path) 
                                                                                                ?>');"></div> -->
                        <a href="categoria_1.php?id_cat=<?php echo $id_linea ?>" class="category-link">
                           <div class="category-image rounded-circle" style="background-image: url('sysadmin/<?php echo str_replace("../..", "", $image_path); ?>');"></div>
                        </a>

                        <a class="btn category-button boton texto_boton" style="border-radius: 0.5rem;" href="categoria_1.php?id_cat=<?php echo $id_linea ?>" role="button">
                           <?php echo $nombre_linea; ?>
                        </a>
                     </div>
                  </div>
               <?php } ?>
            </div>
         </div>
         <script>
            $(document).ready(function() {
               $(".owl-carousel").owlCarousel({
                  loop: false, // Establece a 'true' si quieres que el carrusel sea infinito
                  margin: 10,
                  responsive: {
                     0: {
                        items: 1
                     },
                     768: {
                        items: 2
                     },
                     992: {
                        items: 3
                     }
                  },
                  nav: true, // Muestra las flechas de navegación
                  navText: [
                     '<i class="fas fa-chevron-left"></i>',
                     '<i class="fas fa-chevron-right"></i>'
                  ] // Puedes personalizar el texto o el HTML de las flechas aquí
               });
            });
         </script>
         <!-- Fin Categoria -->

      </div>

      <?php
      $activar_destacados = get_row('perfil', 'activar_destacados', 'id_perfil', 1);
      if ($activar_destacados == 1) { ?>
      <div class="degraded-line"></div>
      
         
      <div class="container mt-4">
         <h1 style="text-align: center">Destacados</h1>
         <br>

         <!-- Productos -->
         <div class="owl-carousel owl-theme" style="margin-bottom: 50px">
            <?php
            $sql = "SELECT * FROM productos WHERE destacado=1";
            $query = mysqli_query($conexion, $sql);
            $num_registros = mysqli_num_rows($query);
            //echo $num_registros, ' Productos';
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
               $precio_normal      = $row['valor4_producto'];
               $stock_producto       = $row['stock_producto'];
               $stock_min_producto   = $row['stock_min_producto'];
               $online   = $row['pagina_web'];
               $status_producto      = $row['estado_producto'];
               $date_added           = date('d/m/Y', strtotime($row['date_added']));
               $image_path           = $row['image_path'];
               $id_imp_producto      = $row['id_imp_producto'];

            ?>
               <div class="item">
                  <div class="grid-container">
                     <div class="card" style="border-radius: 1rem; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                        <!-- Use inline styles or a dedicated class in your stylesheet to set the aspect ratio -->
                        <div class="img-container" style="aspect-ratio: 1 / 1; overflow: hidden; margin-bottom: -120px"><a href="producto_1.php?id=<?php echo $id_producto ?>">
                              <img src=" <?php
                                          $subcadena = "http";

                                          if (strpos(strtolower($image_path), strtolower($subcadena)) === 0) {
                                          ?>
                  <?php echo  $image_path . '"'; ?>
                <?php
                                          } else {
                  ?>
                 sysadmin/<?php echo str_replace("../..", "", $image_path) ?>" <?php
                                                                              }
                                                                                 ?> src="<?php
                                                                                          $subcadena = "http";

                                                                                          if (strpos(strtolower($image_path), strtolower($subcadena)) === 0) {
                                                                                          ?>
                <?php echo  $image_path . '"'; ?>
                <?php
                                                                                          } else {
                  ?>
               sysadmin/<?php echo str_replace("../..", "", $image_path) ?>" <?php
                                                                                          }
                                                                              ?> class="card-img-top mx-auto d-block" alt="Product Name" style="object-fit: cover; width: 55%; height: 55%; margin-top: 10px;">

                           </a>
                        </div>
                        <div class="card-body d-flex flex-column">
                           <p class="card-text flex-grow-1"><a href="producto_1.php?id=<?php echo $id_producto ?>" style="text-decoration: none; color:black;"><strong><?php echo $nombre_producto ?></strong></a></p>
                           <div class="product-footer mb-2">
                              <div class="d-flex flex-row">
                                 <div>
                                    <span style="font-size: 15px; color:#4461ed; padding-right: 10px;">
                                       <strong><?php echo get_row('perfil', 'moneda', 'id_perfil', 1) . number_format($precio_especial, 2); ?></strong>
                                    </span>
                                 </div>
                                 <div>
                                    <?php if ($precio_normal > 0) { ?>
                                       <span class="tachado" style="font-size: 15px; padding-right: 10px;">
                                          <strong><?php echo get_row('perfil', 'moneda', 'id_perfil', 1) . number_format($precio_normal, 2); ?></strong>
                                       </span>
                                    <?php
                                    }
                                    ?>
                                 </div>
                                 <?php if ($precio_normal > 0) { ?>
                                    <div class="px-2" style="background-color: #4464ec; color:white; border-radius: 0.3rem;">


                                       <span style="font-size: 15px;"><i class="bx bxs-purchase-tag"></i>
                                          <strong>AHORRA UN <?php echo number_format(100 - ($precio_especial * 100 / $precio_normal)); ?>%</strong>
                                       </span>

                                    </div>
                                 <?php } ?>
                              </div>
                           </div>
                           <a style="z-index:2; height: 40px; font-size: 16px" class="btn boton texto_boton mt-2" href="producto_1.php?id=<?php echo $id_producto ?>">Comprar</a>
                        </div>

                     </div>
                  </div>
               </div>
            <?php
            }

            ?>
         </div>
         <script>
            $(document).ready(function() {
               $(".owl-carousel").owlCarousel({
                  loop: false, // Establece a 'true' si quieres que el carrusel sea infinito
                  margin: 10, // Espacio entre elementos (tarjetas)
                  responsive: {
                     0: {
                        items: 1 // En pantallas muy pequeñas, muestra 1 elemento
                     },
                     576: { // Dispositivos extra pequeños (por ejemplo, teléfonos), se muestra 1 item
                        items: 2 // En pantallas medianas, muestra 2 elementos
                     },
                     768: { // Dispositivos pequeños (por ejemplo, tablets), se muestran 2 items
                        items: 2 // En pantallas medianas, muestra 2 elementos
                     },
                     992: { // Dispositivos medianos (por ejemplo, laptops), se muestran 3 items
                        items: 3 // En pantallas grandes, muestra 3 elementos
                     },
                     1200: { // Dispositivos grandes (por ejemplo, computadoras de escritorio), se muestran 4 items
                        items: 4 // Aquí le indicas que muestre 4 elementos
                     }
                  },
                  nav: true, // Para mostrar las flechas de navegación
                  navText: [
                     '<i class="fas fa-chevron-left"></i>',
                     '<i class="fas fa-chevron-right"></i>'
                  ] // Puedes personalizar el texto o el HTML de las flechas aquí
               });
            });
         </script>
         <!-- Fin Productos -->
      </div>
      <?php } ?>

      <!-- Iconos -->
      <div class="container" style="margin-bottom: 20px;">
         <div class="row">
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
               <div class="col-md-4 icon_responsive">
                  <a <?php echo $enlace_icon ?>>
                     <div class="card card_icon text-center">
                        <div class="card-body card-body_icon d-flex flex-row">
                           <div style="margin-right: 20px;">
                              <i class="fas <?php echo $icon_text ?> fa-2x"></i> <!-- Cambia el icono según corresponda -->
                           </div>
                           <div>
                              <h5 class="card-title card-title_icon"><?php echo $texto ?></h5>
                              <p class="card-text card-text_icon" style="font-size: 12px;"><?php echo $subtexto_icon ?></p>
                           </div>
                        </div>
                     </div>
                  </a>
               </div>
            <?php
            }
            ?>
         </div>
      </div>
      <!-- Fin Iconos -->

      <div class="marquee-container">
         <div class="marquee">
            <p>
               <?php

               $sql   = "SELECT * FROM  horizontal  where posicion=2";
               $query = mysqli_query($conexion, $sql);
               while ($row = mysqli_fetch_array($query)) {
                  $texto       = $row['texto'];
                  echo $texto . ' - ';
               } ?>
            </p>
         </div>
      </div>

      <?php
         $sql = "SELECT * FROM testimonios";
         $query = mysqli_query($conexion, $sql);
         $count = mysqli_num_rows($query);
         if ($count != 0) {
         ?>

      <div class="container mt-4 testimonios">

         <h1 style="text-align: center">Testimonios</h1>
         <br>
         <!-- Testimonios -->
         <div class="caja" style="margin-bottom: 50px" ;>
            <div class="owl-carousel owl-theme">
               <?php
               include './auditoria.php';
               $sql = "SELECT * FROM testimonios";
               $query = mysqli_query($conexion, $sql);
               while ($row = mysqli_fetch_array($query)) {
                  $id_testimonio = $row['id_testimonio'];
                  $nombre_testimonio = $row['nombre'];
                  $testimonio = $row['testimonio'];
                  $image_path = $row['imagen'];
                  //$image_path = 'https://cdn.icon-icons.com/icons2/2633/PNG/512/office_gallery_image_picture_icon_159182.png';
               ?>
                  <div class="item d-flex flex-column">
                     <div class="testimonios-container">
                        <div class="testimonios-image rounded-circle" style="background-image: url('sysadmin/<?php echo str_replace("../..", "", $image_path); ?>');">
                           <!-- Imagen del testimonio -->
                        </div>
                        <p class="card-text"><strong><?php echo $nombre_testimonio; ?></strong></p>
                        <p class="card-text testimonio-text"><?php echo $testimonio; ?></p>
                     </div>
                  </div>
               <?php } ?>
            </div>
         </div>
         <script>
            $(document).ready(function() {
               $(".owl-carousel").owlCarousel({
                  loop: false, // Establece a 'true' si quieres que el carrusel sea infinito
                  margin: 10,
                  responsive: {
                     0: {
                        items: 1
                     },
                     768: {
                        items: 2
                     },
                     992: {
                        items: 3
                     }
                  },
                  nav: true, // Muestra las flechas de navegación
                  navText: [
                     '<i class="fas fa-chevron-left"></i>',
                     '<i class="fas fa-chevron-right"></i>'
                  ] // Puedes personalizar el texto o el HTML de las flechas aquí
               });
            });
         </script>
         <!-- Fin Testimonios -->
      </div>
      <?php
      } ?>
      <!-- FOOTER -->
      <!-- Botón flotante para WhatsApp -->
      <?php
      function formatPhoneNumber($number)
      {
         // Eliminar caracteres no numéricos excepto el signo +
         $number = preg_replace('/[^\d+]/', '', $number);

         // Verificar si el número ya tiene el código de país +593
         if (!preg_match('/^\+593/', $number)) {
            // Si el número comienza con 0, quitarlo
            if (strpos($number, '0') === 0) {
               $number = substr($number, 1);
            }
            // Agregar el código de país +593 al inicio del número
            $number = '+593' . $number;
         }

         return $number;
      }

      // Usar la función formatPhoneNumber para imprimir el número formateado
      $telefono = get_row('perfil', 'telefono', 'id_perfil', 1);
      $telefonoFormateado = formatPhoneNumber($telefono);
      ?>

      <?php
      $ws_flotante = get_row('perfil', 'whatsapp_flotante', 'id_perfil', 1);
      if ($ws_flotante == 1) { ?>
         <a href="https://wa.me/<?php echo $telefonoFormateado ?>" class="whatsapp-float" target="_blank"><i class="bx bxl-whatsapp-square ws_flotante"></i></a>
      <?php } ?>

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


   </main>

   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
   <script src="js_nuevo/bootstrap.bundle.min.js" type="text/javascript"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   <!-- librerias para el carrusel-->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
   <!-- Fin librerias para el carrusel-->

   <!-- Bootstrap JS -->
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>

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
   </script>
</body>

</html>