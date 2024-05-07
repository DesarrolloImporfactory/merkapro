<?php
require_once("/home/imporsuit/public_html/factelectronica.imporsuit.com/vistas/html/consultas/consulta/lib/fpdf/fpdf.php");
require_once("/home/imporsuit/public_html/factelectronica.imporsuit.com/vistas/html/consultas/consulta/lib/fpdf/code.php");
require_once("/home/imporsuit/public_html/factelectronica.imporsuit.com/vistas/html/consultas/consulta/lib/barcode-php1/class/BCGcode128.barcode.php");
require_once("/home/imporsuit/public_html/factelectronica.imporsuit.com/vistas/html/consultas/consulta/lib/barcode-php1/class/BCGColor.php");
require_once("/home/imporsuit/public_html/factelectronica.imporsuit.com/vistas/html/consultas/consulta/lib/barcode-php1/class/BCGDrawing.php");
require_once("/home/imporsuit/public_html/factelectronica.imporsuit.com/vistas/html/consultas/consulta/lib/barcode-php1/class/BCGFontFile.php");
/*require_once 'C:\xampp\htdocs\punto_venta\vistas\html\consultas\consulta/lib/fpdf/fpdf.php';
require_once 'C:\xampp\htdocs\punto_venta\vistas\html\consultas\consulta/lib/fpdf/code.php';
require_once 'C:\xampp\htdocs\punto_venta\vistas\html\consultas\consulta/lib/barcode-php1/class/BCGcode128.barcode.php';
require_once 'C:\xampp\htdocs\punto_venta\vistas\html\consultas\consulta/lib/barcode-php1/class/BCGColor.php';
require_once 'C:\xampp\htdocs\punto_venta\vistas\html\consultas\consulta/lib/barcode-php1/class/BCGDrawing.php';
require_once 'C:\xampp\htdocs\punto_venta\vistas\html\consultas\consulta/lib/barcode-php1/class/BCGFontFile.php';*/

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of generarPDF
 *
 * @author UESR
 */
class generarPDF {

        public function facturaPDF($document, $claveAcceso) {
        
        $pdf = new PDF_Code();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 8);
		//Caja Emisor
		$pdf->RoundedRect(10, 50, 85, 52, 3, 'D');
		//Caja Documento
		$pdf->RoundedRect(100, 17, 100, 85, 3, 'D');
		//Caja Adquiriente
		$pdf->SetXY(10, 107);
		$pdf->Cell(190, 18, "", 1);
		$pdf->SetXY(15, 10);
        $pdf->image('uploads/logo.jpg', null, null, 80, 30);

        if ($document->infoFactura->obligadoContabilidad == 'SI') {
			$contabilidad = "SI";
        } else {
            $contabilidad = "NO";
        }
        
		//Datos Documento
		$pdf->SetXY(103, 18);
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(97, 8, "R.U.C.: " . $document->infoTributaria->ruc, 0);
		$pdf->SetXY(103, 26);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(97, 8, "FACTURA", 0);
		$pdf->SetXY(103, 34);
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(97, 8, "No.: ".$document->infoTributaria->estab ."-". $document->infoTributaria->ptoEmi ."-". $document->infoTributaria->secuencial, 0);
		$pdf->SetXY(103, 42);
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(97,8,utf8_decode("NÚMERO DE AUTORIZACIÓN"),0);
		$pdf->SetXY(103, 50);
		$pdf->Cell(97,8,$claveAcceso,0);
		
		if ($document->infoTributaria->ambiente == 2) {
            $ambiente = 'PRODUCCIÓN';
        } else {
            $ambiente = 'PRUEBAS';
        }
		
		$pdf->SetXY(103, 58);
		$pdf->Cell(97,8,utf8_decode("AMBIENTE: ".$ambiente),0);
		
		if ($document->infoTributaria->tipoEmision == 1) {
            $emision = 'NORMAL';
        } else {
            $emision = 'NORMAL';
        }
		
		$pdf->SetXY(103, 66);
		$pdf->Cell(97,8,utf8_decode("EMISIÓN: ".$emision),0);
		$pdf->SetXY(103, 74);
		$pdf->Cell(97,8,"CLAVE DE ACCESO:",0);
		$pdf->SetXY(103, 82);
		$pdf->Code128(103,82,$claveAcceso,94,12);
		$pdf->SetXY(103, 93);
		$pdf->Cell(97,8,$claveAcceso,0,0,'C');
		
		//Datos Emisor
		$pdf->SetXY(13, 55);
		$pdf->Cell(82,8,$document->infoTributaria->razonSocial,0);
		$pdf->SetXY(13, 63);
		$pdf->Cell(82,8,"Matriz: ".substr($document->infoTributaria->dirMatriz, 0, 39),0);
		$pdf->SetXY(13, 71);
		$pdf->Cell(82,8,"Sucursal: ".substr($document->infoTributaria->dirMatriz, 0, 39),0);
		$pdf->SetXY(13, 79);
		$pdf->Cell(82,8,"Contribuyente Especial Nro: -- ",0);
		$pdf->SetXY(13, 87);
		$pdf->Cell(82,8,"OBLIGADO LLEVAR CONTABILIDAD: ".$contabilidad,0);
		
		//Datos Adquiriente
		$pdf->SetXY(11, 108);
		$pdf->Cell(120,8,utf8_decode("Razón Social / Nombres y Apellidos: ".$document->infoFactura->razonSocialComprador),0);
		$pdf->SetXY(132, 108);
		$pdf->Cell(67,8,"R.U.C. / C.I.: ".$document->infoFactura->identificacionComprador,0);
		$pdf->SetXY(11, 116);
		$pdf->Cell(120,8,utf8_decode("Fecha Emisión: ".$document->infoFactura->fechaEmision),0);
		$pdf->SetXY(132, 116);
		$pdf->Cell(67,8,utf8_decode("Guía Remisión: ".$document->infoFactura->guiaRemision),0);
		
		//Datos Detalles
		$pdf->SetFont('Arial', '', 7);
		$pdf->SetXY(10, 130);
		$pdf->Cell(20,8,"Cod. Principal",1,0,'C');
		$pdf->SetXY(30, 130);
		$pdf->Cell(20,8,"Cantidad",1,0,'C');
		$pdf->SetXY(50, 130);
		$pdf->Cell(80,8,utf8_decode("Descripción"),1,0,'C');
		$pdf->SetXY(130, 130);
		$pdf->Cell(20,8,"Precio Uni.",1,0,'C');
		$pdf->SetXY(150, 130);
		$pdf->Cell(20,8,"Desc.",1,0,'C');
		$pdf->SetXY(170, 130);
		$pdf->Cell(30,8,"Precio Total",1,0,'C');
		
		//Detalles Lineas
		$ejeX = 130;
		foreach ($document->detalles->detalle as $a => $b) {
            
            $pdf->SetFont('Arial', '', 7);
            $ejeX = $ejeX + 8;
            $pdf->SetXY(10, $ejeX);
            $pdf->Cell(20,8,$b->codigoPrincipal,1,0,'C');
            $pdf->SetXY(30, $ejeX);
            $pdf->Cell(20,8,$b->cantidad,1,0,'C');
            $pdf->SetXY(50, $ejeX);
            $pdf->Cell(80,8,utf8_decode($b->descripcion),1,0,'C');
            $pdf->SetXY(130, $ejeX);
            $pdf->Cell(20,8,"100.00",1,0,'C');
            $pdf->SetXY(150, $ejeX);
            $pdf->Cell(20,8,$b->descuento,1,0,'C');
            $pdf->SetXY(170, $ejeX);
            $pdf->Cell(30,8,$b->precioTotalSinImpuesto,1,0,'C');
            if($ejeX >= 200){
                $pdf->AddPage();
                $ejeX = 0;
            }
		}
		
		$iva = 0;
        $ice = 0;
        $IRBPNR = 0;
        $subtotal12 = 0;
        $subtotal0 = 0;
        $subtotal_no_impuesto = 0;
        $subtotal_no_iva = 0;
        foreach ($document->infoFactura->totalConImpuestos->totalImpuesto as $a => $b) {
            if ($b->codigo == 2) {
                $iva = $b->valor;
                if ($b->codigoPorcentaje == 0) {
                    $subtotal0 = $b->baseImponible;
                }
                if ($b->codigoPorcentaje == 2) {
                    $subtotal12 = $b->baseImponible;
                }
                if ($b->codigoPorcentaje == 6) {
                    $subtotal_no_impuesto = $b->baseImponible;
                }
                if ($b->codigoPorcentaje == 7) {
                    $subtotal_no_iva = $b->baseImponible;
                }
            }
            if ($b->codigo == 3) {
                $ice = $b->valor;
            }
            if ($b->codigo == 5) {
                $IRBPNR = $b->valor;
            }
        }
		
        if($ejeX >= 180){
            $pdf->AddPage();
            $ejeX = 0;
        }
		//Sub Totales
		$ejeX = $ejeX + 15;
		$pdf->SetXY(165, $ejeX);
		$pdf->Cell(35,8,$subtotal12,1,0,'C');
		$pdf->SetXY(130, $ejeX);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(35,8,"SUBTOTAL 15%",1,0,'C');

		$pdf->SetXY(165, $ejeX + 8);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(35,8,$subtotal0,1,0,'C');
		$pdf->SetXY(130, $ejeX + 8);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(35,8,"SUBTOTAL 0%",1,0,'C');

		$pdf->SetXY(165, $ejeX + 16);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(35,8,$subtotal_no_impuesto,1,0,'C');
		$pdf->SetXY(130, $ejeX + 16);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(35,8,"SUBTOTAL  No sujeto IVA",1,0,'C');

		$pdf->SetXY(165, $ejeX + 24);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(35,8,$subtotal_no_iva,1,0,'C');
		$pdf->SetXY(130, $ejeX + 24);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(35,8,"SUBTOTAL Exento de IVA",1,0,'C');

		$pdf->SetXY(165, $ejeX + 32);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(35,8,$document->infoFactura->totalDescuento,1,0,'C');
		$pdf->SetXY(130, $ejeX + 32);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(35,8,"DESCUENTO",1,0,'C');

		$pdf->SetXY(165, $ejeX + 40);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(35,8,$iva,1,0,'C');
		$pdf->SetXY(130, $ejeX + 40);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(35,8,"IVA 12%",1,0,'C');

		$pdf->SetXY(165, $ejeX + 48);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(35,8,$ice,1,0,'C');
		$pdf->SetXY(130, $ejeX + 48);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(35,8,"ICE",1,0,'C');

		$pdf->SetXY(165, $ejeX + 56);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(35,8,$IRBPNR,1,0,'C');
		$pdf->SetXY(130, $ejeX + 56);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(35,8,"IRBPNR",1,0,'C');

		$pdf->SetXY(165, $ejeX + 64);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(35,8,$document->infoFactura->importeTotal,1,0,'C');
		$pdf->SetXY(130, $ejeX + 64);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(35,8,"VALOR TOTAL",1,0,'C');
		
		//Forma de Pago
		$pdf->SetXY(10, $ejeX);
		$pdf->Cell(30,8,"Forma de Pago",1,0,'C');
		$pdf->SetXY(40, $ejeX);
		$pdf->Cell(25,8,"Total",1,0,'C');
		$pdf->SetXY(65, $ejeX);
		$pdf->Cell(25,8,"Plazo",1,0,'C');
		$pdf->SetXY(90, $ejeX);
		$pdf->Cell(25,8,"Unidad de Tiempo",1,0,'C');
		
		foreach ($document->infoFactura->pagos->pago as $e => $f) {
            if ($f->formaPago == '01') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 8);
				$pdf->MultiCell(30,8,utf8_decode("Sin utilizacion del sistema financiero"),1,'C');
				$pdf->SetXY(40, $ejeX + 8);
				$pdf->Cell(25,16,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +8);
				$pdf->Cell(25,16,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 8);
				$pdf->Cell(25,16,utf8_decode($f->unidadTiempo),1,0,'C');
            }
			if ($f->formaPago == '15') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 8);
				$pdf->MultiCell(30,8,utf8_decode("Compensacion de deudas"),1,'C');
				$pdf->SetXY(40, $ejeX + 8);
				$pdf->Cell(25,16,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +8);
				$pdf->Cell(25,16,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 8);
				$pdf->Cell(25,16,utf8_decode($f->unidadTiempo),1,0,'C');
            }
			if ($f->formaPago == '16') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 8);
				$pdf->Cell(30,8,utf8_decode("Tarjeta debito"),1,0,'C');
				$pdf->SetXY(40, $ejeX + 8);
				$pdf->Cell(25,8,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +8);
				$pdf->Cell(25,8,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 8);
				$pdf->Cell(25,8,utf8_decode($f->unidadTiempo),1,0,'C');
            }
			if ($f->formaPago == '17') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 8);
				$pdf->Cell(30,8,utf8_decode("Dinero Electronico"),1,0,'C');
				$pdf->SetXY(40, $ejeX + 8);
				$pdf->Cell(25,8,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +8);
				$pdf->Cell(25,8,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 8);
				$pdf->Cell(25,8,utf8_decode($f->unidadTiempo),1,0,'C');
            }
			if ($f->formaPago == '18') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 8);
				$pdf->Cell(30,8,utf8_decode("Tarjeta Prepago"),1,0,'C');
				$pdf->SetXY(40, $ejeX + 8);
				$pdf->Cell(25,8,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +8);
				$pdf->Cell(25,8,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 8);
				$pdf->Cell(25,8,utf8_decode($f->unidadTiempo),1,0,'C');
            }
			if ($f->formaPago == '198') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 8);
				$pdf->Cell(30,8,utf8_decode("Tarjeta de credito"),1,0,'C');
				$pdf->SetXY(40, $ejeX + 8);
				$pdf->Cell(25,8,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +8);
				$pdf->Cell(25,8,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 8);
				$pdf->Cell(25,8,utf8_decode($f->unidadTiempo),1,0,'C');
            }
			 if ($f->formaPago == '20') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 8);
				$pdf->MultiCell(30,8,utf8_decode("Otros con utilizacion del sistema financiero"),1,'C');
				$pdf->SetXY(40, $ejeX + 8);
				$pdf->Cell(25,16,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +8);
				$pdf->Cell(25,16,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 8);
				$pdf->Cell(25,16,utf8_decode($f->unidadTiempo),1,0,'C');
            }
			if ($f->formaPago == '21') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 8);
				$pdf->Cell(30,8,utf8_decode("Endoso de titulos"),1,0,'C');
				$pdf->SetXY(40, $ejeX + 8);
				$pdf->Cell(25,8,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +8);
				$pdf->Cell(25,8,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 8);
				$pdf->Cell(25,8,utf8_decode($f->unidadTiempo),1,0,'C');
            }
        }

		$infoAdicional = "";
        $correo = "";

        foreach ($document->infoAdicional->campoAdicional as $a) {
            foreach ($a->attributes() as $b) {
                if ($b == 'Email' || $b == 'email' || $b == '=correo' || $b == 'Correo') {
                    $correo = $a;
                    $infoAdicional .= $b . ': ' . $a . "\n";
                } else {
                    $infoAdicional .= $b . ': ' . $a . "\n";
                }
            }
        }
		
		//Informacion Adicional
		$pdf->SetXY(10, $ejeX + 35);
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(100,8,utf8_decode("Información Adicional"),0,0,'C');
		
		$pdf->SetXY(10, $ejeX + 43);
		$pdf->SetFont('Arial', '', 7);
		$pdf->MultiCell(100, 5, "" . $infoAdicional . "", 0);
                
        $pdf->Output('../../comprobantes/' . $claveAcceso . '.pdf', 'F');
        
    }

    public function notaDebitoPDF($document, $claveAcceso) {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);
//$pdf->Cell(40, 10, 'Hello World!');
        if ($document->infoNotaDebito->obligadoContabilidad == 'SI') {

            $contabilidad = "Obligado a llevar contabilidad : SI";
        } else {
            $contabilidad = "Obligado a llevar contabilidad : NO";
        }
        $pdf->SetXY(10, 0);
        $pdf->image('uploads/logo.jpg', null, null, 80, 30);

        $pdf->SetXY(110, 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(100, 10, "RUC: " . $document->infoTributaria->ruc, 0, 'J', true);
        $pdf->SetXY(110, 15);
        $pdf->MultiCell(100, 10, "Nota Debito Nro: " . $document->infoTributaria->estab . $document->infoTributaria->ptoEmi . $document->infoTributaria->secuencial, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(110, 20);
        $pdf->MultiCell(100, 10, 'Nro Autorizacion: ', 0);
        $pdf->SetXY(110, 25);
        $pdf->MultiCell(100, 10, $claveAcceso, 0);
        $pdf->SetXY(110, 30);
        if ($document->infoTributaria->ambiente == 2) {
            $ambiente = 'PRODUCCION';
        } else {
            $ambiente = 'PRUEBAS';
        }
        $pdf->MultiCell(100, 10, 'Ambiente: ' . $ambiente, 0);
        $pdf->SetXY(110, 35);
        if ($document->infoTributaria->tipoEmision == 1) {
            $emision = 'NORMAL';
        } else {
            $emision = 'NORMAL';
        }
        $pdf->MultiCell(100, 10, 'Emision: ' . $emision, 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(10, 20);
        $pdf->MultiCell(100, 10, $document->infoTributaria->razonSocial, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(10, 25);
        $pdf->MultiCell(100, 10, $document->infoTributaria->dirMatriz, 0);
        $pdf->SetXY(10, 30);
        $pdf->MultiCell(100, 10, $contabilidad, 0);
        //Codigo de barras

        $pdf->SetXY(110, 45);
        $this->generarCodigoBarras($claveAcceso);
        $pdf->image('uploads/codigo_mod.png', null, null, 100, 20);
        $pdf->SetXY(110, 63);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(100, 10, $claveAcceso, 0, 0, "C", true);
        //informacion del cliente
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);

        $pdf->SetXY(10, 35);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(100, 10, "INFORMACION DEL CLIENTE", 0);

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(10, 40);
        $pdf->MultiCell(100, 10, "RUC/CI: " . $document->infoNotaDebito->identificacionComprador, 0);
        $pdf->SetXY(10, 45);
        $pdf->MultiCell(100, 10, "Razon Social/Nombre: " . $document->infoNotaDebito->razonSocialComprador, 0);
        $pdf->SetXY(10, 50);
        $pdf->MultiCell(100, 10, "Direccion: " . $document->infoNotaDebito->dirEstablecimiento, 0);
        $pdf->SetXY(10, 70);
        $pdf->MultiCell(100, 10, "Fecha Emision: " . $document->infoNotaDebito->fechaEmision, 0);

        $ejeX = 80;

        $pdf->SetXY(10, $ejeX);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(100, 10, "FORMAS DE PAGO", 0);
        $pdf->SetFont('Arial', '', 8);
        $ejeX = $ejeX + 10;
        $pdf->SetXY(10, $ejeX);
        foreach ($document->infoNotaDebito->pagos->pago as $e => $f) {
            if ($f->formaPago == '01') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Sin utilizacion del sistema financiero', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(5, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(5, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(13, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '15') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Compensacion de deudas', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '16') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Tarjeta debito', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '17') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Dinero Electronico', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '18') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Tarjeta Prepago', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '19') {
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(20, 10, 'Tarjeta de credito', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(1, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '20') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Otros con utilizacion del sistema financiero', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '21') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Endoso de titulos', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }

            $ejeX = $ejeX + 10;
            $pdf->SetX($ejeX);
        }

        //detalle de la factura
        $ejeX = $ejeX + 10;

        $pdf->SetXY(10, $ejeX);
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(0, 255, 255);

        $pdf->Cell(50, 10, "Comprobante que se modifica", 1, 0, "C", true);
        $pdf->Cell(50, 10, "Numero documento modific", 1, 0, "C", true);
        $pdf->Cell(50, 10, "Fecha Emision (Comprobante a", 1, 0, "C", true);
        $pdf->Cell(50, 10, "Razon de la modifi", 1, 0, "C", true);


        $ejeX = $ejeX + 10;
        $pdf->SetXY(10, $ejeX);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);

        if ($document->infoNotaDebito->codDocModificado == "01") {
            $pdf->Cell(50, 10, "FACTURA", 1, 0, "L");
        } else {
            $pdf->Cell(50, 10, $document->infoNotaDebito->codDocModificado, 1, 0, "L");
        }

        $pdf->Cell(50, 10, $document->infoNotaDebito->numDocModificado, 1, 0, "L");
        $pdf->Cell(50, 10, $document->infoNotaDebito->fechaEmisionDocSustento, 1, 0, "L");

        foreach ($document->motivos->motivo as $a => $b) {
            $pdf->Cell(50, 10, $b->razon, 1, 0, "C", true);
            $ejeX = $ejeX + 10;
            $pdf->SetXY(10, $ejeX);
        }


        $pdf->SetXY(150, $ejeX);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $iva = 0;
        $ice = 0;
        $IRBPNR = 0;
        $subtotal12 = 0;
        $subtotal0 = 0;
        $subtotal_no_impuesto = 0;
        $subtotal_no_iva = 0;
        foreach ($document->infoNotaDebito->impuestos->impuesto as $a => $b) {
            if ($b->codigo == 2) {
                $iva = number_format(floatval($b->valor), 2);
                if ($b->codigoPorcentaje == 0) {
                    $subtotal0 = number_format(floatval($b->baseImponible), 2);
                }
                if ($b->codigoPorcentaje == 2) {
                    $subtotal12 = number_format(floatval($b->baseImponible), 2);
                }
                if ($b->codigoPorcentaje == 6) {
                    $subtotal_no_impuesto = number_format(floatval($b->baseImponible), 2);
                }
                if ($b->codigoPorcentaje == 7) {
                    $subtotal_no_iva = number_format(floatval($b->baseImponible), 2);
                }
            }
            if ($b->codigo == 3) {
                $ice = number_format(floatval($b->valor), 2);
            }
            if ($b->codigo == 5) {
                $IRBPNR = number_format(floatval($b->valor), 2);
            }
        }
        $pdf->SetXY(130, $ejeX + 10);
        $pdf->Cell(25, 10, "Subtotal 15%: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 10);
        $pdf->Cell(25, 10, " $subtotal12 ", 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 16);
        $pdf->Cell(25, 10, "SubTotal 0%: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 16);
        $pdf->Cell(25, 10, $subtotal0, 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 22);
        $pdf->Cell(25, 10, "SubTotal no sujeto de IVA: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 22);
        $pdf->Cell(25, 10, $subtotal_no_impuesto, 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 28);
        $pdf->Cell(25, 10, "SubTotal exento de IVA: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 28);
        $pdf->Cell(25, 10, $subtotal_no_iva, 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 34);
        $pdf->Cell(25, 10, "SubTotal sin Impuestos: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 34);
        $pdf->Cell(25, 10, number_format(floatval($document->infoNotaDebito->totalSinImpuestos), 2), 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 40);
        $pdf->Cell(25, 10, "IVA 12%: ", 0, 0, "L");
        $pdf->SetXY(180, $ejeX + 40);
        $pdf->Cell(25, 10, $iva, 0, 0, "R");
        $pdf->SetXY(130, $ejeX + 46);
        $pdf->Cell(25, 10, "ICE: ", 0, 0, "L");
        $pdf->SetXY(180, $ejeX + 46);
        $pdf->Cell(25, 10, $ice, 0, 0, "R");
        $pdf->SetXY(130, $ejeX + 52);
        $pdf->Cell(25, 10, "IRBPNR: ", 0, 0, "L");
        $pdf->SetXY(180, $ejeX + 52);
        $pdf->Cell(25, 10, $IRBPNR, 0, 0, "R");
        $pdf->SetXY(130, $ejeX + 58);
        $pdf->Cell(25, 10, "Valor Total: ", 0, 0, "L");
        $pdf->SetXY(180, $ejeX + 58);
        $pdf->Cell(25, 10, number_format(floatval($document->infoNotaDebito->valorTotal), 2), 0, 0, "R");
        $infoAdicional = "";
        $correo = "";

        foreach ($document->infoAdicional->campoAdicional as $a) {
            foreach ($a->attributes() as $b) {
                if ($b == 'Email' || $b == 'email' || $b == '=correo' || $b == 'Correo') {
                    $correo = $a;
                    $infoAdicional .= $b . ': ' . $a . "\n";
                } else {
                    $infoAdicional .= $b . ': ' . $a . "\n";
                }
            }
        }
        $pdf->SetXY(10, $ejeX + 30);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->MultiCell(100, 10, "Informacion Adicional", 0);
        $pdf->SetXY(10, $ejeX + 40);
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell(100, 5, "" . $infoAdicional . "", 0);

        //$email = new sendEmail();
        
        $pdf->Output('../../comprobantes/' . $claveAcceso . '.pdf', 'F');
        //$email->enviarCorreo('Nota Debito', $document->infoNotaDebito->razonSocialComprador, $claveAcceso, $correo);
    }

    public function guiaRemisionPDF($document, $claveAcceso) {
        $pdf = new PDF_Code();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 8);
        //Caja Emisor
		$pdf->RoundedRect(10, 50, 85, 52, 3, 'D');
		//Caja Documento
		$pdf->RoundedRect(100, 17, 100, 85, 3, 'D');
        //Caja Adquiriente
        $pdf->SetXY(10, 107);
        $pdf->Cell(190, 18, "", 1);
        $pdf->SetXY(15, 10);
        $pdf->image('uploads/logo.jpg', null, null, 80, 30);

        //$pdf->Cell(40, 10, 'Hello World!');
        if ($document->infoGuiaRemision->obligadoContabilidad == 'SI') {

            $contabilidad = "SI";
        } else {
            $contabilidad = "NO";
        }

        //Datos Documento
        $pdf->SetXY(103, 18);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(97, 8, "R.U.C.: " . $document->infoTributaria->ruc, 0);
        $pdf->SetXY(103, 26);
		$pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(97, 8, "GUIA DE REMISION", 0);
		$pdf->SetXY(103, 34);
		$pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(97, 8, "No.: ".$document->infoTributaria->estab ."-". $document->infoTributaria->ptoEmi ."-". $document->infoTributaria->secuencial, 0);
        $pdf->SetXY(103, 42);
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(97,8,utf8_decode("NÚMERO DE AUTORIZACIÓN"),0);
		$pdf->SetXY(103, 50);
		$pdf->Cell(97,8,$claveAcceso,0);

        if ($document->infoTributaria->ambiente == 2) {
            $ambiente = 'PRODUCCION';
        } else {
            $ambiente = 'PRUEBAS';
        }

        $pdf->SetXY(103, 58);
		$pdf->Cell(97,8,utf8_decode("AMBIENTE: ".$ambiente),0);

        if ($document->infoTributaria->tipoEmision == 1) {
            $emision = 'NORMAL';
        } else {
            $emision = 'NORMAL';
        }

        $pdf->SetXY(103, 66);
		$pdf->Cell(97,8,utf8_decode("EMISIÓN: ".$emision),0);
        $pdf->SetXY(103, 74);
		$pdf->Cell(97,8,"CLAVE DE ACCESO:",0);
		$pdf->SetXY(103, 82);
		$pdf->Code128(103,82,$claveAcceso,94,12);
		$pdf->SetXY(103, 93);
		$pdf->Cell(97,8,$claveAcceso,0,0,'C');

        //Datos Emisor
		$pdf->SetXY(13, 55);
		$pdf->Cell(82,8,$document->infoTributaria->razonSocial,0);
        $pdf->SetXY(13, 63);
		$pdf->Cell(82,8,"Matriz: ".substr($document->infoTributaria->dirMatriz, 0, 39),0);
        $pdf->SetXY(13, 71);
		$pdf->Cell(82,8,"Sucursal: ".substr($document->infoTributaria->dirMatriz, 0, 39),0);
        $pdf->SetXY(13, 79);
		$pdf->Cell(82,8,"Contribuyente Especial Nro: -- ",0);
        $pdf->SetXY(13, 87);
		$pdf->Cell(82,8,"OBLIGADO LLEVAR CONTABILIDAD: ".$contabilidad,0);

        //Datos Transportista
		$pdf->SetXY(11, 108);
		$pdf->Cell(120,8,utf8_decode("Razon Social/Nombre:".$document->infoGuiaRemision->razonSocialTransportista),0);
		$pdf->SetXY(132, 108);
		$pdf->Cell(67,8,"R.U.C. / C.I.: ".$document->infoGuiaRemision->rucTransportista,0);
		$pdf->SetXY(11, 116);
		$pdf->Cell(120,8,utf8_decode("Direccion: ".$document->infoGuiaRemision->dirEstablecimiento),0);
		$pdf->SetXY(132, 116);
		$pdf->Cell(67,8,utf8_decode("Placa: ".$document->infoGuiaRemision->placa),0);

        //Datos Transportista
        $pdf->SetXY(10, 126);
        $pdf->Cell(190, 8, "", 1);
		$pdf->SetXY(11, 126);
		$pdf->Cell(120,8,utf8_decode("Punto de Partida:".$document->infoGuiaRemision->dirPartida),0);
		$pdf->SetXY(80, 126);
		$pdf->Cell(67,8,"Fecha Inicio".$document->infoGuiaRemision->fechaIniTransporte,0);
		$pdf->SetXY(150, 126);
		$pdf->Cell(120,8,utf8_decode("Fecha Fin: ".$document->infoGuiaRemision->fechaFinTransporte),0);

        //Datos Detalles
		$pdf->SetFont('Arial', '', 7);
		$pdf->SetXY(10, 135);
		$pdf->Cell(30,8,"NIT/CI Destinatario",1,0,'C');
		$pdf->SetXY(40, 135);
		$pdf->Cell(70,8,"Destinatario",1,0,'C');
		$pdf->SetXY(110, 135);
		$pdf->Cell(60,8,utf8_decode("Dirección"),1,0,'C');
		$pdf->SetXY(170, 135);
		$pdf->Cell(30,8,"Motivo",1,0,'C');

        //Detalles Lineas
		$ejeX = 135;
		foreach ($document->destinatarios->destinatario as $a => $b) {
            
            $pdf->SetFont('Arial', '', 7);
            $ejeX = $ejeX + 8;
            $pdf->SetXY(10, $ejeX);
            $pdf->Cell(30,8,$b->identificacionDestinatario,1,0,'C');
            $pdf->SetXY(40, $ejeX);
            $pdf->Cell(70,8,$b->razonSocialDestinatario,1,0,'C');
            $pdf->SetXY(110, $ejeX);
            $pdf->Cell(60,8,utf8_decode($b->dirDestinatario),1,0,'C');
            $pdf->SetXY(170, $ejeX);
            $pdf->Cell(30,8,$b->motivoTraslado,1,0,'C');
            if($ejeX >= 200){
                $pdf->AddPage();
                $ejeX = 0;
            }
		}
        /*foreach ($document->destinatarios->destinatario as $a => $b) {
            $pdf->Cell(30, 10, $b->identificacionDestinatario, 1);
            $pdf->Cell(40, 10, $b->razonSocialDestinatario, 1);
            $pdf->Cell(50, 10, $b->dirDestinatario, 1);
            $pdf->Cell(30, 10, $b->numDocSustento, 1);
            $pdf->Cell(20, 10, $b->motivoTraslado, 1);
            $pdf->Cell(20, 10, $b->fechaEmisionDocSustento, 1);
            $ejeX = $ejeX + 10;
            $pdf->SetX($ejeX);
        }*/
        $ejeX = $ejeX + 10;
        $pdf->SetFont('Arial', '', 7);
		$pdf->SetXY(10, $ejeX);
        $pdf->Cell(40,8,"Codigo",1,0,'C');
        $pdf->SetXY(50, $ejeX);
		$pdf->Cell(120,8,"Descripcion",1,0,'C');
        $pdf->SetXY(170, $ejeX);
		$pdf->Cell(30,8,"Cantidad",1,0,'C');

        foreach ($document->destinatarios->destinatario as $a => $b) {
            foreach ($b->detalles->detalle as $c => $d) {
                $pdf->SetFont('Arial', '', 7);
                $ejeX = $ejeX + 8;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(40,8,$d->codigoInterno,1,0,'C');
                $pdf->SetXY(50, $ejeX);
                $pdf->Cell(120,8,$d->descripcion,1,0,'C');
                $pdf->SetXY(170, $ejeX);
                $pdf->Cell(30,8,$d->cantidad,1,0,'C');

                if($ejeX >= 200){
                    $pdf->AddPage();
                    $ejeX = 0;
                }
                /*$pdf->Cell(25, 10, $d->codigoInterno, 1, 0, "C", true);
                $pdf->Cell(50, 10, $d->descripcion, 1, 0, "C", true);
                $pdf->Cell(25, 10, $d->cantidad, 1, 0, "C", true);
                $ejeX = $ejeX + 10;
                $pdf->SetXY(10, $ejeX);*/
            }
        }

        
        $infoAdicional = "";
        $correo = "";

        foreach ($document->infoAdicional->campoAdicional as $a) {
            foreach ($a->attributes() as $b) {
                if ($b == 'Email' || $b == 'email' || $b == '=correo' || $b == 'Correo') {
                    $correo = $a;
                    $infoAdicional .= $b . ': ' . $a . "\n";
                } else {
                    $infoAdicional .= $b . ': ' . $a . "\n";
                }
            }
        }
        //Informacion Adicional
		$pdf->SetXY(10, $ejeX + 10);
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(100,8,utf8_decode("Información Adicional"),0,0,'C');
		
		$pdf->SetXY(10, $ejeX + 18);
		$pdf->SetFont('Arial', '', 7);
		$pdf->MultiCell(100, 5, "" . $infoAdicional . "", 0);

        

        // Pie de pagina*/

        $pdf->Output('comprobantes/GR_' . $claveAcceso . '.pdf', 'F');
        
        //$pdf->Output('../../comprobantes/' . $claveAcceso . '.pdf', 'F');
       // //$email = new sendEmail();
       // //$email->enviarCorreo('Guia Remision', $document->infoGuiaRemision->razonSocialTransportista, $claveAcceso, $correo);
    }

    public function comprobanteRetencionPDF($document, $claveAcceso) {
        $pdf = new PDF_Code();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 8);
        //Caja Emisor
        $pdf->RoundedRect(10, 50, 85, 52, 3, 'D');
        //Caja Documento
        $pdf->RoundedRect(100, 17, 100, 85, 3, 'D');
        $pdf->SetXY(10, 107);
        $pdf->Cell(190, 18, "", 1);
        $pdf->SetXY(15, 10);

        $pdf->image('uploads/logo.jpg', null, null, 80, 30);

        if ($document->infoCompRetencion->obligadoContabilidad == 'SI') {

            $contabilidad = "SI";
        } else {
            $contabilidad = "NO";
        }

        //Datos Documento
        $pdf->SetXY(103, 18);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(97, 8, "R.U.C.: " . $document->infoTributaria->ruc, 0);
        $pdf->SetXY(103, 26);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(97, 8, "RETENCION", 0);
        $pdf->SetXY(103, 34);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(97, 8, "No.: " . $document->infoTributaria->estab . "-" . $document->infoTributaria->ptoEmi . "-" . $document->infoTributaria->secuencial, 0);
        $pdf->SetXY(103, 42);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(97, 8, utf8_decode("NÚMERO DE AUTORIZACIÓN"), 0);
        $pdf->SetXY(103, 50);
        $pdf->Cell(97, 8, $claveAcceso, 0);

        if ($document->infoTributaria->ambiente == 2) {
            $ambiente = 'PRODUCCION';
        } else {
            $ambiente = 'PRUEBAS';
        }

        $pdf->SetXY(103, 58);
        $pdf->Cell(97, 8, utf8_decode("AMBIENTE: " . $ambiente), 0);
        
        if ($document->infoTributaria->tipoEmision == 1) {
            $emision = 'NORMAL';
        } else {
            $emision = 'NORMAL';
        }

        $pdf->SetXY(103, 66);
        $pdf->Cell(97, 8, utf8_decode("EMISIÓN: " . $emision), 0);
        $pdf->SetXY(103, 74);
        $pdf->Cell(97, 8, "CLAVE DE ACCESO:", 0);
        $pdf->SetXY(103, 82);
        $pdf->Code128(103, 82, $claveAcceso, 94, 12);
        $pdf->SetXY(103, 93);
        $pdf->Cell(97, 8, $claveAcceso, 0, 0, 'C');
        
        //Datos Emisor
        $pdf->SetXY(13, 55);
        $pdf->Cell(82, 8, $document->infoTributaria->razonSocial, 0);
        //$pdf->Cell(82,8,$document->infoTributaria->nombreComercial,0)

        $pdf->SetXY(13, 63);
        $pdf->SetFont('Arial', '', 7);
        //$document->infoTributaria->dirMatriz = 'Quevedo Norte - Av 7 de Octubre Palmeiras y Decima Primera -Local 406 Frente a Servientrega';
        if (strlen($document->infoTributaria->dirMatriz) <= 53) {

            $pdf->MultiCell(100, 10, 'Matriz: ' . substr($document->infoTributaria->dirMatriz, 0, 53), 0);
        } else {
            $pdf->MultiCell(100, 10, 'Matriz: ' . substr($document->infoTributaria->dirMatriz, 0, 50), 0);
            $pdf->SetXY(13, 66);
            $pdf->MultiCell(100, 10, substr($document->infoTributaria->dirMatriz, 50, 200), 0);
        }

        $pdf->SetXY(13, 71);
        if ($document->infoCompRetencion->dirEstablecimiento != '') {
            if (strlen($document->infoTributaria->dirMatriz) <= 53) {
                $pdf->MultiCell(100, 10, 'Sucursal: ' . substr($document->infoTributaria->dirMatriz, 0, 53), 0);
            } else {
                $pdf->MultiCell(100, 10, 'Sucursal: ' . substr($document->infoTributaria->dirMatriz, 0, 50), 0);
                $pdf->SetXY(13, 75);
                $pdf->MultiCell(100, 10, substr($document->infoTributaria->dirMatriz, 50, 200), 0);
            }

        } else {

            if (strlen($document->infoCompRetencion->dirEstablecimiento) <= 53) {
                $pdf->MultiCell(100, 10, 'Sucursal: ' . substr($document->infoCompRetencion->dirEstablecimiento, 0, 53), 0);
            } else {
                $pdf->MultiCell(100, 10, 'Sucursal: ' . substr($document->infoCompRetencion->dirEstablecimiento, 0, 50), 0);
                $pdf->SetXY(13, 75);
                $pdf->MultiCell(100, 10, substr($document->infoCompRetencion->dirEstablecimiento, 50, 200), 0);
            }

        }
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(13, 79);
        $pdf->Cell(82, 8, "Contribuyente Especial Nro: -- ", 0);
        $pdf->SetXY(13, 87);
        $pdf->Cell(82, 8, "OBLIGADO LLEVAR CONTABILIDAD: " . $contabilidad, 0);

        //Datos Adquiriente
        $pdf->SetXY(11, 108);
        $pdf->Cell(120, 8, utf8_decode("Razón Social / Nombres y Apellidos: " . $document->infoCompRetencion->razonSocialComprador), 0);
        $pdf->SetXY(132, 108);
        $pdf->Cell(67, 8, "R.U.C. / C.I.: " . $document->infoCompRetencion->identificacionComprador, 0);
        $pdf->SetXY(11, 116);
        $pdf->Cell(120, 8, utf8_decode("Fecha Emisión: " . $document->infoCompRetencion->fechaEmision), 0);
        $pdf->SetXY(110, 116);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(55, 8, utf8_decode("Direccion: " . $document->infoCompRetencion->dirEstablecimiento), 0);
        $pdf->SetFont('Arial', '', 8);
        $ejeX = 80;
        //detalle de la retencion

        $ejeX = $ejeX + 40;
        $pdf->SetXY(10, $ejeX + 10);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->MultiCell(15, 5, "Impuesto", 1, "C", true);
        $pdf->SetXY(25, $ejeX + 10);
        $pdf->MultiCell(20, 5, "Cod. Retenci", 1, "C", true);
        $pdf->SetXY(45, $ejeX + 10);
        $pdf->MultiCell(25, 5, "Base Imponible", 1, "C", true);
        $pdf->SetXY(70, $ejeX + 10);
        $pdf->MultiCell(20, 5, "Porcentaje", 1, "C", true);
        $pdf->SetXY(90, $ejeX + 10);
        $pdf->MultiCell(15, 5, "Sustento", 1, "C", true);
        $pdf->SetXY(105, $ejeX + 10);
        $pdf->MultiCell(35, 5, "Documento", 1, "C", true);
        $pdf->SetXY(140, $ejeX + 10);
        $pdf->MultiCell(15, 5, "Ejercicio", 1, "C", true);
        $pdf->SetXY(155, $ejeX + 10);
        $pdf->MultiCell(15, 5, "Fecha", 1, "C", true);
        $pdf->SetXY(170, $ejeX + 10);
        $pdf->MultiCell(30, 5, "Valor Retenido", 1, "C", true);
        
        $ejeX = $ejeX + 15;
        $pdf->SetXY(10, $ejeX);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $xx = 10;
        $y = $ejeX;

        $x1 = 40;
        $y1 = $ejeX;
        $n = 0;
        $anchocelda = 30;
        $altocelda = 0;
        $anchocelda2 = 15;
        $altocelda2 = 0;
        $bool_page = false;
        $count = 0;
        $total = 0;
        foreach ($document->impuestos->impuesto as $a => $b) {
        //foreach ($document->docsSustento->docSustento->retenciones->retencion as $a => $b) {
            $pila = array();
            array_push($pila, strlen($b->codigoPrincipal), strlen($b->codigoAuxiliar), strlen($b->descripcion));
            $max = max($pila);
            for ($i = 0; $i < count($pila); $i++) {
                if ($pila[$i] == $max)
                    $posicionmax = $i;
            }
            
            $pdf->SetXY($xx, $y);
            $pdf->SetFont('Arial', 'B', 7);
            
            if ($b->codigo == 1) {
                $pdf->MultiCell(15, 5, 'IVA', 'T', 'C', true);
            } else if ($b->codigo == 2) {
                $pdf->MultiCell(15, 5, 'Renta', 'T', 'C', true);
            } else {
                $pdf->MultiCell(15, 5, $b->codigo, 'T', 'C', true);
            }

            $xx = $xx + 15;
            $pdf->SetXY($xx, $y);

            $pdf->SetFont('Arial', '', 6);
            $pdf->MultiCell(20, 5, $b->codigoRetencion, 'T', "C");

            $xx = $xx + 20;
            $pdf->SetXY($xx, $y);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->MultiCell(25, 5, number_format(floatval($b->baseImponible), 2), 'T', "C");
            
            $xx = $xx + 25;
            $pdf->SetXY($xx, $y);
            $pdf->MultiCell(20, 5, $b->porcentajeRetener . "%", 'T', "C");
            
            $xx = $xx + 20;
            $pdf->SetXY($xx, $y);
            if ($b->codDocSustento = '01') {
                $pdf->MultiCell(15, 5, "FACTURA", 'T', "C");
            } else {
                $pdf->MultiCell(15, 5, $b->codDocSustento, 'T', "C");
            }
            
            $xx = $xx + 15;
            $pdf->SetXY($xx, $y);
            $pdf->MultiCell(35, 5, $b->numDocSustento, 'T', "C");
            
            $xx = $xx + 34;
            $pdf->SetXY($xx, $y);
            $pdf->MultiCell(15, 5, date("Y"), 'T', "C");    

            $xx = $xx + 17;
            $pdf->SetXY($xx, $y);
            $pdf->MultiCell(15, 5, $b->fechaEmisionDocSustento, 'T', "C");  
        
            $xx = $xx + 14;
            $pdf->SetXY($xx, $y);
            $pdf->MultiCell(30, 5, $b->valorRetenido, 'T', "C");  
            $xx = 10;
            $total += floatval($b->valorRetenido);

            if ($y >= 263) {

                $pdf->AddPage();
                $xx = 10;
                $y = 10;
                $yy = 10;
                
                $bool_page = true;
                
            }else{
                $y = $y + 5;
            }
            $count ++;
        }
        $ejeX = $y;
        if ($y >= 263 or $count >=15) {
            $pdf->AddPage();
            $ejeX = 0;

        } else {
            if($bool_page == true){
                $ejeX = $xx + 10;
                
                $pdf->Line(10, $y-5, 200, $y-5);
            }else{
                if($count <= 4){
                    $ejeX = $ejeX -5;
                }else{
                    if($max > 68){
                        $ejeX = $ejeX + 50;    
                    }else{
                        $ejeX = $ejeX + 25;
                    }
                    
                }
                
                $pdf->Line(10, $y, 200, $y);
            }
            

        }

        if($count >= 13){
            $ejeX = $ejeX + 5;
        }
        else if($count <= 4){
            $ejeX = $ejeX + 20;
        }else{
            $ejeX = $ejeX + 25;
        }

        $pdf->SetXY(170, $ejeX + 5);//170
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$total,2),1,0,'C');//30
		$pdf->SetXY(130, $ejeX + 5);//130
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"TOTAL",1,0,'C');

       
        $infoAdicional = "";
        $correo = "";
        foreach ($document->infoAdicional->campoAdicional as $a) {
            foreach ($a->attributes() as $b) {
                if ($b == 'Email' || $b == 'email' || $b == '=correo' || $b == 'Correo') {
                    $correo = $a;
                    $infoAdicional .= $b . ': ' . $a . "\n";
                } else {
                    $infoAdicional .= $b . ': ' . $a . "\n";
                }
            }
        }
        

        //Información Adicional
		$pdf->SetXY(10, $ejeX + 5);
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(80,8,utf8_decode("Información Adicional"),1,0,'C');
		
		$pdf->SetXY(10, $ejeX + 13);
		$pdf->SetFont('Arial', '', 7);
		$pdf->MultiCell(80, 4, "" . $infoAdicional . "", 1);

        
        //$pdf->Output('../../comprobantes/' . $claveAcceso . '.pdf', 'F');
        //$pdf->Output('comprobantes/' . $claveAcceso . '.pdf', 'F');
        //$pdf->Output('/home/imporsuit/public_html/factelectronica.imporsuit.com/vistas/html/comprobantes/consultas/consulta/comprobantes/RC_' . $claveAcceso . '.pdf', 'F');
        $pdf->Output('comprobantes/RC_' . $claveAcceso . '.pdf', 'F');
        //$email = new sendEmail();
        //$email->enviarCorreo('Comprobante de Retencion', $document->infoCompRetencion->razonSocialSujetoRetenido, $claveAcceso, $correo);
    }

    public function notaCreditoPDF($document, $claveAcceso) {
        $pdf = new PDF_Code();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 8);
        //$pdf->Cell(40, 10, 'Hello World!');
        //Caja Emisor
        $pdf->RoundedRect(10, 50, 85, 52, 3, 'D');
        //Caja Documento
        $pdf->RoundedRect(100, 17, 100, 85, 3, 'D');
        //Caja Adquiriente
        $pdf->SetXY(10, 107);
        $pdf->Cell(190, 18, "", 1);
        $pdf->SetXY(15, 20);

        $pdf->image('uploads/logo.jpg', null, null, 80, 27);
        
        if ($document->infoNotaCredito->obligadoContabilidad == 'SI') {

            $contabilidad = "SI";
        } else {
            $contabilidad = "NO";
        }

        //Datos Documento
        $pdf->SetXY(103, 18);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(97, 8, "R.U.C.: " . $document->infoTributaria->ruc, 0);
        $pdf->SetXY(103, 26);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(97, 8, "NOTA CREDITO", 0);
        $pdf->SetXY(103, 34);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(97, 8, "No.: " . $document->infoTributaria->estab . "-" . $document->infoTributaria->ptoEmi . "-" . $document->infoTributaria->secuencial, 0);
        $pdf->SetXY(103, 42);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(97, 8, utf8_decode("NÚMERO DE AUTORIZACIÓN"), 0);
        $pdf->SetXY(103, 50);
        $pdf->Cell(97, 8, $claveAcceso, 0);

        if ($document->infoTributaria->ambiente == 2) {
            $ambiente = 'PRODUCCION';
        } else {
            $ambiente = 'PRUEBAS';
        }

        $pdf->SetXY(103, 58);
        $pdf->Cell(97, 8, utf8_decode("AMBIENTE: " . $ambiente), 0);
        
        if ($document->infoTributaria->tipoEmision == 1) {
            $emision = 'NORMAL';
        } else {
            $emision = 'NORMAL';
        }

        $pdf->SetXY(103, 66);
        $pdf->Cell(97, 8, utf8_decode("EMISIÓN: " . $emision), 0);
        $pdf->SetXY(103, 74);
        $pdf->Cell(97, 8, "CLAVE DE ACCESO:", 0);
        $pdf->SetXY(103, 82);
        $pdf->Code128(103, 82, $claveAcceso, 94, 12);
        $pdf->SetXY(103, 93);
        $pdf->Cell(97, 8, $claveAcceso, 0, 0, 'C');

        //Datos Emisor
        $pdf->SetXY(13, 55);
        $pdf->Cell(82, 8, $document->infoTributaria->razonSocial, 0);
        //$pdf->Cell(82,8,$document->infoTributaria->nombreComercial,0);

        $pdf->SetXY(13, 63);
       // $document->infoTributaria->dirMatriz = 'Quevedo Norte - Av 7 de Octubre Palmeiras y Decima Primera -Local 406 Frente a Servientrega';
        if (strlen($document->infoTributaria->dirMatriz) <= 53) {
            $pdf->MultiCell(100, 10, 'Matriz: ' . substr($document->infoTributaria->dirMatriz, 0, 53), 0);
        } else {
            $pdf->MultiCell(100, 10, 'Matriz: ' . substr($document->infoTributaria->dirMatriz, 0, 50), 0);
            $pdf->SetXY(13, 66);
            $pdf->MultiCell(100, 10, substr($document->infoTributaria->dirMatriz, 50, 200), 0);
        }

        $pdf->SetXY(13, 71);
        if ($document->infoNotaCredito->dirEstablecimiento != '') {
            if (strlen($document->infoTributaria->dirMatriz) <= 53) {
                $pdf->MultiCell(100, 10, 'Sucursal: ' . substr($document->infoTributaria->dirMatriz, 0, 53), 0);
            } else {
                $pdf->MultiCell(100, 10, 'Sucursal: ' . substr($document->infoTributaria->dirMatriz, 0, 50), 0);
                $pdf->SetXY(13, 75);
                $pdf->MultiCell(100, 10, substr($document->infoTributaria->dirMatriz, 50, 200), 0);
            }

        } else {

            if (strlen($document->infoNotaCredito->dirEstablecimiento) <= 53) {
                $pdf->MultiCell(100, 10, 'Sucursal: ' . substr($document->infoNotaCredito->dirEstablecimiento, 0, 53), 0);
            } else {
                $pdf->MultiCell(100, 10, 'Sucursal: ' . substr($document->infoNotaCredito->dirEstablecimiento, 0, 50), 0);
                $pdf->SetXY(13, 75);
                $pdf->MultiCell(100, 10, substr($document->infoNotaCredito->dirEstablecimiento, 50, 200), 0);
            }

        }

        $pdf->SetXY(13, 79);
        $pdf->Cell(82, 8, "Contribuyente Especial Nro: -- ", 0);
        $pdf->SetXY(13, 87);
        $pdf->Cell(82, 8, "OBLIGADO LLEVAR CONTABILIDAD: " . $contabilidad, 0);

        //Datos Adquiriente
        $pdf->SetXY(11, 108);
        $pdf->Cell(120, 8, utf8_decode("Razón Social / Nombres y Apellidos: " . $document->infoNotaCredito->razonSocialComprador), 0);
        $pdf->SetXY(132, 108);
        $pdf->Cell(67, 8, "R.U.C. / C.I.: " . $document->infoNotaCredito->identificacionComprador, 0);
        $pdf->SetXY(11, 116);
        $pdf->Cell(120, 8, utf8_decode("Fecha Emisión: " . $document->infoNotaCredito->fechaEmision), 0);
        $pdf->SetXY(132, 116);
        $pdf->Cell(67, 8, utf8_decode("Guía Remisión: " . $document->infoNotaCredito->guiaRemision), 0);

        //Datos Adquiriente
        $pdf->SetXY(11, 120);
        $pdf->Cell(120, 18, utf8_decode("Doc. Modif" . $document->infoNotaCredito->numDocModificado), 0);
        $pdf->SetXY(132, 120);
        $pdf->Cell(67, 18, "Nro Documento" . 'FACTURA', 0);
        $pdf->SetXY(11, 128);
        $pdf->Cell(120, 18, utf8_decode("Fecha Emision " . $document->infoNotaCredito->fechaEmisionDocSustento), 0);
        $pdf->SetXY(132, 128);
        $pdf->Cell(67, 18, utf8_decode("Motivo" . $document->infoNotaCredito->motivo), 0);


        $ejeX = 80;
        //detalle de la notacredito

        $ejeX = $ejeX + 55;
        $pdf->SetXY(10, $ejeX + 10);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->MultiCell(30, 5, "Codigo", 1, "C", true);
        $pdf->SetXY(40, $ejeX + 10);
        $pdf->MultiCell(95, 5, "Descripcion", 1, "C", true);
        $pdf->SetXY(135, $ejeX + 10);
        $pdf->MultiCell(15, 5, "Cantidad", 1, "C", true);
        $pdf->SetXY(150, $ejeX + 10);
        $pdf->MultiCell(15, 5, "Precio", 1, "C", true);
        $pdf->SetXY(165, $ejeX + 10);
        $pdf->MultiCell(15, 5, "% Desc", 1, "C", true);
        $pdf->SetXY(180, $ejeX + 10);
        $pdf->MultiCell(15, 5, "Total", 1, "C", true);

        $ejeX = $ejeX + 15;
        $pdf->SetXY(10, $ejeX);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $xx = 10;
        $y = $ejeX;

        $x1 = 40;
        $y1 = $ejeX;
        $n = 0;
        $anchocelda = 30;
        $altocelda = 0;
        $anchocelda2 = 15;
        $altocelda2 = 0;
        $bool_page = false;
        $count = 0;
        foreach ($document->detalles->detalle as $a => $b) {
            $pila = array();
            array_push($pila, strlen($b->codigoPrincipal), strlen($b->codigoAuxiliar), strlen($b->descripcion));
            $max = max($pila);
            for ($i = 0; $i < count($pila); $i++) {
                if ($pila[$i] == $max)
                    $posicionmax = $i;
            }

            $pdf->SetXY($xx, $y);
            $pdf->SetFont('Arial', 'B', 7);

            $pdf->MultiCell(30, 5, $b->codigoInterno, 'T', 'C', true);
            $xx = $xx + 30;
            $pdf->SetXY($xx, $y);
            /*$pdf->MultiCell(15, 5, $b->codigoAuxiliar, 'TL', "C");
            $xx = $xx + 15;*/
            $pdf->SetXY($xx, $y);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->MultiCell(95, 5, $b->descripcion, 'T', "C");
            $xx = $xx + 95;
            $pdf->SetXY($xx, $y);
            $pdf->SetFont('Arial', 'B', 7);
            if (strlen($b->descripcion) <= 68 ||  strlen($b->codigoPrincipal) <= 16 ) {
                $pdf->MultiCell(15, 5, $b->cantidad, 'T', "C");
            }else if(strlen($b->descripcion) > 68 && strlen($b->descripcion) < 132  || strlen($b->codigoPrincipal) >= 16 && strlen($b->codigoPrincipal) <= 30 ){
                $pdf->MultiCell(15, 10, $b->cantidad, 'T', "C");
            }else {
                $pdf->MultiCell(15, 20, $b->cantidad, 'T', "C");
            }
            $xx = $xx + 15;
            $pdf->SetXY($xx, $y);

            if (strlen($b->descripcion) <= 68 ||  strlen($b->codigoPrincipal) <= 16 ) {
                $pdf->MultiCell(15, 5, number_format(floatval($b->precioUnitario), 2), 'T', "C");
            }else if(strlen($b->descripcion) > 68 && strlen($b->descripcion) < 132  || strlen($b->codigoPrincipal) >= 16 && strlen($b->codigoPrincipal) <= 30 ){
                $pdf->MultiCell(15, 10, number_format(floatval($b->precioUnitario), 2), 'T', "C");
            }else{
                $pdf->MultiCell(15, 20, number_format(floatval($b->precioUnitario), 2), 'T', "C");
            }
            
            $xx = $xx + 15;
            $pdf->SetXY($xx, $y);
            
            if (strlen($b->descripcion) <= 68 ||  strlen($b->codigoPrincipal) <= 16 ) {
                $pdf->MultiCell(15, 5, number_format(floatval($b->descuento), 2), 'T', "C");
            }else if(strlen($b->descripcion) > 68 && strlen($b->descripcion) < 132  || strlen($b->codigoPrincipal) >= 16 && strlen($b->codigoPrincipal) <= 30 ){
                $pdf->MultiCell(15, 10, number_format(floatval($b->descuento), 2), 'T', "C");
            }else{
                $pdf->MultiCell(15, 20, number_format(floatval($b->descuento), 2), 'T', "C");
            }
            $xx = $xx + 15;
            $pdf->SetXY($xx, $y);
            

            
            if (strlen($b->descripcion) <= 68 ||  strlen($b->codigoPrincipal) <= 16 ) {
                $pdf->MultiCell(15, 5, number_format(floatval($b->precioTotalSinImpuesto), 2), 'T', "C");
            }else if(strlen($b->descripcion) > 68 && strlen($b->descripcion) < 132  || strlen($b->codigoPrincipal) >= 16 && strlen($b->codigoPrincipal) <= 30 ){
                $pdf->MultiCell(15, 10, number_format(floatval($b->precioTotalSinImpuesto), 2), 'T', "C");
            }else{
                $pdf->MultiCell(15, 20, number_format(floatval($b->precioTotalSinImpuesto), 2), 'T', "C");
            }
            
            $xx = 10;

            if ($posicionmax = 2 && strlen($b->descripcion) < 23) {
                //$altocelda = 15;
                $y = $y + 5;
            } else if (strlen($b->descripcion) > 68 && strlen($b->descripcion) <= 132 && $posicionmax = 2 ) {
                $y = $y + 10;
            } else if (strlen($b->descripcion) > 131 && $posicionmax = 2 ){
                //var_dump(strlen($b->descripcion),$posicionmax);die;
                $y = $y + 15;
            }else {
                //var_dump(strlen($b->descripcion),$posicionmax);die;
                $y = $y + 5;
            }

            if ($y >= 263) {

                $pdf->AddPage();
                $xx = 10;
                $y = 10;
                $yy = 10;
                
                $bool_page = true;
                
            }
            $count ++;
        }

        if ($y >= 263 or $count >=15) {
            $pdf->AddPage();
            $ejeX = 0;

        } else {
            if($bool_page == true){
                $ejeX = $xx + 10;
                $pdf->Line(10, $y-5, 195, $y-5);
            }else{
                if($count <= 4){
                    $ejeX = $ejeX -5;
                }else{
                    if($max > 68){
                        $ejeX = $ejeX + 50;    
                    }else{
                        $ejeX = $ejeX + 25;
                    }
                    
                }
                
                $pdf->Line(10, $y, 195, $y);
            }
            

        }
        
        $pdf->SetXY(10, $ejeX + 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $iva = 0;
        $ice = 0;
        $IRBPNR = 0;
        $subtotal12 = 0;
        $subtotal0 = 0;
        $subtotal_no_impuesto = 0;
        $subtotal_no_iva = 0;

        
        foreach ($document->infoNotaCredito->totalConImpuestos->totalImpuesto as $a => $b) {
            if ($b->codigo == 2) {

                if ($b->codigoPorcentaje == 0) {
                    $subtotal0 = number_format(floatval($b->baseImponible), 2);
                }
                if ($b->codigoPorcentaje == 2) {
                    $subtotal12 = number_format(floatval($b->baseImponible), 2);
                    //$iva = $b->valor;
                }
                if ($b->codigoPorcentaje == 6) {
                    $subtotal_no_impuesto = number_format(floatval($b->baseImponible), 2);
                }
                if ($b->codigoPorcentaje == 7) {
                    $subtotal_no_iva = number_format(floatval($b->baseImponible), 2);
                }
            }
            if ($b->codigo == 3) {
                $ice = number_format(floatval($b->valor), 2);
            }
            if ($b->codigo == 5) {
                $IRBPNR = number_format(floatval($b->valor), 2);
            }
        }
        if($count >= 13){
            $ejeX = $ejeX + 5;
        }
        else if($count <= 4){
            $ejeX = $ejeX + 20;
        }else{
            $ejeX = $ejeX + 25;
        }

        $pdf->SetXY(170, $ejeX + 5);//170
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$subtotal12,2),1,0,'C');//30
		$pdf->SetXY(130, $ejeX + 5);//130
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"SUBTOTAL 15%",1,0,'C');

        $pdf->SetXY(170, $ejeX + 11);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$subtotal0,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 11);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"SUBTOTAL 0%",1,0,'C');

        $pdf->SetXY(170, $ejeX + 17);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$subtotal_no_impuesto,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 17);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"SUBTOTAL  No sujeto IVA",1,0,'C');

        $pdf->SetXY(170, $ejeX + 23);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$subtotal_no_iva,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 23);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"SUBTOTAL Exento de IVA",1,0,'C');

        $pdf->SetXY(170, $ejeX + 29);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$document->infoNotaCredito->totalSinImpuestos,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 29);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"SubTotal sin Impuestos",1,0,'C');

        $pdf->SetXY(170, $ejeX + 35);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$iva,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 35);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"IVA 12%",1,0,'C');

        $pdf->SetXY(170, $ejeX + 41);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$ice,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 41);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"ICE",1,0,'C');

        $pdf->SetXY(170, $ejeX + 47);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$IRBPNR,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 47);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"IRBPNR",1, 0,'C');

        $pdf->SetXY(170, $ejeX + 53);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$document->infoNotaCredito->valorModificacion,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 53);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"VALOR TOTAL",1,0,'C');

        
        $infoAdicional = "";
        $correo = "";
        foreach ($document->infoAdicional->campoAdicional as $a) {
            foreach ($a->attributes() as $b) {
                if ($b == 'Email' || $b == 'email' || $b == '=correo' || $b == 'Correo') {
                    $correo = $a;
                    $infoAdicional .= $b . ': ' . $a . "\n";
                } else {
                    $infoAdicional .= $b . ': ' . $a . "\n";
                }
            }
        }

        //Información Adicional
		$pdf->SetXY(10, $ejeX + 5);
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(80,8,utf8_decode("Información Adicional"),1,0,'C');

        $pdf->SetXY(10, $ejeX + 13);
		$pdf->SetFont('Arial', '', 7);
		$pdf->MultiCell(80, 4, "" . $infoAdicional . "", 1);

        //$email = new sendEmail();
        
        //$pdf->Output('comprobantes/' . $claveAcceso . '.pdf', 'F');
        $pdf->Output('comprobantes/NC_' . $claveAcceso . '.pdf', 'F');
        //$email->enviarCorreo('Nota Credito', $document->infoNotaCredito->razonSocialComprador, $claveAcceso, $correo);
    }

    public function generarCodigoBarras($claveAcceso) {
        $colorFront = new BCGColor(0, 0, 0);
        $colorBack = new BCGColor(255, 255, 255);

        $code = new BCGcode128();
        $code->setScale(4);
        $code->setThickness(30);
        $code->setForegroundColor($colorFront);
        $code->setBackgroundColor($colorBack);
        $code->parse($claveAcceso);

        $drawing = new BCGDrawing('uploads/codigo.png', $colorBack);
        $drawing->setBarcode($code);

        $drawing->draw();
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
        $this->redim('uploads/codigo.png', 'uploads/codigo_mod.png', 1000, 200);
    }

    public function redim($ruta1, $ruta2, $ancho, $alto) {
        # se obtene la dimension y tipo de imagen 
        $datos = getimagesize($ruta1);

        $ancho_orig = $datos[0]; # Anchura de la imagen original 
        $alto_orig = $datos[1];    # Altura de la imagen original 
        $tipo = $datos[2];

        if ($tipo == 1) { # GIF 
            if (function_exists("imagecreatefromgif"))
                $img = imagecreatefromgif($ruta1);
            else
                return false;
        }
        else if ($tipo == 2) { # JPG 
            if (function_exists("imagecreatefromjpeg"))
                $img = imagecreatefromjpeg($ruta1);
            else
                return false;
        }
        else if ($tipo == 3) { # PNG 
            if (function_exists("imagecreatefrompng"))
                $img = imagecreatefrompng($ruta1);
            else
                return false;
        }

        # Se calculan las nuevas dimensiones de la imagen 
        if ($ancho_orig > $alto_orig) {
            $ancho_dest = $ancho;
            $alto_dest = ($ancho_dest / $ancho_orig) * $alto_orig;
        } else {
            $alto_dest = $alto;
            $ancho_dest = ($alto_dest / $alto_orig) * $ancho_orig;
        }

        // imagecreatetruecolor, solo estan en G.D. 2.0.1 con PHP 4.0.6+ 
        $img2 = @imagecreatetruecolor($ancho_dest, $alto_dest) or $img2 = imagecreate($ancho_dest, $alto_dest);

        // Redimensionar 
        // imagecopyresampled, solo estan en G.D. 2.0.1 con PHP 4.0.6+ 
        @imagecopyresampled($img2, $img, 0, 0, 0, 0, $ancho_dest, $alto_dest, $ancho_orig, $alto_orig) or imagecopyresized($img2, $img, 0, 0, 0, 0, $ancho_dest, $alto_dest, $ancho_orig, $alto_orig);

        // Crear fichero nuevo, seg�n extensi�n. 
        if ($tipo == 1) // GIF 
            if (function_exists("imagegif"))
                imagegif($img2, $ruta2);
            else
                return false;

        if ($tipo == 2) // JPG 
            if (function_exists("imagejpeg"))
                imagejpeg($img2, $ruta2);
            else
                return false;

        if ($tipo == 3)  // PNG 
            if (function_exists("imagepng"))
                imagepng($img2, $ruta2);
            else
                return false;

        return true;
    }

    public function liquidacionPDF($document, $claveAcceso)
    {
        
        $pdf = new PDF_Code();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 8);
        //Caja Emisor
        $pdf->RoundedRect(10, 50, 85, 52, 3, 'D');
        //Caja Documento
        $pdf->RoundedRect(100, 17, 100, 85, 3, 'D');
        //Caja Adquiriente
        $pdf->SetXY(10, 107);
        $pdf->Cell(190, 18, "", 1);
        $pdf->SetXY(15, 15);
        //$pdf->image('http://localhost:8080/Facturacion/sistema/img/Logo.jpg', null, null, 70, 25);//ubicacion de la img,null,null,ancho,alto
        //$pdf->image('img/Logo.jpg' , null,null, 70, 25);//ubicacion de la img,null,null,ancho,alto

        $file='assets/images/Logo.jpg';
		$exists = is_file($file);
        $pdf->image('uploads/logo.jpg', null, null, 80, 30);

        if ($document->infoLiquidacionCompra->obligadoContabilidad == 'SI') {
            $contabilidad = "SI";
        } else {
            $contabilidad = "NO";
        }

        //Datos Documento
        $pdf->SetXY(103, 18);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(97, 8, "R.U.C.: " . $document->infoTributaria->ruc, 0);
        $pdf->SetXY(103, 24);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(50, 8, utf8_decode("LIQUIDACIÓN DE COMPRA DE BIENES"), 0);
        $pdf->SetXY(103, 29);
        $pdf->Cell(50, 8, utf8_decode("Y PRESTACIÓN DE SERVICIOS"), 0);
        $pdf->SetXY(103, 34);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(97, 8, "No.: " . $document->infoTributaria->estab . "-" . $document->infoTributaria->ptoEmi . "-" . $document->infoTributaria->secuencial, 0);
        $pdf->SetXY(103, 42);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(97, 8, utf8_decode("NÚMERO DE AUTORIZACIÓN"), 0);
        $pdf->SetXY(103, 50);
        $pdf->Cell(97, 8, $claveAcceso, 0);

        if ($document->infoTributaria->ambiente == 2) {
            $ambiente = 'PRODUCCION';
        } else {
            $ambiente = 'PRUEBAS';
        }

        $pdf->SetXY(103, 58);
        $pdf->Cell(97, 8, utf8_decode("AMBIENTE: " . $ambiente), 0);

        if ($document->infoTributaria->tipoEmision == 1) {
            $emision = 'NORMAL';
        } else {
            $emision = 'NORMAL';
        }

        $pdf->SetXY(103, 66);
        $pdf->Cell(97, 8, utf8_decode("EMISIÓN: " . $emision), 0);
        $pdf->SetXY(103, 74);
        $pdf->Cell(97, 8, "CLAVE DE ACCESO:", 0);
        $pdf->SetXY(103, 82);
        $pdf->Code128(103, 82, $claveAcceso, 94, 12);
        $pdf->SetXY(103, 93);
        $pdf->Cell(97, 8, $claveAcceso, 0, 0, 'C');

        //Datos Emisor
        $pdf->SetXY(13, 55);
        $pdf->Cell(82, 8, $document->infoTributaria->razonSocial, 0);
        //$pdf->Cell(82,8,$document->infoTributaria->nombreComercial,0);

        $pdf->SetXY(13, 63);
       // $document->infoTributaria->dirMatriz = 'Quevedo Norte - Av 7 de Octubre Palmeiras y Decima Primera -Local 406 Frente a Servientrega';
        if (strlen($document->infoTributaria->dirMatriz) <= 53) {
            $pdf->MultiCell(100, 10, 'Matriz: ' . substr($document->infoTributaria->dirMatriz, 0, 53), 0);
        } else {
            $pdf->MultiCell(100, 10, 'Matriz: ' . substr($document->infoTributaria->dirMatriz, 0, 50), 0);
            $pdf->SetXY(13, 66);
            $pdf->MultiCell(100, 10, substr($document->infoTributaria->dirMatriz, 50, 200), 0);
        }

        $pdf->SetXY(13, 71);
        if ($document->infoLiquidacionCompra->dirEstablecimiento != '') {
            if (strlen($document->infoTributaria->dirMatriz) <= 53) {
                $pdf->MultiCell(100, 10, 'Sucursal: ' . substr($document->infoTributaria->dirMatriz, 0, 53), 0);
            } else {
                $pdf->MultiCell(100, 10, 'Sucursal: ' . substr($document->infoTributaria->dirMatriz, 0, 50), 0);
                $pdf->SetXY(13, 75);
                $pdf->MultiCell(100, 10, substr($document->infoTributaria->dirMatriz, 50, 200), 0);
            }

        } else {

            if (strlen($document->infoLiquidacionCompra->dirEstablecimiento) <= 53) {
                $pdf->MultiCell(100, 10, 'Sucursal: ' . substr($document->infoLiquidacionCompra->dirEstablecimiento, 0, 53), 0);
            } else {
                $pdf->MultiCell(100, 10, 'Sucursal: ' . substr($document->infoLiquidacionCompra->dirEstablecimiento, 0, 50), 0);
                $pdf->SetXY(13, 75);
                $pdf->MultiCell(100, 10, substr($document->infoLiquidacionCompra->dirEstablecimiento, 50, 200), 0);
            }

        }

        $pdf->SetXY(13, 79);
        $pdf->Cell(82, 8, "Contribuyente Especial Nro: -- ", 0);
        $pdf->SetXY(13, 87);
        $pdf->Cell(82, 8, "OBLIGADO LLEVAR CONTABILIDAD: " . $contabilidad, 0);

        //Datos Adquiriente
        $pdf->SetXY(11, 108);
        $pdf->Cell(120, 8, utf8_decode("Razón Social / Nombres y Apellidos: " . $document->infoLiquidacionCompra->razonSocialProveedor), 0);//razonSocialProveedor y/o razonSocialComprador
        $pdf->SetXY(132, 108);
        $pdf->Cell(67, 8, "R.U.C. / C.I.: " . $document->infoLiquidacionCompra->identificacionProveedor, 0);//identificacionComprador y/o identificacionProveedor
        $pdf->SetXY(11, 116);
        $pdf->Cell(120, 8, utf8_decode("Fecha Emisión: " . $document->infoLiquidacionCompra->fechaEmision), 0);
        //$pdf->SetXY(132, 116);
        //$pdf->Cell(67, 8, utf8_decode("Guía Remisión: " . $document->infoLiquidacionCompra->guiaRemision), 0);

        
        $ejeX = 80;
        //detalle de la factura

        $ejeX = $ejeX + 40;
        $pdf->SetXY(10, $ejeX + 10);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->MultiCell(30, 5, "Codigo", 1, "C", true);
        $pdf->SetXY(40, $ejeX + 10);
        $pdf->MultiCell(95, 5, "Descripcion", 1, "C", true);
        $pdf->SetXY(135, $ejeX + 10);
        $pdf->MultiCell(15, 5, "Cantidad", 1, "C", true);
        $pdf->SetXY(150, $ejeX + 10);
        $pdf->MultiCell(15, 5, "Precio", 1, "C", true);
        $pdf->SetXY(165, $ejeX + 10);
        $pdf->MultiCell(15, 5, "% Desc", 1, "C", true);
        $pdf->SetXY(180, $ejeX + 10);
        $pdf->MultiCell(15, 5, "Total", 1, "C", true);

        $ejeX = $ejeX + 15;
        $pdf->SetXY(10, $ejeX);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $xx = 10;
        $y = $ejeX;

        $x1 = 40;
        $y1 = $ejeX;
        $n = 0;
        $anchocelda = 30;
        $altocelda = 0;
        $anchocelda2 = 15;
        $altocelda2 = 0;
        $bool_page = false;
        $count = 0;
        foreach ($document->detalles->detalle as $a => $b) {
            $pila = array();
            array_push($pila, strlen($b->codigoPrincipal), strlen($b->codigoAuxiliar), strlen($b->descripcion));
            $max = max($pila);
            for ($i = 0; $i < count($pila); $i++) {
                if ($pila[$i] == $max)
                    $posicionmax = $i;
            }
            

            //var_dump(strlen('DIMM MEMORIA RAM HIKVISION HEKSEMI P/ESCRITORIO DDR4 8GB 2666MGZ RGB'));
            //var_dump($pila);die;
            $pdf->SetXY($xx, $y);
            $pdf->SetFont('Arial', 'B', 7);
            
            $pdf->MultiCell(30, 5, $b->codigoPrincipal, 'T', 'C', true);
            $xx = $xx + 30;
            $pdf->SetXY($xx, $y);
            /*$pdf->MultiCell(15, 5, $b->codigoAuxiliar, 'TL', "C");
            $xx = $xx + 15;*/
            $pdf->SetXY($xx, $y);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->MultiCell(95, 5, $b->descripcion, 'T', "C");
            $xx = $xx + 95;
            $pdf->SetXY($xx, $y);
            $pdf->SetFont('Arial', 'B', 7);
            if (strlen($b->descripcion) <= 68 ||  strlen($b->codigoPrincipal) <= 16 ) {
                $pdf->MultiCell(15, 5, $b->cantidad, 'T', "C");
            }else if(strlen($b->descripcion) > 68 && strlen($b->descripcion) < 132  || strlen($b->codigoPrincipal) >= 16 && strlen($b->codigoPrincipal) <= 30 ){
                $pdf->MultiCell(15, 10, $b->cantidad, 'T', "C");
            }else {
                $pdf->MultiCell(15, 20, $b->cantidad, 'T', "C");
            }
            $xx = $xx + 15;
            $pdf->SetXY($xx, $y);


            if (strlen($b->descripcion) <= 68 ||  strlen($b->codigoPrincipal) <= 16 ) {
                $pdf->MultiCell(15, 5, number_format(floatval($b->precioUnitario), 2), 'T', "C");
            }else if(strlen($b->descripcion) > 68 && strlen($b->descripcion) < 132  || strlen($b->codigoPrincipal) >= 16 && strlen($b->codigoPrincipal) <= 30 ){
                $pdf->MultiCell(15, 10, number_format(floatval($b->precioUnitario), 2), 'T', "C");
            }else{
                $pdf->MultiCell(15, 20, number_format(floatval($b->precioUnitario), 2), 'T', "C");
            }


            $xx = $xx + 15;
            $pdf->SetXY($xx, $y);

            
            if (strlen($b->descripcion) <= 68 ||  strlen($b->codigoPrincipal) <= 16 ) {
                $pdf->MultiCell(15, 5, number_format(floatval($b->descuento), 2), 'T', "C");
            }else if(strlen($b->descripcion) > 68 && strlen($b->descripcion) < 132  || strlen($b->codigoPrincipal) >= 16 && strlen($b->codigoPrincipal) <= 30 ){
                $pdf->MultiCell(15, 10, number_format(floatval($b->descuento), 2), 'T', "C");
            }else{
                $pdf->MultiCell(15, 20, number_format(floatval($b->descuento), 2), 'T', "C");
            }
                               
            
            $xx = $xx + 15;
            $pdf->SetXY($xx, $y);
            

            
            if (strlen($b->descripcion) <= 68 ||  strlen($b->codigoPrincipal) <= 16 ) {
                $pdf->MultiCell(15, 5, number_format(floatval($b->precioTotalSinImpuesto), 2), 'T', "C");
            }else if(strlen($b->descripcion) > 68 && strlen($b->descripcion) < 132  || strlen($b->codigoPrincipal) >= 16 && strlen($b->codigoPrincipal) <= 30 ){
                $pdf->MultiCell(15, 10, number_format(floatval($b->precioTotalSinImpuesto), 2), 'T', "C");
            }else{
                $pdf->MultiCell(15, 20, number_format(floatval($b->precioTotalSinImpuesto), 2), 'T', "C");
            }
            //var_dump($b->codigoPrincipal);die;
            /*$pdf->MultiCell(30, 10, $b->codigoPrincipal, 1, 0, "C", true);
            $pdf->MultiCell(30, 15, $b->codigoAuxiliar, 1, 0, "C", true);
            $pdf->MultiCell(55, 10, $b->descripcion, 1, 0, "C", true);
            $pdf->MultiCell(25, 10, $b->cantidad, 1, 0, "C", true);
            $pdf->MultiCell(25, 10, number_format(floatval($b->precioUnitario), 2), 1, 0, "C", true);
            $pdf->MultiCell(25, 10, $b->descuento, 1, 0, "C", true);
            $pdf->MultiCell(25, 10, $b->precioTotalSinImpuesto, 1, 0, "C", true);*/
            $xx = 10;
            //var_dump(strlen($b->descripcion),$posicionmax);die;
            if ($posicionmax = 2 && strlen($b->descripcion) < 23) {
                //$altocelda = 15;
                $y = $y + 5;
            } else if (strlen($b->descripcion) > 68 && strlen($b->descripcion) <= 132 && $posicionmax = 2 ) {
                $y = $y + 10;
            } else if (strlen($b->descripcion) > 131 && $posicionmax = 2 ){
                //var_dump(strlen($b->descripcion),$posicionmax);die;
                $y = $y + 15;
            }else {
                //var_dump(strlen($b->descripcion),$posicionmax);die;
                $y = $y + 5;
            }

            //$pdf->SetXY($x, $y);
            //$ejeX = $ejeX + 10;
            //$pdf->SetXY(10, $ejeX);
            if ($y >= 263) {

                $pdf->AddPage();
                $xx = 10;
                $y = 10;
                $yy = 10;
                
                $bool_page = true;
                
            }
            $count ++;
        }
        
        /*foreach ($document->detalles->detalle as $a => $b) {
        
        if(strlen($b->codigoPrincipal) > 16){
        $altocelda = $altocelda + 5;
        $pdf->MultiCell($anchocelda,$altocelda,$b->codigoPrincipal, 1,'C',true);
        $y = $y + 10;
        }else{
        $altocelda = 5;
        $pdf->MultiCell($anchocelda,$altocelda,$b->codigoPrincipal, 1,'C',true);
        $y = $y + 5;
        }
        if(strlen($b->codigoAuxiliar) > 7){
        $altocelda2 = $altocelda2 + 5;
        $pdf->MultiCell($anchocelda2,$altocelda2,$b->codigoAuxiliar, 1,'C',true);
        $y1 = $y1 + 10;
        }else{
        $altocelda2 = 5;
        $pdf->MultiCell($anchocelda2,$altocelda2,$b->codigoAuxiliar, 1,'C',true);
        $y1 = $y1 + 5;
        }
        $x = $x + 30;
        if(strlen($b->codigoAuxiliar) > 8){
        $altocelda2 = $altocelda2 + 5;
        $pdf->MultiCell($anchocelda2,$altocelda2,$b->codigoAuxiliar, 1,'C',true);
        $y = $y + 10;
        }else{
        $altocelda2 = 5;
        $pdf->MultiCell($anchocelda2,$altocelda2,$b->codigoAuxiliar, 1,'C',true);
        $y = $y + 5;
        }
        //var_dump(strlen($b->codigoPrincipal));die;
        //$pdf->MultiCell($anchocelda,$altocelda,$b->codigoPrincipal, 1,'C',true);
        
        $pdf->SetXY($x, $y);
        //$pdf->SetXY($x1, $y1);
        //$n = $n + 1;
        }*/
        //var_dump($n);die;
        /*foreach ($document->detalles->detalle as $a => $b) {
        $pdf->SetXY($x, $y);
        $pdf->MultiCell(30, 10, $b->codigoPrincipal, 1,'C',false);
        $x = $x + 30;
        $pdf->SetXY($x, $y);
        $pdf->MultiCell(15, 10, $b->codigoAuxiliar, 1,"C");
        $x = $x + 15;
        $pdf->SetXY($x, $y);
        $pdf->MultiCell(55, 10, $b->descripcion, 1, "C");
        $x = $x + 55;
        $pdf->SetXY($x, $y);
        $pdf->MultiCell(25, 10, $b->cantidad, 1, "C");
        $x = $x + 25;
        $pdf->SetXY($x, $y);
        $pdf->MultiCell(25, 10, number_format(floatval($b->precioUnitario), 2), 1,"C");
        $x = $x + 25;
        $pdf->SetXY($x, $y);
        $pdf->MultiCell(25, 10, $b->cantidad, 1, "C");
        $x = $x + 25;
        $pdf->SetXY($x, $y);
        $pdf->MultiCell(25, 10, $b->precioTotalSinImpuesto, 1,"C");
        //var_dump($b->codigoPrincipal);die;
        /*$pdf->MultiCell(30, 10, $b->codigoPrincipal, 1, 0, "C", true);
        $pdf->MultiCell(30, 15, $b->codigoAuxiliar, 1, 0, "C", true);
        $pdf->MultiCell(55, 10, $b->descripcion, 1, 0, "C", true);
        $pdf->MultiCell(25, 10, $b->cantidad, 1, 0, "C", true);
        $pdf->MultiCell(25, 10, number_format(floatval($b->precioUnitario), 2), 1, 0, "C", true);
        $pdf->MultiCell(25, 10, $b->descuento, 1, 0, "C", true);
        $pdf->MultiCell(25, 10, $b->precioTotalSinImpuesto, 1, 0, "C", true);
        $x = 10;
        $y = $y + 30;
        $pdf->SetXY($x, $y);
        //$ejeX = $ejeX + 10;
        //$pdf->SetXY(10, $ejeX);
        if($y >= 263){
        $pdf->AddPage();
        $x =  10;
        }
        //}*/

        //Total de la factura

        //$ejeX = $y + 50;
        //$x = $x + 10;

        //var_dump($y);die;
        
        
        if ($y >= 263 or $count >=15) {
            $pdf->AddPage();
            $ejeX = 0;

        } else {
            if($bool_page == true){
                $ejeX = $xx + 10;
                $pdf->Line(10, $y-5, 195, $y-5);
            }else{
                if($count <= 4){
                    $ejeX = $ejeX -5;
                }else{
                    if($max > 68){
                        $ejeX = $ejeX + 50;    
                    }else{
                        $ejeX = $ejeX + 25;
                    }
                    
                }
                
                $pdf->Line(10, $y, 195, $y);
            }
            

        }


        $pdf->SetXY(10, $ejeX + 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $iva = 0;
        $ice = 0;
        $IRBPNR = 0;
        $subtotal12 = 0;
        $subtotal0 = 0;
        $subtotal_no_impuesto = 0;
        $subtotal_no_iva = 0;
        foreach ($document->infoLiquidacionCompra->totalConImpuestos->totalImpuesto as $a => $b) {
            if ($b->codigo == 2) {
                $iva = $b->valor;
                if ($b->codigoPorcentaje == 0) {
                    $subtotal0 = $b->baseImponible;
                }
                if ($b->codigoPorcentaje == 2) {
                    $subtotal12 = $b->baseImponible;
                    //    $iva = $b->valor;
                }
                if ($b->codigoPorcentaje == 6) {
                    $subtotal_no_impuesto = $b->baseImponible;
                }
                if ($b->codigoPorcentaje == 7) {
                    $subtotal_no_iva = $b->baseImponible;
                }
            }
            if ($b->codigo == 3) {
                $ice = $b->valor;
            }
            if ($b->codigo == 5) {
                $IRBPNR = $b->valor;
            }
        }
        if($count >= 13){
            $ejeX = $ejeX + 5;
        }
        else if($count <= 4){
            $ejeX = $ejeX + 20;
        }else{
            $ejeX = $ejeX + 25;
        }
        
		$pdf->SetXY(170, $ejeX + 5);//170
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$subtotal12,2),1,0,'C');//30
		$pdf->SetXY(130, $ejeX + 5);//130
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"SUBTOTAL 15%",1,0,'C');

		$pdf->SetXY(170, $ejeX + 11);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$subtotal0,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 11);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"SUBTOTAL 0%",1,0,'C');

		$pdf->SetXY(170, $ejeX + 17);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$subtotal_no_impuesto,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 17);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"SUBTOTAL  No sujeto IVA",1,0,'C');

		$pdf->SetXY(170, $ejeX + 23);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$subtotal_no_iva,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 23);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"SUBTOTAL Exento de IVA",1,0,'C');

		$pdf->SetXY(170, $ejeX + 29);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$document->infoLiquidacionCompra->totalDescuento,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 29);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"DESCUENTO",1,0,'C');

		$pdf->SetXY(170, $ejeX + 35);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$iva,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 35);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"IVA 12%",1,0,'C');

		$pdf->SetXY(170, $ejeX + 41);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$ice,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 41);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"ICE",1,0,'C');

		$pdf->SetXY(170, $ejeX + 47);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$IRBPNR,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 47);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"IRBPNR",1, 0,'C');
 
		$pdf->SetXY(170, $ejeX + 53);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(25,6,number_format((float)$document->infoLiquidacionCompra->importeTotal,2),1,0,'C');
		$pdf->SetXY(130, $ejeX + 53);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(40,6,"VALOR TOTAL",1,0,'C');
		
		//Forma de Pago
		$pdf->SetXY(10, $ejeX + 5);
		$pdf->Cell(30,6,"Forma de Pago",1,0,'C');
		$pdf->SetXY(40, $ejeX+5);
		$pdf->Cell(25,6,"Total",1,0,'C');
		$pdf->SetXY(65, $ejeX+5);
		$pdf->Cell(25,6,"Plazo",1,0,'C');
		$pdf->SetXY(90, $ejeX+5);
		$pdf->Cell(25,6,"Unidad de Tiempo",1,0,'C');
		
		foreach ($document->infoLiquidacionCompra->pagos->pago as $e => $f) {
            if ($f->formaPago == '01') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 11);
				$pdf->MultiCell(30,6,utf8_decode("Sin utilizacion del sistema financiero"),1,'C');
				$pdf->SetXY(40, $ejeX + 11);
				$pdf->Cell(25,12,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +11);
				$pdf->Cell(25,12,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 11);
				$pdf->Cell(25,12,utf8_decode($f->unidadTiempo),1,0,'C');
            }
			if ($f->formaPago == '15') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 16);
				$pdf->MultiCell(30,6,utf8_decode("Compensacion de deudas"),1,'C');
				$pdf->SetXY(40, $ejeX + 16);
				$pdf->Cell(25,6,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +16);
				$pdf->Cell(25,6,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 16);
				$pdf->Cell(25,6,utf8_decode($f->unidadTiempo),1,0,'C');
            }
			if ($f->formaPago == '16') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 16);
				$pdf->Cell(30,6,utf8_decode("Tarjeta debito"),1,0,'C');
				$pdf->SetXY(40, $ejeX + 16);
				$pdf->Cell(25,6,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +16);
				$pdf->Cell(25,6,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 16);
				$pdf->Cell(25,6,utf8_decode($f->unidadTiempo),1,0,'C');
            }
			if ($f->formaPago == '17') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 16);
				$pdf->Cell(30,6,utf8_decode("Dinero Electronico"),1,0,'C');
				$pdf->SetXY(40, $ejeX + 16);
				$pdf->Cell(25,6,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +16);
				$pdf->Cell(25,6,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 16);
				$pdf->Cell(25,6,utf8_decode($f->unidadTiempo),1,0,'C');
            }
			if ($f->formaPago == '18') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 16);
				$pdf->Cell(30,6,utf8_decode("Tarjeta Prepago"),1,0,'C');
				$pdf->SetXY(40, $ejeX + 16);
				$pdf->Cell(25,6,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +16);
				$pdf->Cell(25,6,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 16);
				$pdf->Cell(25,6,utf8_decode($f->unidadTiempo),1,0,'C');
            }
			if ($f->formaPago == '198') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 16);
				$pdf->Cell(30,6,utf8_decode("Tarjeta de credito"),1,0,'C');
				$pdf->SetXY(40, $ejeX + 16);
				$pdf->Cell(25,6,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +16);
				$pdf->Cell(25,6,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 16);
				$pdf->Cell(25,6,utf8_decode($f->unidadTiempo),1,0,'C');
            }
			 if ($f->formaPago == '20') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX+11);
				$pdf->MultiCell(30,6,utf8_decode("Otros con utilizacion del sistema financiero"),1,'C');
				$pdf->SetXY(40, $ejeX + 11);
				$pdf->Cell(25,6,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX + 11);
				$pdf->Cell(15,6,$f->plazo,1,0,'C');
				$pdf->SetXY(80, $ejeX + 11);
				$pdf->Cell(25,6,utf8_decode($f->unidadTiempo),1,0,'C');
            }
			if ($f->formaPago == '21') {
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY(10, $ejeX + 16);
				$pdf->Cell(30,6,utf8_decode("Endoso de titulos"),1,0,'C');
				$pdf->SetXY(40, $ejeX + 16);
				$pdf->Cell(25,6,$f->total,1,0,'C');
				$pdf->SetXY(65, $ejeX +16);
				$pdf->Cell(25,6,$f->plazo,1,0,'C');
				$pdf->SetXY(90, $ejeX + 16);
				$pdf->Cell(25,6,utf8_decode($f->unidadTiempo),1,0,'C');
            }
        }

		$infoAdicional = "";
        $correo = "";

        foreach ($document->infoAdicional->campoAdicional as $a) {
            foreach ($a->attributes() as $b) {
                if ($b == 'Email' || $b == 'email' || $b == '=correo' || $b == 'Correo') {
                    $correo = $a;
                    $infoAdicional .= $b . ': ' . $a . "\n";
                } else {
                    $infoAdicional .= $b . ': ' . $a . "\n";
                }
            }
        }
		
		//Información Adicional
		$pdf->SetXY(10, $ejeX + 36);
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(80,8,utf8_decode("Información Adicional"),1,0,'C');
		
		$pdf->SetXY(10, $ejeX + 44);
		$pdf->SetFont('Arial', '', 7);
		$pdf->MultiCell(80, 4, "" . $infoAdicional . "", 1);
        // Pie de pagina
        //$pdf->SetXY(110, $ejeX + 80);
        //$pdf->MultiCell(100, 5, "EXIJA AL VENDEDOR EL RECIBO DE PAGO CUANDO ABONE O \nCANCELE UNA FACTURA UNICO DOCUMENTO VALIDO PARA RESPALDAR SU PAGO", 0, 'C');
        
        //$email = new sendEmail();
        $pdf->Output('comprobantes/LC_' . $claveAcceso . '.pdf', 'F');
        //$pdf->Output('../../../../../assets/comprobantes/autorizados/liquidacion' . $claveAcceso . '.pdf', 'F');
      //  $email->enviarCorreo('Nota Debito', $document->infoNotaDebito->razonSocialComprador, $claveAcceso, $correo);
    }

}
