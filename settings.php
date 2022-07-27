
<?php

class settings{


//*****************************************Settings*****************************************

const  latLongitudInicial='39.56399710,-1.90732650';// buscar un punto del pais desde google maps
const  autoClose='false';
const  serverIP='poner ip del server sql server';
const  portdb='1433';
const  userdb='poner usuario';
const  passdb='poner password';
const  database='poner nombre de la base de datos';
const  ficheroRealtime='C:\xampp\Queries\ALarmasBufer.sql';
const  ficheroHistorico='C:\xampp\Queries\utimas2hs.sql';//incidentesDia.sql';
const  tiempoConsultaficheroRealtime=60*5; // segundos que se refrescará el json que lee el mapa
const  tiempoConsultaficheroHistorico=60*60; // (60*60*5 -> 5 horas ) o en segundos que se refrescará el json histórico que lee el mapa
const  tamanioCirculoHistorico1=100; // es el radio del circulo
const  etiquetaJobsAbiertos='ALARMAS DE ACUDA';
const  etiquetaHistoricos='HISTÓRICO DE HOY DESDE LAS 00:00 HORAS';
const  etiquetaAlarmasRealTime='ALARMAS ACTIVAS DE HOY ';
const  ficheroCacheHistorico='C:\xampp\ArchivosJson\eventohistorico.json';
const  labelFicheroCacheHistorico='HISTORICO';
const  ficheroCacheRealTime='C:\xampp\ArchivosJson\eventosRealTime.json';
const  labelFicheroCacheRealTime='TIEMPO REAL';
const  username='alarmas';// para el login inicial
const  password='dtialarmas'; //para el login inicial

//********************************************************************//
const  latLongitudInicialMiniatura='29.525481, -16.563644';

//*****************************************Settings*****************************************


public static function getTiempoRefreshMapa(){
	return self::tiempoRefreshMapa;
}
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