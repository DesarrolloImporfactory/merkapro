<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['mod_id'])) {
    $errors[] = "ID vacío";
} else if (
    !empty($_POST['mod_id'])
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    require_once "../funciones.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    //$nombre      = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_nombre"], ENT_QUOTES)));
    //$descripcion = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_descripcion"], ENT_QUOTES)));
    $estado      = intval($_POST['mod_estado']);
    $id      = intval($_POST['mod_id']);



    $sql = "UPDATE facturas_cot SET  estado_factura=" . $estado . ", estado_guia_sistema= " . $estado . "
                                WHERE id_factura='" . $id . "'";

    $sql_id_factura_origen = "SELECT id_factura_origen, tienda FROM facturas_cot WHERE id_factura='" . $id . "'";
    $query_id_factura_origen = mysqli_query($conexion, $sql_id_factura_origen);
    $id_fa_resultctura_origen = mysqli_fetch_array($query_id_factura_origen);
    $id_factura_origen = $id_fa_resultctura_origen['id_factura_origen'];
    $tienda_venta = $id_fa_resultctura_origen['tienda'];

    $sql_guia = "UPDATE guia_laar SET  estado_guia=" . $estado . "
                                WHERE id_pedido='" . $id_factura_origen . "' AND tienda_venta='" . $tienda_venta . "'";
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

    if ($server_url != $tienda_venta) {
        $tienda_proveedor = get_row('facturas_cot', 'tienda', 'id_factura', $id);
        $prove_temp = $tienda_proveedor;
        $sql = "UPDATE facturas_cot SET  estado_factura=" . $estado . ", estado_guia_sistema= " . $estado . "
                                WHERE id_factura='" . $id . "'";

        $sql_update_guia = "UPDATE guia_laar SET  estado_guia=" . $estado . " WHERE id_pedido='" . $id_factura_origen . "'";
        $archivo_tienda = $prove_temp . '/sysadmin/vistas/db1.php';
        $archivo_destino_tienda = "../db_destino_guia.php";
        $contenido_tienda = file_get_contents($archivo_tienda);
        $get_data = json_decode($contenido_tienda, true);
        if (file_put_contents($archivo_destino_tienda, $contenido_tienda) !== false) {
            $host_d = $get_data['DB_HOST'];
            $user_d = $get_data['DB_USER'];
            $pass_d = $get_data['DB_PASS'];
            $base_d = $get_data['DB_NAME'];
            $conexion_remota = mysqli_connect($host_d, $user_d, $pass_d, $base_d);
            $query_update = mysqli_query($conexion_remota, $sql);
            $query_update_guia = mysqli_query($conexion_remota, $sql_update_guia);
        }
    }
    $query_update = mysqli_query($conexion, $sql);
    $query_update_guia = mysqli_query($conexion, $sql_guia);

    if ($estado === 3) {
        $guia = "select guia_laar from guia_laar where id_pedido = " . $id_factura_origen . " and tienda_venta = '" . $tienda_venta . "'";
        $guia = mysqli_query($conexion, $guia);
        $guia = mysqli_fetch_array($guia);
        $guia = $guia['guia_laar'];

        $data = array("noGuia" => $guia, "estadoActualCodigo" => "7", "novedades" => []);
        $data_string = json_encode($data);
        $ch = curl_init('https://marketplace.imporsuit.com/sysadmin/api/integracion/Laar/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
            )
        );
        $result = curl_exec($ch);

        curl_close($ch);
    }

    if ($estado == 8) {
        $guia = get_row('guia_laar', 'guia_laar', 'id_pedido', $id);
        $authData = array(
            "username" => "import.uio.api",
            "password" => "Imp@rt*23"
        );

        //echo $guia;
        // Convertir los datos de autenticación a formato JSON
        $authDataJSON = json_encode($authData);

        // URL y datos para la autenticación
        $authURL = 'https://api.laarcourier.com:9727/authenticate';
        $authHeaders = array(
            'accept: application/json',
            'Content-Type: application/json',
        );

        // Inicializar cURL para la autenticación
        $chAuth = curl_init($authURL);
        curl_setopt($chAuth, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($chAuth, CURLOPT_POSTFIELDS, $authDataJSON);
        curl_setopt($chAuth, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chAuth, CURLOPT_HTTPHEADER, $authHeaders);

        // Ejecutar la solicitud de autenticación y obtener la respuesta
        $authResponse = curl_exec($chAuth);

        // Verificar si la autenticación fue exitosa
        $httpCode = curl_getinfo($chAuth, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            echo 'Error en la autenticación. Código de estado: ' . $httpCode;
            // Manejar el error apropiadamente
        } else {
            // Decodificar la respuesta JSON de autenticación
            $authResult = json_decode($authResponse, true);

            // Obtener el token de autenticación
            $token = $authResult['token'];

            // URL para la solicitud DELETE
            $deleteURL = 'https://api.laarcourier.com:9727/guias/anular/' . $guia;

            // Inicializar cURL para la solicitud DELETE con la cabecera de autenticación
            $chDelete = curl_init($deleteURL);
            $deleteHeaders = array(
                'Authorization: Bearer ' . $token,
            );

            curl_setopt($chDelete, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($chDelete, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chDelete, CURLOPT_HTTPHEADER, $deleteHeaders);

            // Ejecutar la solicitud DELETE y obtener la respuesta
            $deleteResponse = curl_exec($chDelete);

            // Verificar si la solicitud DELETE fue exitosa
            $deleteHttpCode = curl_getinfo($chDelete, CURLINFO_HTTP_CODE);
            if ($deleteHttpCode === 200) {

                echo 'ok';
            } else {
                echo 'Error al enviar la solicitud DELETE. Código de estado: ' . $deleteHttpCode;
                // Manejar el error apropiadamente
            }

            // Cerrar las conexiones cURL
            curl_close($chDelete);
        }

        // Cerrar la conexión cURL de autenticación
        curl_close($chAuth);
    }


    //echo $sql; 

    if ($query_update) {
        $messages[] = "Linea ha sido actualizada con Exito.";
    } else {
        $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
    }
} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {

?>
    <div class="alert alert-danger" role="alert">
        <strong>Error!</strong>
        <?php
        foreach ($errors as $error) {
            echo $error;
        }
        ?>
    </div>
<?php
}
if (isset($messages)) {
    echo json_encode($messages);
}
?>