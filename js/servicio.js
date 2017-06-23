$(function(){
		
	$('.btn_comprar').on('click',function(){
						
		var url = 'ws_conecta.php';							
		var servicio = $(this).attr('id');
		var ConnectionId = $('#ConnectionId').val();
		
		var datos = {
			
			metodo: 'GetServiceData',
			servicio_actual: servicio,
			ConnectionId: ConnectionId
		}
		
		$.post(url,datos,function(data){
			
			var posicion_div = $('#titulo_planta').offset().top;
			$("html, body").animate({scrollTop:posicion_div+"px"});
			
			$('#primer_piso').css('background-color','white');
			$('#primer_piso').css('color','black');
			$('#planta_baja').css('background-color','white');
			$('#planta_baja').css('color','black');
			$('#ls_pasajeros').css('background-color','white');
			$('#ls_pasajeros').css('color','black');
			
			$('#primer_piso').html("<h3 class='headers_planta'>Primer Piso</h3><br>"+data);
			$('#planta_baja').html("<h3 class='headers_planta'>Planta Baja</h3><br>");
			$('#ls_pasajeros').html("<h3 class='headers_planta'>Lista de pasajeros</h3><br>");	
						
		})
		
		
	})
	
})

