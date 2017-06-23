$(document).ready(function(){
				
	var url = "ws_conecta.php";
	
	var datos = {
		metodo: "StartSession"
	}
	
	$.post(url,datos,function(data){
		
		$("#ConnectionId").val(data);
		$('#inicio_sesion').html('Sesion Iniciada correctamente');			
	})
	
	$('#ver_servicios').on('click',function(){
		
		var datos2 = {
			
			metodo: "GetByFechaOrigenDestino",
			ConnectionId: $('#ConnectionId').val(),
			IdParadaOrigen: $('#IdParadaOrigen').val(),
			IdParadaDestino: $('#IdParadaDestino').val(),
			FechaBusqueda: $('#FechaBusqueda').val()
		}
		
		$.post(url,datos2,function(data){
			$('#servicios').html(data);				
		})
		
	})
	
	
	
})