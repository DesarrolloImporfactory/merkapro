<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
define('DB_USER', 'danielbonilla522@gmail.com');
define('DB_PASS', 'Mark2demasiado.');
$credenciales= array('usuario' => DB_USER, 'contrasena' => DB_PASS);
echo json_encode($credenciales);