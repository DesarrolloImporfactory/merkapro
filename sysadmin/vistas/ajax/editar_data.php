<?php
$nombre = $_POST['nombredestino'];
$identificacion = $_POST['identificacion'];
$telefono = $_POST['telefono'];
$celular = $_POST['telefono'];
$provinica = $_POST['provinica'];
$ciudad_entrega = $_POST['ciudad_entrega'];
$direccion = $_POST['direccion'];

// separar direccion en calle principal y secundaria el separador es el 'y'
$separador = 'y';
$pos = strpos($direccion, $separador);
$calle_principal = substr($direccion, 0, $pos);
$calle_secundaria = substr($direccion, $pos + strlen($separador));

$referencia = $_POST['referencia'];
$numerocasa = $_POST['numerocasa'];
