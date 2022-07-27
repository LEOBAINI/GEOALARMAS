<?php 

class lectorFichero{


	public function leerFichero($fichero){
		$query='';
		$fp = fopen($fichero, "r");
		while (!feof($fp)){
 	   $linea = fgets($fp);
 	   $query=$query.$linea;
 	 //  echo $linea;
		}
		fclose($fp);
		return $query;
	}


}
?>