<?php

class Laar extends Controller
{
    public function index()
    {
        $json = file_get_contents('php://input');
        $json_decode = json_decode($json, true);
        print_r($json_decode['novedades']);
        if (count($json_decode['novedades']) > 0) {
            foreach ($json_decode['novedades'] as $novedad) {
                if ($novedad['codigoTipoNovedad'] != 43) {
                    $novedad["noGuia"] = $json_decode['noGuia'];
                    $novedad["para"] = $json_decode['para'];
                    $this->model->verificarNovedades($novedad);
                }
                if ($novedad['codigoTipoNovedad'] == 42 || $novedad['codigoTipoNovedad'] == 96) {
                    $estado_actual_codigo = 9;
                    break;
                } else {
                    $estado_actual_codigo = 7;
                }
                if ($novedad['codigoTipoNovedad'] == 95) {
                    $estado_actual_codigo = 95;
                }
            }
        } else {
            $estado_actual_codigo = $json_decode['estadoActualCodigo'];
        }
        $no_guia = $json_decode['noGuia'];
        if ($estado_actual_codigo == 95) {
            $this->model->cambiarGuia($no_guia);
        } else {
            $this->model->cambiarEstado($no_guia, $estado_actual_codigo);
        }
    }
    public function recibir()
    {
        $json = file_get_contents('php://input');
        echo $json;
    }

    public function guias()
    {
        $json = file_get_contents('php://input');
        $json_decode = json_decode($json, true);
        $numero_factura = $json_decode['factura'];
        $this->model->establecer_guia($numero_factura);
    }

    public function devolucion()
    {
        $json = file_get_contents('php://input');
        parse_str($json, $output);
        $guia = $output['guia_laar'];
        $estado = $output['estado'];
        $this->model->devolucion($guia, $estado);
    }
}
