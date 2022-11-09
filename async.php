<?php

include "funcionesEspeciales.php";
include_once "settings.php";




if ($argv[1]=='realtime'){
	obtenerDatosAJson(settings::getFicheroRealTime(),settings::ficheroCacheRealTime);
}
if($argv[1]=='historico'){
	obtenerDatosAJson(settings::getFicheroHistorico(),settings::ficheroCacheHistorico);
}







?>


