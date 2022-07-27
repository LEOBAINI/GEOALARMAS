<?php

include_once "sqlServer.php";

/*
Devuelve la antiguedad en segundos de un archivo determinado.
Lo hace restando el timestamp de creación, vs la hora actual.
*/
 function antiguedadArchivo($archivo){
	 $antig=0;
	 if (file_exists($archivo)){
 	$archivoFecha=date (filemtime($archivo));
	$ahoraFecha=date(time());
    
	$antig= $ahoraFecha-$archivoFecha;
	 }
	 return $antig;

 }
/*
Recibe un array asociativo que debe contener las palabras latitude y longitude para poder dibujar.
El color y ancho, se manejan desde el archivo settings.php
*/

 function dibujarCirculos($row,$radius){
    if(!empty($row)){
    foreach($row as $fila) {
      if($fila["latitude"]!=null && $fila["longitude"]!=null){

     
     echo   'circle=L.circle(['.$fila["latitude"].','.$fila["longitude"].'], {';
     echo   'color: "'.$fila["color"].'",';
     echo   'fillColor: "'.$fila["color"].'",';
     echo   'fillOpacity: 0.2,';
     echo   'radius: '.$radius;
     echo   '}).addTo(map).bindPopup("'

        .'contrato:'.$fila["contrato"].'<br>'
      //  .'site_name:'.$fila["site_name"].'<br>'
        .'latitude:'.$fila["latitude"].'<br>'
        .'longitude:'.$fila["longitude"].'<br>'  
        .'date:'.$fila["alarm_server_date"]["date"].'<br>' 
        
        
        .'");';
     
     echo "\n";
    }
} 
}
}


function dibujarMarcadores($row){//L.marker([51.5, -0.09]).addTo(map)
foreach($row as $fila) {
     echo   'marker2=L.marker(['.$fila["latitude"].','.$fila["longitude"].'], {';
     echo   'color: "orange",';
    // echo 'fillColor: "#f03",';
     echo   'fillOpacity: 0.01,';
     echo   'radius: 60';
     echo   '}).addTo(map);';
     echo "\n";
    }
}
/*
Es la etiqueta que aparece en la barra inferior
*/
function mostrarEtiquetaInformativa($cantidadAlarmasRealTime,$cantidadJobsAbiertos,$cantidadHistoricos){
    if(empty($cantidadHistoricos)){
        $cantidadHistoricos[]='';
    }

    echo settings::etiquetaAlarmasRealTime." : "
    .count($cantidadAlarmasRealTime)." || "
    .settings::etiquetaJobsAbiertos." : ".
    $cantidadJobsAbiertos." || "
    .settings::etiquetaHistoricos." : ".count($cantidadHistoricos);
     
     echo '<div id="salir"><a href="salir.php">SALIR</a></div>';
	
    }
    
/*
Dibuja las alarmas en tiempo real, en caso de job abierto, se dibuja una moto.
Devuelve la cantidad de jobs abiertos para luego poder ser usado por el contados de jobs abiertos que se muestra
en la etiqueta
*/
function dibujarPuntos($row){
    $motos=0;
	$estadosNoMostrar=array();//antes 'LP ','TEN'
    
    foreach($row as $fila) {
        if(!in_array($fila["state_id"],$estadosNoMostrar)){
        echo 'lat_lng = ['.$fila["latitude"].','.$fila["longitude"].'];';
        echo "\n";
        echo 'L.marker(lat_lng,{icon:'; 
        if($fila["job_no"]==''){
            echo    'iconoAlarmaTiempoReal';
        }else{
            echo    'iconoDeMoto';
            $motos=$motos+1;
        }
        
        echo '}).addTo(map).bindPopup("'

        .'descr:'.$fila["descr"].'<br>'
        .'contrato:'.$fila["contrato"].'<br>'
        .'job_no:'.$fila["job_no"].'<br>'
        .'geo_code:'.$fila["geo_code"].'<br>'
        .'tipo_eventos:'.$fila["geo_code"].'<br>'
		.'state_id:'.$fila["state_id"].'<br>'
        .'alarm_date:'.$fila["alarm_date"].


        '",{autoClose:';

        echo settings::getAutoClose();// si se cierra auto los pop ups o no

        echo '});';
        echo "\n";
        
        echo 'bounds.extend(lat_lng)';
        echo "\n";
		}
    }
    return $motos;
}

function dibujarPuntosEstados($row){
    $motos=0;
	$estadosNoMostrar=array('LP ','TEN');
    
    foreach($row as $fila) {
        if(in_array($fila["state_id"],$estadosNoMostrar)){
        echo 'lat_lng = ['.$fila["latitude"].','.$fila["longitude"].'];';
        echo "\n";
        echo 'L.marker(lat_lng,{icon:'; 
        if($fila["job_no"]==''){
            echo    'iconoAlarmaTiempoReal';
        }else{
            echo    'iconoDeMoto';
            $motos=$motos+1;
        }
        
        echo '}).addTo(map2).bindPopup("'

        .'descr:'.$fila["descr"].'<br>'
        .'contrato:'.$fila["contrato"].'<br>'
        .'job_no:'.$fila["job_no"].'<br>'
        .'geo_code:'.$fila["geo_code"].'<br>'
        .'tipo_eventos:'.$fila["geo_code"].'<br>'
		.'state_id:'.$fila["state_id"].'<br>'
        .'alarm_date:'.$fila["alarm_date"].


        '",{autoClose:';

        echo settings::getAutoClose();// si se cierra auto los pop ups o no

        echo '});';
        echo "\n";
        
        echo 'bounds.extend(lat_lng)';
        echo "\n";
		}
    }
    return $motos;
}
/*
Devuelve el array asociativo correspondiente a los objetos formados en el json
Lo hace posible el parámetro true de json_decode($eventos_json, true); 
*/
function leerArchivoJson($rutaAlArchivo,$NombreIndex){

    $eventos_json = file_get_contents($rutaAlArchivo); 
    $decoded_json = json_decode($eventos_json, true); 
    $eventos = $decoded_json[$NombreIndex];
    return $eventos;
}
/*function recargarHistorico(){
    $ficheroHistorico=settings::ficheroCacheHistorico;
        if (file_exists($ficheroHistorico)) {

            if(antiguedadArchivo($ficheroHistorico)>settings::tiempoConsultaficheroHistorico){// cada 30 minutos
              recargarJson(settings::getFicheroHistorico(),$ficheroHistorico);
             }
        }else{// si no existe, crear

             recargarJson(settings::getFicheroHistorico(),$ficheroHistorico);
        }
}*/

function recargarFicheroRealtime(){
    
    $ficheroCacheRealTime=settings::ficheroCacheRealTime;
    if(file_exists($ficheroCacheRealTime)){

         if(antiguedadArchivo($ficheroCacheRealTime)>settings::tiempoConsultaficheroRealtime){
            
            recargarJson(settings::getFicheroRealTime(),$ficheroCacheRealTime);
           
        }// fin si supera la antiguedad
    }//fin si existe fichero

    else{
           
            recargarJson(settings::getFicheroRealTime(),$ficheroCacheRealTime);
        }
}

function recargarFicheroRealTimeAsync(){
   $cmd='php async.php realtime';
  

    $ficheroCacheRealTime=settings::ficheroCacheRealTime;
    if(file_exists($ficheroCacheRealTime)){

         if(antiguedadArchivo($ficheroCacheRealTime)>settings::tiempoConsultaficheroRealtime){
            
           
          exec($cmd);
           
        }// fin si supera la antiguedad
    }//fin si existe fichero

    else{
           
         
          exec($cmd);


        }
    


}

function recargarFicheroHistoricoAsync(){
   $cmd='start /b historico.bat';//'php async.php historico';
   

    $ficheroCacheHistorico=settings::ficheroCacheHistorico;
    if(file_exists($ficheroCacheHistorico)){

         if(antiguedadArchivo($ficheroCacheHistorico)>settings::tiempoConsultaficheroHistorico){
            
           copy($ficheroCacheHistorico, 'historico.tmp');
           unlink($ficheroCacheHistorico);
           copy('historico.tmp', $ficheroCacheHistorico);
           unlink('historico.tmp');
           exec($cmd);
           
           
        }// fin si supera la antiguedad
    }//fin si existe fichero

    else{
           
         
           exec($cmd);


        }
    


}

/*
Obtiene un query, y un archivo destino donde escribir.
*/
function recargarJson($ficheroQuery,$archivoDestino){
    $instanciaSqlServer=new  miconexion();
    $instanciaSqlServer->obtenerDatosAJson($ficheroQuery,$archivoDestino);
}


function escribir_consola($data) {
 $console = $data;
 if (is_array($console))
 $console = implode(',', $console);

 echo "console.log('Console: " . $console . "' );";
}
function escribirLog($archivo,$texto){
    $fp = fopen($archivo, 'a');//opens file in append mode  
    fwrite($fp, $texto);  
    fclose($fp);  
}


function calcularAntiguedadSegundos($fecha){
    $fechaTime=strtotime($fecha);
    return time()-$fechaTime;

}
function calcularAntiguedadMinutos($fecha){
    
    return calcularAntiguedadSegundos($fecha)/60;

}



 function obtenerDatosAJson($ficheroQuery,$nombreFichero){
    set_time_limit(13000);
  //  exec("doTask.php $arg1 $arg2 $arg3 >/dev/null 2>&1 &");


    include_once "lectorFichero.php";
    $instanciaSqlServer=new miconexion();
    $conn=$instanciaSqlServer->conectar();

    $instanciaFichero=new lectorFichero();
    $contenidoFichero=$instanciaFichero->leerFichero($ficheroQuery);
 
    $megaArray=array();
    $sql = $contenidoFichero;//"SELECT top 10 site_no,system_no from system";

    $result = sqlsrv_query($conn, $sql);

    if($result === false) {
    die(print_r(sqlsrv_errors(), true));
    }else{

    $i=0;   
    while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

    

   $resultados[]=$row;
   
  
  
}
sqlsrv_free_stmt($result);  
sqlsrv_close($conn);
}

$CODIFICADO=json_encode(['INFO' => $resultados]);
$CODIFICADO=str_replace('\\"',"",$CODIFICADO);//Quitar los strings que tienen contrabarra y comillas dobles..

//!empty($arreglo);
if($CODIFICADO!='{"INFO":null}'){
file_put_contents($nombreFichero,$CODIFICADO);
}else{
    file_put_contents('Errores.log',$resultados);
}

}

 ?>
