
<?php

class settings{


//*****************************************Settings*****************************************

const  latLongitudInicial='-33.45127917470724, -70.67639411303647';// buscar un punto del pais desde google maps
const  autoClose='false';
const  serverIP='UNA IP';
const  portdb='UN PUERTO';
const  userdb='UN USER';
const  passdb='UNA PASSWORD';
const  database='NOMBRE DE LA BASE DE DATOS';
const  ficheroRealtime='C:\xampp\Queries\AlarmasBuffer_CHILETEST.sql';
const  ficheroHistorico='C:\xampp\Queries\utimasNhs_CHILE.sql';//incidentesDia.sql';
const  tiempoConsultaficheroRealtime=(120); // segundos que se refrescará el json que lee el mapa
const  tiempoConsultaficheroHistorico=60*60; // (60*60*5 -> 5 horas ) o en segundos que se refrescará el json histórico que lee el mapa
const  tamanioCirculoHistorico1=300; // es el radio del circulo
const  etiquetaJobsAbiertos='ALARMAS DE ACUDA';
const  mostrarAcuda=false; //muestra en la eqtiqueta info acudas y cantidades
const  etiquetaHistoricos='HISTÓRICO DE HOY DESDE LAS 00:00 HORAS';
const  etiquetaAlarmasRealTime='ALARMAS ACTIVAS';
const  ficheroCacheHistorico='C:\xampp\ArchivosJson_CH\eventohistorico.json'; //desde donde lee historico
const  labelFicheroCacheHistorico='HISTORICO'; //texto que se visualiza en pantalla
const  ficheroCacheRealTime='C:\xampp\ArchivosJson_CH\RMTEST\eventosRealTime.json';// desde donde lee realtime
const  labelFicheroCacheRealTime='TIEMPO REAL'; //etiqueta
const  repeticiones=3;//luego de cuantas repeticiones se pinta de rojo el circulo de alarma
const  iconoAlarma='police-siren-siren2.gif';//Icono de alarma en tiempo real
const  mapaAjustarApuntos=false;// acomoda el mapa automáticamente para que se ajuste a las alarmas realtime y se vea lo mas cerca posible
const  username='alarmas';// para el login inicial
const  password='dtialarmas'; //para el login inicial

//********************************************************************//
//const  latLongitudInicialMiniatura='29.525481, -16.563644' HABILITAR PARA ESPAÑA;

//*****************************************Settings*****************************************


/*public static function getTiempoRefreshMapa(){
	return self::tiempoRefreshMapa;
}*/
public static function getLatLongitudInicial(){
	return self::latLongitudInicial;
}
public static function getAutoClose(){
	return self::autoClose;
}
public static function getServerIp(){
	return self::serverIP;
}
public static function getPortDb(){
	return self::portdb;
}
public static function getUserDb(){
	return self::userdb;
}
public static function getPassDb(){
	return self::passdb;
}
public static function getDataBase(){
	return self::database;
}
public static function getFicheroRealTime(){
	return self::ficheroRealtime;
}
public static function getFicheroHistorico(){
	return self::ficheroHistorico;
}



}
?>