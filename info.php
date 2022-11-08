<?php 
include_once "settings.php";
include_once "funcionesEspeciales.php";


//echo '<div id="informativa">fffff</div>';
echo '<div id="informativa2">...</div>';
$diferenciaSegundosRestantesReal=(settings::tiempoConsultaficheroRealtime-antiguedadArchivo(settings::ficheroCacheRealTime));
$diferenciaHistorico=(settings::tiempoConsultaficheroHistorico-antiguedadArchivo(settings::ficheroCacheHistorico));
$ficheroCacheRealTime=settings::ficheroCacheRealTime;
	 //realtime
     $mensaje=settings::labelFicheroCacheRealTime.':'.(settings::tiempoConsultaficheroRealtime-antiguedadArchivo(settings::ficheroCacheRealTime)).' SEG ' ;
	 $mensajeAntiguedadRealTime=$mensaje;
	 //historico
	 $mensaJeHistorico= settings::labelFicheroCacheHistorico.':'.(settings::tiempoConsultaficheroHistorico-antiguedadArchivo(settings::ficheroCacheHistorico)).' SEG' ;
 

if(!file_exists($ficheroCacheRealTime)||$diferenciaSegundosRestantesReal<=0 // si no existe o si el archivo ya es viejo
){
	
    
   // echo "REFRESCANDO ARCHIVO ".settings::labelFicheroCacheRealTime;
	
    recargarFicheroRealTimeAsync();// recargar archivo desde base de datos
    mostrarMensajeInformativo('Buscando información nueva ',$mensaJeHistorico);
	
	
	
    }else{ // si el archivo existe y todavía es nuevo
	
		if(antiguedadArchivo(settings::ficheroCacheRealTime)<=1){// si es muy reciente, recién cargado, refrescar página.
			recargarPagina();
		}
		mostrarMensajeInformativo($mensaje,$mensaJeHistorico);
	
		if(esArchivoSinInformación()==true){
			
			
			 $mensaje="SIN INFORMACIÓN, PROBANDO CADA 10. SEGUNDOS";
			 mostrarMensajeInformativo($mensaje,$mensaJeHistorico);
		
		
			   recargarFicheroRealTimeAsync();
			    $mensaje="Recargando";
			 
			 mostrarMensajeInformativo($mensajeAntiguedadRealTime,$mensaJeHistorico);
			 sleep(2);
			 mostrarMensajeInformativo('La query no trajo datos',$mensaJeHistorico);
			 sleep(2);
			 mostrarMensajeInformativo('Reintentando obtener datos',$mensaJeHistorico);
			 sleep(6);
		 }
       
    }	

	/*
if(!file_exists(settings::ficheroCacheRealTime)){//Si no existe el archivo, en general cuando la query no trae datos, ejecutar de nuevo.
		 echo "REFRESCANDO ARCHIVO ".settings::labelFicheroCacheRealTime;
		  echo "<script>window.location.reload();</script>";//recargar para que aparezca vacío
		recargarFicheroRealTimeAsync();
		
		 //acá esperar la recarga definida en el setting.
		 
		
		
		}	
		*/
	
	
if($diferenciaHistorico<=0 
||
(antiguedadArchivo(settings::ficheroCacheHistorico)>=settings::tiempoConsultaficheroHistorico+10)
|| 
!file_exists(settings::ficheroCacheHistorico)
){

    echo "REFRESCANDO ARCHIVO ".settings::labelFicheroCacheHistorico;
    recargarFicheroHistoricoAsync();
    echo "<script>window.location.reload();</script>";
}else{
    // echo settings::labelFicheroCacheHistorico.':'.     
     //   (settings::tiempoConsultaficheroHistorico-antiguedadArchivo(settings::ficheroCacheHistorico)).' SEG' ;
}





 ?>
