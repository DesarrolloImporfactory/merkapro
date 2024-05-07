<style>
  .datos {

    border-radius: 0 10px 10px 0;
    font-size: 20px;
  }

  .icon_datos {
    height: 45px;
    width: 35px;
    font-size: 20px;
  }

  #datos {
    padding: 5px !important;
  }
</style>
<div class="modal fade" style="font-size:15px; padding: 10px" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="gracias.php" id="formulario">
      <div id="gracias" class="modal-content">
        <div class="modal-header">
          <?php
          $envioGratis_checkout = get_row('perfil', 'envioGratis_checkout', 'id_perfil', 1);
          if ($envioGratis_checkout == 1) { ?>
            <h5 class="modal-title" id="exampleModalLabel">ENVÍO GRATIS 🚨</h5>
          <?php }else{ ?>
            <h5 class="modal-title" id="exampleModalLabel">COMPLETA TU COMPRA 🚨</h5>
            <?php }?>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="resultados" class="modal-body">

        </div>

        <div id="datos" class="col-12 modal-body">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span style="height: 45px" class="icon_datos input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="datos form-control" id="nombre" name="nombre" placeholder="Nombre y Apellido *" required>
            <input type="hidden" class="form-control" id="session" name="session" value="<?php echo $session_id; ?>">
            <input type="hidden" class="form-control" id="cliente" name="cliente" value="1">
          </div>
        </div>

        <div id="datos" class="col-12 modal-body">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span style="height: 45px" class="icon_datos input-group-text"><i class="fas fa-phone"></i></span>
            </div>
            <input type="text" class="datos form-control" id="telefono" name="telefono" placeholder="Telefono *" required>
          </div>
        </div>

        <div id="datos" class="col-12 modal-body">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span style="height: 45px" class="icon_datos input-group-text"><i class="fas fa-map-marker-alt"></i></span>
            </div>
            <input type="text" class="datos form-control" id="calle_principal" name="calle_principal" placeholder="Calle Principal *" required>
          </div>
        </div>

        <div id="datos" class="col-12 modal-body">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span style="height: 45px" class="icon_datos input-group-text"><i class="fas fa-map-marker-alt"></i></span>
            </div>
            <input type="text" class="datos form-control" id="calle_secundaria" name="calle_secundaria" placeholder="Calle Secundaria *" required>
          </div>
        </div>

        <div id="datos" class="col-12 modal-body">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span style="height: 45px" class="icon_datos input-group-text"><i class="fas fa-map-marker-alt"></i></span>
            </div>
            <input type="text" class="datos form-control" id="referencia" name="referencia" placeholder="Referencia *" required>
          </div>
        </div>

        <div id="datos" class="col-12 modal-body">
          <div class="input-group mb-3" id="">
            <div class="input-group-prepend">
              <span style="height: 45px" class=" icon_datos input-group-text"><i class="fas fa-map-marker-alt"></i></span>
            </div>
            <?php
            $esDepartamento = get_row('perfil', 'pais', 'id_perfil', 1);
            if ($esDepartamento == 2) {
              $provincia = "Departamento *";
              $ciudad = "Distrito *";
            } else {
              $provincia = "Provincia *";
              $ciudad = "Ciudad *";
            }
            ?>
            <select onchange="cargar_provincia(this.value)" class="datos form-control" id="provinica" name="provinica" required>
              <option value=""> <?php echo $provincia ?></option>
              <?php
              $pais = get_row('perfil', 'pais', 'id_perfil', 1);
              if ($pais == 2) {
                $sql2 = "select * from provincia_laar where id_pais=2 and provincia IN ('Amazonas', 'Ancash', 'Apurímac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Callao', 'Cusco', 'Huancavelica', 'Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno', 'San Martín', 'Tacna', 'Tumbes', 'Ucayali') order by provincia asc;                ";
              } else {
                $sql2 = "select * from provincia_laar where id_pais=$pais order by provincia asc";
              }

              //echo $sql2;
              $query2 = mysqli_query($conexion, $sql2);

              $rowcount = mysqli_num_rows($query2);
              //echo $rowcount;
              $i = 1;
              while ($row2 = mysqli_fetch_array($query2)) {
                $id_prov       = $row2['id_prov'];
                $provincia      = $row2['provincia'];
                $cod_provincia      = $row2['codigo_provincia'];

              ?>
                <option value="<?php echo $cod_provincia; ?>"><?php echo $provincia; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div id="datos" class="col-12 modal-body">
          <div class="input-group mb-3" id="div_ciudad">
            <div class="input-group-prepend">
              <span style="height: 45px" class="icon_datos input-group-text"><i class="fas fa-map-marker-alt"></i></span>
            </div>
            <select onchange="cargar_provincia(this.value)" class="datos form-control" id="ciudad" name="ciudad" disabled="disabled" required>
              <option value=""> <?php echo $ciudad ?> </option>
              <?php
              $sql2 = "select * from provincia_laar ";
              //echo $sql2;
              $query2 = mysqli_query($conexion, $sql2);

              $rowcount = mysqli_num_rows($query2);
              //echo $rowcount;
              $i = 1;
              while ($row2 = mysqli_fetch_array($query2)) {
                $id_prov       = $row2['id_prov'];
                $provincia      = $row2['provincia'];
                $cod_provincia      = $row2['codigo_provincia'];

              ?>
                <option value="<?php echo $cod_provincia; ?>"><?php echo $provincia; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div id="datos" class="col-12 modal-body">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span style="height: 45px" class="icon_datos input-group-text"><i class="fas fa-arrow-right"></i></span>
            </div>
            <input type="text" class="datos form-control" id="observacion" name="observacion" placeholder="Referencias Adicionales (Opcional)">
          </div>
        </div>



        <div class="modal-footer">

          <button type="submit" style="width:100%; height: 40px; font-size: 20px" class="btn boton"><span class="texto_boton"> Completa tu compra</span></button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  function cargar_provincia(id_provincia) {

    var formulario = document.getElementById('formulario');
    //  alert($('#provinica').val())
    var data = new FormData(formulario);
    data.set('provinica', $('#provinica option:selected').text());




    $.ajax({
      url: "ajax/cargar_ciudad.php", // Url to which the request is send
      type: "POST", // Type of request to be send, called as method
      data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function(data) // A function to be called if request succeeds
      {
        //alert(data);
        $('#div_ciudad').html(data);

      }
    });

  }
</script>