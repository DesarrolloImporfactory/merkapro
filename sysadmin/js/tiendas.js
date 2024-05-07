		$(document).ready(function() {
		    load(1);
		});

		function load(page) {
		    var q = $("#q").val();
		    $("#loader").fadeIn('slow');
		    $.ajax({
		        url: '../ajax/buscar_tienda.php?action=ajax&page=' + page + '&q=' + q,
		        beforeSend: function(objeto) {
		            $('#loader').html('<img src="../../img/ajax-loader.gif"> Cargando...');
		        },
		        success: function(data) {
		            $(".outer_div").html(data).fadeIn('slow');
		            $('#loader').html('');
		            $('[data-toggle="tooltip"]').tooltip({
		                html: true
		            });
		        }
		    })
		}
		$("#guardar_tienda").submit(function(event) {
                    alert('sd');
		    $('#guardar_datos').attr("disabled", true);
		    var parametros = $(this).serialize();
		    $.ajax({
		        type: "POST",
		        url: "../ajax/nueva_tienda.php",
		        data: parametros,
		        beforeSend: function(objeto) {
		            $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
		        },
		        success: function(datos) {
		            $("#resultados_ajax").html(datos);
		            $('#guardar_datos').attr("disabled", false);
		            load(1);
		            //resetea el formulario
		            $("#guardar_linea")[0].reset();
		            $("#nombre").focus();
		            //desaparecer la alerta
		            window.setTimeout(function() {
		                $(".alert").fadeTo(200, 0).slideUp(200, function() {
		                    $(this).remove();
		                });
		            }, 2000);
		        }
		    });
		    event.preventDefault();
		})
		$("#editar_linea").submit(function(event) {
		    $('#actualizar_datos').attr("disabled", true);
		    var parametros = $(this).serialize();
		    $.ajax({
		        type: "POST",
		        url: "../ajax/editar_tienda.php",
		        data: parametros,
		        beforeSend: function(objeto) {
		            $("#resultados_ajax2").html('<img src="../../img/ajax-loader.gif"> Cargando...');
		        },
		        success: function(datos) {
		            $("#resultados_ajax2").html(datos);
		            $('#actualizar_datos').attr("disabled", false);
		            load(1);
		            //desaparecer la alerta
		            window.setTimeout(function() {
		                $(".alert").fadeTo(200, 0).slideUp(200, function() {
		                    $(this).remove();
		                });
		            }, 2000);
		        }
		    });
		    event.preventDefault();
		})
                
                function obtener_datos(id) {
                  
		    var nombre = $("#nombre" + id).val();
		    var contacto = $("#contacto" + id).val();
		    var whatsapp = $("#whatsapp" + id).val();
                    var fecha_ingresa = $("#fecha_ingresa" + id).val();
                      
                    //alert(online)
                    var fecha_caduca = $("#fecha_caduca" + id).val();
                   
                    var fecha_actualza = $("#fecha_actualza" + id).val();
                    
                    var id_plan = $("#id_plan" + id).val();
                    
                    
                     
                    var url_imporsuit = $("#url_imporsuit" + id).val();
                    alert(url_imporsuit);
                     var carpeta = $("#carpeta" + id).val();
                    var dominio = $("#dominio" + id).val();
                    var carpeta_servidor = $("#carpeta_servidor" + id).val();
                    var email = $("#email" + id).val();
                    
                     var db_name = $("#db_name" + id).val();
                     var db_user = $("#db_user" + id).val();
                     var db_pass = $("#db_pass" + id).val();
                   
		    $("#mod_nombre").val(nombre);
		    $("#mod_contacto").val(contacto);
		    $("#mod_whatsapp").val(whatsapp);
		    $("#mod_id").val(id);
                    $("#mod_fecha_ingresa").val(fecha_ingresa);
                    $("#mod_fecha_caduca").val(fecha_caduca);
                    $("#mod_fecha_actualza").val(fecha_actualza);
                     $("#mod_id_plan").val(id_plan);
                      $("#mod_subdominio").val(url_imporsuit);
                     $("#mod_dominio").val(dominio);
                      $("#mod_carpeta").val(carpeta_servidor);
                       $("#mod_email").val(email);
                       
                        $("#mod_name").val(db_name);
                         $("#mod_user").val(db_user);
                         $("#mod_pass").val(db_pass);
                    
		}

