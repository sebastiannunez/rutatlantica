$(function(){
	
	$('td .p_primer_piso').on('click',function(){
		
		var text = $(this).data('text');
		var fila = $(this).data('fila');
		var col = $(this).data('col');
		
        //$('.modal-body').html('Fila:'+fila+'<br>Columna: '+col+'<br>Text (numero asiento): '+text);
		
		$('#pasaje_text').val(text);
		$('#pasaje_fila').val(fila);
		$('#pasaje_columna').val(col);
		
					
	})
	
	$('#btnGuardarPasajero').on('click',function(){
		
		var text = $('#pasaje_text').val();
		var fila = $('#pasaje_fila').val();
		var col = $('#pasaje_columna').val()-1;
		var nombres = $('#nombresId').val();
		var apellidos = $('#apellidosId').val();
		var nacionalidad = $('#NacionalidadId').val();
		var tipoDocId = $('#tipoDocId').val();
		var documentoId = $('#documentoId').val();
		
		var dibujo = $("#tab_primerPiso").find('tr:eq('+fila+')').find('td:eq('+col+')').html();		
		dibujo = dibujo.replace("image/seat.png", "image/seat_selected.png");
		
		$("#ls_pasajeros").append("<div class='row' data-fila="+fila+" data-col="+col+" data-text="+text+"  >" 
										+"<div class='col-md-2' style='margin: 10px 0px; padding-left: 0px; text-align: left; background-color: #c2c2c2;'>"+dibujo+"</div>"
										+"<div class='col-md-6' style='margin: 10px 0px; padding-left: 0px; text-align: left; background-color: #c2c2c2;'>"+apellidos+" "+nombres+"</div>"
										+"<div class='col-md-2' style='margin: 10px 0px; padding-left: 0px; text-align: left; background-color: #c2c2c2;'>AR$731</div>"
										+"<div class='col-md-2' style='margin: 10px 0px; padding-left: 0px; text-align: left; background-color: #c2c2c2;'><button class='btn btn-sm btn-warning'>Quitar</button></div>"
								  +"</div>");		
		
		
    
    
		
		$("#tab_primerPiso").find('tr:eq('+fila+')').find('td:eq('+col+')').html(dibujo);
		
		
		
	})
	
})