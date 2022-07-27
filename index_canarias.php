
<?php
	include 'settings.php';	
	include 'funcionesEspeciales.php';
	require_once "validaUsuario.php";
	$ficheroCacheHistorico=settings::ficheroCacheHistorico;
	$ficheroCacheRealTime=settings::ficheroCacheRealTime;
	
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">   
	 <link rel="stylesheet"  type = "text/css" href="css/bootstrap.min.css">
	 <link rel="stylesheet"  type = "text/css" href="js/leaflet.css">
	 <link rel="stylesheet"  type = "text/css" href="css/estilos.css">
	 <script src="js/leaflet.js"></script>	
	 <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	  

	
</head>
<body>

<div id="mapCanarias" >


<script>

	var map2 = L.map('mapCanarias').setView([
		<?php
		 echo settings::latLongitudInicialMiniatura; //-34.567200,-58.562193
		 ?>
		], 6);
	map2.options.minZoom = 6;
	var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 18,
		attribution:false
	}).addTo(map2);
	
	
	var circle;
	var marker;
	var marker2;
	bounds = L.latLngBounds();
	var iconoAlarmaTiempoReal = new L.Icon({
  	iconUrl: 'police-siren-siren.gif',//police-siren-siren.gif',
  	iconSize: [20, 20],
  	iconAnchor: [20, 20]
}); 

	var iconoDeMoto = new L.Icon({
  	iconUrl: 'motos-gif-fazendo-curva.gif',
  	iconSize: [60, 60],
  	iconAnchor: [30, 30]
});
	<?php

	

	
	$motos=0;
	$arrayAsociativoAlarmasTiempoReal=array();

	if (file_exists($ficheroCacheRealTime)) {
	$arrayAsociativoAlarmasTiempoReal=leerArchivoJson($ficheroCacheRealTime,'INFO');	
	$motos=dibujarPuntosEstados($arrayAsociativoAlarmasTiempoReal);
		
}	

   
	



	?>
	
	
	//map.fitBounds(bounds)// hace que el mapa se acomode para que se visualicen todos los marcadores
	
$('.leaflet-control-attribution').hide();
$('.leaflet-control-zoom-in').hide();
$('.leaflet-control-zoom-out').hide();
	



</script>
</div>

</body>
</html>

