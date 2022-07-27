<?php 
include_once "settings.php";
include_once "funcionesEspeciales.php";


$diferenciaSegundosRestantesReal=(settings::tiempoConsultaficheroRealtime-antiguedadArchivo(settings::ficheroCacheRealTime));
$diferenciaHistorico=(settings::tiempoConsultaficheroHistorico-antiguedadArchivo(settings::ficheroCacheHistorico));
 //echo "<script>console.log(map.getZoom());</script>";
if($diferenciaSegundosRestantesReal<=0 
//|| (antiguedadArchivo(settings::ficheroCacheRealTime)>=settings::tiempoConsultaficheroRealtime+10)
){
    
    echo "REFRESCANDO ARCHIVO ".settings::labelFicheroCacheRealTime;
    recargarFicheroRealTimeAsync();
    echo "<script>window.location.reload();</script>";
    }else{
        echo settings::labelFicheroCacheRealTime.':'.     
        (settings::tiempoConsultaficheroRealtime-antiguedadArchivo(settings::ficheroCacheRealTime)).' SEG ' ;


       
    }
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
     echo settings::labelFicheroCacheHistorico.':'.     
        (settings::tiempoConsultaficheroHistorico-antiguedadArchivo(settings::ficheroCacheHistorico)).' SEG' ;
}





 ?>
