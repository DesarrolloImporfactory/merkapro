<section class="bg-light py-5">
        <div class="container my-4">
            <div class="row text-center py-3">
                <div class="col-lg-6 m-auto">
                    <h1 class="h1">Testimonios</h1>
                    <p>
                 
                    </p>
                </div>
                <div class="col-lg-9 m-auto tempaltemo-carousel">
                    <div class="row d-flex flex-row">
                        <!--Controls-->
                        <div class="col-1 align-self-center">
                            <a class="h1" href="#multi-item-example" role="button" data-bs-slide="prev">
                                <i class="text-light fas fa-chevron-left"></i>
                            </a>
                        </div>
                        <!--End Controls-->

                        <!--Carousel Wrapper-->
                        <div class="col">
                            <div class="carousel slide carousel-multi-item pt-2 pt-md-0" id="multi-item-example" data-bs-ride="carousel">
                                <!--Slides-->
                                <div class="carousel-inner product-links-wap" role="listbox">

                                    <!--First slide-->
                                                <?php
$sql2="select * from testimonios ";
$query2 = mysqli_query($conexion, $sql2);
$contador_testimonio=1;
$bandera_testimonio='active';
 $rowcount=mysqli_num_rows($query2);
 //echo $rowcount;
 $i=1;
while ($row2 = mysqli_fetch_array($query2)) {
    
    
//echo $contador_testimonio;
    $id_testimoniio       = $row2['id_testimonio'];
            $nombre    = $row2['nombre'];
            $testimonio    = $row2['testimonio'];
           
            $image_path           = $row2['imagen'];
            if ($contador_testimonio==1){
                echo "<div class='carousel-item $bandera_testimonio'><div class='row'>";
                }
                ?> 
                                    <div class="col-md-4 col-sm-1 p-md-5">
                                                <a href="#"><img style="border-radius: 75%; height: 100px; width: 100px " class="" src="sysadmin/<?php  echo str_replace ( "../.." , "" , $image_path  )?>" alt="Brand Logo"></a>
                                                <br>
                                                <br>
                                                <p style="font-size: 11px !important"><?php echo $testimonio; ?><br>
                                                <strong style=" font-size: 13px !important"> <?php echo $nombre; ?></strong></p>
                                                 
                                            </div>
                                     <?php
              if ($contador_testimonio==3){
                echo '</div></div>';
                $contador_testimonio=0;
                $bandera_testimonio='';
            }
            
            if ($i==$rowcount){
               if ($i % 3 !== 0) {
                echo '</div></div>';   
               }
            }
            $contador_testimonio++;
            $i++;
            
            //echo $image_path;
} 

    ?>
                                    
                                  
                                    
                                    <!--End Third slide-->

                                </div>
                                <!--End Slides-->
                            </div>
                        </div>
                        <!--End Carousel Wrapper-->

                        <!--Controls-->
                        <div class="col-1 align-self-center">
                            <a class="h1" href="#multi-item-example" role="button" data-bs-slide="next">
                                <i class="text-light fas fa-chevron-right"></i>
                            </a>
                        </div>
                        <!--End Controls-->
                    </div>
                </div>
                
                
            </div>
        </div>
    </section>