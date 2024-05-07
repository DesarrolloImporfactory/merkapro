<!DOCTYPE html>
<?php

//echo $session_id;
require_once "sysadmin/vistas/db.php";
require_once "sysadmin/vistas/php_conexion.php";
require_once "sysadmin/vistas/funciones.php";
?>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    
    body {
      background-image: url('sysadmin/img_sistema/fondo.jpeg'); /* Reemplaza 'ruta/a/tu/imagen.jpg' con la ruta de tu imagen de fondo */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }
    .logo {
      text-align: center;
      margin-bottom: 20px;
    }
    .logo img {
      max-width: 100%;
      height: auto;
    }
    .container {
      background-color: rgba(255, 255, 255, 0.95); /* Fondo semitransparente blanco para mejorar la legibilidad del contenido */
      border-radius: 10px;
      padding: 20px;
      margin-top: 20px;
    }
  </style>
  <title>Lista de Proveedores</title>
</head>
<body>

<div class="container mt-5">
  <div class="logo">
     
      <img width="150px" src="sysadmin/img_sistema/logo.png" alt="Logo de la empresa"> <!-- Reemplaza 'ruta/a/tu/logo.png' con la ruta de tu logo -->
  </div>
  <h2 class="mb-4">Lista de Proveedores</h2>
  
											<div class="input-group">
												<input type="text" class="form-control" id="q" placeholder="Buscar por NOMBRE, CATEGORÍA O PAÍS" onkeyup='load(1);' autocomplete="off">
                                                                                                <select class="form-control" id="q2" name="q2" onchange="load()">
                                                                                                    <option value="">Seleccione País</option>
                                                                                                    <option value="ECUADOR">ECUADOR</option>
                                                                                                    <option value="COLOMBIA">COLOMBIA</option>
                                                                                                    <option value="PERÚ">PERÚ</option>
                                                                                                    <option value="CHILE">CHILE</option>
                                                                                                    <option value="CHINA">CHINA</option>
                                                                                                </select>
                                                                                                
										
												</div>
											
  
  <div class="datos_ajax_delete"></div><!-- Datos ajax Final -->
									<div class='outer_div'></div><!-- Carga los datos ajax -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Agrega el script de Bootstrap y jQuery al final para mejorar el rendimiento -->
<script type="text/javascript" src="js/proveedores_marketplace.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
