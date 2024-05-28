<?php
class ShopifyModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtener_conexion($tienda)
    {
        $send = "testing";
        $protocolo = 'https://';
        $archivo_tienda =  $tienda . '/sysadmin/vistas/db1.php';
        $archivo_destino_tienda = "../../vistas/db_destino_guia.php";
        $contenido_tienda = file_get_contents($archivo_tienda);
        $get_data = json_decode($contenido_tienda, true);
        if (file_put_contents($archivo_destino_tienda, $contenido_tienda) !== false) {
            $host_d = $get_data['DB_HOST'];
            $user_d = $get_data['DB_USER'];
            $pass_d = $get_data['DB_PASS'];
            $base_d = $get_data['DB_NAME'];
            // Conexión a la base de datos de la tienda, establece la hora -5 GTM
            date_default_timezone_set('America/Guayaquil');
            $conexion = mysqli_connect($host_d, $user_d, $pass_d, $base_d);
            if (!$conexion) {
                die("Connection failed: " . mysqli_connect_error());
            }
            return $conexion;
        } else {
            echo "Error al copiar el archivo";
        }
    }

    public function getJson($json)
    {
        $sql = "INSERT INTO shopify (json) VALUES (?)";
        $data = array($json);
        $query = $this->insert($sql, $data);
        return $query;
    }

    public function insertarPedido($nombre, $apellido, $principal, $secundaria, $provincia, $ciudad, $codigo_postal, $pais, $telefono, $email, $total, $line_items, $discount, $shipping_lines, $shipping_lines_title)
    {
        date_default_timezone_set('America/Guayaquil');

        //verifica si existe el producto
        $sku = $line_items[0]['sku'];
        $sql = "SELECT * FROM productos WHERE codigo_producto = '$sku';";
        $query = $this->select($sql);
        if (empty($query)) {
            // si no existe sale del programa
            echo "no existe";
            return false;
        }
        /* if ($discount > 0) {

            $total = $total - $discount;
        } */
        $ultima_factura_sql = "SELECT MAX(numero_factura) AS factura FROM facturas_cot where numero_factura like '%COT%'";
        $ultima_factura = $this->select($ultima_factura_sql);
        $ultima_factura_numero = $ultima_factura[0]['factura'];
        $ciudad = strtoupper($ciudad);
        $es_ciudad = "SELECT * FROM ciudad_cotizacion where ciudad = '$ciudad'";
        $ciudad2 = $this->select($es_ciudad);
        print_r($ciudad2);
        //verificar si la ciudad existe

        if (empty($ciudad2)) {
            echo "XDAA";
            $ciudad = "0";
        } else {
            $ciudad = $ciudad[0]['id_cotizacion'];
        }
        echo $ciudad;
        $protocolo = 'https://';
        $tienda =  $protocolo . $_SERVER['HTTP_HOST'];
        echo "nuevo";

        $provincia = strtoupper($provincia);
        $provincia_sql = "SELECT codigo_provincia FROM provincia_laar WHERE provincia = '$provincia';";
        $provincia = $this->select($provincia_sql);
        $provincia = $provincia[0]['codigo_provincia'];


        // Extrae el número actual de la factura y el prefijo
        preg_match('/^COT-(\d+)$/', $ultima_factura_numero, $matches);
        $numero_actual = (int)$matches[1];

        // Incrementa el número actual
        $nuevo_numero = $numero_actual + 1;


        // Formatea el nuevo número con ceros a la izquierda
        $nueva_factura_numero_formateada = sprintf("COT-%06d", $nuevo_numero);

        $fecha_actual = date('Y-m-d H:i:s');

        $proviene = $this->obtenerProveedor($line_items[0]['sku']);

        $tienda_provenencia = "";
        if ($proviene) {
            if ($proviene == "enviado") {
                $protocolo = 'https://';

                $proviene =  $protocolo . $_SERVER['HTTP_HOST'];
                $tienda_provenencia = $proviene;
            } else {
                $tienda_provenencia = $proviene;
            }
            $drogshiping = 1;
        } else {
            $protocolo = 'https://';
            $drogshiping = 0;
            $tienda_provenencia = $protocolo . $_SERVER['HTTP_HOST'];
        }

        #$sql_factura_cot = "INSERT INTO facturas_cot ('numero_factura','fecha_factura','id_cliente','id_vendedor','condiciones','monto_factura','estado_factura','id_users_factura','validez','id_sucursal','nombre','telefono','provincia','c_principal','ciudad_cot','c_secundaria','referencia','observacion','guia_enviada','transporte','identificacion','celular','cod','valor_seguro','drogshipin','tienda') VALUES ('$nueva_factura_numero_formateada',$fecha_actual,0,0,'$nueva_factura_numero_formateada','$total','Pendiente',0,'30 días',0,'$nombre $apellido','$telefono','$provincia','$principal','$ciudad','$secundaria','','$email','','','','','','','');";
        $sql_factura_cot = "INSERT INTO `facturas_cot` (`numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `validez`, `id_sucursal`, `nombre`, `telefono`, `provincia`, `c_principal`, `ciudad_cot`, `c_secundaria`, `referencia`, `observacion`, `guia_enviada`, `transporte`, `identificacion`, `celular`, `cod`, `valor_seguro`, `drogshipin`, `tienda`, `importado`, `plataforma_importa`) VALUES (?,?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

        $factura_data = array($nueva_factura_numero_formateada, $fecha_actual, "1", "1", '1', $total, "1", "1", "3", "1", $nombre . ' ' . $apellido, $telefono, $provincia, $principal, $ciudad, $secundaria, " ", $shipping_lines_title, "0", NULL, NULL, NULL, "0", "0", $drogshiping, $tienda_provenencia, "1", "Shopify");
        $ultima_factura_local_sql = "SELECT MAX(id_factura) AS factura FROM facturas_cot;";
        $ultima_factura_local = $this->select($ultima_factura_local_sql);
        $ultima_factura_local_numero = $ultima_factura_local[0]['factura'];
        $ultima_factura_local_numero = $ultima_factura_local_numero + 1;
        echo "debug";
        $query_factura_cot = $this->insert($sql_factura_cot, $factura_data);
        $vueltas = 0;
        $es_drogshipin = 0;
        $nueva_factura_numero_formateada_marketplace = "";
        $nueva_factura_numero_formateada_proveedor = "";
        foreach ($line_items as $key => $value) {

            $es_drogshipin = $this->buscarProducto($value['sku']);
            $es_drogshipin = $es_drogshipin[0]['drogshipin'];

            $nombre_producto = $value['name'];
            $cantidad = $value['quantity'];
            $precio = $value['price'];

            $sku = $value['sku'];
            echo "debug2";
            echo $es_drogshipin;
            if ($es_drogshipin == 1) {
                // se obtiene el proveedor
                $proveedor_server = $this->buscarProveedor($sku);
                if ($proveedor_server != false) {
                    $conexion_proveedor = $this->obtener_conexion($proveedor_server);
                    $conexion_marketplace = $this->obtener_conexion('https://merkapro.ec');
                    $proveedor_server = $this->conseguirUltimaFactura($conexion_proveedor);
                }
                echo "net";
                // se obtiene la ultima factura del marketplace
                $marketplace_server = $this->conseguirUltimaFactura($conexion_marketplace);

                // se separa el COT-000001 en COT y 000001
                preg_match('/^COT-(\d+)$/', $proveedor_server, $matches);
                $numero_actual_proveedor = (int)$matches[1];
                $nuevo_numero_proveedor = $numero_actual_proveedor + 1;
                $nueva_factura_numero_formateada_proveedor = sprintf("COT-%06d", $nuevo_numero_proveedor);

                preg_match('/^COT-(\d+)$/', $marketplace_server, $matches);
                $numero_actual_marketplace = (int)$matches[1];
                $nuevo_numero_marketplace = $numero_actual_marketplace + 1;
                $nueva_factura_numero_formateada_marketplace = sprintf("COT-%06d", $nuevo_numero_marketplace);
                echo "debug3";
                // $this->insertarFacturaProveedor($nueva_factura_numero_formateada_proveedor, "INSERT INTO `facturas_cot` (`numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `validez`, `id_sucursal`, `nombre`, `telefono`, `provincia`, `c_principal`, `ciudad_cot`, `c_secundaria`, `referencia`, `observacion`, `guia_enviada`, `transporte`, `identificacion`, `celular`, `cod`, `valor_seguro`, `drogshipin`, `tienda`, `importado`, `plataforma_importa`, `id_factura_origen`) VALUES ('$nueva_factura_numero_formateada_proveedor', '$fecha_actual', '1', '1', '1', '$total', '1', '1', '3', '1', '$nombre $apellido', '$telefono', '$provincia', '$principal', '$ciudad', '$secundaria', ' ', ' ', '0', NULL, NULL, NULL, '0', '0', '3', '$tienda', '1', 'Shopify', '$ultima_factura_local_numero');", $conexion_proveedor);
                echo "cd";
                // $this->insertarFacturaMarketplace($nueva_factura_numero_formateada_marketplace, "INSERT INTO `facturas_cot` (`numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `validez`, `id_sucursal`, `nombre`, `telefono`, `provincia`, `c_principal`, `ciudad_cot`, `c_secundaria`, `referencia`, `observacion`, `guia_enviada`, `transporte`, `identificacion`, `celular`, `cod`, `valor_seguro`, `drogshipin`, `tienda`, `importado`, `plataforma_importa`, `id_factura_origen`) VALUES ('$nueva_factura_numero_formateada_marketplace', '$fecha_actual', '1', '1', '1', '$total', '1', '1', '3', '1', '$nombre $apellido', '$telefono', '$provincia', '$principal', '$ciudad', '$secundaria', ' ', ' ', '0', NULL, NULL, NULL, '0', '0', '3','$tienda' , '1', 'Shopify', '$ultima_factura_local_numero');", $conexion_marketplace);
                echo "debug4c";
                //$this->insertarPedidoMarketplace($nueva_factura_numero_formateada_marketplace, $cantidad, $precio, $sku, $conexion_marketplace);
                //$this->insertarPedidoProveedor($nueva_factura_numero_formateada_proveedor, $cantidad, $precio, $sku, $conexion_proveedor);

                echo "a";
            } else {
                echo "debug33";

                $conexion_marketplace = $this->obtener_conexion('https://marketplace.imporsuit.com');
                $marketplace_server = $this->conseguirUltimaFactura($conexion_marketplace);
                preg_match('/^COT-(\d+)$/', $marketplace_server, $matches);
                echo "debug44";
                $numero_actual_marketplace = (int)$matches[1];
                $nuevo_numero_marketplace = $numero_actual_marketplace + 1;
                $nueva_factura_numero_formateada_marketplace = sprintf("COT-%06d", $nuevo_numero_marketplace);
                //  $this->insertarFacturaMarketplace($nueva_factura_numero_formateada_marketplace, "INSERT INTO `facturas_cot` (`numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `validez`, `id_sucursal`, `nombre`, `telefono`, `provincia`, `c_principal`, `ciudad_cot`, `c_secundaria`, `referencia`, `observacion`, `guia_enviada`, `transporte`, `identificacion`, `celular`, `cod`, `valor_seguro`, `drogshipin`, `tienda`, `importado`, `plataforma_importa`, `id_factura_origen`) VALUES ('$nueva_factura_numero_formateada_marketplace', '$fecha_actual', '1', '1', '1', '$total', '1', '1', '3', '1', '$nombre $apellido', '$telefono', '$provincia', '$principal', '$ciudad', '$secundaria', ' ', ' ', '0', NULL, NULL, NULL, '0', '0', '4','$tienda' , '1', 'Shopify', '$ultima_factura_local_numero');", $conexion_marketplace);
                //$this->insertarPedidoMarketplace($nueva_factura_numero_formateada_marketplace, $cantidad, $precio, $sku, $conexion_marketplace);

                echo "b";
            }

            echo "debug5";
            if ($discount > 0 && $vueltas == 0) {
                echo $discount;
                $valor_completo = $precio * $cantidad;
                $porcentaje_discount = ($discount / $valor_completo) * 100;
                $porcentaje_discount = round($porcentaje_discount, 2);
                echo $porcentaje_discount;
            } else {
                $porcentaje_discount = 0;
            }
            if ($vueltas == 0) {
                $precio = $precio + $shipping_lines;
                if ($es_drogshipin == 1) {
                    $this->insertarFacturaProveedor($nueva_factura_numero_formateada_proveedor, "INSERT INTO `facturas_cot` (`numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `validez`, `id_sucursal`, `nombre`, `telefono`, `provincia`, `c_principal`, `ciudad_cot`, `c_secundaria`, `referencia`, `observacion`, `guia_enviada`, `transporte`, `identificacion`, `celular`, `cod`, `valor_seguro`, `drogshipin`, `tienda`, `importado`, `plataforma_importa`, `id_factura_origen`) VALUES ('$nueva_factura_numero_formateada_proveedor', '$fecha_actual', '1', '1', '1', '$total', '1', '1', '3', '1', '$nombre $apellido', '$telefono', '$provincia', '$principal', '$ciudad', '$secundaria', ' ', ' ', '0', NULL, NULL, NULL, '0', '0', '3', '$tienda', '1', 'Shopify', '$ultima_factura_local_numero');", $conexion_proveedor);
                }
                $this->insertarFacturaMarketplace($nueva_factura_numero_formateada_marketplace, "INSERT INTO `facturas_cot` (`numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `validez`, `id_sucursal`, `nombre`, `telefono`, `provincia`, `c_principal`, `ciudad_cot`, `c_secundaria`, `referencia`, `observacion`, `guia_enviada`, `transporte`, `identificacion`, `celular`, `cod`, `valor_seguro`, `drogshipin`, `tienda`, `importado`, `plataforma_importa`, `id_factura_origen`) VALUES ('$nueva_factura_numero_formateada_marketplace', '$fecha_actual', '1', '1', '1', '$total', '1', '1', '3', '1', '$nombre $apellido', '$telefono', '$provincia', '$principal', '$ciudad', '$secundaria', ' ', ' ', '0', NULL, NULL, NULL, '0', '0', '3','$tienda' , '1', 'Shopify', '$ultima_factura_local_numero');", $conexion_marketplace);
            }

            $this->insertarDetalleFactura_local($nueva_factura_numero_formateada, $cantidad, $precio, $sku, $porcentaje_discount);
            $vueltas++;
        }
        return array($query_factura_cot);
    }

    private function insertarDetalleFactura_local($numero_factura, $cantidad, $precio, $sku, $discount = 0)
    {
        $ultima_factura = $this->select("SELECT MAX(id_factura) AS factura FROM facturas_cot;");
        $ultima_factura_numero = $ultima_factura[0]['factura'];
        $id_producto = $this->select("SELECT id_producto FROM productos WHERE codigo_producto = '$sku';");
        $id_producto = $id_producto[0]['id_producto'];
        echo $id_producto;

        $sql_detalle_factura_cot = "INSERT INTO `detalle_fact_cot` ( `id_factura`, `numero_factura`, `id_producto`, `cantidad`, `desc_venta`, `precio_venta`, `drogshipin_tmp`, `id_producto_origen`) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?);";
        $detalle_fac_data = array($ultima_factura_numero, $numero_factura, $id_producto, $cantidad, $discount, $precio, 1, $id_producto);
        $query_detalle_factura_cot = $this->insert($sql_detalle_factura_cot, $detalle_fac_data);
        return array($query_detalle_factura_cot);
    }

    private function buscarProducto($sku)
    {
        $sql = "SELECT drogshipin FROM productos WHERE codigo_producto = '$sku';";
        $query = $this->select($sql);
        return $query;
    }

    protected function conectarMarketplace()
    {
        # Conexión a la base de datos de marketplace
        $market_connect = mysqli_connect(MARKETPLACE, MARKETPLACE_USER, MARKETPLACE_PASSWORD, MARKETPLACE_DB);
        if (!$market_connect) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $market_connect;
    }

    protected function conectarProveedor($proveedor)
    {
        $contrasena = $proveedor;
        if ($proveedor == 'imporsuit_imporshop') {
            $contrasena = 'E?c7Iij&885Y';
        }
        $proveedor_connect = mysqli_connect('localhost', $proveedor, $contrasena, $proveedor);
        if (!$proveedor_connect) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $proveedor_connect;
    }

    public function insertarPedidoProveedor($numero_factura, $cantidad, $precio, $sku, $conexion)
    {
        $ultima_factura_sql = "SELECT MAX(id_factura) AS factura FROM facturas_cot;";
        $ultima_factura = mysqli_query($conexion, $ultima_factura_sql);
        $ultima_factura = mysqli_fetch_assoc($ultima_factura);
        $ultima_factura_numero = $ultima_factura['factura'] + 1;

        $id_producto = $this->select("SELECT id_producto FROM productos WHERE codigo_producto = '$sku';");
        $id_producto = $id_producto[0]['id_producto'];

        $sql_detalle_factura_cot = "INSERT INTO `detalle_fact_cot` ( `id_factura`, `numero_factura`, `id_producto`, `cantidad`, `desc_venta`, `precio_venta`, `drogshipin_tmp`, `id_producto_origen`) VALUES ('$ultima_factura_numero', '$numero_factura', '$id_producto', '$cantidad', NULL, '$precio', '1', '$id_producto');";

        $query = mysqli_query($conexion, $sql_detalle_factura_cot);
        echo mysqli_error($conexion);

        mysqli_close($conexion);

        return $query;
    }

    public function insertarPedidoMarketplace($numero_factura, $cantidad, $precio, $sku, $conexion)
    {
        $ultima_factura_sql = "SELECT MAX(id_factura) AS factura FROM facturas_cot;";
        $ultima_factura = mysqli_query($conexion, $ultima_factura_sql);
        $ultima_factura = mysqli_fetch_assoc($ultima_factura);
        $ultima_factura_numero = $ultima_factura['factura'];
        $id_producto = $this->select("SELECT id_producto FROM productos WHERE codigo_producto = '$sku';");
        $id_producto = $id_producto[0]['id_producto'];

        if ($id_producto == NULL) {
            $id_producto = $sku;
        }

        $sql_detalle_factura_cot = "INSERT INTO `detalle_fact_cot` ( `id_factura`, `numero_factura`, `id_producto`, `cantidad`, `desc_venta`, `precio_venta`, `drogshipin_tmp`, `id_producto_origen`) VALUES ('$ultima_factura_numero', '$numero_factura', '$id_producto', '$cantidad', NULL, '$precio', NULL, NULL);";

        $query = mysqli_query($conexion, $sql_detalle_factura_cot);
        echo mysqli_error($conexion);

        mysqli_close($conexion);

        return $query;
    }

    public function insertarFacturaProveedor($ultima_factura, $sql, $conexion)
    {

        $sql_factura = "SELECT numero_factura FROM facturas_cot WHERE numero_factura = '$ultima_factura';";

        $query_factura = mysqli_query($conexion, $sql_factura);
        $factura = mysqli_fetch_assoc($query_factura);
        if (!empty($factura)) {
            mysqli_close($conexion);
            return false;
        } else {
            $query = mysqli_query($conexion, $sql);
            echo mysqli_error($conexion);
            mysqli_close($conexion);
            return $query;
        }
    }

    public function insertarFacturaMarketplace($ultima_factura, $sql, $conexion)
    {
        //Verificar si la factura ya existe
        $sql_factura = "SELECT numero_factura FROM facturas_cot WHERE numero_factura = '$ultima_factura';";

        $query_factura = mysqli_query($conexion, $sql_factura);
        $factura = mysqli_fetch_assoc($query_factura);
        echo mysqli_error($conexion);

        if (!empty($factura)) {
            mysqli_close($conexion);
            return false;
        } else {
            $query = mysqli_query($conexion, $sql);
            echo mysqli_error($conexion);
            mysqli_close($conexion);
            return $query;
        }
    }

    public function buscarProveedor($sku)
    {
        $sql = "SELECT tienda FROM productos WHERE codigo_producto = '$sku';";
        $query = $this->select($sql);
        $dominiotienda = $query[0]['tienda'];
        if ($dominiotienda) {
            return $dominiotienda;
        } else {
            return false;
        }
    }

    public function obtenerProveedor($sku)
    {

        $sql = "SELECT * FROM productos WHERE codigo_producto = '$sku';";
        $query = $this->select($sql);

        $dominiotienda = $query[0]['tienda'];

        return $dominiotienda;
    }

    public function conseguirUltimaFactura($conexion)
    {

        $sql = "SELECT MAX(numero_factura) AS factura FROM facturas_cot;";
        $query = mysqli_query($conexion, $sql);
        $factura = mysqli_fetch_assoc($query);
        if (empty($factura['factura'])) {
            $factura['factura'] = 'COT-000001';
        }
        echo mysqli_error($conexion);
        $factura = $factura['factura'];
        return $factura;
    }
}
