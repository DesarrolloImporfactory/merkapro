<?php
include ('autorizacionComprobante.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cargarXml
 *
 * @author UESR
 */
class cargar {

    //put your code here

    public function cargarXml($salida) {
        if (!empty($salida)) {
            foreach ($salida as $key => $value) {
                if (!empty($salida[$key][9])) {
                    
                    
                    $claveAcceso = $salida[$key][9];
                    $autorizarComprobante = new autorizacionComprobante();
                    $autorizarComprobante->generar($claveAcceso, $salida[$key]);
                }
            }

            return "Comprobantes Generados";
        }
        else{
            return "Informacion de Comprobantes Vacia!";
        }
    }

    public function cargarTxt($filename = '') {
        $filename = "consultas/consulta/txt/".$filename;
        //ini_set('auto_detect_line_endings', TRUE);
        $fp = fopen($filename, "r");
        
        $file_contents = file_get_contents($filename);
        $file_contents = utf8_encode($file_contents);
        $file_cont_new = str_replace("\r", "|", $file_contents);
        $file_cont_new = str_replace("\n", "|", $file_cont_new);
        $file_cont_new = str_replace("\t", "|", $file_cont_new);
        $file_cont_new = str_replace("NUMERO_DOCUMENTO_MODIFICADO", "", $file_cont_new);
        $file_cont_new = str_replace("||", "|", $file_cont_new);
        

        file_put_contents($filename, $file_cont_new);

        fclose($fp);
        $csvFile = $filename;
        $allRowsAsArray = array();
        $data = [];
        $contador = 0;
        $salida = array();

        if (!$fp = fopen($csvFile, "r"))
            echo "The file could not be opened.<br/>";
        while (( $data = fgetcsv($fp, 0, "|")) !== FALSE) {
            $allRowsAsArray = $data;
        }

        
        
        
        

        $salida = array_chunk($allRowsAsArray, 11);
        
        unset($salida[0]);
        
        array_pop($salida);
        
        $GLOBALS['salida'] = $salida;
        
        
        //generarXml();
        return $salida;
    }

}
