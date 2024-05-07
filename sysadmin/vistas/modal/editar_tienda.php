<?php
if (isset($conexion)) {
    ?>
	<div id="editarLinea" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Nueva Tienda</h4>
				</div>
                            <form class="form-horizontal" method="post" id="editar_linea" name="editar_linea">
				<div class="modal-body">
					
						<div id="resultados_ajax"></div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Nombre Tienda:</label>
									<input type="text" class="form-control UpperCase" id="mod_nombre" name="mod_nombre"  autocomplete="off" required>
                                                                        <input id="mod_id" name="mod_id" type='hidden'>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Contacto:</label>
									<input type="text" class="form-control UpperCase" id="mod_contacto" name="mod_contacto"  autocomplete="off" required>
								</div>
							</div>
						</div>
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Whatsapp:</label>
									<input type="text" class="form-control UpperCase" id="mod_whatsapp" name="mod_whatsapp"  autocomplete="off" required>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="fecha" class="control-label">Fecha Ingreso:</label>
									<input type="date" class="form-control UpperCase" id="mod_fecha_ingresa" name="mod_fecha_ingresa"  autocomplete="off" required>
								</div>
							</div>
						</div>
                                                
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Fecha Actualiza:</label>
									<input type="date" class="form-control UpperCase" id="mod_fecha_actualza" name="mod_fecha_actualza"  autocomplete="off" required>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="fecha" class="control-label">Fecha Caduca:</label>
									<input type="date" class="form-control UpperCase" id="mod_fecha_caduca" name="mod_fecha_caduca"  autocomplete="off" required>
								</div>
							</div>
						</div>
                                                
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Plan:</label>
                                                                        <select  class="form-control " id="mod_id_plan" name="mod_id_plan"  autocomplete="off" required>
                                                                            <option value="">Seleccione Plan</option>
                                                                             <option value="1">Prueba</option>
                                                                            <option value="2">Free</option>
                                                                            <option value="3">Premium</option>
                                                                        </select>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="fecha" class="control-label">Subdominio:</label>
									<input type="text" class="form-control " id="mod_subdominio" name="mod_subdominio"  autocomplete="off" required>
								</div>
							</div>
						</div>
                                                
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Carpeta:</label>
                                                                      <input type="text" class="form-control " id="mod_carpeta" name="mod_carpeta"  autocomplete="off" required>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="fecha" class="control-label">Dominio Propio:</label>
									<input type="text" class="form-control " id="mod_dominio" name="mod_dominio"  autocomplete="off" >
								</div>
							</div>
						</div>
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Email:</label>
                                                                      <input type="text" class="form-control " id="mod_email" name="mod_email"  autocomplete="off" required>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="fecha" class="control-label">Base de datos:</label>
									<input type="text" class="form-control " id="mod_name" name="mod_name"  autocomplete="off" >
								</div>
							</div>
						</div>
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Usuario Base de Datos:</label>
                                                                      <input type="text" class="form-control " id="mod_user" name="mod_user"  autocomplete="off" required>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="fecha" class="control-label">Password Base de datos:</label>
                                                                        <input type="password" class="form-control " id="mod_pass" name="mod_pass"  autocomplete="off" >
								</div>
							</div>
						</div>
                                                <div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="nombre" class="control-label">Referido:</label>
                                                                      <select class="form-control" id="mod_referido" name="mod_referido" required>
										<option value="">-- Selecciona --</option>
										<option value="1" >SI</option>
										<option value="0" selected>NO</option>
									</select>
								</div>
							</div>
                                                    <div class="col-md-4">
								<div class="form-group">
									<label for="nombre" class="control-label">Token:</label>
                                                                      <label for="fecha" class="control-label">Padre:</label>
                                                                        <input type="text" class="form-control " id="mod_token" name="mod_token"  autocomplete="off" >
								</div>
							</div>
                                                    <div class="col-md-4">
								<div class="form-group">
									<label for="fecha" class="control-label">Padre:</label>
                                                                        <input type="text" class="form-control " id="mod_padre" name="mod_padre"  autocomplete="off" >
								</div>
							</div>
						</div>

						
                                                
                                                
                                                 
						

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary waves-effect waves-light" id="actualizar_datos">Actualiza</button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- /.modal -->
	<?php
}
?>
