<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once '../db.php';
require_once '../php_conexion.php';

// Verificar conexión
if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

$sql = "SELECT * FROM guia_laar WHERE guia_laar IS NOT NULL and estado_guia not in (2,3,4,5,6,8,101)";
$result = mysqli_query($conexion, $sql);

if (!$result) {
    die("Error en la consulta SELECT: " . mysqli_error($conexion));
}

$req = 00001;
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
