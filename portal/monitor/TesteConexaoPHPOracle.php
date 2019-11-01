<?php

function NovaConexaoBanco(){
	
error_reporting(E_ALL);
	$user = "DBMCABO";
	$dbpas =  "BBC#13CO";
	$dbcid = "sinnbcv";


	$db ="(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = sinpx14a)(PORT = 1550))
    (CONNECT_DATA = (SID = sinnbcv))
  )";

		
		
	$conn = ocilogon($user,$dbpas,$db);
	
	if (!$conn) {
	$e = ocierror();
	var_dump($e);
	print "\nError code = "     . $e['code'];
	print "\nError message = "  . $e['message'];
	print "\nError position = " . $e['offset'];
	print "\nSQL Statement = "  . $e['sqltext'];
	}
	
	$sql = ociparse($conn,"select count(*) qtde from pessoa");// or die ("ERRO na análise do SQL");
	
	ociexecute($sql,OCI_DEFAULT);// or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
	
	if (!ociexecute($sql, OCI_DEFAULT)) {
		$erro = ocierror($comando);
		echo $erro["code"]." - erro gerado 2<br/>";
		die;
	}
	
	while(Ocifetch($sql)) {
		echo "Resultado: " . ociresult($sql,'QTDE');
	}
	
	@oci_close($conn);
}

?>

<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <body>
   <form>

<?PHP
NovaConexaoBanco();
?>
   </form>
  </body>

</html>