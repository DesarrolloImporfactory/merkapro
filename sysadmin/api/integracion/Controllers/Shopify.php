<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
class Shopify extends Controller
{

    public function index()
    {
        $json = file_get_contents('php://input');
        $this->model->getJson($json);
        /* // Crear o abrir el archivo log.txt y escribir el contenido de la solicitud
        $logData = "Pedido recibido: " . date("Y-m-d H:i:s") . "\n";
        $logData .= "Nombre: $nombre $apellido\n";
        $logData .= "Dirección: $principal, $secundaria, $ciudad, $provincia, $codigo_postal, $pais\n";
        $logData .= "Teléfono: $telefono\n";
        $logData .= "Email: $email\n";
        $logData .= "Total: $total\n";
        $logData .= "Items: " . json_encode($line_items) . "\n\n";
        $logData .= "LOG:" . $json;

        file_put_contents('log.txt', $logData, FILE_APPEND); */
        $json_decode = json_decode($json, true);

        $nombre = $json_decode['billing_address']['first_name'];
        $apellido = $json_decode['billing_address']['last_name'];
        $principal = $json_decode['billing_address']['address1'];
        $secundaria = $json_decode['billing_address']['address2'];
        if (empty($secundaria) || $secundaria === null) {
            $secundaria = " ";
        }
        $provincia = $json_decode['billing_address']['province'];
        $ciudad = $json_decode['billing_address']['city'];
        $codigo_postal = $json_decode['billing_address']['zip'];
        $pais = $json_decode['billing_address']['country'];
        $telefono = $json_decode['billing_address']['phone'];
        $email = $json_decode['email'];
        $total = $json_decode['current_total_price'];

        $line_items = $json_decode['line_items'];

        $discount = $json_decode['current_total_discounts'];
        if ($discount == null || $discount == "" || $discount == 0 || empty($discount)) {
            $discount = 0;
        }

        $shipping_lines = $json_decode['shipping_lines'][0]['price'];
        if ($shipping_lines == null || $shipping_lines == "" || $shipping_lines == 0 || empty($shipping_lines)) {
            $shipping_lines = 0;
        }
        $shipping_lines_title = $json_decode['shipping_lines'][0]['title'];
        //$this->model->insertarPedido($nombre, $apellido, $principal, $secundaria, $provincia, $ciudad, $codigo_postal, $pais, $telefono, $email, $total, $nombre_producto, $cantidad, $precio, $sku, $line_items);
        $this->model->insertarPedido($nombre, $apellido, $principal, $secundaria, $provincia, $ciudad, $codigo_postal, $pais, $telefono, $email, $total, $line_items, $discount, $shipping_lines, $shipping_lines_title);
    }

    public function recibir()
    {
        $json = file_get_contents('php://input');
        $this->model->getJson($json);
    }

    public function testing($tienda)
    {
        $this->model->testing($tienda);
    }
}
