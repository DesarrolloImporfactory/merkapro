<?php
session_start();
if (!isset($_SESSION["comprar"])) {
  $session_id = 'user_' . mt_rand();
  $_SESSION["comprar"] = $session_id;
} else {
  $session_id = $_SESSION["comprar"];
}
if (isset($_GET['id_cat'])) {
  $id_categoria = $_GET['id_cat'];
}

require_once "sysadmin/vistas/db.php";
require_once "sysadmin/vistas/php_conexion.php";
require_once "sysadmin/vistas/funciones.php";

$id_producto = 0;
$pagina = 'CATALOGO';
include './auditoria.php';
include './includes/style.php';
if (isset($_GET['id_cat'])) {
  $sql = "select * from lineas where online='1' and padre='$id_categoria'";
  //echo $sql;
  $query = mysqli_query($conexion, $sql);
  $categorias = '';
  while ($row = mysqli_fetch_array($query)) {
    $id_linea         = $row['id_linea'];
    $nombre_linea     = $row['nombre_linea'];
    $padre  = $row['padre'];
    $categorias .= "'" . $row['id_linea'] . "',";
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Asignación de valores mínimos y máximos desde el filtro de precios
  $valorMinimo = filter_input(INPUT_POST, 'valorMinimo', FILTER_SANITIZE_NUMBER_INT) ?? 0;
  $valorMaximo = filter_input(INPUT_POST, 'valorMaximo', FILTER_SANITIZE_NUMBER_INT) ?? 500;

  // Asignación de criterio de ordenamiento desde el formulario de ordenar por
  if (isset($_POST['ordenar_por'])) {
    $_SESSION['ordenar_por'] = $_POST['ordenar_por']; // Guardar en sesión
  }

  // Establecer $orderSql según la opción de ordenamiento seleccionada
  if (isset($_SESSION['ordenar_por'])) {
    switch ($_SESSION['ordenar_por']) {
      case 'Mayor precio':
        $orderSql = ' ORDER BY valor3_producto DESC';
        break;
      case 'Menor precio':
        $orderSql = ' ORDER BY valor3_producto ASC';
        break;
        // Otras condiciones según sea necesario
    }
  }
} else {
  // Valores por defecto si no se recibe una solicitud POST
  $valorMinimo = 0;
  $valorMaximo = 3000;
  $orderSql = ''; // Establecer un orden predeterminado si lo necesitas
}
?>
<!doctype html>
<html lang="es">

<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider/distribute/nouislider.min.css">
  <style>
    .card {
      transition: transform .2s;
      /* Animación para el efecto de hover */
    }

    .card:hover {
      transform: scale(1.05);
      /* Aumenta ligeramente el tamaño de la tarjeta al pasar el ratón */
    }

    .product-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .text-muted {
      text-decoration: line-through;
      /* Efecto tachado para el precio anterior */
    }

    .text-price {
      color: red;
      font-weight: bold;
    }

    .left-column {
      width: 20%;
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
      display: flex;
      flex-direction: column;
      align-items: center;
      /* Esto centrará sus hijos horizontalmente */
      align-self: start;
      /* Añade esta línea para alinear la propia .right-column al inicio de su contenedor flex */
      width: 80%;
      padding: 20px;
      padding-top: 60px;
      min-height: 600px;
      /* Ajusta esto según la altura mínima que desees */
    }

    .content_left_right {
      display: flex;
    }

    #accordionCategorias .card {
      margin-bottom: 0.5rem;
      border: none;
      /* Elimina los bordes si lo deseas */
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      /* Sombra suave para dar profundidad */
    }

    #accordionCategorias .card-header {
      padding: 0;
      /* Ajusta el relleno según sea necesario */
      background: #fff;
      /* Fondo blanco o el color que prefieras */
      border-bottom: 1px solid #eaeaea;
      /* Borde suave en la parte inferior */
    }

    #accordionCategorias .btn {
      width: 100%;
      /* Asegúrate de que los botones usen todo el ancho disponible */
      text-align: left;
      /* Alinea el texto a la izquierda */
      padding: 0;
      /* Ajusta el relleno para aumentar la altura de las filas */
      color: #333;
      /* Color de texto */
      background-color: transparent;
      /* Fondo transparente */
      border: none;
      /* Sin bordes */
      border-radius: 0.25rem;
      /* Esquinas ligeramente redondeadas */
    }

    #accordionCategorias .btn:hover,
    #accordionCategorias .btn:focus {
      color: #0056b3;
      /* Cambia el color del texto al pasar el mouse o enfocar */
      text-decoration: none;
      /* Elimina la decoración de subrayado */
      background-color: #f8f9fa;
      /* Fondo ligeramente más oscuro al pasar el mouse o enfocar */
    }

    #accordionCategorias .collapse.show {
      max-height: none;
      /* Asegúrate de que el contenido colapsable pueda expandirse completamente */
    }

    /* Transición suave para el colapso y la expansión */
    #accordionCategorias .collapse {
      transition: max-height 0.4s ease;
      padding-top: 0;
    }

    #accordionCategorias .btn {
      text-transform: capitalize;
      /* Solo la primera letra de cada palabra en mayúsculas */
      font-size: 1rem;
      /* Ajusta al tamaño de fuente deseado */
    }

    /* Esconde la columna izquierda en pantallas pequeñas */
    @media (max-width: 768px) {
      .left-column {
        display: none;
      }

      .right-column {
        width: 100%;
        padding: 0px;
      }
    }

    /* Estilo para el modal que ocupe toda la pantalla */
    .fullscreen-modal .modal-dialog {
      width: 100%;
      max-width: none;
      height: 100%;
      margin: 0;
    }

    .fullscreen-modal .modal-content {
      height: 100%;
      border-radius: 0;
    }

    /* Slide de rango de precions con noUiSlider */
    /* Base del Slider */
    .noUi-target {
      background-color: #B2B2B2;
      height: 10px;
      border-radius: 5px;
    }

    /* Conexión entre las manijas */
    .noUi-connect {
      background-color: <?php echo get_row('perfil', 'color', 'id_perfil', '1') ?>;
      /* Tu color de elección para la barra activa */
    }

    /* Manijas del Slider */
    .noUi-handle {
      outline: none;
      top: -5px;
      /* Ajusta esta propiedad para cambiar la posición vertical de la manija */
      border: 1px solid #D3D3D3;
      /* Borde de la manija */
      background-color: white;
      border-radius: 50%;
      width: 19px !important;
      /* Ancho de la manija */
      height: 19px !important;
      /* Altura de la manija */
      box-shadow: none;
      cursor: pointer;
      background-image: none !important;
    }

    .noUi-handle::after,
    .noUi-handle::before {
      content: none !important;
      /* Elimina el contenido de los pseudo-elementos */
    }

    /* Tooltips (los que muestran los valores encima de las manijas) */
    .noUi-tooltip {
      display: none;
      /* Oculta el tooltip por defecto de noUiSlider */
    }

    .caja_categorias {
      padding-top: 20px !important;
      padding-bottom: 40px !important;
      border-radius: 25px;
      -webkit-box-shadow: -2px 5px 5px 0px rgba(0, 0, 0, 0.23);
      -moz-box-shadow: -2px 2px 5px 0px rgba(0, 0, 0, 0.23);
      box-shadow: -2px 2px 5px 0px rgba(0, 0, 0, 0.23);
      background-color: white;
      position: relative;
      z-index: 10;
      /* Asegúrate de que esto sea mayor que el z-index de otros elementos */
      display: flex;
      /* Usa flexbox para alinear elementos internos */
      justify-content: flex-start;
      /* Alinea el menú a la izquierda */
      width: 100%;
      /* O el ancho que desees para esta caja */
      box-sizing: border-box;
      /* Asegura que el padding no añada al ancho total */
    }

    .filtro-flotante {
      position: absolute;
      right: 20;
    }

    .btn_filtro {
      font-size: 20px !important;
      background: transparent;
      color: black !important;
      border-radius: 0.5rem !important;
    }

    .row {
      width: 100%;
    }

    .ver-todo-btn {
      background-color: transparent;
      /* Hace que el fondo sea transparente */
      color: #b4b4b4;
      /* Establece el color inicial del texto */
      text-decoration: none;
      /* Elimina el subrayado */
      padding: .375rem .75rem;
      /* Añade algo de padding */
      border: 1px solid white;
      /* Añade un borde si lo deseas */
      border-radius: .25rem;
      /* Redondea las esquinas si lo deseas */
      transition: color .3s;
      /* Suaviza la transición del color */
    }

    .ver-todo-btn:hover {
      color: black;
      /* Cambia el color del texto al pasar el ratón por encima */
      background-color: rgba(255, 255, 255, .3);
      /* Opcional: cambia ligeramente el color de fondo al pasar el ratón por encima */
    }

    /* Estilo sin imagen doble de producto*/
    .image-sin-hover {
      position: relative;
    }

    /* Fin estilo sin imagen doble de producto*/

    /* Estilo imagen doble de producto*/
    .img-container {
      position: relative;
    }

    .img-container .hover-img {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      transition: opacity 0.7s ease-in-out;
      opacity: 0;
      display: block !important;
    }

    .img-container:hover .hover-img {
      opacity: 1;
    }

    .img-container:hover .primary-img {
      opacity: 0;
    }

    /* Fin estilo imagen doble de producto*/
  </style>
  <?php
  include './includes/head_1.php';
  ?>
  <link href="css_nuevo/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <meta name="theme-color" content="#7952b3">



  <link href="css_nuevo/carousel.css" rel="stylesheet" type="text/css" />
  <!-- Custom styles for this template -->

</head>

<body>
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

  <main>
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
    <div class="container-fluid mt-4">
      <h1 style="text-align: center">Categorías</h1>
      <br>
      <?php
      $categorias_acordion = mysqli_query($conexion, "SELECT * FROM lineas");
      ?>
      <div class="content_left_right">


        <!-- Modal -->
        <div class="modal fade fullscreen-modal" id="leftColumnModal" tabindex="-1" aria-labelledby="leftColumnModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <!-- Cabeza del modal con el botón de cerrar -->
              <div class="modal-header">
                <h5 class="modal-title" id="leftColumnModalLabel">Filtros</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <!-- Contenido del modal -->
              <div class="modal-body">
                <!-- Aquí incluyes el contenido de tu left-column -->
                <!-- Puedes hacerlo directamente o incluirlo con PHP como parte de la estructura de tu página -->
                <div class="filtro_productos caja px-3">
                  <!-- Acordeón -->
                  <div id="accordionCategorias" class="accordion">
                    <!-- Este es el acordeón padre para la categoría principal -->
                    <div class="card">
                      <div class="card-header d-flex flex-row justify-content-between align-items-center" id="headingCategorias">
                        <h5 class="mb-0 flex-grow-1">
                          <button class="btn collapsed" data-toggle="collapse" data-target="#collapseCategorias" aria-expanded="true" aria-controls="collapseCategorias"><strong>
                              Categorías
                            </strong></button>
                        </h5>
                        <!-- Botón Ver Todo al lado del título Categorías -->
                        <a href="categoria_1.php" class="ver-todo-btn ml-auto">ver todo</a>
                      </div>
                      <div id="collapseCategorias" class="collapse show" aria-labelledby="headingCategorias" data-parent="#accordionCategorias">
                        <div class="card-body">
                          <!-- Aquí comienza el acordeón anidado para las subcategorías -->
                          <div id="accordionSubcategorias" class="accordion">
                            <?php while ($categoria_acordion = mysqli_fetch_assoc($categorias_acordion)) : ?>
                              <div class="card">
                                <div class="card-header" id="heading-<?php echo htmlspecialchars($categoria_acordion['nombre_linea']); ?>">
                                  <h5 class="mb-0">
                                    <button type="button" class="btn" onclick="window.location.href='categoria_1.php?id_cat=<?php echo urlencode($categoria_acordion['id_linea']); ?>'">
                                      <?php echo htmlspecialchars($categoria_acordion['nombre_linea']); ?>
                                    </button>
                                  </h5>
                                </div>

                              </div>
                            <?php endwhile;
                            // Reiniciar el puntero al principio del conjunto de resultados
                            mysqli_data_seek($categorias_acordion, 0); ?>
                          </div>
                          <!-- Fin del acordeón anidado para las subcategorías -->
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Fin Acordeón -->

                  <div>
                    <form id="form-rango-precios-modal" method="post">
                      <div class="filter-header"><strong>Rango de precios</strong></div>
                      <div id="slider-rango-precios-modal"></div>
                      <p>Valor mínimo: $<span id="valorMinimo-modal">0</span></p>
                      <p>Valor máximo: $<span id="valorMaximo-modal">0</span></p>
                      <input type="hidden" id="inputValorMinimo-modal" name="valorMinimo" value="0">
                      <input type="hidden" id="inputValorMaximo-modal" name="valorMaximo" value="0">
                      <button type="submit" class="btn-filter">Filtrar</button>
                    </form>
                  </div>



                  <script>
                    document.getElementById('btn-filtrar').addEventListener('click', function() {
                      var valorMin = document.getElementById('valorMinimo').textContent;
                      var valorMax = document.getElementById('valorMaximo').textContent;

                      fetch('categoria_1.php', {
                          method: 'POST',
                          headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                          },
                          body: `valorMinimo=${valorMin}&valorMaximo=${valorMax}`
                        })
                        .then(response => response.text())
                        .then(data => {
                          // Suponiendo que la respuesta sea un fragmento de HTML con los productos filtrados
                          document.querySelector('.right-column').innerHTML = data;
                        })
                        .catch(error => console.error('Error:', error));
                    });
                  </script>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Fin Modal -->

        <div class="left-column d-none d-lg-block">
          <div class="filtro_productos caja px-3">
            <!-- Acordeón -->
            <div id="accordionCategorias" class="accordion">
              <!-- Este es el acordeón padre para la categoría principal -->
              <div class="card">
                <div class="card-header d-flex flex-row justify-content-between align-items-center" id="headingCategorias">
                  <h5 class="mb-0 flex-grow-1">
                    <button class="btn collapsed" data-toggle="collapse" data-target="#collapseCategorias" aria-expanded="true" aria-controls="collapseCategorias"><strong>
                        Categorías
                      </strong></button>
                  </h5>
                  <!-- Botón Ver Todo al lado del título Categorías -->
                  <a href="categoria_1.php" class="ver-todo-btn ml-auto">ver todo</a>
                </div>
                <div id="collapseCategorias" class="collapse show" aria-labelledby="headingCategorias" data-parent="#accordionCategorias">
                  <div class="card-body">
                    <!-- Aquí comienza el acordeón anidado para las subcategorías -->
                    <div id="accordionSubcategorias" class="accordion">
                      <?php while ($categoria_acordion = mysqli_fetch_assoc($categorias_acordion)) : ?>
                        <div class="card">
                          <div class="card-header" id="heading-<?php echo htmlspecialchars($categoria_acordion['nombre_linea']); ?>">
                            <h5 class="mb-0">
                              <button type="button" class="btn" onclick="window.location.href='categoria_1.php?id_cat=<?php echo urlencode($categoria_acordion['id_linea']); ?>'">
                                <?php echo htmlspecialchars($categoria_acordion['nombre_linea']); ?>
                              </button>
                            </h5>
                          </div>

                        </div>
                      <?php endwhile; ?>
                    </div>
                    <!-- Fin del acordeón anidado para las subcategorías -->
                  </div>
                </div>
              </div>
            </div>
            <!-- Fin Acordeón -->

            <div>
              <form id="form-rango-precios-left" method="post">
                <div class="filter-header"><strong>Rango de precios</strong></div>
                <div id="slider-rango-precios-left"></div>
                <p>Valor mínimo: $<span id="valorMinimo-left">0</span></p>
                <p>Valor máximo: $<span id="valorMaximo-left">0</span></p>
                <input type="hidden" id="inputValorMinimo-left" name="valorMinimo" value="0">
                <input type="hidden" id="inputValorMaximo-left" name="valorMaximo" value="0">
                <button type="submit" class="btn-filter">Filtrar</button>
              </form>
            </div>



            <script>
              document.getElementById('btn-filtrar').addEventListener('click', function() {
                var valorMin = document.getElementById('valorMinimo').textContent;
                var valorMax = document.getElementById('valorMaximo').textContent;

                fetch('categoria_1.php', {
                    method: 'POST',
                    headers: {
                      'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `valorMinimo=${valorMin}&valorMaximo=${valorMax}`
                  })
                  .then(response => response.text())
                  .then(data => {
                    // Suponiendo que la respuesta sea un fragmento de HTML con los productos filtrados
                    document.querySelector('.right-column').innerHTML = data;
                  })
                  .catch(error => console.error('Error:', error));
              });
            </script>
          </div>
        </div>

        <div class="right-column">
          <div class="caja_categorias">
            <form id="ordenarForm" method="post">
              <div class="custom-select-wrapper" onclick="this.querySelector('.custom-select').classList.toggle('open');">
                <div class="custom-select">
                  <div class="custom-select-trigger">Ordenar por</div>
                  <div class="custom-options">
                    <button type="submit" class="option" name="ordenar_por" value="Mayor precio">Mayor precio</button>
                    <button type="submit" class="option" name="ordenar_por" value="Menor precio">Menor precio</button>
                  </div>
                </div>
              </div>
              <!-- Campos ocultos para mantener los valores de rango de precios -->
              <input type="hidden" name="valorMinimo" value="<?php echo htmlspecialchars($valorMinimo); ?>">
              <input type="hidden" name="valorMaximo" value="<?php echo htmlspecialchars($valorMaximo); ?>">
            </form>
            <!-- Botón que se muestra solo en pantallas pequeñas -->
            <div class="d-lg-none filtro-flotante">
              <button type="button" class="btn_filtro btn" data-toggle="modal" data-target="#leftColumnModal">
                <i class='bx bxs-filter-alt'></i> Filtro
              </button>
            </div>
          </div>
          <div class="row" style="padding-top: 15;">
            <!-- Categoría 1 -->
            <?php
            if (isset($_GET['id_cat'])) {
              if (isset($categorias) and $categorias != '') {
                $lista_cat = substr($categorias, 0, -1);
                $sql = "select * from productos where (pagina_web='1' and stock_producto > 0 and id_linea_producto in ($lista_cat) and valor3_producto >= $valorMinimo and valor3_producto <= $valorMaximo or id_linea_producto=$id_categoria) " . $orderSql;
              } else {
                $lista_cat = "''";
                $sql = "select * from productos where (pagina_web='1' and stock_producto > 0 and id_linea_producto=$id_categoria and valor3_producto >= $valorMinimo and valor3_producto <= $valorMaximo) " . $orderSql;
              }
            } else {
              $sql = "select * from productos where  (pagina_web='1' and stock_producto > 0 and valor3_producto >= $valorMinimo and valor3_producto <= $valorMaximo) " . $orderSql;
            }

            $query = mysqli_query($conexion, $sql);
            if (!$query) {
              die("Error en la consulta: " . mysqli_error($conexion));
            }
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
              $url_a1            = $row['url_a1'];

            ?>

              <div class="col-6 col-md-4 col-lg-3" style="padding-bottom: 15px;">
                <div class="card h-100" style="border-radius: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                  <!-- Use inline styles or a dedicated class in your stylesheet to set the aspect ratio -->
                  <a href="producto_1.php?id=<?php echo $id_producto ?>" class="category-link">

                    <?php
                    // condicion para poner el hover si existe el secundario
                    $secondaryImagePath2 = strpos(strtolower($url_a1), "http") === 0 ? $url_a1 : 'sysadmin/' . str_replace("../..", "", $url_a1);
                    if (!empty($url_a1) && @getimagesize($secondaryImagePath2)) { // El @ suprime los errores si getimagesize falla
                    ?>
                      <div class="img-container d-flex" style="aspect-ratio: 1 / 1; overflow: hidden; justify-content: center; align-items: center;">
                      <?php } else { ?>
                        <div class="image-sin-hover d-flex" style="aspect-ratio: 1 / 1; overflow: hidden; justify-content: center; align-items: center;">
                        <?php } ?>

                        <img src="<?php echo strpos(strtolower($image_path), "http") === 0 ? $image_path : 'sysadmin/' . str_replace("../..", "", $image_path); ?>" class="card-img-top primary-img" alt="Nombre del Producto" style="object-fit: cover; width: 80%; height: 80%;">
                        <?php
                        // Suponiendo que $url_a1 es la URL de la imagen secundaria
                        $secondaryImagePath = strpos(strtolower($url_a1), "http") === 0 ? $url_a1 : 'sysadmin/' . str_replace("../..", "", $url_a1);
                        if (!empty($url_a1) && @getimagesize($secondaryImagePath)) { // El @ suprime los errores si getimagesize falla
                        ?>
                          <img src="<?php echo $secondaryImagePath; ?>" class="card-img-top hover-img" alt="Imagen Secundaria del Producto" style="object-fit: cover; width: 80%; height: 80%;">
                        <?php } ?>
                        </div>

                  </a>
                  <div class="card-body d-flex flex-column">
                    <a href="producto_1.php?id=<?php echo $id_producto ?>" style="text-decoration: none; color:black;">
                      <h6 class="card-title titulo_producto"><?php echo $nombre_producto; ?></h6>
                    </a>
                    <div class="product-footer mb-2">

                      <span class="text-muted"><?php if ($precio_normal > 0) {
                                                  echo get_row('perfil', 'moneda', 'id_perfil', 1) . $precio_normal;
                                                } ?></span>

                      <span class="text-price"><?php echo get_row('perfil', 'moneda', 'id_perfil', 1) . number_format($precio_especial, 2); ?></span>
                    </div>
                    <a style="z-index:2; height: 40px; font-size: 16px; margin-top: auto !important;" class="btn boton texto_boton mt-2" href="#" onclick="agregar_tmp(<?php echo $id_producto; ?>, <?php echo $precio_especial; ?>)" data-bs-toggle="modal" data-bs-target="#exampleModal">Comprar</a>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>

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
  <script src="assets/js/jquery-2.1.4.min.js" type="text/javascript"></script>
  <script src="https://cdn.jsdelivr.net/npm/nouislider/distribute/nouislider.min.js"></script>
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

    // Función para inicializar un slider
    function initSlider(sliderId, valorMinimoId, valorMaximoId, inputValorMinimoId, inputValorMaximoId, onSliderUpdateCallback) {
      var slider = document.getElementById(sliderId);
      noUiSlider.create(slider, {
        start: [parseInt(localStorage.getItem(inputValorMinimoId) || 0), parseInt(localStorage.getItem(inputValorMaximoId) || 3000)],
        connect: true,
        range: {
          'min': 0,
          'max': 3000
        }
      });

      slider.noUiSlider.on('update', function(values, handle) {
        var value = values[handle];
        var valorMinimo = document.getElementById(valorMinimoId);
        var valorMaximo = document.getElementById(valorMaximoId);
        var inputValorMinimo = document.getElementById(inputValorMinimoId);
        var inputValorMaximo = document.getElementById(inputValorMaximoId);

        if (handle) {
          valorMaximo.textContent = Math.round(value);
          inputValorMaximo.value = Math.round(value);
          localStorage.setItem(inputValorMaximoId, Math.round(value));
        } else {
          valorMinimo.textContent = Math.round(value);
          inputValorMinimo.value = Math.round(value);
          localStorage.setItem(inputValorMinimoId, Math.round(value));
        }

        // Ejecutar el callback después de actualizar el slider
        if (onSliderUpdateCallback) {
          onSliderUpdateCallback(values[0], values[1]);
        }
      });
    }

    document.addEventListener('DOMContentLoaded', function() {
      initSlider('slider-rango-precios-left', 'valorMinimo-left', 'valorMaximo-left', 'inputValorMinimo-left', 'inputValorMaximo-left');
      initSlider('slider-rango-precios-modal', 'valorMinimo-modal', 'valorMaximo-modal', 'inputValorMinimo-modal', 'inputValorMaximo-modal');

      // Obtén las instancias de noUiSlider para cada slider
      const sliderLeft = document.getElementById('slider-rango-precios-left').noUiSlider;
      const sliderModal = document.getElementById('slider-rango-precios-modal').noUiSlider;

      // Función para sincronizar los sliders
      function sincronizarSliders(sourceSlider, targetSlider) {
        sourceSlider.on('update', function(values) {
          // Verifica si los valores son diferentes para evitar la actualización innecesaria
          const targetValues = targetSlider.get().map(v => parseFloat(v));
          if (values[0] != targetValues[0] || values[1] != targetValues[1]) {
            targetSlider.set(values);
          }
        });
      }

      // Sincroniza los sliders entre sí
      sincronizarSliders(sliderLeft, sliderModal);
      sincronizarSliders(sliderModal, sliderLeft);
    });
  </script>
</body>

</html>