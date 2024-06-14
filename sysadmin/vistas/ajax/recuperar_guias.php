<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once '../db.php';
require_once '../php_conexion.php';

// Verificar conexión
if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

$sql = "SELECT * 
FROM guia_laar 
WHERE guia_laar IN (
    'MKP251', 'MKP253', 'MKP254', 'MKP255', 'MKP257', 'MKP258', 'MKP334', 'MKP344',
    'MKP382', 'MKP383', 'MKP386', 'MKP390', 'MKP391', 'MKP398', 'MKP399', 'MKP400',
    'MKP406', 'MKP408', 'MKP409', 'MKP410', 'MKP411', 'MKP415', 'MKP416', 'MKP418',
    'MKP422', 'MKP424', 'MKP426', 'MKP462', 'MKP465', 'MKP466', 'MKP474', 'MKP476',
    'MKP481', 'MKP486', 'MKP488', 'MKP489', 'MKP491', 'MKP496', 'MKP497', 'MKP498',
    'MKP503', 'MKP507', 'MKP508', 'MKP514', 'MKP520', 'MKP521', 'MKP523', 'MKP527',
    'MKP529', 'MKP530', 'MKP532', 'MKP533', 'MKP534', 'MKP553', 'MKP557', 'MKP559',
    'MKP560', 'MKP561', 'MKP564', 'MKP566', 'MKP567', 'MKP569', 'MKP571', 'MKP572',
    'MKP590', 'MKP592', 'MKP593', 'MKP595', 'MKP597', 'MKP598', 'MKP599', 'MKP619',
    'MKP620', 'MKP621', 'MKP622', 'MKP626', 'MKP628', 'MKP629', 'MKP631', 'MKP637',
    'MKP638', 'MKP640', 'MKP641', 'MKP642', 'MKP645', 'MKP646', 'MKP647', 'MKP648',
    'MKP651', 'MKP653', 'MKP654', 'MKP657'
)";
$result = mysqli_query($conexion, $sql);

if (!$result) {
    die("Error en la consulta SELECT: " . mysqli_error($conexion));
}
$req = 800;
while ($rw = mysqli_fetch_array($result)) {
    $nombre = $rw['nombreD'];
    $guia_laar = $rw['guia_laar'];
    $proveedor = $rw['tienda_proveedor'];
    $tienda_venta = $rw['tienda_venta'];
    $fecha = $rw['fecha'];
    $estado_guia = $rw['estado_guia'];
    $precio_envio = $rw['costoflete'];
    $total_venta = $rw['costoproducto'];
    $costo = $rw['valor_costo'];
    $monto_recibir = $total_venta - $costo - $precio_envio;
    $valor_cobrado = 0;
    $valor_pendiente = $monto_recibir;
    $cod = $rw['cod'];

    $insert_cuenta_pagar = "INSERT INTO cabecera_cuenta_pagar 
        (numero_factura, fecha, cliente, tienda, estado_guia, total_venta, costo, precio_envio, monto_recibir, valor_cobrado, valor_pendiente, guia_laar, visto, cod, proveedor) 
        VALUES 
        ('$req-P', '$fecha', '$nombre', '$tienda_venta', '$estado_guia', '$total_venta', '$costo', '$precio_envio', '$monto_recibir', '$valor_cobrado', '$valor_pendiente', '$guia_laar', 0, '$cod', '$proveedor')";

    $resultado_cuenta_pagar = mysqli_query($conexion, $insert_cuenta_pagar);

    if (!$resultado_cuenta_pagar) {
        echo "Error en la consulta INSERT: " . mysqli_error($conexion) . "<br>";
        echo "Consulta: " . $insert_cuenta_pagar . "<br>";
    } else {
        echo "Registro insertado correctamente: " . $insert_cuenta_pagar . "<br>";
    }

    $req++;
}

mysqli_close($conexion);
