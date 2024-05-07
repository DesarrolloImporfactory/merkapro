
<div align="center"style="color: white !important;" class="texto_cabecera superior horizontal-ticker horizontal-ticker-sections--20805847122201__2c2ec774-3430-481f-b927-e9c035b9d24e section-sections--20805847122201__2c2ec774-3430-481f-b927-e9c035b9d24e-padding">
<div  class="  horizontal-ticker__container ">

    <?php
     $sql   = "SELECT * FROM  horizontal  where posicion=1 or posicion is null";
     $query = mysqli_query($conexion, $sql);
     while ($row = mysqli_fetch_array($query)) {
         $texto       = $row['texto'];
   
     ?>
<p class=" horizontal-ticker__item">
       <?php echo $texto; ?>
      </p>
      <?php
              
     }
     ?>
      

      </div>  
      
</div>