<?php

class informa_dados{
	
	function informa_dados(){}

    function InformaSenha($usu,$segmento,$base){
	   if(($usu == "DBMDTH") && ($base == "PRODUCAO")){
		   //return "MD#10DPR";
		   return "BC#10DMD";
	   }else
	     if(($usu == "DBMDTH") && ($base == "BCV")){
		     return "BC#10DMD";
		     //return "MD#10DPR";
	     }else
	       if(($usu == "DBMCABO") && ($base == "PRODUCAO")){
		       //return "CO$13PBD";
		       return "BBC#13CO";
	       }else
	         if(($usu == "DBMCABO") && ($base == "BCV")){
		         return "BBC#13CO";
	     }    
	}
	
	
	function InformaBase($usu,$base){
	   if(($usu == "DBMDTH") && ($base == "PRODUCAO")){
		   //return "SINNRAC";
		   //$db ="(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = sinpx15-scan.telemar)(PORT = 1549)) (CONNECT_DATA = (SERVICE_NAME = sinnprod)))";
		   $db ="(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = sinpx16.interno)(PORT = 1550)) (CONNECT_DATA = (SID = sinnprod)))";
		   return $db;
	   }else
	     if(($usu == "DBMDTH") && ($base == "BCV")){
		     //return "sinnbcv";
		     $db ="(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = sinpx16.interno)(PORT = 1550)) (CONNECT_DATA = (SID = sinnprod)))";
		   	 return $db;
	     }else
	       if(($usu == "DBMCABO") && ($base == "PRODUCAO")){
		       //return "SINNRAC";
		       //$db ="(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = sinpx15-scan.telemar)(PORT = 1549)) (CONNECT_DATA = (SERVICE_NAME = sinnprod)))";
		   	   $db ="(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = sinpx16.interno)(PORT = 1550)) (CONNECT_DATA = (SID = sinnprod)))";
		       return $db;
	       }else
	         if(($usu == "DBMCABO") && ($base == "BCV")){
		       // return "sinnbcv";
		       $db ="(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = sinpx16.interno)(PORT = 1550)) (CONNECT_DATA = (SID = sinnprod)))";
		   	   return $db;
	     }    
	}
	
	function InformaSeveridadeARS(){
		
		/*if((date("H") >= 8) && (date("H") <= 18))
			return "ALARME";
		else
			return "ALARME"; //"SEV";*/
		return "ARS";
	}
	
/*	function InformaSeveridadeARS($tempo){
		
		if((date("H") <= 8) && (date("H") >= 19) && ($tempo < 10))
			return "SEV";
		else
			return "ALARME";
	}*/
}
?>