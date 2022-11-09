
<?php
	include 'settings.php';	
	include "sqlServer.php";
	include 'funcionesEspeciales.php';
	require_once "validaUsuario.php";
	
	$ficheroCacheHistorico=settings::ficheroCacheHistorico;
	$ficheroCacheRealTime=settings::ficheroCacheRealTime;
	
?>	
<!DOCTYPE html>
<html lang="es">
<head>


	
     <meta name="viewport" content="width=device-width, initial-scale=1.0">   
	 <link rel="stylesheet"  type = "text/css" href="css/bootstrap.min.css">
	 <link rel="stylesheet"  type = "text/css" href="js/leaflet.css">
	 <link rel="stylesheet"  type = "text/css" href="css/estilos.css">
	 <script src="js/leaflet.js"></script>	
	 <script src="js/leafletMarkerCluster.js"></script>	
 
	 
	 
	 <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	 <link rel="icon" href="prosegur.png">  
	 <title>GEOALARMAS 2.0</title>

	
</head>
<body>

<div id="map" >


<!--<div id="canarias"></div> HABILITAR ESTE COMENTARIO PARA ESPAÑA-->

<script>

	var map = L.map('map').setView([
		<?php
		 echo settings::getLatLongitudInicial(); //-34.567200,-58.562193
		 ?>
		], 7.3);
	
	var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 18,
		attribution:false
	}).addTo(map);
	
	let lat_lng;
	var circle;
	var marker;
	var marker2;
	bounds = L.latLngBounds();
	var iconoAlarmaTiempoReal = new L.Icon({
  	iconUrl: '<?php echo settings::iconoAlarma?>',
  	iconSize: [30, 30],
  	iconAnchor: [30, 30]
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
	$motos=dibujarPuntos($arrayAsociativoAlarmasTiempoReal);

		
		
}else{
	recargarFicheroRealTimeAsync();
	
	
	
}

	

	$arrayAsociativoAlarmasHistorico=array();

	
	if (file_exists($ficheroCacheHistorico)) {
	$arrayAsociativoAlarmasHistorico=leerArchivoJson($ficheroCacheHistorico,'INFO');//$instanciaSql->obtenerDatos(

	
	dibujarCirculos(
		$arrayAsociativoAlarmasHistorico,
		settings::tamanioCirculoHistorico1
	);
}
	if(settings::mapaAjustarApuntos==true){
	echo "map.fitBounds(bounds)";
	}

	?>
	
	
	//map.fitBounds(bounds)// hace que el mapa se acomode para que se visualicen todos los marcadores
	

	 

	



</script>
</div>
<nav id="menuHamburguesa">
  <input type="checkbox" id="menu">
  <label for="menu"> ☰ </label>
  <ul>
    <li><a href="filtroContrato.php">Filtrar Contratos</a></li>
  
  </ul>
</nav>

<div id="info">
<?php
mostrarEtiquetaInformativa($arrayAsociativoAlarmasTiempoReal,$motos,$arrayAsociativoAlarmasHistorico);
?>
<div id="info2">

</div>
<img id="logo" src = 'prosegur.png' />

</div>

<script>


$(document).ready(function() {
      var refreshId =  setInterval( function(){
    $('#info2').load('info.php');//actualizas el div
   }, 1000 );
});
/*$(document).ready(
	function(){
	$('#canarias').load('index_canarias.php');	
	ocultarMiniMapaSiCorresponde();
	
	}
	);  
	$('.leaflet-control-attribution').hide();
	*/


 //let canar = document.getElementById('canarias');

 /*canar.addEventListener('click',
 function(){
	 map.flyTo([28.417209, -16.161493], 8);
	 ocultarMiniMapaSiCorresponde();
 }
 );		
 mapa.addEventListener('wheel',
 function(){
	ocultarMiniMapaSiCorresponde();
	
 }
 );
 mapa.addEventListener('click',
 function(){
	ocultarMiniMapaSiCorresponde();
	
 }
 );
 function ocultarMiniMapaSiCorresponde(){
	 if(map.getZoom()==6){
	 canar.style.visibility = "visible";
	 
	 }else{
	canar.style.visibility = "hidden";
	
	 }
 }*/ 


</script>

</html>
