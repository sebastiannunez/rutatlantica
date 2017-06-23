<?php

/*$Username = $_POST['Username'];
$Password = $_POST['Password'];
$CodigoWebId = $_POST['CodigoWebId'];
$Key = $_POST['Key']; */

$Username="VENTARTA";
$Password="VENTARTA";
$CodigoWebId=354;
$WebAgenciaId=2086;
$Key="410E5313-25AC-442E-AA3E-C7B067CE26E9";
$post_opt_base="Username=$Username&Password=$Password&CodigoWebId=$CodigoWebId&Key=$Key";
//echo "$post_opt_base"; exit();

$metodo = $_POST['metodo'];

switch ($metodo) {
	
	case 'StartSession':
		
		$request =  "http://www.sittnet.com:8053/prosys.integra.asmx/StartSession";
		$session = curl_init($request);
		curl_setopt($session, CURLOPT_POST, 1);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_POSTFIELDS, $post_opt_base);
		
		$response = curl_exec($session);
		curl_close($session);
			
		//echo "$response";
		
		if (!($xml = strstr($response, '<?xml'))) { $xml = null; die('Inicio Sesion Fallo'); }
			$doc = new DOMDocument('1.0');
			$doc->LoadXML($xml);
			$ok = $doc->getElementsByTagName( "IsOk" );
			$todobien = $ok->item(0)->nodeValue;
			
			if($todobien=="true"){ 
			 
				$temp = $doc->getElementsByTagName( "ConnectionId" );
				$ConnectionId = $temp->item(0)->nodeValue;
				$post_opt_base = $post_opt_base."&Conexion=".$ConnectionId;
				
				echo "$ConnectionId"; 
			}
			else{
				echo "Inicio Sesion Fallo";	
			}
		
		break;
		
	case 'GetByFechaOrigenDestino':
		
		/***************** SERVICIOS *****************/
		
		$ConnectionId = $_POST['ConnectionId'];
		$IdParadaOrigen = $_POST['IdParadaOrigen'];
		$IdParadaDestino = $_POST['IdParadaDestino'];
		$FechaBusqueda = $_POST['FechaBusqueda'];
		
		
		$request =  "http://www.sittnet.com:8053/prosys.integra.asmx/GetByFechaOrigenDestino";
		
		$postop=$post_opt_base."&Conexion=".$ConnectionId."&WebAgenciaId=".$WebAgenciaId."&IdParadaOrigen=".$IdParadaOrigen."&IdParadaDestino=".$IdParadaDestino."&FechaBusqueda=".$FechaBusqueda;
		$session = curl_init($request);
		curl_setopt($session, CURLOPT_POST, 1);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_POSTFIELDS, $postop);
		$response2 = curl_exec($session);
		curl_close($session);
			
		//echo htmlentities( $response2);
	 	if (!($xml2 = strstr($response2, '<?xml'))) { $xml2 = null; die('Documento invalido'); }
	    $doc2 = new DOMDocument('1.0');
		$doc2->LoadXML($xml2);
		$servicios = $doc2->getElementsByTagName( "Servicio" );
		$i=1;
		//echo "llegue";
		
		echo "<script src='js/servicio.js'></script>
			  <table id='tab_servicios' class='table'>
				<thead>
					<tr class='info'>
						<th>Empresa</th>
						<th>HoraSalida</th>
						<th>HoraLlegada</th>
						<th>CLASE</th>
						<th>BUTACAS LIBRES</th>
						<th>Precio</th>
						<th>Comprar</th>
					</tr>
				</thead>
				<tbody>";
		
		foreach( $servicios as $servicio )
		{
		   $ServiceId[$i]=$servicio->getAttribute("idServicio");
		   $Salida[$i]=$servicio->getElementsByTagName( "HoraSalida" )->item(0)->nodeValue;
		   $Clase[$i]=$servicio->getElementsByTagName( "Clase" )->item(0)->nodeValue;
		   $Precio[$i]=$servicio->getElementsByTagName( "Precio" )->item(0)->nodeValue;
		   $Empresa[$i]=$servicio->getElementsByTagName( "Empresa" )->item(0)->nodeValue;
		   $Empresa[$i]=$servicio->getElementsByTagName( "Empresa" )->item(0)->nodeValue;
		   
		   $HoraSalida[$i]=$servicio->getElementsByTagName( "HoraSalida" )->item(0)->nodeValue;
		   $HoraLlegada[$i]=$servicio->getElementsByTagName( "HoraLlegada" )->item(0)->nodeValue;
		   
		   $values = explode(' ',$servicio->getElementsByTagName( "ButacasLibres" )->item(0)->nodeValue);
		   $Libres[$i]=$values[1];
		   
		   //plataforma 10: empresa | salida | llegada  | duracion | comodidad | disponibilidad | precio 
		   //echo "Empresa: ".$Empresa[$i]." HoraSalida: ".$HoraSalida[$i]." HoraLlegada: ".$HoraLlegada[$i]."- CLASE: <b>".$Clase[$i]."</b> - BUTACAS LIBRES: <b>".$Libres[$i]."</b> - Precio:<b>".$Precio[$i]."</b> ";		   
		   //echo "<br/><hr/>";
		   
		   echo "	<tr>
						<td>$Empresa[$i]</td>
						<td>$HoraSalida[$i]</td>
						<td>$HoraLlegada[$i]</td>
						<td>$Clase[$i]</td>
						<td>$Libres[$i]</td>
						<td>$Precio[$i]</td>	
						<td><a id='$ServiceId[$i]' class='btn btn-danger btn_comprar'><i class='fa fa-check-square' aria-hidden='true'></i>&nbsp; Comprar</a></td>					
					</tr>";
		   $i++;
		} 
		
		echo "</tbody>
			</table>
			
			";
		$servicio_actual = $ServiceId[3] ;
		
	break;		
	
	case 'GetServiceData':
		
		$servicio_actual = $_POST['servicio_actual'] ;
		$ConnectionId = $_POST['ConnectionId'] ;
		
		$request = "http://www.sittnet.com:8053/prosys.integra.asmx/GetServiceData";
		$postop=$post_opt_base."&Conexion=".$ConnectionId."&ServiceId=".$servicio_actual;
		
		$session = curl_init($request);
		curl_setopt($session, CURLOPT_POST, 1);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_POSTFIELDS, $postop);
		$response3 = curl_exec($session);
		curl_close($session);
		//echo "<br><br>$response3<br><br>";				
		
		if (!($xml2 = strstr($response3, '<?xml'))) { $xml2 = null; die('Documento invalido'); }
	    $doc2 = new DOMDocument('1.0');
		$doc2->LoadXML($xml2);
		
		$qualities=$doc2->getElementsByTagName( "Qualities" );
		
		foreach( $qualities as $quality ){
		
			$calidad=$quality->getElementsByTagName( "Codigo" )->item(0)->nodeValue;
			$Descripcion=$quality->getElementsByTagName( "Descripcion" )->item(0)->nodeValue;
			
		}
		
		//Armado de PLANTA
		$seats = $doc2->getElementsByTagName( "Seats" );
		$Floors = $doc2->getElementsByTagName( "Floors" );
		
		$planta ="";
		$z = 0;
		$col = 0;
		$fila = 0;
		
		$planta.= "<script src='js/plantas.js'></script>
				   <table id='tab_primerPiso' class='table'>
						<thead>
						</thead>
						<tbody>
							<tr>";
		
		foreach( $seats as $seat ){
			
			$type=$seat->getElementsByTagName( "Type" )->item(0)->nodeValue;
			$status=$seat->getElementsByTagName( "Status" )->item(0)->nodeValue;
			$text=$seat->getElementsByTagName( "Text" )->item(0)->nodeValue;
			
			if(floor($z/5)==$z/5){				
				$planta.= "</tr><tr>";
				$fila++;								
			}	
			
			if($col==5){
				$col=1 ;
			}else{
				$col++;
			}
			
			switch ($type) {
					
					case 'Undefined':
							
							if($text=='WC'){
								
								$planta.= "<td><img src='image/bano.png' /></td>";
							}else{
								$planta.= "<td>".$text."</td>";	
							}
						
						break;
					
					case 'Seat':
							
							if($status=="Free"){
								$planta.= "<td><a href='#ventana1' class='p_primer_piso' data-text='$text' data-fila='$fila' data-col='$col' data-toggle='modal'><img src='image/seat.png' />".$text."</a></td>";	
							}else{
								$planta.= "<td><span><img src='image/seat_taken.png' />".$text."</span></td>";
							}
							
						break;
					
					case 'TV':
							
							$planta.= "<td><img src='image/tv.png' /></td>";
							
						break;
					
					case 'Phone':
							
							$planta.= "<td><img src='image/atencion.png' /></td>";
							
						break;
					
					case 'Bar':
							
							$planta.= "<td><img src='image/bar.png' /></td>";
							
						break;
						
					case 'Stairs':
							
							$planta.= "<td><img src='image/stairs.png' /></td>";
							
						break;
					
					default:
							
						break;
				}
			
			$z++;
			
			
			
		}
		
		$planta.= "<tbody>
				</table>";
		//FIN ARMADO DE PLANTA		
		
		echo $planta ;
		
	break;
	
	default:
		
		break;
}

?>