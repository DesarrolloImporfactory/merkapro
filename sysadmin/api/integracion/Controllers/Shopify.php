<?php

class Shopify extends Controller
{

    public function index()
    {
        $json = file_get_contents('php://input');

        $json_decode = json_decode($json, true);

        $nombre = $json_decode['billing_address']['first_name'];
        $apellido = $json_decode['billing_address']['last_name'];
        $principal = $json_decode['billing_address']['address1'];
        $secundaria = $json_decode['billing_address']['address2'];
        $provincia = $json_decode['billing_address']['province'];
        $ciudad = $json_decode['billing_address']['city'];
        $codigo_postal = $json_decode['billing_address']['zip'];
        $pais = $json_decode['billing_address']['country'];
        $telefono = $json_decode['billing_address']['phone'];
        $email = $json_decode['email'];
        $total = $json_decode['current_total_price'];

        $line_items = $json_decode['line_items'];

        //$this->model->insertarPedido($nombre, $apellido, $principal, $secundaria, $provincia, $ciudad, $codigo_postal, $pais, $telefono, $email, $total, $nombre_producto, $cantidad, $precio, $sku, $line_items);
        $this->model->insertarPedido($nombre, $apellido, $principal, $secundaria, $provincia, $ciudad, $codigo_postal, $pais, $telefono, $email, $total, $line_items);
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
