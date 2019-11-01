<?php

ini_set("display_errors",1);
ini_set("display_startup_erros",1);
error_reporting(E_ALL);

putenv("ORACLE_HOME=/oracle/app/product/10.2.0/");
//putenv("LD_LIBRARY_PATH=/opt/app/oracle/product/11.2.0/db_1/lib:/lib:/usr/lib");

//function NovaConexaoBanco($user, $base){
//echo "Teste";
	/*
	$user = "DBMCABO";
	$dbpas =  "BBC#13CO";
	$dbcid = "sinnbcv";
*/


$db ="(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = sinpx07-scan.interno)(PORT = 1549))
    (CONNECT_DATA = (SERVICE_NAME = sinnprod))
  )
";
//$db = "(DESCRIPTION =  (ADDRESS = (PROTOCOL = TCP)(HOST = cblprd04.telemar)(PORT = 1542)) (CONNECT_DATA = (SID = sinnprod)))";


$user = "DBMDTH";
$dbpas =  "BC#10DMD";
//$dbcid = "10.32.214.229:1550/sinntst1";
	
	//$conn = ocilogon($user,$dbpas,$db);
	
	$conn = oci_connect($user,$dbpas,$db);
	if (!$conn) {
    	$e = oci_error();
    	
    	var_dump($e);
		print htmlentities($e['message']);
    	    	
    	print "<br>Error code = "     . $e['code'];
		print "<br>Error message = "  . $e['message'];
		print "<br>Error position = " . $e['offset'];
		print "<br>SQL Statement = "  . $e['sqltext'];
		print "<br>SQL User = "  	  . $user;
		print "<br>SQL Pass = "  	  . $dbpas;
		print "<br>SQL String = "  	  . $db;
    	trigger_error(htmlentities($e['message']), E_USER_ERROR);
		die("erro");
    	
	}

	
	if (!$conn) {
		$e = ocierror();
		var_dump($e);
		echo $e;
		
		$e = oci_error();
				
		print "\nError code = "     . $e['code'];
		print "\nError message = "  . $e['message'];
		print "\nError position = " . $e['offset'];
		print "\nSQL Statement = "  . $e['sqltext'];
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
	}
	
	
	$sql = ociparse($conn,"SELECT count(*) QTDE FROM sinndth.parametro") or die ("ERRO na análise do SQL");

	ociexecute($sql,OCI_DEFAULT) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");

	while(Ocifetch($sql)) {
		echo "Resultado - FRANGO: " . ociresult($sql,'QTDE');
	}

	@oci_close($conn);
	
	

//}

?>