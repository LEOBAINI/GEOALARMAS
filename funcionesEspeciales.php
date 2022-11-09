<?php

include_once "sqlServer.php";
include_once 'settings.php';



/*
Devuelve la antiguedad en segundos de un archivo determinado.
Lo hace restando el timestamp de creación, vs la hora actual.
*/
function antiguedadArchivo($archivo)
{
    $antig = 0;
    if (file_exists($archivo)) {
        $archivoFecha = date(filemtime($archivo));
        $ahoraFecha = date(time());

        $antig = $ahoraFecha - $archivoFecha;
    }
    return $antig;
}
function contarContratosEnArray($row, $contrato)
{
    $repeticiones = 0;
    foreach ($row as $fila) {
        if ($fila["contrato"] == $contrato) {
            $repeticiones++;
        }
    }
    return $repeticiones;
}
/*
Recibe un array asociativo que debe contener las palabras latitude y longitude para poder dibujar.
El color y ancho, se manejan desde el archivo settings.php
*/

function dibujarCirculos($row, $radius)
{


    if (!empty($row)) {
        foreach ($row as $fila) {

            if ($fila["latitude"] != null && $fila["longitude"] != null) {
                $repeticiones = contarContratosEnArray($row, $fila["contrato"]);
                if ($repeticiones >= settings::repeticiones) {
                    $fila["color"] = 'red';
                }

                imprimirCirculos($fila, $radius, $repeticiones);
            }
        }
    } // fin del for
    //  
}
//recargarPagina();

function imprimirCirculos($fila, $radius, $repeticiones)
{
    echo   'circle=L.circle([' . $fila["latitude"] . ',' . $fila["longitude"] . '], {';
    echo   'color: "' . $fila["color"] . '",';
    echo   'fillColor: "' . $fila["color"] . '",';
    echo   'fillOpacity: 0.2,';
    echo   'radius: ' . $radius;
    echo   '}).addTo(map).bindPopup("'
        . 'evento:' . $fila["descr"] . '<br>'
        . 'tipo evento:' . $fila["tipo_eventos"] . '<br>'
        . 'contrato:' . $fila["contrato"] . '<br>'
        . 'site_name:' . $fila["site_name"] . '<br>'
        . 'latitude:' . $fila["latitude"] . '<br>'
        . 'longitude:' . $fila["longitude"] . '<br>'
        . 'date:' . $fila["alarm_server_date"]["date"] . '<br>'
        . 'repeticiones:' . $repeticiones . '<br>'


        . '");';

    echo "\n";
}


function dibujarMarcadores($row)
{ //L.marker([51.5, -0.09]).addTo(map)
    foreach ($row as $fila) {
        echo   'marker2=L.marker([' . $fila["latitude"] . ',' . $fila["longitude"] . '], {';
        echo   'color: "orange",';
        // echo 'fillColor: "#f03",';
        echo   'fillOpacity: 0.01,';
        echo   'radius: 60';
        echo   '}).addTo(map);';
        echo "\n";
    }
    //recargarPagina();
}
/*
Es la etiqueta que aparece en la barra inferior
*/
function mostrarEtiquetaInformativa($cantidadAlarmasRealTime, $cantidadJobsAbiertos, $cantidadHistoricos)
{



    if (empty($cantidadHistoricos)) {
        $cantidadHistoricos[] = '';
    }
    if (settings::mostrarAcuda) {
        echo settings::etiquetaAlarmasRealTime . " : "
            . count($cantidadAlarmasRealTime) . " || "
            . settings::etiquetaJobsAbiertos . " : " .
            $cantidadJobsAbiertos . " || "
            . settings::etiquetaHistoricos . " : " . count($cantidadHistoricos);
    } else {
        echo settings::etiquetaAlarmasRealTime . " : "
            . count($cantidadAlarmasRealTime) . " || "
            . settings::etiquetaHistoricos . " : " . count($cantidadHistoricos);
    }
    echo '<div id="salir"><a href="salir.php">SALIR</a></div>';
}

/*
Dibuja las alarmas en tiempo real, en caso de job abierto, se dibuja una moto.
Devuelve la cantidad de jobs abiertos para luego poder ser usado por el contados de jobs abiertos que se muestra
en la etiqueta
*/
function dibujarPuntos($row)
{

    $motos = 0;
   // $estadosNoMostrar = array(); //antes 'LP ','TEN'

    foreach ($row as $fila) {
        echo 'lat_lng = [' . $fila["latitude"] . ',' . $fila["longitude"] . '];';
        echo "\n";
        echo 'L.marker(lat_lng,{icon:';
        if ($fila["job_no"] == '') {
            echo    'iconoAlarmaTiempoReal';
        } else {
            echo    'iconoDeMoto';
            $motos = $motos + 1;
        }

        echo '}).addTo(map).bindPopup("'

            . 'descr:' . $fila["descr"] . '<br>'
            . 'site_name:' . $fila["site_name"] . '<br>'
            . 'contrato:' . $fila["contrato"] . '<br>'
            . 'job_no:' . $fila["job_no"] . '<br>'
            . 'geo_code:' . $fila["geo_code"] . '<br>'
            . 'tipo_eventos:' . $fila["geo_code"] . '<br>'
            . 'state_id:' . $fila["state_id"] . '<br>'
            . 'alarm_date:' . $fila["alarm_date"] .


            '",{autoClose:';

        echo settings::getAutoClose(); // si se cierra auto los pop ups o no

        echo '});';
        echo "\n";

        echo 'bounds.extend(lat_lng)';
        echo "\n";
    }




    return $motos;
}
function imprimirPuntos($fila, $motos)
{
    echo 'lat_lng = [' . $fila["latitude"] . ',' . $fila["longitude"] . '];';
    echo "\n";
    echo 'L.marker(lat_lng,{icon:';
    if ($fila["job_no"] == '') {
        echo    'iconoAlarmaTiempoReal';
    } else {
        echo    'iconoDeMoto';
        $motos = $motos + 1;
    }

    echo '}).addTo(map).bindPopup("'

        . 'descr:' . $fila["descr"] . '<br>'
        . 'site_name:' . $fila["site_name"] . '<br>'
        . 'contrato:' . $fila["contrato"] . '<br>'
        . 'job_no:' . $fila["job_no"] . '<br>'
        . 'geo_code:' . $fila["geo_code"] . '<br>'
        . 'tipo_eventos:' . $fila["geo_code"] . '<br>'
        . 'state_id:' . $fila["state_id"] . '<br>'
        . 'alarm_date:' . $fila["alarm_date"] .


        '",{autoClose:';

    echo settings::getAutoClose(); // si se cierra auto los pop ups o no

    echo '});';
    echo "\n";

    echo 'bounds.extend(lat_lng)';
    echo "\n";
}

function dibujarPuntosEstados($row)
{
    $motos = 0;
    $estadosNoMostrar = array('LP ', 'TEN');

    foreach ($row as $fila) {
        if (in_array($fila["state_id"], $estadosNoMostrar)) {
            echo 'lat_lng = [' . $fila["latitude"] . ',' . $fila["longitude"] . '];';
            echo "\n";
            echo 'L.marker(lat_lng,{icon:';
            if ($fila["job_no"] == '') {
                echo    'iconoAlarmaTiempoReal';
            } else {
                echo    'iconoDeMoto';
                $motos = $motos + 1;
            }

            echo '}).addTo(map2).bindPopup("'

                . 'descr:' . $fila["descr"] . '<br>'
                . 'contrato:' . $fila["contrato"] . '<br>'
                . 'job_no:' . $fila["job_no"] . '<br>'
                . 'geo_code:' . $fila["geo_code"] . '<br>'
                . 'tipo_eventos:' . $fila["geo_code"] . '<br>'
                . 'state_id:' . $fila["state_id"] . '<br>'
                . 'alarm_date:' . $fila["alarm_date"] .


                '",{autoClose:';

            echo settings::getAutoClose(); // si se cierra auto los pop ups o no

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
function leerArchivoJson($rutaAlArchivo, $NombreIndex)
{

    $eventos_json = file_get_contents($rutaAlArchivo);
    $decoded_json = json_decode($eventos_json, true);
    $eventos = $decoded_json[$NombreIndex];

    return eventosFiltrados($eventos);
}
/*
Función que busca en el array de session si los contratos coinciden con el filtro, 
solo carga en memoria aquellos contratos cuya coincidencia sea true.
*/
function eventosFiltrados($eventos)
{
    $arrayFiltro = [];
    $arrayFiltrados = [];

    if (isset($_SESSION['contratos'])) {
        $arrayFiltro = $_SESSION['contratos'];
    }

    if (sizeof($arrayFiltro) == 0) { // si no hay filtros cargados, devolver mismo array
        return $eventos;
    } else {
        foreach ($eventos as $elemento) {
            //  var_dump($elemento);
            if (in_array($elemento["contrato"], $arrayFiltro)) {
                array_push($arrayFiltrados, $elemento);
            }
        }
        // var_dump($arrayFiltro);
        return $arrayFiltrados;
    }
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

function recargarFicheroRealtime()
{

    $ficheroCacheRealTime = settings::ficheroCacheRealTime;
    if (file_exists($ficheroCacheRealTime)) {


        // si corresponde por antiguedad, regargar de la base
        if (antiguedadArchivo($ficheroCacheRealTime) > settings::tiempoConsultaficheroRealtime) {

            recargarJson(settings::getFicheroRealTime(), $ficheroCacheRealTime);
        } // fin si supera la antiguedad
    } //fin si existe fichero

    else { //si archivo no existe recargar

        recargarJson(settings::getFicheroRealTime(), $ficheroCacheRealTime);
    }
}
function mostrarmensajePorConsola($mensaje)
{
?>
    <script>
        console.log(<?php echo $mensaje; ?>);
    </script>
<?php
}
// se encarga de ejecutar a la base, pero a prueba de ansiosos, si ya está ejecutando, a esperar, no vamos a romper la base.
function recargarFicheroRealTimeAsync()
{
    // $cmd='php async.php realtime';
    $cmd = 'realtimeFirstTime.bat';


    /* $ficheroCacheRealTime=settings::ficheroCacheRealTime;
    if(file_exists($ficheroCacheRealTime)){

         if(antiguedadArchivo($ficheroCacheRealTime)>settings::tiempoConsultaficheroRealtime){
			 */
    if (!file_exists('temporalReal.txt')) {

        //  mostrarmensajePorConsola("Ejecutando consulta a base");
        exec($cmd);
    }/*else{
		   mostrarmensajePorConsola("Ocupado, solo una consulta a la vez =)");
			}*/

    // }// fin si supera la antiguedad

    //  }//fin si existe fichero

    /*   else{
           
        mostrarmensajePorConsola("Ejecutando consulta");
         exec($cmd);
		
		 }*/
}

function recargarFicheroHistoricoAsync()
{
    $cmd = 'start /b historico.bat'; //'php async.php historico';


    $ficheroCacheHistorico = settings::ficheroCacheHistorico;
    if (file_exists($ficheroCacheHistorico)) {

        if (antiguedadArchivo($ficheroCacheHistorico) > settings::tiempoConsultaficheroHistorico) {

            copy($ficheroCacheHistorico, 'historico.tmp');
            unlink($ficheroCacheHistorico);
            copy('historico.tmp', $ficheroCacheHistorico);
            unlink('historico.tmp');
            exec($cmd);
        } // fin si supera la antiguedad
    } //fin si existe fichero

    else {


        exec($cmd);
    }
}

/*
Obtiene un query, y un archivo destino donde escribir.
*/
function recargarJson($ficheroQuery, $archivoDestino)
{
    //$instanciaSqlServer=new  miconexion();
    //$instanciaSqlServer->
    obtenerDatosAJson($ficheroQuery, $archivoDestino);
}


function escribir_consola($data)
{
    $console = $data;
    if (is_array($console))
        $console = implode(',', $console);

    echo "console.log('Console: " . $console . "' );";
}
function escribirLog($archivo, $texto)
{
    $fp = fopen($archivo, 'a'); //opens file in append mode  
    fwrite($fp, $texto);
    fclose($fp);
}


function calcularAntiguedadSegundos($fecha)
{
    $fechaTime = strtotime($fecha);
    return time() - $fechaTime;
}
function calcularAntiguedadMinutos($fecha)
{

    return calcularAntiguedadSegundos($fecha) / 60;
}

function recargarPagina()
{
    echo "<script>window.location.reload();</script>";
}

function obtenerDatosAJson($ficheroQuery, $nombreFichero)
{
    set_time_limit(60000);
    $CODIFICADO = '';
    $resultados = null;

    //  exec("doTask.php $arg1 $arg2 $arg3 >/dev/null 2>&1 &");


    include_once "lectorFichero.php";
    $instanciaSqlServer = new miconexion();
    $conn = $instanciaSqlServer->conectar();

    $instanciaFichero = new lectorFichero();
    $contenidoFichero = $instanciaFichero->leerFichero($ficheroQuery);

    $megaArray = array();
    $sql = $contenidoFichero; //"SELECT top 10 site_no,system_no from system";

    $result = sqlsrv_query($conn, $sql);
    echo $result;
    if ($result === false) {
        echo sqlsrv_errors();
        echo "No hay conexion...";
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "tratando de obtener datos...";


        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            echo "llenando datos..";
            echo '<br>';
            $resultados[] = $row;
        }
        echo "Finalizando carga de datos...";
        echo '<br>';

        sqlsrv_free_stmt($result);
        sqlsrv_close($conn);

        if (empty($resultados)) {
            echo '<br>';
            echo 'No hay resultados de esa query =(';
            echo '<br>';
        };
        $CODIFICADO = json_encode(['INFO' => $resultados]);
        echo $CODIFICADO;
        $CODIFICADO = str_replace('\\"', "", $CODIFICADO); //Quitar los strings que tienen contrabarra y comillas dobles..
    }


    //!empty($arreglo);
    if ($CODIFICADO != '{"INFO":null}') {
        file_put_contents($nombreFichero, $CODIFICADO);
    } else {
        if (file_exists($nombreFichero)) {
            unlink($nombreFichero);

            recargarPagina();
            //file_put_contents('Errores.log',$resultados);
        } else {
            //poner archivo vacio {"INFO":[]}
            $CODIFICADO = '{"INFO":[]}';
            //settings::tiempoConsultaficheroRealtime=30;
            file_put_contents($nombreFichero, $CODIFICADO);
            recargarPagina();
        }
    }
}
// Compara si el archivo tiene formato de vacio
function esArchivoSinInformación()
{
    $ficheroCacheRealTime = settings::ficheroCacheRealTime;
    $archivoRealTime = leerArchivoJson($ficheroCacheRealTime, 'INFO');

    if (sizeof($archivoRealTime) == 0) {
        return true;
    }
    return false;
}
function mostrarMensajeInformativo($mensaje, $mensaJeHistorico)
{
?>
    <script>
        document.getElementById("informativa2").innerHTML = "<?php echo $mensaje, ' || ', $mensaJeHistorico; ?>";
    </script>
<?php
}

?>