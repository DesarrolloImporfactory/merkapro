	<form id="">
		<div class="modal fade" id="stock_ad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<input type="hidden" id="id_producto" name="id_producto">
					<!--h3 class="text-center text-muted">Estas seguro?</h3-->
					<p class="lead text-muted text-center" style="display: block;margin:9px">INGRESE LA CARACTERÍSTICA DEL PRODUCTO</p>
                                        <div style="padding: 5px" class="row">
                                        <div class="col-md-8">
                                            <input class='form-control UpperCase' placeholder="Ingrese el nombre del atributo Ej. TALLA" name='atributo' id='atributo' required>
    
                                            
    </div>
   
                                             <div class="col-md-4">
                                                 <?php ?>
                                                 <button type="button" class="btn btn-primary waves-effect waves-light" onclick="agrega_atributo()" id="stock_lote" name="stock_lote">AÑADIR</button>
    </div>
                                            </div>
                                        <div style="padding: 5px" id="stock_lista" class="row">
                              
                                            </div>
  
                                        
                                        
                                        <div class="modal-footer">
						<button type="button" class="btn btn-default waves-effect waves-light" data-dismiss="modal">Cancelar</button>
						
					</div>
				</div>
			</div>
		</div>
	</form>