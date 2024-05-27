<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Decodifica el JSON recibido en el cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

require_once "sysadmin/vistas/db.php";
require_once "sysadmin/vistas/php_conexion.php";
// Conexión a la base de datos (asegúrate de tener tu conexión establecida aquí)
// $conexion = new mysqli('localhost', 'usuario', 'contraseña', 'base_de_datos');

// Verifica si la decodificación fue exitosa
if ($data) {
    // Obtener el último id_factura
    $sql_last = "SELECT MAX(id_factura) as id_factura FROM facturas_cot";
    $result = mysqli_query($conexion, $sql_last);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $id_factura = $row['id_factura'] + 1;
    } else {
        $id_factura = 1;
    }

    // Preparar la consulta de inserción
    $sql_insert = "INSERT INTO `facturas_cot`(
        `numero_factura`, 
        `fecha_factura`, 
        `id_cliente`, 
        `id_vendedor`, 
        `condiciones`, 
        `monto_factura`, 
        `estado_factura`, 
        `id_users_factura`, 
        `validez`, 
        `id_sucursal`, 
        `nombre`, 
        `telefono`, 
        `provincia`, 
        `c_principal`, 
        `ciudad_cot`, 
        `c_secundaria`, 
        `referencia`, 
        `observacion`, 
        `guia_enviada`, 
        `transporte`, 
        `identificacion`, 
        `celular`, 
        `cod`, 
        `valor_seguro`, 
        `drogshipin`, 
        `tienda`, 
        `importado`, 
        `plataforma_importa`, 
        `estado_guia_sistema`, 
        `id_factura_origen`, 
        `impreso`
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexion, $sql_insert);

    if ($stmt === false) {
        die('Error al preparar la consulta: ' . mysqli_error($conexion));
    }

    // Recorre cada elemento del arreglo principal
    foreach ($data as $item) {
        $numero_factura = "REQ-000" . $id_factura;
        //separa celular por medio de -
        $celular = explode('-', $item['celular']);
        $celular = $celular[0];
        // Vincular los parámetros
        mysqli_stmt_bind_param(
            $stmt,
            "ssiiidiiiisssssssssssssssssssii",
            $numero_factura,
            $item['fecha_factura'],
            $item['id_cliente'],
            $item['id_vendedor'],
            $item['condiciones'],
            $item['monto_factura'],
            $item['estado_factura'],
            $item['id_users_factura'],
            $item['validez'],
            $item['id_sucursal'],

            $item['nombre'],
            $item['telefono'],
            $item['provincia'],
            $item['c_principal'],
            $item['ciudad_cot'],
            $item['c_principal'],
            $item['c_principal'],
            $item['observacion'],
            $item['guia_enviada'],
            $item['transporte'],

            $item['identificacion'],
            $celular,
            $item['cod'],
            $item['valor_seguro'],
            $item['drogshipin'],
            $item['tienda'],
            $item['importado'],
            $item['plataforma_importa'],
            $item['estado_guia_sistema'],
            $item['id_factura_origen'],
            $item['impreso'],
        );

        // Ejecutar la consulta
        if (!mysqli_stmt_execute($stmt)) {
            print_r($smtp);
            echo 'Error al ejecutar la consulta: ' . mysqli_stmt_error($stmt);
        }

        $id_factura++; // Incrementar el ID de factura para la próxima inserción
    }

    // Cerrar la declaración
    mysqli_stmt_close($stmt);
} else {
    echo "Error al decodificar el JSON.";
}

// Cerrar la conexión
// mysqli_close($conexion);
