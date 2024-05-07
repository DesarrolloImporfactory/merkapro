<?php
if (isset($conexion)) {
    $sql        = mysqli_query($conexion, "select LAST_INSERT_ID(id_factura) as last from retencion20 order by id_factura desc limit 0,1 ");
    $rw         = mysqli_fetch_array($sql);
    if(isset($rw) == null){
        $id_retencion = 0 + 1;
    }else{
        $id_retencion = $rw['last'] + 1;
    }
    ?>
	<div id="codigo-retencion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-search'></i> Seleccione el codigo </h4>
				</div>
				<div class="modal-body">

					<form class="form-horizontal">
					
					</form>
                    <div class="outer_lib" >
                        <div class="table-responsive">
                            <!--<table class="table table-bordered table-striped table-sm">-->
                            <table class="table table-bordered table-hover table-sm" id="codigo-retencion-table">
							<thead>
								<tr>
									<th style="width: 10%" >Tipo</th>
									<th style="width: 10%" >C&oacute;digo</th>
									<th style="width: 10%" >% Retenci&oacute;n</th>                   
									<th>Descripci&oacute;n</th>
								</tr>
							</thead>
							<tbody>
							<tr>
                                <td>IVA</td>
                                <td class="codigo">9</td>
                                <td class="porcentaje" >10</td>
                                <td>Retención IVA 10%</td>
                            </tr>
                            <tr>
                                <td>IVA</td>
                                <td class="codigo">10</td>
                                <td class="porcentaje" >20</td>
                                <td>Retención IVA 20%</td>
                            </tr>
                            <tr>
                                <td>IVA</td>
                                <td class="codigo">1</td>
                                <td class="porcentaje" >30</td>
                                <td>Retención IVA 30%</td>
                            </tr>
                            <tr>
                                <td>IVA</td>
                                <td class="codigo">11</td>
                                <td class="porcentaje" >50</td>
                                <td>Retención IVA 50%</td>
                            </tr>
                            <tr>
                                <td>IVA</td>
                                <td class="codigo">2</td>
                                <td class="porcentaje" >70</td>
                                <td>Retención IVA 70%</td>
                            </tr>
                            <tr>
                                <td>IVA</td>
                                <td class="codigo">3</td>
                                <td class="porcentaje" >100</td>
                                <td>Retención IVA 100%</td>
                            </tr>
                
<tr><td>Renta</td><td class="codigo">303</td><td class="porcentaje">10</td><td>Honorarios profesionales y demás pagos por servicios relacionados con el título profesional</td></tr>
<tr><td>Renta</td><td class="codigo">304</td><td class="porcentaje">8</td><td>Servicios predomina el intelecto no relacionados con el título profesional</td></tr>
<tr><td>Renta</td><td class="codigo">307</td><td class="porcentaje">2</td><td>Servicios predomina la mano de obra</td></tr>
<tr><td>Renta</td><td class="codigo">308</td><td class="porcentaje">10</td><td>Utilización o aprovechamiento de la imagen o renombre</td></tr>
<tr><td>Renta</td><td class="codigo">309</td><td class="porcentaje">1.75</td><td>Servicios prestados por medios de comunicación y agencias de publicidad</td></tr>
<tr><td>Renta</td><td class="codigo">310</td><td class="porcentaje">1</td><td>Servicio de transporte privado de pasajeros o transporte público o privado de carga</td></tr>
<tr><td>Renta</td><td class="codigo">311</td><td class="porcentaje">2</td><td>Pagos a través de liquidación de compra (nivel cultural o rusticidad)</td></tr>
<tr><td>Renta</td><td class="codigo">312</td><td class="porcentaje">1.75</td><td>Transferencia de bienes muebles de naturaleza corporal</td></tr>
<tr><td>Renta</td><td class="codigo">319</td><td class="porcentaje">1.75</td><td>Cuotas de arrendamiento mercantil (prestado por sociedades), inclusive la de opción de compra</td></tr>
<tr><td>Renta</td><td class="codigo">320</td><td class="porcentaje">8</td><td>Arrendamiento bienes inmuebles</td></tr>
<tr><td>Renta</td><td class="codigo">322</td><td class="porcentaje">1.75</td><td>Seguros y reaseguros (primas y cesiones)</td></tr>
<tr><td>Renta</td><td class="codigo">323</td><td class="porcentaje">2</td><td>Rendimientos financieros pagados a naturales y sociedades  (No a IFIs)</td></tr>
<tr><td>Renta</td><td class="codigo">325</td><td class="porcentaje">0</td><td>Anticipo dividendos</td></tr>
<tr><td>Renta</td><td class="codigo">326</td><td class="porcentaje">0</td><td>Dividendos distribuidos que correspondan al impuesto a la renta único establecido en el art. 27 de la LRTI </td></tr>
<tr><td>Renta</td><td class="codigo">327</td><td class="porcentaje">0</td><td>Dividendos distribuidos a personas naturales residentes</td></tr>
<tr><td>Renta</td><td class="codigo">328</td><td class="porcentaje">0</td><td>Dividendos distribuidos a sociedades residentes</td></tr>
<tr><td>Renta</td><td class="codigo">329</td><td class="porcentaje">0</td><td>Dividendos distribuidos a fideicomisos residentes</td></tr>
<tr><td>Renta</td><td class="codigo">331</td><td class="porcentaje">0</td><td>Dividendos en acciones (capitalización de utilidades)</td></tr>
<tr><td>Renta</td><td class="codigo">332</td><td class="porcentaje">0</td><td>Otras compras de bienes y servicios no sujetas a retención</td></tr>
<tr><td>Renta</td><td class="codigo">333</td><td class="porcentaje">10</td><td>Ganancia en la enajenación de derechos representativos de capital u otros derechos que permitan la exploración, explotación, concesión o similares de sociedades, que se coticen en bolsa de valores del Ecuador</td></tr>
<tr><td>Renta</td><td class="codigo">334</td><td class="porcentaje">1</td><td>Contraprestación producida por la enajenación de derechos representativos de capital u otros derechos que permitan la exploración, explotación, concesión o similares de sociedades, no cotizados en bolsa de valores del Ecuador</td></tr>
<tr><td>Renta</td><td class="codigo">335</td><td class="porcentaje">15</td><td>Loterías, rifas, apuestas y similares</td></tr>
<tr><td>Renta</td><td class="codigo">336</td><td class="porcentaje">0</td><td>Venta de combustibles a comercializadoras</td></tr>
<tr><td>Renta</td><td class="codigo">337</td><td class="porcentaje">0</td><td>Venta de combustibles a distribuidores</td></tr>
<tr><td>Renta</td><td class="codigo">338</td><td class="porcentaje">0</td><td>Producción y venta local de banano producido o no por el mismo sujeto pasivo</td></tr>
<tr><td>Renta</td><td class="codigo">340</td><td class="porcentaje">3</td><td>Impuesto único a la exportación de banano</td></tr>
<tr><td>Renta</td><td class="codigo">343</td><td class="porcentaje">1</td><td>Otras retenciones aplicables el 1%</td></tr>
<tr><td>Renta</td><td class="codigo">345</td><td class="porcentaje">8</td><td>Otras retenciones aplicables el 8%</td></tr>
<tr><td>Renta</td><td class="codigo">346</td><td class="porcentaje">1.75</td><td>Otras retenciones aplicables a otros porcentajes </td></tr>
<tr><td>Renta</td><td class="codigo">348</td><td class="porcentaje">1</td><td>Impuesto único a ingresos provenientes de actividades agropecuarias en etapa de producción / comercialización local o exportación</td></tr>
<tr><td>Renta</td><td class="codigo">350</td><td class="porcentaje">0</td><td>Otras autoretenciones</td></tr>
<tr><td>Renta</td><td class="codigo">351</td><td class="porcentaje">1.75</td><td>REGIMEN MICRO EMPRESARIAL</td></tr>
<tr><td>Renta</td><td class="codigo">500</td><td class="porcentaje">0</td><td>Pago a no residentes - Rentas Inmobiliarias</td></tr>
<tr><td>Renta</td><td class="codigo">501</td><td class="porcentaje">0</td><td>Pago a no residentes - Beneficios/Servicios  Empresariales</td></tr>
<tr><td>Renta</td><td class="codigo">503</td><td class="porcentaje">0</td><td>Pago a no residentes- Navegación Marítima y/o aérea</td></tr>
<tr><td>Renta</td><td class="codigo">504</td><td class="porcentaje">25</td><td>Pago a no residentes- Dividendos distribuidos a personas naturales (domicilados o no en paraiso fiscal) o a sociedades sin beneficiario efectivo persona natural residente en Ecuador</td></tr>
<tr><td>Renta</td><td class="codigo">505</td><td class="porcentaje">0</td><td>Pago a no residentes - Rendimientos financieros</td></tr>
<tr><td>Renta</td><td class="codigo">509</td><td class="porcentaje">0</td><td>Pago a no residentes- Cánones, derechos de autor,  marcas, patentes y similares</td></tr>
<tr><td>Renta</td><td class="codigo">510</td><td class="porcentaje">0</td><td>Pago a no residentes - Otras ganancias de capital distintas de enajenación de derechos representativos de capital </td></tr>
<tr><td>Renta</td><td class="codigo">511</td><td class="porcentaje">0</td><td>Pago a no residentes - Servicios profesionales independientes</td></tr>
<tr><td>Renta</td><td class="codigo">512</td><td class="porcentaje">0</td><td>Pago a no residentes - Servicios profesionales dependientes</td></tr>
<tr><td>Renta</td><td class="codigo">513</td><td class="porcentaje">0</td><td>Pago a no residentes- Artistas</td></tr>
<tr><td>Renta</td><td class="codigo">514</td><td class="porcentaje">0</td><td>Pago a no residentes - Participación de consejeros</td></tr>
<tr><td>Renta</td><td class="codigo">515</td><td class="porcentaje">0</td><td>Pago a no residentes - Entretenimiento Público</td></tr>
<tr><td>Renta</td><td class="codigo">516</td><td class="porcentaje">0</td><td>Pago a no residentes - Pensiones</td></tr>
<tr><td>Renta</td><td class="codigo">517</td><td class="porcentaje">0</td><td>Pago a no residentes- Reembolso de Gastos</td></tr>
<tr><td>Renta</td><td class="codigo">518</td><td class="porcentaje">0</td><td>Pago a no residentes- Funciones Públicas</td></tr>
<tr><td>Renta</td><td class="codigo">519</td><td class="porcentaje">0</td><td>Pago a no residentes - Estudiantes</td></tr>
<tr><td>Renta</td><td class="codigo">521</td><td class="porcentaje">0</td><td>Pago a no residentes - Enajenación de derechos representativos de capital u otros derechos que permitan la exploración, explotación, concesión o similares de sociedades</td></tr>
<tr><td>Renta</td><td class="codigo">525</td><td class="porcentaje">0</td><td>Pago a no residentes- Donaciones en dinero -Impuesto a la donaciones</td></tr>
<tr><td>Renta</td><td class="codigo">525</td><td class="porcentaje">0</td><td>Pago a no residentes- Donaciones en dinero -Impuesto a la donaciones</td></tr>
<tr><td>Renta</td><td class="codigo">3440</td><td class="porcentaje">2.75</td><td>Otras retenciones aplicables el 2,75%</td></tr>
<tr><td>Renta</td><td class="codigo">304A</td><td class="porcentaje">8</td><td>Comisiones y demás pagos por servicios predomina intelecto no relacionados con el título profesional</td></tr>
<tr><td>Renta</td><td class="codigo">304B</td><td class="porcentaje">8</td><td>Pagos a notarios y registradores de la propiedad y mercantil por sus actividades ejercidas como tales</td></tr>
<tr><td>Renta</td><td class="codigo">304C</td><td class="porcentaje">8</td><td>Pagos a deportistas, entrenadores, árbitros, miembros del cuerpo técnico por sus actividades ejercidas como tales</td></tr>
<tr><td>Renta</td><td class="codigo">304D</td><td class="porcentaje">8</td><td>Pagos a artistas por sus actividades ejercidas como tales</td></tr>
<tr><td>Renta</td><td class="codigo">304E</td><td class="porcentaje">8</td><td>Honorarios y demás pagos por servicios de docencia</td></tr>
<tr><td>Renta</td><td class="codigo">312A</td><td class="porcentaje">1</td><td>Compra de bienes de origen agrícola, avícola, pecuario, apícola, cunícula, bioacuático, forestal y carnes en estado natural</td></tr>
<tr><td>Renta</td><td class="codigo">312B</td><td class="porcentaje">1</td><td>Impuesto a la Renta único para la actividad de producción y cultivo de palma aceitera</td></tr>
<tr><td>Renta</td><td class="codigo">314A</td><td class="porcentaje">8</td><td>Regalías por concepto de franquicias de acuerdo a Ley de Propiedad Intelectual - pago a personas naturales</td></tr>
<tr><td>Renta</td><td class="codigo">314B</td><td class="porcentaje">8</td><td>Cánones, derechos de autor,  marcas, patentes y similares de acuerdo a Ley de Propiedad Intelectual – pago a personas naturales</td></tr>
<tr><td>Renta</td><td class="codigo">314C</td><td class="porcentaje">8</td><td>Regalías por concepto de franquicias de acuerdo a Ley de Propiedad Intelectual  - pago a sociedades</td></tr>
<tr><td>Renta</td><td class="codigo">314D</td><td class="porcentaje">8</td><td>Cánones, derechos de autor,  marcas, patentes y similares de acuerdo a Ley de Propiedad Intelectual – pago a sociedades</td></tr>
<tr><td>Renta</td><td class="codigo">323 M</td><td class="porcentaje">2</td><td>Rendimientos financieros: Inversiones en títulos valores en renta fija gravados </td></tr>
<tr><td>Renta</td><td class="codigo">323 N</td><td class="porcentaje">0</td><td>Rendimientos financieros: Inversiones en títulos valores en renta fija exentos</td></tr>
<tr><td>Renta</td><td class="codigo">323 O</td><td class="porcentaje">0</td><td>Intereses y demás rendimientos financieros pagados a bancos y otras entidades sometidas al control de la Superintendencia de Bancos y de la Economía Popular y Solidaria</td></tr>
<tr><td>Renta</td><td class="codigo">323 P</td><td class="porcentaje">2</td><td>Intereses pagados por entidades del sector público a favor de sujetos pasivos</td></tr>
<tr><td>Renta</td><td class="codigo">323A</td><td class="porcentaje">2</td><td>Rendimientos financieros: depósitos Cta. Corriente</td></tr>
<tr><td>Renta</td><td class="codigo">323B1</td><td class="porcentaje">2</td><td>Rendimientos financieros:  depósitos Cta. Ahorros Sociedades</td></tr>
<tr><td>Renta</td><td class="codigo">323E</td><td class="porcentaje">2</td><td>Rendimientos financieros: depósito a plazo fijo  gravados</td></tr>
<tr><td>Renta</td><td class="codigo">323E2</td><td class="porcentaje">0</td><td>Rendimientos financieros: depósito a plazo fijo exentos</td></tr>
<tr><td>Renta</td><td class="codigo">323F</td><td class="porcentaje">2</td><td>Rendimientos financieros: operaciones de reporto - repos</td></tr>
<tr><td>Renta</td><td class="codigo">323G</td><td class="porcentaje">2</td><td>Inversiones (captaciones) rendimientos distintos de aquellos pagados a IFIs</td></tr>
<tr><td>Renta</td><td class="codigo">323H</td><td class="porcentaje">2</td><td>Rendimientos financieros: obligaciones</td></tr>
<tr><td>Renta</td><td class="codigo">323I</td><td class="porcentaje">2</td><td>Rendimientos financieros: bonos convertible en acciones</td></tr>
<tr><td>Renta</td><td class="codigo">323Q</td><td class="porcentaje">2</td><td>Otros intereses y rendimientos financieros gravados </td></tr>
<tr><td>Renta</td><td class="codigo">323R</td><td class="porcentaje">0</td><td>Otros intereses y rendimientos financieros exentos</td></tr>
<tr><td>Renta</td><td class="codigo">323S</td><td class="porcentaje">2</td><td>Pagos y créditos en cuenta efectuados por el BCE y los depósitos centralizados de valores, en calidad de intermediarios, a instituciones del sistema financiero por cuenta de otras personas naturales y sociedades</td></tr>
<tr><td>Renta</td><td class="codigo">323T</td><td class="porcentaje">0</td><td>Rendimientos financieros originados en la deuda pública ecuatoriana</td></tr>
<tr><td>Renta</td><td class="codigo">323U</td><td class="porcentaje">0</td><td>Rendimientos financieros originados en títulos valores de obligaciones de 360 días o más para el financiamiento de proyectos públicos en asociación público-privada</td></tr>
<tr><td>Renta</td><td class="codigo">324A</td><td class="porcentaje">1</td><td>Intereses y comisiones en operaciones de crédito entre instituciones del sistema financiero y entidades economía popular y solidaria.</td></tr>
<tr><td>Renta</td><td class="codigo">324B</td><td class="porcentaje">1</td><td>Inversiones entre instituciones del sistema financiero y entidades economía popular y solidaria</td></tr>
<tr><td>Renta</td><td class="codigo">324C</td><td class="porcentaje">1</td><td>Pagos y créditos en cuenta efectuados por el BCE y los depósitos centralizados de valores, en calidad de intermediarios, a instituciones del sistema financiero por cuenta de otras instituciones del sistema financiero</td></tr>
<tr><td>Renta</td><td class="codigo">325A</td><td class="porcentaje">0</td><td>Préstamos accionistas, beneficiarios o partícipes residentes o establecidos en el Ecuador</td></tr>
<tr><td>Renta</td><td class="codigo">332B</td><td class="porcentaje">0</td><td>Compra de bienes inmuebles</td></tr>
<tr><td>Renta</td><td class="codigo">332C</td><td class="porcentaje">0</td><td>Transporte público de pasajeros</td></tr>
<tr><td>Renta</td><td class="codigo">332D</td><td class="porcentaje">0</td><td>Pagos en el país por transporte de pasajeros o transporte internacional de carga, a compañías nacionales o extranjeras de aviación o marítimas</td></tr>
<tr><td>Renta</td><td class="codigo">332E</td><td class="porcentaje">0</td><td>Valores entregados por las cooperativas de transporte a sus socios</td></tr>
<tr><td>Renta</td><td class="codigo">332F</td><td class="porcentaje">0</td><td>Compraventa de divisas distintas al dólar de los Estados Unidos de América</td></tr>
<tr><td>Renta</td><td class="codigo">332G</td><td class="porcentaje">0</td><td>Pagos con tarjeta de crédito </td></tr>
<tr><td>Renta</td><td class="codigo">332H</td><td class="porcentaje">0</td><td>Pago al exterior tarjeta de crédito reportada por la Emisora de tarjeta de crédito, solo RECAP</td></tr>
<tr><td>Renta</td><td class="codigo">332I</td><td class="porcentaje">0</td><td>Pago a través de convenio de debito (Clientes IFI`s)</td></tr>
<tr><td>Renta</td><td class="codigo">343A</td><td class="porcentaje">1</td><td>Energía eléctrica</td></tr>
<tr><td>Renta</td><td class="codigo">343B</td><td class="porcentaje">0.0175</td><td>Actividades de construcción de obra material inmueble, urbanización, lotización o actividades similares</td></tr>
<tr><td>Renta</td><td class="codigo">343C</td><td class="porcentaje">1</td><td>Impuesto Redimible a las botellas plásticas - IRBP</td></tr>
<tr><td>Renta</td><td class="codigo">344A</td><td class="porcentaje">2</td><td>Pago local tarjeta de crédito /débito reportada por la Emisora de tarjeta de crédito / entidades del sistema financiero</td></tr>
<tr><td>Renta</td><td class="codigo">344B</td><td class="porcentaje">2</td><td>Adquisición de sustancias minerales dentro del territorio nacional</td></tr>
<tr><td>Renta</td><td class="codigo">346A</td><td class="porcentaje">0</td><td>Otras ganancias de capital distintas de enajenación de derechos representativos de capital </td></tr>
<tr><td>Renta</td><td class="codigo">346B</td><td class="porcentaje">0</td><td>Donaciones en dinero -Impuesto a la donaciones </td></tr>
<tr><td>Renta</td><td class="codigo">346C</td><td class="porcentaje">0</td><td>Retención a cargo del propio sujeto pasivo por la exportación de concentrados y/o elementos metálicos</td></tr>
<tr><td>Renta</td><td class="codigo">346D</td><td class="porcentaje">0</td><td>Retención a cargo del propio sujeto pasivo por la comercialización de productos forestales</td></tr>
<tr><td>Renta</td><td class="codigo">501A</td><td class="porcentaje">0</td><td>Pago a no residentes - Servicios técnicos, administrativos o de consultoría y regalías</td></tr>
<tr><td>Renta</td><td class="codigo">504A</td><td class="porcentaje">0</td><td>Dividendos a sociedades con beneficiario efectivo persona natural residente en el Ecuador</td></tr>
<tr><td>Renta</td><td class="codigo">504B</td><td class="porcentaje">35</td><td>Dividendos a no residentes incumpliendo el deber de informar la composición societaria</td></tr>
<tr><td>Renta</td><td class="codigo">504C</td><td class="porcentaje">0</td><td>Dividendos a residentes o establecidos en paraísos fiscales o regímenes de menor imposición (con beneficiario Persona Natural residente en Ecuador)</td></tr>
<tr><td>Renta</td><td class="codigo">504D</td><td class="porcentaje">0</td><td>Pago a no residentes - Dividendos a fideicomisos domiciladas en paraísos fiscales o regímenes de menor imposición (con beneficiario efectivo persona natural residente en el Ecuador)</td></tr>
<tr><td>Renta</td><td class="codigo">504E</td><td class="porcentaje">0</td><td>Pago a no residentes - Anticipo dividendos (no domiciliada en paraísos fiscales o regímenes de menor imposición)</td></tr>
<tr><td>Renta</td><td class="codigo">504F</td><td class="porcentaje">0</td><td>Pago a no residentes - Anticipo dividendos (domiciliadas en paraísos fiscales o regímenes de menor imposición)</td></tr>
<tr><td>Renta</td><td class="codigo">504G</td><td class="porcentaje">0</td><td>Pago a no residentes - Préstamos accionistas, beneficiarios o partìcipes (no domiciladas en paraísos fiscales o regímenes de menor imposición)</td></tr>
<tr><td>Renta</td><td class="codigo">504H</td><td class="porcentaje">0</td><td>Pago a no residentes - Préstamos accionistas, beneficiarios o partìcipes (domiciladas en paraísos fiscales o regímenes de menor imposición)</td></tr>
<tr><td>Renta</td><td class="codigo">504I</td><td class="porcentaje">0</td><td>Pago a no residentes - Préstamos no comerciales a partes relacionadas  (no domiciladas en paraísos fiscales o regímenes de menor imposición)</td></tr>
<tr><td>Renta</td><td class="codigo">504J</td><td class="porcentaje">0</td><td>Pago a no residentes - Préstamos no comerciales a partes relacionadas  (domiciladas en paraísos fiscales o regímenes de menor imposición)</td></tr>
<tr><td>Renta</td><td class="codigo">505A</td><td class="porcentaje">0</td><td>Pago a no residentes – Intereses de créditos de Instituciones Financieras del exterior</td></tr>
<tr><td>Renta</td><td class="codigo">505B</td><td class="porcentaje">0</td><td>Pago a no residentes – Intereses de créditos de gobierno a gobierno</td></tr>
<tr><td>Renta</td><td class="codigo">505C</td><td class="porcentaje">0</td><td>Pago a no residentes – Intereses de créditos de organismos multilaterales</td></tr>
<tr><td>Renta</td><td class="codigo">505D</td><td class="porcentaje">25</td><td>Pago a no residentes - Intereses por financiamiento de proveedores externos</td></tr>
<tr><td>Renta</td><td class="codigo">505E</td><td class="porcentaje">25</td><td>Pago a no residentes - Intereses de otros créditos externos</td></tr>
<tr><td>Renta</td><td class="codigo">505F</td><td class="porcentaje">0</td><td>Pago a no residentes - Otros Intereses y Rendimientos Financieros</td></tr>
<tr><td>Renta</td><td class="codigo">509A</td><td class="porcentaje">0</td><td>PPago a no residentes - Regalías por concepto de franquicias</td></tr>
<tr><td>Renta</td><td class="codigo">513A</td><td class="porcentaje">0</td><td>Pago a no residentes - Deportistas</td></tr>
<tr><td>Renta</td><td class="codigo">520A</td><td class="porcentaje">0</td><td>Pago a no residentes - Pago a proveedores de servicios hoteleros y turísticos en el exterior</td></tr>
<tr><td>Renta</td><td class="codigo">520B</td><td class="porcentaje">0</td><td>Pago a no residentes - Arrendamientos mercantil internacional</td></tr>
<tr><td>Renta</td><td class="codigo">520D</td><td class="porcentaje">0</td><td>Pago a no residentes - Comisiones por exportaciones y por promoción de turismo receptivo</td></tr>
<tr><td>Renta</td><td class="codigo">520E</td><td class="porcentaje">0</td><td>Pago a no residentes - Por las empresas de transporte marítimo o aéreo y por empresas pesqueras de alta mar, por su actividad.</td></tr>
<tr><td>Renta</td><td class="codigo">520F</td><td class="porcentaje">0</td><td>Pago a no residentes - Por las agencias internacionales de prensa</td></tr>
<tr><td>Renta</td><td class="codigo">520G</td><td class="porcentaje">0</td><td>Pago a no residentes - Contratos de fletamento de naves para empresas de transporte aéreo o marítimo internacional</td></tr>
<tr><td>Renta</td><td class="codigo">523A</td><td class="porcentaje">0</td><td>Pago a no residentes - Seguros y reaseguros (primas y cesiones)  </td></tr>
<tr><td>Renta</td><td class="codigo">523A</td><td class="porcentaje">0</td><td>Pago a no residentes - Seguros y reaseguros (primas y cesiones)  </td></tr>
								
							</tbody>
						</table>
                        </div>
                    </div><!-- Datos ajax Final -->

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div><!-- /.modal -->
	<?php
}
?>