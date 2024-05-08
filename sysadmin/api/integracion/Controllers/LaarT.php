<?php

class Laar extends Controller
{
    private $jsonData;

    public function __construct()
    {
        $json = file_get_contents('php://input');
        $this->jsonData = json_decode($json, true);
    }

    public function index()
    {
        if (!empty($this->jsonData['novedades'])) {
            $estado_actual_codigo = $this->handleNovedades($this->jsonData);
        } else {
            $estado_actual_codigo = $this->jsonData['estadoActualCodigo'] ?? null;
        }

        $no_guia = $this->jsonData['noGuia'];
        $this->model->processGuiaStatus($no_guia, $estado_actual_codigo);
    }

    private function handleNovedades($data)
    {
        $estado_actual_codigo = 7; // Default state
        foreach ($data['novedades'] as $novedad) {
            if ($novedad['codigoTipoNovedad'] == 42 || $novedad['codigoTipoNovedad'] == 96) {
                $estado_actual_codigo = 9;
                break;
            } elseif ($novedad['codigoTipoNovedad'] == 95) {
                $estado_actual_codigo = 95;
            }

            if ($novedad['codigoTipoNovedad'] != 43) {
                $novedad["noGuia"] = $data['noGuia'];
                $novedad["para"] = $data['para'];
                $this->model->verificarNovedades($novedad);
            }
        }
        return $estado_actual_codigo;
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
