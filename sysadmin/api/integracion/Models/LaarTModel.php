<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../PHPMailer/PHPMailer.php';
require_once '../../PHPMailer/SMTP.php';
require_once '../../PHPMailer/Exception.php';


use PHPMailer\PHPMailer\PHPMailer;

class LaarModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function processGuiaStatus($no_guia, $estado_actual_codigo)
    {
        $this->updateMarketplace($no_guia, $estado_actual_codigo);
        if ($estado_actual_codigo == 7) {
            $this->pedidoEntragado($no_guia, $estado_actual_codigo);
        } else if ($estado_actual_codigo == 9) {
            $this->pedidoDevolucion($no_guia, $estado_actual_codigo);
        }
    }

    public function updateMarketplace($no_guia, $estado_actual_codigo)
    {
        if ($estado_actual_codigo == 14) {
            $this->sendMail($no_guia, "devolucion");
        }
        $marketplace = $this->conectarMarketplace();
        $sql = "UPDATE guia_laar SET estado_guia ='$estado_actual_codigo' WHERE guia_laar ='$no_guia'";
        $result = mysqli_query($marketplace, $sql);
        echo mysqli_error($marketplace);
        $sql = "SELECT id_pedido, tienda_venta FROM guia_laar WHERE guia_laar ='$no_guia'";
        $query = $this->select($sql);
        $id_pedido = $query[0]['id_pedido'];
        $tienda_venta = $query[0]['tienda_venta'];
        $sql = "UPDATE facturas_cot SET estado_guia_sistema ='$estado_actual_codigo' WHERE id_factura_origen ='$id_pedido' AND tienda = '$tienda_venta'";
        $result = mysqli_query($marketplace, $sql);
        echo mysqli_error($marketplace);
        mysqli_close($marketplace);
        return $result;
    }

    private function sendMail($no_guia, $cause)
    {
        $tienda_venta_sql = "SELECT tienda_venta FROM guia_laar WHERE guia_laar = '$no_guia'";
        $tienda_venta = $this->select($tienda_venta_sql);
        $tienda_venta = $tienda_venta[0]['tienda_venta'];
        $conexion_proveedor = $this->obtener_conexion($tienda_venta);
        $sql_correo = "SELECT * from users where id_users='1'";
        $sql_correo = mysqli_query($conexion_proveedor, $sql_correo);
        $sql_correo = mysqli_fetch_array($sql_correo);
        $correo = $sql_correo['email_users'];
        if ($correo !== "root@gmail.com") {
            if ($cause === "devolucion") {
                require_once '../../PHPMailer/Mail_devolucion.php';
            } else if ($cause === "pedido") {
                require_once '../../PHPMailer/Mail_pedido.php';
            }
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = $smtp_debug;
            $mail->Host = $smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $smtp_user;
            $mail->Password = $smtp_pass;
            $mail->Port = 465;
            $mail->SMTPSecure = $smtp_secure;
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($smtp_from, $smtp_from_name);
            $mail->addAddress($correo);
            $mail->Subject = $smtp_subject;
            $mail->Body = $message_body_pedido;
            if ($mail->send()) {
                //echo "Correo enviado";
            } else {
                echo "Error al enviar el correo: " . $mail->ErrorInfo;
            }
        }
    }

    public function buscarProveedor($no_guia)
    {
        $query = "SELECT tienda_proveedor FROM guia_laar WHERE guia_laar = '$no_guia'";
        $query = $this->select($query);
        $dominiotienda = $query[0]['tienda_proveedor'];
        return  $dominiotienda;
    }

    public function buscarTiendaVenta($no_guia)
    {
        $query = "SELECT tienda_venta FROM guia_laar WHERE guia_laar = '$no_guia'";
        $query = $this->select($query);
        $dominiotienda = $query[0]['tienda_venta'];
        return  $dominiotienda;
    }

    public function pedidoEntragado($no_guia, $estado_actual_codigo)
    {
        $tienda_venta = $this->buscarTiendaVenta($no_guia);
        $tienda_proveedor = $this->buscarProveedor($no_guia);

        $numero_factura_verificar = $this->select("SELECT * FROM guia_laar WHERE guia_laar = '$no_guia' AND estado_guia = '$estado_actual_codigo'");
        $id_pedidoverificar = $numero_factura_verificar[0]['id_pedido'];
        $numero_factura = $this->select("SELECT numero_factura FROM facturas_cot WHERE tienda = '$tienda_venta' AND id_factura_origen = '$id_pedidoverificar'");
        $numero_factura_verificar = $numero_factura[0]['numero_factura'];
        $verificar = $this->select("SELECT * FROM cabecera_cuenta_pagar WHERE numero_factura = '$numero_factura_verificar'");
        $verificar = count($verificar);
        if ($verificar > 0) {
            echo json_encode('ya_existe');
            exit;
        }
        $query = $this->select("SELECT * from facturas_cot WHERE tienda = '$tienda_venta' AND id_factura_origen = '$id_pedidoverificar'");
        $numero_factura = $query[0]['numero_factura'];
        $fecha = $query[0]['fecha_factura'];
        $nombre_cliente = $query[0]['nombre'];
        $tienda = $query[0]['tienda'];
        $estado_pedido = $query[0]['estado_factura'];
        $guia_enviada = $query[0]['guia_enviada'];
        $ciudad_cot = $query[0]['ciudad_cot'];
        $id_factura = $query[0]['id_factura'];
        $id_pedido_origen = $query[0]['id_factura_origen'];
        $tieneGuias_query = $this->select("SELECT * FROM `guia_laar` WHERE tienda_venta='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
        $tieneGuias = count($tieneGuias_query);
        if (empty($tieneGuias)) {
            echo json_encode('no_guias');
            exit;
        }
        $ciudadD = $tieneGuias_query[0]['ciudadD'];
        $producto_id = $this->select("SELECT id_producto FROM detalle_fact_cot WHERE id_factura = '$id_factura'");
        $producto_id = $producto_id[0]['id_producto'];
        $costo_total = $this->select("SELECT costo_producto FROM productos WHERE id_producto = '$producto_id'");
        $costo_total = $costo_total[0]['costo_producto'];
        $valor_base = $this->select("SELECT precio FROM ciudad_laar WHERE codigo = '$ciudad_cot'");
        $valor_base = $valor_base[0]['precio'];
        if ($valor_base == null || $valor_base == 0) {
            $valor_base = $this->select("SELECT precio FROM ciudad_laar WHERE codigo = '$ciudadD'");
            if ($valor_base == null || $valor_base == 0) {
                $valor_base = $this->select("SELECT trayecto_laar from ciudad_cotizacion where id_cotizacion = '$ciudad_cot'");
                $valor_base = $valor_base[0]['trayecto_laar'];
                $valor_base = $this->select("SELECT precio from cobertura_laar where tipo_cobertura = '$valor_base'");
                $valor_base = $valor_base[0]['precio'];
            }
        }
        if ($tienda_venta === "https://yapando.imporsuit.com" || $tienda_venta === "https://onlytap.imporsuit.com" || $tienda_venta === "https://ecuashop.imporsuit.com" || $tienda_venta === "https://merkatodo.imporsuit.com") {
            $conexion_tiend  = $this->obtener_conexion($tienda_venta);
            $sql_tipo = "SELECT * FROM `guia_laar` where guia_laar ='" . $no_guia . "'";
            $sql_tipo = mysqli_query($conexion_tiend, $sql_tipo);
            $sql_tipo = mysqli_fetch_array($sql_tipo);
            if (strpos($no_guia, 'FAST') === true) {
                $valor_base = $this->select("SELECT precio FROM ciudad_laar WHERE codigo = '$ciudadD'");
                $valor_base = $valor_base[0]['precio'];
            } else {
                $valor_base = $sql_tipo['precio'];
            }
        }
        $total_guia = $this->select("SELECT costoproducto FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
        $total_guia = $total_guia[0]['costoproducto'];
        if ($this->select("SELECT cod FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'")[0]['cod'] == 1) {
            $valor_base = $valor_base + ($total_guia * 0.03);
        }
        $valor_declarado = $this->select("SELECT valorDeclarado FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
        $valor_declarado = $valor_declarado[0]['valorDeclarado'];
        if ($valor_declarado > 1) {
            $valor = $this->select("SELECT valorDeclarado FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
            $valor_base = $valor_base + ($valor[0]['valorDeclarado'] * 0.01);
        }
        $costo_guia = $this->select("SELECT valor_costo FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
        $costo_guia = $costo_guia[0]['valor_costo'];
        $valor_total = $this->select("SELECT valor1_producto FROM productos WHERE id_producto = '$producto_id'");
        $valor_total = $valor_total[0]['valor1_producto'];
        $drogshipin = $this->select("SELECT drogshipin FROM facturas_cot WHERE tienda ='$tienda_venta' AND id_factura_origen = '$id_pedido_origen'");
        $cod = $this->select("SELECT cod FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
        $cod = $cod[0]['cod'];
        if ($cod == 1) {
            if ($drogshipin[0]['drogshipin'] == 4 || $drogshipin[0]['drogshipin'] == 0) {
                $monto_recibir = $total_guia - $valor_base;
            } else {
                $monto_recibir = $total_guia - $valor_base - $costo_guia;
            }
        } else {
            if ($drogshipin[0]['drogshipin'] == 4 || $drogshipin[0]['drogshipin'] == 0) {
                $total_guia = 0;
                $costo_guia = 0;
                $monto_recibir = 0 - $valor_base;
            } else {
                $total_guia = 0;
                $monto_recibir = $total_guia - $valor_base - $costo_guia;
            }
        }

        if ($tienda_venta === $tienda_proveedor) {
            $url_proveedor = " ";
        } else {
            $url_proveedor = $tienda_venta;
        }

        $monto_recibir = number_format($monto_recibir, 2);
        $sql_cc = "INSERT INTO `cabecera_cuenta_pagar`(`numero_factura`, `fecha`, `cliente`, `tienda`, `estado_guia`, `estado_pedido`, `total_venta`, `costo`, `precio_envio`, `monto_recibir`,`valor_pendiente`,`guia_laar`,`cod`,`proveedor`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";
        $datos = array($numero_factura, $fecha, $nombre_cliente, $tienda, $estado_actual_codigo, $estado_pedido, $total_guia, $costo_guia, $valor_base, $monto_recibir, $monto_recibir, $no_guia, $cod, $url_proveedor);
        $query_insertar_cc = $this->insert($sql_cc, $datos);
        if ($query_insertar_cc) {
            echo json_encode('ok');
        } else {
            echo json_encode('error');
        }
    }

    public function pedidoDevolucion($no_guia, $estado_actual_codigo)
    {
        //verificar si ya existe la guia en la tabla de cuenta por pagar
        $tienda_venta = $this->buscarTiendaVenta($no_guia);
        $tienda_proveedor = $this->buscarProveedor($no_guia);
        $numero_factura_verificar = $this->select("SELECT * FROM guia_laar WHERE guia_laar = '$no_guia' AND estado_guia = '$estado_actual_codigo'");
        $id_pedidoverificar = $numero_factura_verificar[0]['id_pedido'];
        $numero_factura = $this->select("SELECT numero_factura FROM facturas_cot WHERE tienda = '$tienda_venta' AND id_factura_origen = '$id_pedidoverificar'");
        $numero_factura_verificar = $numero_factura[0]['numero_factura'];
        $verificar = $this->select("SELECT * FROM cabecera_cuenta_pagar WHERE numero_factura = '$numero_factura_verificar'");
        $verificar = count($verificar);
        if ($verificar > 0) {
            echo json_encode('ya_existe');
            exit;
        }
        $query = $this->select("SELECT id_pedido, tienda_venta FROM guia_laar WHERE guia_laar = '$no_guia'");
        $id_pedido = $query[0]['id_pedido'];
        $tienda_venta = $query[0]['tienda_venta'];
        $query = $this->select("SELECT * from facturas_cot WHERE tienda = '$tienda_venta' AND id_factura_origen = '$id_pedido'");
        $numero_factura = $query[0]['numero_factura'];
        $fecha = $query[0]['fecha_factura'];
        $nombre_cliente = $query[0]['nombre'];
        $tienda = $query[0]['tienda'];
        $estado_pedido = $query[0]['estado_factura'];
        $guia_enviada = $query[0]['guia_enviada'];
        $ciudad_cot = $query[0]['ciudad_cot'];
        $id_factura = $query[0]['id_factura'];
        $id_pedido_origen = $query[0]['id_factura_origen'];
        $cod = $query[0]['cod'];
        $tieneGuias_query = $this->select("SELECT * FROM `guia_laar` WHERE tienda_venta='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
        $tieneGuias = count($tieneGuias_query);
        if (empty($tieneGuias)) {
            echo json_encode('no_guias');
            exit;
        }
        $producto_id = $this->select("SELECT id_producto FROM detalle_fact_cot WHERE id_factura = '$id_factura'");
        $producto_id = $producto_id[0]['id_producto'];
        $costo_total = $this->select("SELECT costo_producto FROM productos WHERE id_producto = '$producto_id'");
        $costo_total = $costo_total[0]['costo_producto'];
        $valor_base = $this->select("SELECT precio FROM ciudad_laar WHERE codigo = '$ciudad_cot'");
        $valor_base = $valor_base[0]['precio'];
        $total_guia = $this->select("SELECT costoproducto FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
        $total_guia = $total_guia[0]['costoproducto'];
        $auxiliar = $this->select("SELECT cod FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
        $auxiliar = $auxiliar[0]['cod'];
        if ($auxiliar == 1) {
            $valor_base = $valor_base + ($total_guia * 0.03);
        }
        $valor_declarado = $this->select("SELECT valorDeclarado FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
        $valor_declarado = $valor_declarado[0]['valorDeclarado'];
        if ($valor_declarado > 1) {
            $valor = $this->select("SELECT valorDeclarado FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
            $valor_base = $valor_base + ($valor[0]['valorDeclarado'] * 0.01);
        }
        $costo_guia = $this->select("SELECT valor_costo FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
        $costo_guia = $costo_guia[0]['valor_costo'];
        $valor_total = $this->select("SELECT valor1_producto FROM productos WHERE id_producto = '$producto_id'");
        $valor_total = $valor_total[0]['valor1_producto'];
        if ($tienda == "https://yapando.imporsuit.com" || $tienda == "https://onlytap.imporsuit.com" || $tienda == "https://ecuashop.imporsuit.com" || $tienda == "https://universalmarkethub.imporsuit.com") {
            $conexion_tiend  = $this->obtener_conexion($tienda);
            $sql_tipo = "SELECT precio from ciudad_laar where codigo = '$ciudad_cot'";
            $sql_tipo = mysqli_query($conexion_tiend, $sql_tipo);
            $sql_tipo = mysqli_fetch_array($sql_tipo);
            $valor_base = $sql_tipo['precio'];
            $costo_envio = $valor_base;
        } else {
            $costo_envio = $valor_base + ($valor_base * 0.25);
        }
        $costo_envio = number_format($costo_envio, 2);
        $conexion_proveedor = $this->obtener_conexion($tienda_venta);
        $sql_nodevolucion = "SELECT nodevolucion FROM `perfil`; ";
        $sql_nodevolucion_ = mysqli_query($conexion_proveedor, $sql_nodevolucion);
        $sql_nodevolucion_ = mysqli_fetch_array($sql_nodevolucion_);
        $sql_nodevolucion_ = $sql_nodevolucion_['nodevolucion'];
        if ($sql_nodevolucion_ == 1) {
            $monto_recibir = 0;
        } else {
            $monto_recibir = 0 - $costo_envio;
        }
        $monto_recibir = number_format($monto_recibir, 2);
        if ($tienda_venta === $tienda_proveedor) {
            $url_proveedor = " ";
        } else {
            $url_proveedor = $tienda_venta;
        }
        $sql_cc = "INSERT INTO `cabecera_cuenta_pagar`(`numero_factura`, `fecha`, `cliente`, `tienda`, `estado_guia`, `estado_pedido`, `total_venta`, `costo`, `precio_envio`, `monto_recibir`,`valor_pendiente`,`guia_laar`, `cod`,`proveedor`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
        $datos = array($numero_factura, $fecha, $nombre_cliente, $tienda, $estado_actual_codigo, $estado_pedido, $total_guia, $costo_guia, $valor_base, $monto_recibir, $monto_recibir, $no_guia, $cod, $url_proveedor);
        $query_insertar_cc = $this->insert($sql_cc, $datos);
        // enviar correo
        $this->sendMail($no_guia, "devolucion");


        if ($query_insertar_cc) {
            echo json_encode('ok');
        } else {
            echo json_encode('error');
        }
    }
    public function establecer_guia($numero_factura)
    {
        $datos_para_laar = $this->select("SELECT tienda, id_factura_origen FROM facturas_cot WHERE numero_factura = '$numero_factura'");
        $tienda = $datos_para_laar[0]['tienda'];
        $id_factura_origen = $datos_para_laar[0]['id_factura_origen'];
        $datos_para_laar = $this->select("SELECT guia_laar FROM guia_laar WHERE tienda_venta = '$tienda' AND id_pedido = '$id_factura_origen'");
        $guia_laar = $datos_para_laar[0]['guia_laar'];
        if ($guia_laar == '') {
            echo json_encode('no_existe');
            exit;
        }
        $existe_cabecera = $this->select("SELECT * FROM cabecera_cuenta_pagar WHERE numero_factura = '$numero_factura'");
        $verificar = count($existe_cabecera);
        if ($verificar > 0) {
            $query = "UPDATE cabecera_cuenta_pagar SET guia_laar = ? WHERE numero_factura = ?";
            $datos = array($guia_laar, $numero_factura);
            $query = $this->update($query, $datos);
            if ($query) {
                echo json_encode('ok');
            } else {
                echo json_encode('error');
            }
        } else {
            echo json_encode('no_existe');
        }
    }

    public function devolucion($no_guia, $estado_actual_codigo)
    {
        $tienda_venta = $this->buscarTiendaVenta($no_guia);
        $tienda_proveedor = $this->buscarProveedor($no_guia);
        $numero_factura_verificar = $this->select("SELECT * FROM guia_laar WHERE guia_laar = '$no_guia' ");
        $id_pedidoverificar = $numero_factura_verificar[0]['id_pedido'];
        $numero_factura = $this->select("SELECT numero_factura FROM facturas_cot WHERE tienda = '$tienda_venta' AND id_factura_origen = '$id_pedidoverificar'");
        $numero_factura_verificar = $numero_factura[0]['numero_factura'];
        $query = "SELECT id_pedido, tienda_venta FROM guia_laar WHERE guia_laar = '$no_guia'";
        $query = $this->select($query);
        $id_pedido = $query[0]['id_pedido'];
        $tienda_venta = $query[0]['tienda_venta'];
        $query = "SELECT * from facturas_cot WHERE tienda = '$tienda_venta' AND id_factura_origen = '$id_pedido'";
        $query = $this->select($query);
        $numero_factura = $query[0]['numero_factura'];
        $fecha = $query[0]['fecha_factura'];
        $nombre_cliente = $query[0]['nombre'];
        $tienda = $query[0]['tienda'];
        $estado_pedido = $query[0]['estado_factura'];
        $guia_enviada = $query[0]['guia_enviada'];
        $ciudad_cot = $query[0]['ciudad_cot'];
        $id_factura = $query[0]['id_factura'];
        $id_pedido_origen = $query[0]['id_factura_origen'];
        $tieneGuias_sql = "SELECT * FROM `guia_laar` WHERE tienda_venta='$tienda_venta' AND id_pedido = '$id_pedido_origen'";
        $tieneGuias_query = $this->select($tieneGuias_sql);
        $tieneGuias = count($tieneGuias_query);
        if (empty($tieneGuias)) {
            echo json_encode('no_guias');
            exit;
        }
        $producto_id = $this->select("SELECT id_producto FROM detalle_fact_cot WHERE id_factura = '$id_factura'");
        $producto_id = $producto_id[0]['id_producto'];
        $costo_total = $this->select("SELECT costo_producto FROM productos WHERE id_producto = '$producto_id'");
        $costo_total = $costo_total[0]['costo_producto'];
        $valor_base = $this->select("SELECT precio FROM ciudad_laar WHERE codigo = '$ciudad_cot'");
        $valor_base = $valor_base[0]['precio'];
        $total_guia = $this->select("SELECT costoproducto FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
        $total_guia = $total_guia[0]['costoproducto'];
        $auxiliar = $this->select("SELECT cod FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
        $auxiliar = $auxiliar[0]['cod'];
        if ($auxiliar == 1) {
            $valor_base = $valor_base + ($total_guia * 0.03);
        }
        $valor_declarado = $this->select("SELECT valorDeclarado FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
        $valor_declarado = $valor_declarado[0]['valorDeclarado'];
        if ($valor_declarado > 1) {
            $valor = $this->select("SELECT valorDeclarado FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
            $valor_base = $valor_base + ($valor[0]['valorDeclarado'] * 0.01);
        }
        $costo_guia = $this->select("SELECT valor_costo FROM guia_laar WHERE tienda_venta ='$tienda_venta' AND id_pedido = '$id_pedido_origen'");
        $costo_guia = $costo_guia[0]['valor_costo'];
        $valor_total = $this->select("SELECT valor1_producto FROM productos WHERE id_producto = '$producto_id'");
        $valor_total = $valor_total[0]['valor1_producto'];
        $costo_envio = $valor_base + ($valor_base * 0.25);
        $costo_envio = number_format($costo_envio, 2);
        $monto_recibir = 0 - $costo_envio;
        $monto_recibir = number_format($monto_recibir, 2);
        $verificar = $this->select("SELECT * FROM cabecera_cuenta_pagar WHERE numero_factura = '$numero_factura_verificar'");
        $verificar = count($verificar);
        if ($verificar > 0) {
            $sql_edit = "UPDATE `cabecera_cuenta_pagar` SET `estado_guia` = ?, `estado_pedido` = ?, `total_venta` = ?, `costo` = ?, `precio_envio` = ?, `monto_recibir` = ?, `valor_pendiente` = ? WHERE `numero_factura` = ?";
            $datos_edit = array($estado_actual_codigo, $estado_pedido, $total_guia, $costo_guia, $valor_base, $monto_recibir, $monto_recibir, $numero_factura_verificar);
            $query_edit = $this->update($sql_edit, $datos_edit);
            $sql_edit_facturas_cot = "UPDATE `facturas_cot` SET `estado_guia_sistema` = ? WHERE `numero_factura` = ?";
            $datos_edit_facturas_cot = array($estado_actual_codigo, $numero_factura_verificar);
            $query_edit_facturas_cot = $this->update($sql_edit_facturas_cot, $datos_edit_facturas_cot);
            $sql_edit_guia_laar = "UPDATE `guia_laar` SET `estado_guia` = ? WHERE `guia_laar` = ?";
            $datos_edit_guia_laar = array($estado_actual_codigo, $no_guia);
            $query_edit_guia_laar = $this->update($sql_edit_guia_laar, $datos_edit_guia_laar);
            if ($query_edit) {
                echo json_encode('ok');
            } else {
                echo json_encode('error');
            }
        } else {
            if ($tienda_venta === $tienda_proveedor) {
                $url_proveedor = " ";
            } else {
                $url_proveedor = $tienda_venta;
            }
            $sql_cc = "INSERT INTO `cabecera_cuenta_pagar`(`numero_factura`, `fecha`, `cliente`, `tienda`, `estado_guia`, `estado_pedido`, `total_venta`, `costo`, `precio_envio`, `monto_recibir`,`valor_pendiente`,`guia_laar`,`proveedor`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
            $datos = array($numero_factura, $fecha, $nombre_cliente, $tienda, $estado_actual_codigo, $estado_pedido, $total_guia, $costo_guia, $valor_base, $monto_recibir, $monto_recibir, $no_guia, $url_proveedor);
            $query_insertar_cc = $this->insert($sql_cc, $datos);
            if ($query_insertar_cc) {
                echo json_encode('ok');
            } else {
                echo json_encode('error');
            }
        }
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

    public function cambiarGuias($no_guia)
    {
        $nueva_guia = "M" . $no_guia;
        $tienda_venta = $this->select("SELECT tienda_venta, tienda_proveedor FROM guia_laar WHERE guia_laar = '$no_guia'");
        $tienda_venta = $tienda_venta[0]['tienda_venta'];
        $tienda_proveedor = $tienda_venta[0]['tienda_proveedor'];
        $obtener_conexion = $this->obtener_conexion($tienda_venta);
        $obtener_conexion_proveedor = $this->obtener_conexion($tienda_proveedor);
        $sql_marketplace = "UPDATE guia_laar SET guia_laar = '$nueva_guia'  WHERE guia_laar = ?";
        $datos_marketplace = array($no_guia);
        $query_marketplace = $this->update($sql_marketplace, $datos_marketplace);
        $sql_tienda_venta = "UPDATE guia_laar SET guia_laar = '$nueva_guia'  WHERE guia_laar = '$no_guia'";
        $query_tienda_venta = mysqli_query($obtener_conexion, $sql_tienda_venta);
        $sql_proveedor = "UPDATE guia_laar SET guia_laar = '$nueva_guia'  WHERE guia_laar = '$no_guia'";
        $query_proveedor = mysqli_query($obtener_conexion_proveedor, $sql_proveedor);
    }

    public function verificarNovedades($novedad)
    {

        echo "ebtre a verificar novedades";
        $cod_novedad = $novedad["codigoTipoNovedad"];
        $no_guia = $novedad["noGuia"];
        $cliente  = $novedad["para"];
        $detalle = $novedad["nombreDetalleNovedad"];

        $tienda_venta = $this->select("SELECT tienda_venta FROM guia_laar WHERE guia_laar = '$no_guia'");
        $tienda_venta = $tienda_venta[0]['tienda_venta'];
        $conexion_proveedor = $this->obtener_conexion($tienda_venta);
        $tracking = "https://fenix.laarcourier.com/Tracking/Guiacompleta.aspx?guia=" . $no_guia;

        $existe = "SELECT * FROM novedades WHERE guia_novedad = '$no_guia' ";
        $existe = mysqli_query($conexion_proveedor, $existe);
        $existe = mysqli_fetch_array($existe);

        if ($existe) {
            $sql = "UPDATE novedades SET estado_novedad = ?, novedad = ?, tracking = ? WHERE guia_novedad = ?";
            $stmt = $conexion_proveedor->prepare($sql);
            $stmt->bind_param("ssss", $cod_novedad, $detalle, $tracking, $no_guia);
            if ($stmt->execute()) {
                echo json_encode('ok');
                echo "se actualizo la novedad";
                $data = array($cod_novedad, $detalle, $tracking, $no_guia);
                $query = $this->update($sql, $data);
            } else {
                echo json_encode('error');
            }
            $existe_m = "SELECT * FROM novedades WHERE guia_novedad = '$no_guia' ";
            $existe_m = $this->select($existe_m);

            $existe_m = count($existe_m);

            if (!empty($existe_m)) {
                echo "dx";
                $sql_u = "UPDATE novedades SET estado_novedad = ?, novedad = ?, tracking = ? WHERE guia_novedad = ?";
                $data = array($cod_novedad, $detalle, $tracking, $no_guia);
                $query = $this->update($sql_u, $data);
                echo "se actualizo la novedad";
            } else {

                echo "XD";
                $sql = "INSERT INTO `novedades` (`guia_novedad`, `cliente_novedad`, `estado_novedad`, `novedad`,  `tracking`, `tienda`) VALUES ( ?, ?, ?, ?, ?, ?)";
                $data = array($no_guia, $cliente, $cod_novedad, $detalle, $tracking, $tienda_venta);
                $query = $this->insert($sql, $data);
                echo "se inserto la novedad";
            }
        } else {

            $sql = "INSERT INTO `novedades` (`guia_novedad`, `cliente_novedad`, `estado_novedad`, `novedad`,  `tracking`) VALUES ( ?, ?, ?, ?, ?)";
            $stmt = $conexion_proveedor->prepare($sql);
            $stmt->bind_param("sssss", $no_guia, $cliente, $cod_novedad, $detalle, $tracking);

            if ($stmt->execute()) {
                echo json_encode('ok');
                // enviar correo
                $existe_m = "SELECT * FROM novedades WHERE guia_novedad = '$no_guia' ";
                $existe_m = $this->select($existe_m);

                $existe_m = count($existe_m);

                if (!empty($existe_m)) {
                    echo "dx";
                    $sql_u = "UPDATE novedades SET estado_novedad = ?, novedad = ?, tracking = ? WHERE guia_novedad = ?";
                    $data = array($cod_novedad, $detalle, $tracking, $no_guia);
                    $query = $this->update($sql_u, $data);
                    echo "se actualizo la novedad";
                } else {

                    echo "XD";
                    $sql = "INSERT INTO `novedades` (`guia_novedad`, `cliente_novedad`, `estado_novedad`, `novedad`,  `tracking`, `tienda`) VALUES ( ?, ?, ?, ?, ?, ?)";
                    $data = array($no_guia, $cliente, $cod_novedad, $detalle, $tracking, $tienda_venta);
                    $query = $this->insert($sql, $data);
                    echo "se inserto la novedad";
                }

                $tienda_venta = $this->select("SELECT tienda_venta FROM guia_laar WHERE guia_laar = '$no_guia'");
                $tienda_venta = $tienda_venta[0]['tienda_venta'];
                $conexion_proveedor = $this->obtener_conexion($tienda_venta);


                $sql_correo = "SELECT * from users where id_users='1'";
                $sql_correo = mysqli_query($conexion_proveedor, $sql_correo);
                $sql_correo = mysqli_fetch_array($sql_correo);
                $correo = $sql_correo['email_users'];
                if ($correo === "root@mail.com") {
                } else {
                    require_once '../../PHPMailer/Mail_devolucion.php';
                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->SMTPDebug = $smtp_debug;
                    $mail->Host = $smtp_host;
                    $mail->SMTPAuth = true;
                    $mail->Username = $smtp_user;
                    $mail->Password = $smtp_pass;
                    $mail->Port = 465;
                    $mail->SMTPSecure = $smtp_secure;
                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom($smtp_from, $smtp_from_name);
                    $mail->addAddress($correo);
                    $mail->Subject = 'Novedad Pedido | Laar Courier';
                    $mail->Body = $message_body_pedido;
                    if ($mail->send()) {
                        //echo "Correo enviado";
                    } else {
                        echo "Error al enviar el correo: " . $mail->ErrorInfo;
                    }
                }
            } else {
                echo json_encode('error');
            }
        }
    }
}
