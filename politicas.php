<?php
session_start();
require_once "sysadmin/vistas/db.php";
require_once "sysadmin/vistas/php_conexion.php";
require_once "sysadmin/vistas/funciones.php";
// echo 'sysadmin/vistas/ajax/banner/'.get_row('perfil', 'banner', 'id_perfil', 1);

$pagina = 'INICIO';

include './includes/style.php';
$id_politica = $_GET['id'];


// Obtener el protocolo (http o https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Obtener el dominio (nombre de host)
$domain = $_SERVER['HTTP_HOST'];


?>
<!doctype html>
<html lang="es">

<head>
  <style>
    html,
    body {
      height: 100%;
      margin: 0;
      padding-bottom: 0 !important;
    }

    body {
      display: flex;
      flex-direction: column;
    }
    main {
      flex: 1 0 auto;
      /* La página principal ocupa el espacio necesario */
    }

    .footer-contenedor {
      flex-shrink: 0;
      /* Esto asegura que el footer no se encoja */
    }
    .caja div{
      margin: 0 !important;
    }
    .documento_politica {
      width: 75%; 
      margin: 0 auto;
    }
    @media (max-width: 768px) {
    .documento_politica {
      width: 90%; 
    }
  }
  </style>

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

  <main style="background-color: #f9f9f9; padding-top: 100px; padding-bottom:30px;">
    <section class="caja documento_politica">

      <?php
      echo get_row('politicas_empresa', 'politica', 'id_politica', $id_politica);
      ?>
    </section>


    </section>
  </main>
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

  <footer>
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
      <div class="d-flex flex-column">
        <div class="footer-contenedor">
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
        </div>
        <div class="text-center p-4 derechos-autor">© 2024 IMPORSUIT S.A. | Todos los derechos reservados.
        </div>
      </div>
  </footer>





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