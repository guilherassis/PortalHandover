<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Verifica Serviços de Login do SINN Web</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<?php
require_once('../lib/nusoap.php');
?>

<form method="post">

<br>
<div align="CENTER"><font class="Titulo">Verifica Serviços de Login do SINN Web</font></div>

<br>
<div align="center">
<table border="1" cellpadding="0" cellspacing="0" width="50%">
<tr class="Titulo"><td>Servidor</td><td>Porta</td><td>Retorno</td></tr>
<?php
for($controle = 0; $controle < 8; $controle++){
	
	switch($controle){
		case 0:
			$numServer = 4;
			$nomeServer = "BLGPRD0".$numServer;
			$numPorta = "9180";
			break;
		case 1:
			$numServer++;
			$nomeServer = "BLGPRD0".$numServer;
			$numPorta = "9180";
			break;
		case 2:
			$numServer++;
			$nomeServer = "BLGPRD0".$numServer;
			$numPorta = "9180";
			break;
		case 3:
			$numServer++;
			$nomeServer = "BLGPRD0".$numServer;
			$numPorta = "9180";
			break;
		case 4:
			$numServer = 4;
			$nomeServer = "BLGPRD0".$numServer;
			$numPorta = "9380";
			break;
		case 5:
			$numServer++;
			$nomeServer = "BLGPRD0".$numServer;
			$numPorta = "9380";
			break;					
		case 6:
			$numServer++;
			$nomeServer = "BLGPRD0".$numServer;
			$numPorta = "9380";
			break;
		case 7:
			$numServer++;
			$nomeServer = "BLGPRD0".$numServer;
			$numPorta = "9380";
			break;
	}		
	
	echo "<tr><td>".$nomeServer."</td><td>".$numPorta."</td><td>".verificaStatusServicoLoginSINN($nomeServer, $numPorta)."&nbsp;</td></tr>";

}
?>
</table>
</div>
</form>

<html>

<?php


function verificaStatusServicoLoginSINN($appserver, $porta){
	$bodyxml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:obj="objectiveng.sinnweb">'.
   '<soapenv:Header/>'.
   '<soapenv:Body>'.
   '   <obj:realizaLoginUsuarioESenha>'.
   '      <!--Optional:-->'.
   '      <login>w1025139</login>'.
   '      <!--Optional:-->'.
   '      <senha>w1025139</senha>'.
   '      <!--Optional:-->'.
   '      <canal>web</canal>'.
   '   </obj:realizaLoginUsuarioESenha>'.
   '</soapenv:Body>'.
   '</soapenv:Envelope>';

   
   $wsdl = "http://".$appserver.":".$porta."/webservices-sinnweb/SinnWebWs?wsdl";
   
	$client = new nusoap_client($wsdl,true);
	$err = $client->getError();
	if ($err) {
		echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		exit();
	}

	$client->soap_defencoding = 'utf-8';
	$client->useHTTPPersistentConnection();
	$client->setUseCurl($useCURL);
	$bsoapaction = "consultarPlano";
	$result = $client->send($bodyxml, $bsoapaction);
	// Check for a fault
	if ($client->fault) {
		echo '<h2>Fault</h2><pre>';
 		print_r($result);
	 	echo '</pre>';
	} else {
		// Check for errors
	 	$err = $client->getError();
 		if ($err) {
	 		// Display the error
  			return '<h2>Error</h2><pre>' . $err . '</pre>';
 		}
	}
	
	
	return $result['return']['mensagem'];
	
	//return $cliente;
}

?>