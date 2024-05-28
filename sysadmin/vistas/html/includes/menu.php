<!-- Top Bar Start -->
<?php
require_once "../funciones.php";
$marketplace_url = $_SERVER['HTTP_HOST'];
$marketplace_url = str_replace(["www.", ".com"], "", $marketplace_url);


$marketplace_url_conexion = 'imporsuit_marketplace';
if ($_SERVER['HTTP_HOST'] == 'localhost') {
	$marketplace_conexion_2 = new mysqli('localhost', 'root', '', 'master');
} else {
	$marketplace_conexion_2 = mysqli_connect('localhost', $marketplace_url_conexion, $marketplace_url_conexion, $marketplace_url_conexion);
}


$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';

$dominio_completo =     $protocol . $_SERVER['HTTP_HOST'];


$query_total_ventas = "SELECT SUM(valor_pendiente) AS total_pendiente_a_la_tienda FROM cabecera_cuenta_pagar WHERE tienda = '$dominio_completo' and visto='1'";
$total_venta = mysqli_query($marketplace_conexion_2, $query_total_ventas);

@$total_venta = mysqli_fetch_assoc($total_venta);
@$total_venta = $total_venta['total_pendiente_a_la_tienda'];
$color = '';
$pais = get_row('perfil', 'pais', 'id_perfil', 1);
if ($total_venta == null) {
	$total_venta = 0;
	$color = 'text-white';
} elseif ($total_venta > 0) {
	$color = 'text-success';
} else {

	$color = 'text-danger';
}
$total_venta = number_format($total_venta, 2, '.', ',');
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
?>
<div class="topbar" style="background: #ececec">

	<!-- LOGO -->
	<div class="topbar-left" style="background: #ececec">
		<div class="text-center d-flex justify-content-center pt-2">
			<!-- <a href="#" class="logo"> <span>IMPORSUIT</span></a> -->
			<img src="https://marketplace.imporsuit.com/sysadmin/img/MERKATODO-LOGO.png" id="mi-imagen" width="100px" header="100px">
			<script>
				// Función para cambiar la imagen según el tamaño de la ventana
				function cambiarImagenPorTamaño() {
					var imagen = document.getElementById('mi-imagen'); // Asegúrate de tener un elemento img con id="mi-imagen"

					if (window.matchMedia("(max-width: 768px)").matches) {
						// Si la pantalla es menor o igual a 768px de ancho, usa la imagen para móviless
						imagen.src = 'https://marketplace.imporsuit.com/sysadmin/img/MERKATODO-LOGO-MINI.png';
						imagen.style.width = '40px'; // Establece el ancho deseado para móviles
						imagen.style.height = '40px';
					} else {
						// Si la pantalla es mayor a 768px de ancho, usa la imagen para escritorio
						imagen.src = 'https://marketplace.imporsuit.com/sysadmin/img/MERKATODO-LOGO.png';
						imagen.style.width = '100px';
					}
				}

				// Escuchar el evento resize de la ventana
				window.addEventListener('resize', cambiarImagenPorTamaño);

				// También ejecuta la función al cargar la página para establecer la imagen inicial correcta
				window.addEventListener('load', cambiarImagenPorTamaño);
			</script>
		</div>
	</div>

	<!-- Button mobile view to collapse sidebar menu -->
	<nav class="navbar-custom" style="background: #ececec">

		<ul class="list-inline float-right mb-0">


			<li class="list-inline-item notification-list hide-phone   waves-light waves-effect">
				<i class="ti-wallet"></i>
				<span style="color: #006ba5 !important" class="<?php echo $color ?>"><?php echo $simbolo_moneda . $total_venta ?></span>
			</li>

			<li class="list-inline-item notification-list hide-phone">
				<a class="nav-link waves-light waves-effect" href="#" id="btn-fullscreen">
					<i style="color: #006ba5 !important" class="mdi mdi-crop-free noti-icon"></i>
				</a>
			</li>
			<?php if ($dominio_completo === "https://yapando.imporsuit.com" || $dominio_completo === "https://onlytap.imporsuit.com") {
				echo '
				
				';
			} else {
				echo '<li class="list-inline-item notification-list hide-phone">
				
				<a  class="nav-link waves-light waves-effect" onclick="actualizar()" id="">
				<i style="color: #006ba5 !important" class="mdi mdi-radar noti-icon"></i>
				</a>
				</li>
				';
			} ?>

			<li class="list-inline-item dropdown notification-list">
				<a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
					<img src="<?php echo get_row('perfil', 'logo_url', 'id_perfil', 1); ?>" alt="user" class="rounded-circle">
				</a>
				<div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">

					<!-- item-->
					<a href="javascript:void(0);" class="dropdown-item notify-item">
						<i class="mdi mdi-account-star-variant"></i> <span>Perfil</span>
					</a>

					<!-- item-->
					<a href="../../login.php?logout" class="dropdown-item notify-item">
						<i class="mdi mdi-logout"></i> <span>Salir</span>
					</a>

				</div>
			</li>

		</ul>

		<ul class="list-inline menu-left mb-0">
			<li class="float-left">
				<button class="button-menu-mobile open-left waves-light waves-effect" style="background: #ececec">
					<i style="color: #006ba5 !important" class="mdi mdi-menu"></i>
				</button>
			</li>
		</ul>

	</nav>

</div>
<!-- Top Bar End -->
<!-- ========== Left Sidebar Start ========== -->

<div class="left side-menu">
	<div class="sidebar-inner slimscrollleft">
		<!--- Divider -->
		<div id="sidebar-menu">
			<ul>

				<li>
					<a href="dashboard.php" class="waves-effect waves-primary"><i class="ti-home"></i><span> Inicio </span></a>
				</li>
				<li>
					<a href="marketplace.php" class="waves-effect waves-primary"><i class="ti-import"></i><span> Marketplace </span></a>
				</li>
				<li>
					<a href="../html/clientes.php" class="waves-effect waves-primary"><i class="ti-user"></i><span> Clientes </span></a>
				</li>

				<li class="has_sub">
					<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-package"></i><span> Productos </span>
						<span class="menu-arrow"></span></a>
					<ul class="list-unstyled">
						<li><a href="../html/lineas.php">Categorias</a></li>
						<li><a href="../html/productos.php">Productos</a></li>
						<li><a href="../html/kardex.php">Kardex</a></li>
						<li><a href="../html/ajustes.php">Ajuste de Inventario</a></li>
					</ul>
				</li>

				<li class="has_sub">
					<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-bag"></i><span> Compras </span> <span class="menu-arrow"></span></a>
					<ul class="list-unstyled">
						<li><a href="../html/proveedores.php">Proveedores</a></li>
						<li><a href="../html/new_compra.php">Nueva Compra</a></li>
						<li><a href="../html/bitacora_compras.php">Bitácora de Compras</a></li>
					</ul>
				</li>

				<!--<li>
					<a href="../html/traslados.php" class="waves-effect waves-primary"><i
					class="ti-truck"></i><span> Traslados </span></a>
				</li>-->

				<!-- <li class="has_sub">
					<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-shopping-cart-full"></i><span> Ventas
						
						<li><a href="../html/new_notacredito.php">Nueva Nota Credito</a></li>
						<li><a href="../html/bitacora_credito.php">Bitacora Nota Cr&eacute;dito</a></li>
						
					</span> <span class="menu-arrow"></span></a>
					<ul class="list-unstyled">
						<li><a href="../html/bitacora_ventas.php">Bitácora de Ventas</a></li>
						<li><a href="../html/new_venta.php">Nueva Venta</a></li>
											
											<li><a href="../html/new_liquidacioncompra.php">Nueva Liquidacion Compra</a></li>
											<li><a href="../html/bitacora_liquidacion.php">Bitacora Liquidacion Compra</a></li>
											<li><a href="../html/new_notadebito20.php">Nueva Nota D&eacute;bito</a></li>
											<li><a href="../html/bitacora_notadebito20.php">Bitacora Nota D&eacute;bito</a></li> -->

				<!--<li><a href="../html/new_notadebito.php">Nueva Nota D&eacute;bito</a></li>
											<li><a href="../html/bitacora_debito.php">Bitacora Nota D&eacute;bito</a></li>
											<br>
				li><a href="../html/new_guia.php">Nueva Gu&iacute;a</a></li>
				<i><a href="../html/bitacora_guia.php">Bitacora Gu&iacute;a</a></i>
										<li><a href="../html/new_retencion.php">Nueva Retenci&oacute;n</a></li>
											<li><a href="../html/bitacora_retencion.php">Bitacora Retenci&oacute;n</a></li>

				<li><a href="../html/new_retencion20.php">Nueva Retenci&oacute;n</a></li>
											<li><a href="../html/bitacora_retencion20.php">Bitacora Retenci&oacute;n</a></li>
											<li><a href="../html/caja.php">Caja</a></li>
										</ul>
									</li-->
				<li class="has_sub">
					<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-desktop"></i><span> POS
						</span> <span class="menu-arrow"></span></a>

					<ul class="list-unstyled">
						<!--li><a href="../html/new_cotizacion.php">Agregar Pedido</a></li-->

						<li><a href="../html/new_venta.php">Punto de Venta</a></li>
						<li><a href="../html/bitacora_ventas.php">Listado de Facturas</a></li>





					</ul>
				</li>

				<li class="has_sub">
					<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-receipt"></i><span> Pedidos
						</span> <span class="menu-arrow"></span></a>

					<ul class="list-unstyled">
						<!--li><a href="../html/new_cotizacion.php">Agregar Pedido</a></li-->
						<li><a href="../html/new_cotizacion.php">Nuevo Pedido</a></li>

						<?php if ($pais == 1) {

						?>
							<li><a href="../html/bitacora_pedidos_new.php">Pedidos Ingresados</a></li>
						<?php  } else {
						?>
							<li><a href="../html/bitacora_cotizacion_p.php">Pedidos Ingresados</a></li>
						<?php
						} ?>

						<?php if ($dominio_completo == 'https://yapando.imporsuit.com') { ?>
							<li><a href="../html/bitacora_externa.php">Pedidos Externos</a></li>

						<?php } ?>

						<li><a href="../html/guias_bitacora_cotizacion_new.php">Guias</a></li>

						<li><a href="../html/guias_anuladas_bitacora_cotizacion_new.php">Guias anuladas</a></li>

						<li>
							<a href="../html/novedades.php">Novedades</a>
						</li>


					</ul>
				</li>
				<!-- <li class="has_sub">
					<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-agenda"></i><span> Cobros y Pagos </span>
						<span class="menu-arrow"></span></a>
					<ul class="list-unstyled">
						<li><a href="../html/cxc.php">Abono Cliente</a></li>
						<li><a href="../html/cxp.php">Abono Proveedor</a></li>
					</ul>
				</li> -->

				<!--li class="has_sub">
					<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-files"></i><span> Reportes </span> <span class="menu-arrow"></span></a>
					<ul class="list-unstyled">
						
						<li><a href="../html/rep_ventas.php">Reporte de Ventas</a></li>
						<li><a href="../html/rep_ventas_clientes.php">Ventas por Cliente</a></li>
						<li><a href="../html/rep_compras.php">Reporte de Compras</a></li>
						<li><a href="../html/rep_caja_chica.php">Reporte Caja chica</a></li>
						<li><a href="../html/rep_caja_general.php">Corte de Caja General</a></li>
						<li><a href="../html/rep_financiero.php">Reporte Financiero</a></li>
					</ul>
				</li-->

				<!--li class="has_sub">
												<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-files"></i><span> Reportes Facturaci&oacute;n </span> <span class="menu-arrow"></span></a>
												<ul class="list-unstyled">
													
													<li><a href="../html/rep_comprobantes.php">Reporte de Comprobantes</a></li>
													<li><a href="../html/rep_comprobantes_ventas.php">Ventas</a></li>
													<li><a href="../html/rep_ventas_detalladas.php">Ventas Detalladas</a></li>
													<li><a href="../html/rep_retenciones_totales.php">Reporte Retenciones Totales</a></li>
													<li><a href="../html/rep_retenciones_factura.php">Reporte Retenciones x Factura</a></li>
													
												</ul>
											</li-->

				<li class="has_sub">
					<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-settings"></i><span> Configuración </span> <span class="menu-arrow"></span></a>
					<ul class="list-unstyled">
						<li><a href="../html/empresa.php">Empresa</a></li>
						<li><a href="../html/sucursales.php">Sucursales</a></li>
						<li><a href="../html/comprobantes.php">Comprobantes</a></li>
						<!--<li><a href="../html/impuestos.php">Impuestos</a></li>-->
						<li><a href="../html/grupos.php">Grupos de Usuarios</a></li>
						<li><a href="../html/usuarios.php">Usuario</a></li>
						<li><a href="../html/backup.php">Backup</a></li>
						<li><a href="../html/restore.php">Restore</a></li>
					</ul>
				</li>
				<li>
					<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-desktop"></i><span> Tienda On Line </span> <span class="menu-arrow"></span></a>
					<ul class="list-unstyled">

						<li><a href="../html/info_web_1.php">Tienda On Line</a></li>
						<li><a href="../html/politicas.php">Politicas de Privacidad</a></li>
						<li><a href="../html/pixel.php">Pixele Seg</a></li>
						<li><a href="../html/gracias.php">Pagina de Gracias</a></li>
						<li><a href="../html/integraciones.php">Integraciones</a></li>
						<li><a href="../html/dominios.php">Dominio</a></li>



					</ul>
				</li>
				<li>
					<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-truck"></i><span> Transporte</span> <span class="menu-arrow"></span></a>
					<ul class="list-unstyled">

						<li><a href="../html/origen_laar.php">Configurar Origen Laar Courier</a></li>
						<li><a href="../html/bitacora_transportadoras.php">Configurar Transportadores</a></li>


					</ul>
				</li>
				<!--li>
					<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-wallet"></i><span> Billetera</span> <span class="menu-arrow"></span></a>
					<ul class="list-unstyled">
						<li><a href="../html/wallet.php">Detalles</a></li>
						<li><a href="../html/datos_banco.php">Datos bancarios</a></li>
						<?php if ($dominio_completo == 'https://merkapro.ec') { ?>
							<li><a href="../html/solicitudes.php">Solicitudes de Pago</a></li>

						<?php } ?>
					</ul>
				</li-->

				<!--li>
					<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-list"></i><span> Referidos</span> <span class="menu-arrow"></span></a>
					<ul class="list-unstyled">
						<li><a href="../html/referidos.php">Detalles</a></li>

					</ul>
				</li-->

				<?php if ($dominio_completo == 'https://merkapro.ec') { ?>
					<li>
						<a href="administrar_marketplace.php" class="waves-effect waves-primary"><i class="ti-home"></i><span> Adminmistrar tiendas </span></a>
					</li>
				<?php } ?>

				<?php if ($dominio_completo == 'https://merkapro.ec') { ?>
					<li>
						<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-list"></i><span> Tiendas</span> <span class="menu-arrow"></span></a>
						<ul class="list-unstyled">
							<?php if ($dominio_completo == 'https://merkapro.ec') { ?>

								<li><a href="../html/tiendas.php">Detalles</a></li>
							<?php } ?>

							<li><a href="../html/tiendas_clientes.php">Registro tiendas</a></li>

						</ul>
					</li>

				<?php } ?>


				<!--li class="has_sub">
										<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-import"></i><span> Carga Txt
										</span> <span class="menu-arrow"></span></a>
										<ul class="list-unstyled">
											<li><a href="../html/cargatxt.php">Carga Facturacion Txt</a></li>
											
																																					   
										</ul>
</li-->

			</ul>

			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- Left Sidebar End -->