<?php
$numero_factura = file_get_contents('php://input');

require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
require_once "../funciones.php"; //Contiene funcion que conecta a la base de datos
require_once "../funciones_destino.php";
if (
    isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
) {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}
$server_url = $protocol . $_SERVER['HTTP_HOST'];

// verifica si ya existe la facutra en la tabla de cuenta por cobrar
$existeFactura_sql = "SELECT * FROM `cabecera_cuenta_cobrar` WHERE numero_factura = '$numero_factura'";
$existeFactura_query = mysqli_query($conexion, $existeFactura_sql);
$existeFactura = mysqli_num_rows($existeFactura_query);
if ($existeFactura > 0) {
    echo json_encode('existe');
    exit;
}

$conexion = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);
$conexion->set_charset("utf8");

$consulta = "SELECT * FROM facturas_cot WHERE numero_factura = '$numero_factura'";

$resultado = mysqli_query($conexion, $consulta);

$datos = mysqli_fetch_array($resultado);

$numero_factura = $datos['numero_factura'];
$fecha = $datos['fecha_factura'];
$nombre_cliente = $datos['nombre'];
$tienda = $datos['tienda'];
$estado_pedido = $datos['estado_factura'];
$guia_enviada = $datos['guia_enviada'];
$ciudad_cot = $datos['ciudad_cot'];
$id_factura = $datos['id_factura'];
$id_pedido_origen = $datos['id_factura_origen'];

$tieneGuias_sql = "SELECT * FROM `guia_laar` WHERE id_pedido = '$id_pedido_origen'";

$tieneGuias_query = mysqli_query($conexion, $tieneGuias_sql);

$tieneGuias = mysqli_num_rows($tieneGuias_query);

if (empty($tieneGuias)) {
    echo json_encode('no_guias');
    exit;
}

$producto_id = get_row('detalle_fact_cot', 'id_producto', 'id_factura', $id_factura);



$costo_total = get_row('productos', 'costo_producto', 'id_producto', $producto_id);

$valor_base = get_row('ciudad_laar', 'precio', 'codigo', $ciudad_cot);
$total_guia = get_row('guia_laar', 'costoproducto', 'id_pedido', $id_pedido_origen);
if (get_row('guia_laar', 'cod', 'id_pedido', $id_pedido_origen) == 1) {
    $valor_base = $valor_base + ($total_guia * 0.03);
}
if (get_row('guia_laar', 'valorDeclarado', 'id_pedido', $id_pedido_origen) > 1) {
    $valor_base = $valor_base + (get_row('guia_laar', 'valorDeclarado', 'id_pedido', $id_pedido_origen) * 0.01);
}
$costo_guia = get_row('guia_laar', 'valor_costo', 'id_pedido', $id_pedido_origen);

$valor_total = get_row('productos', 'valor1_producto', 'id_producto', $producto_id);

$monto_recibir = $total_guia - $valor_base - $costo_guia;



$sql_cc = "INSERT INTO `cabecera_cuenta_cobrar`(`numero_factura`, `fecha`, `cliente`, `tienda`, `estado_guia`, `estado_pedido`, `total_venta`, `costo`, `precio_envio`, `monto_recibir`,`valor_pendiente`) VALUES ('$numero_factura','$fecha','$nombre_cliente','$tienda','2','$estado_pedido','$valor_total','$costo_total','$valor_base','$monto_recibir','$monto_recibir')";

$query_insertar_cc = mysqli_query($conexion, $sql_cc);

echo mysqli_error($conexion);

if ($query_insertar_cc) {

    echo json_encode('ok');
} else {
    echo json_encode('error');
}
