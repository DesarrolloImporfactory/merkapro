<?php
// Obtener el protocolo (http o https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Obtener el dominio (nombre de host)
$domain = $_SERVER['HTTP_HOST'];

// Obtener la URL base completa
$base_url = $protocol . '://' . $domain;

// Imprimir la URL base
//echo $base_url;
?>
<title><?php echo get_row('perfil', 'nombre_empresa', 'id_perfil', '1') ?></title>
<link rel="apple-touch-icon" href="sysadmin/<?php echo str_replace("../..", "", get_row('perfil', 'logo_url', 'id_perfil', '1')) ?>">
<link rel="shortcut icon" type="image/x-icon" href="sysadmin<?php
                                                            if (get_row('perfil', 'favicon', 'id_perfil', '1') == "") {
                                                               echo "/assets/images/favicon.png";
                                                            } else {
                                                               echo str_replace("../..", "", get_row('perfil', 'favicon', 'id_perfil', '1'));
                                                            }
                                                            ?>">
<meta name="title" content="<?php echo get_row('perfil', 'nombre_empresa', 'id_perfil', '1') ?>">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="">
<title>
   <?php echo get_row('perfil', 'nombre_empresa', 'id_perfil', '1') ?>
</title>
<meta property="og:site_name" content="<?php echo get_row('perfil', 'nombre_empresa', 'id_perfil', '1') ?>">
<meta property="og:url" content="<?php echo $base_url; ?>">
<meta property="og:title" content="<?php echo get_row('perfil', 'nombre_empresa', 'id_perfil', '1') ?>">
<meta property="og:type" content="website">
<meta property="og:description" content="<?php echo get_row('perfil', 'giro_empresa', 'id_perfil', '1') ?>">
<meta property="og:image" content="<?php echo $base_url; ?>/sysadmin/<?php echo str_replace("../..", "", get_row('perfil', 'logo_url', 'id_perfil', '1')) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo get_row('perfil', 'nombre_empresa', 'id_perfil', '1') ?>">
<meta name="twitter:description" content="<?php echo get_row('perfil', 'nombre_empresa', 'id_perfil', '1') ?>">
<?php
$sql = "select * from pixel where id_pixel= 1";
$query = mysqli_query($conexion, $sql);
$row = mysqli_fetch_array($query);

?>

<!-- Meta Pixel Code -->
<script>
   ! function(f, b, e, v, n, t, s) {
      if (f.fbq) return;
      n = f.fbq = function() {
         n.callMethod ?
            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
      };
      if (!f._fbq) f._fbq = n;
      n.push = n;
      n.loaded = !0;
      n.version = '2.0';
      n.queue = [];
      t = b.createElement(e);
      t.async = !0;
      t.src = v;
      s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
   }(window, document, 'script',
      'https://connect.facebook.net/en_US/fbevents.js');
   //track imporsuit
   fbq('init', '1868724866850222');
   fbq('init', '<?php echo $row['pixel'] ?>');
   fbq('track', 'PageView');
   fbq('track', 'ViewContent');
</script>

<?php
$sql_pixeles = "SELECT * FROM pixel WHERE id_pixel > 1";
$query_pixeles = mysqli_query($conexion, $sql_pixeles);

while ($row_pixeles = mysqli_fetch_array($query_pixeles)) {
   $pixel = $row_pixeles['pixel'];
   echo $pixel; // Asegúrate de que $pixel contiene el script correcto y no necesita más procesamiento.
}
?>

<noscript>
   <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=260280873723650&ev=PageView&noscript=1" /></noscript>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- End Meta Pixel Code -->