<?php
date_default_timezone_set("America/Argentina/San_Luis");
include 'funcionesEspeciales.php';

$arreglo= leerArchivoJson('eventosRealTime.json','INFO');

foreach ($arreglo as $key => $value) {
	echo calcularAntiguedadSegundos($value['alarm_date']);
	echo "<br>";
}
echo "********";
echo "<br>";
echo date("M d Y H:iA",time());
$fecha=date("M d Y H:iA",time());
echo "<br>";
echo time();


function calcularAntiguedadSegundos($fecha){
	$fechaTime=strptime($fecha);
	return time()-$fechaTime;

}
?>