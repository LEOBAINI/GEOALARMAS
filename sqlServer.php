<?php 

class miconexion {
	
/**
* Gestiona la conexión con la base de datos
*/
public function obtenerDatos($ficheroQuery){
	//include 'settings.php';	
	include_once "lectorFichero.php";
	
	$instanciaFichero=new lectorFichero();
	$contenidoFichero=$instanciaFichero->leerFichero($ficheroQuery);
	$serverName = settings::getServerIp().','. settings::getPortDb(); //serverName\instanceName, portNumber (por defecto es 1433)
	$connectionInfo = array( 
	"Database"=>settings::getDataBase(),
	"Encrypt" => true,
    "TrustServerCertificate" => false,
	"UID"=>settings::getUserDb(),
	"PWD"=>settings::getPassDb());
	try{
$conn = sqlsrv_connect( $serverName, $connectionInfo);
}catch(Exception $e){
	echo 'Excepción capturada: ',  $e->getMessage(), "\n";
	
 echo "<script>console.log('Console: " . $e->getMessage() . "' );</script>";
}


if( $conn === false ) {
     header('Location: '.'error.php');//'No es posible conectar cn la base de datos';
     die( print_r( sqlsrv_errors(), true));
} else {
  //  print "Good DB Connection: $conn<br>";
}


$sql = $contenidoFichero;//"SELECT top 10 site_no,system_no from system";
$resultados = array();
$result = sqlsrv_query($conn, $sql);
if($result === false) {
    die(print_r(sqlsrv_errors(), true));
}else{
#Fetching Data by array
     $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
     //echo $row;
     //die();
while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
   $resultados[]=$row;
}
sqlsrv_free_stmt($result);  
sqlsrv_close($conn);
}
return $resultados;
}

public function conectar(){
    $serverName = settings::getServerIp().','. settings::getPortDb(); //serverName\instanceName, portNumber (por defecto es 1433)
    $connectionInfo = array( "Database"=>settings::getDataBase(), "UID"=>settings::getUserDb(), "PWD"=>settings::getPassDb(),"CharacterSet" => "UTF-8");// muy importante el charset para luego decodificar, sino falla json encode
   
    try{
   
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
   
    }catch(Exception $e){
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    
    echo "<script>console.log('Console: " . $e->getMessage() . "' );</script>";
    header('Location: '.'error.php');//'No es posible conectar cn la base de datos';
     die( print_r( sqlsrv_errors(), true));
    }


    if( $conn === false ) {
     header('Location: '.'error.php');//'No es posible conectar cn la base de datos';
     die( print_r( sqlsrv_errors(), true));
    } else {
  //  print "Good DB Connection: $conn<br>";
}
    return $conn;

}
/*
public function obtenerDatosAJson($ficheroQuery,$nombreFichero){
    set_time_limit(13000);
  //  exec("doTask.php $arg1 $arg2 $arg3 >/dev/null 2>&1 &");


    include_once "lectorFichero.php";

    $conn=$this->conectar();

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

}*/

}
?>