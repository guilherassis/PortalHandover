<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Verifica Serviços de Busca Contrato pela URA</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="estilos.css">
<meta http-equiv="refresh" content="60">
</head>
<?php
require_once('../lib/nusoap.php');
?>

<form method="post">

<br>
<div align="CENTER"><font class="Titulo">Verifica Serviços de Busca Contrato pela URA</font></div>
<br>
<div align="center">
<table border="1" cellpadding="0" cellspacing="0" width="50%">
<tr class="Titulo"><td>Servidor</td><td>Porta</td><td>Retorno</td></tr>
<?php
for($QtdeAppServer = 0; $QtdeAppServer < 8; $QtdeAppServer++){
	
	switch($QtdeAppServer){
		case 0:
			$NumAppServer = 4;
			$NomeAppServer = "BLGPRD0".$NumAppServer;
			$NumPorta = "9580";
			break;
		case 1:
			$NumAppServer++;
			$NomeAppServer = "BLGPRD0".$NumAppServer;
			$NumPorta = "9580";
			break;
		case 2:
			$NumAppServer++;
			$NomeAppServer = "BLGPRD0".$NumAppServer;
			$NumPorta = "9580";
			break;
		case 3:
			$NumAppServer++;
			$NomeAppServer = "BLGPRD0".$NumAppServer;
			$NumPorta = "9580";
			break;
		case 4:
			$NumAppServer = 4;
			$NomeAppServer = "BLGPRD0".$NumAppServer;
			$NumPorta = "9080";
			break;
		case 5:
			$NumAppServer++;
			$NomeAppServer = "BLGPRD0".$NumAppServer;
			$NumPorta = "9080";
			break;					
		case 6:
			$NumAppServer++;
			$NomeAppServer = "BLGPRD0".$NumAppServer;
			$NumPorta = "9080";
			break;
		case 7:
			$NumAppServer++;
			$NomeAppServer = "BLGPRD0".$NumAppServer;
			$NumPorta = "9080";
			break;
	}		
	/*$time_start = microtime(true);
	$msg = "INICIO;".date("d/m/Y G:i:s").";".$NomeAppServer.";".$NumPorta.";".$time_start.";";
	GravarLog($msg);*/
	echo "<tr><td>".$NomeAppServer."</td><td>".$NumPorta."</td><td>".verificaStatusServicoLoginSINN($NomeAppServer, $NumPorta)."&nbsp;</td></tr>";
	/*$time_end = microtime(true);
	$time = $time_end - $time_start;
	$time = number_format($time,3,",",".");
	$msg = "TERMINO;".date("d/m/Y G:i:s").";".$NomeAppServer.";".$NumPorta.";".$time_start.";".$time."\n";
	GravarLog($msg);*/

}
?>
</table>
</div>
</form>

<html>

<?php


function verificaStatusServicoLoginSINN($NomeAppServer, $NumPorta){
	
	$cpf = $NumPorta=="9580"?"31360017453":"03144722669";
	
	$bodyxml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:obj="objectiveng.ura">'.
   '<soapenv:Header/>'.
   '<soapenv:Body>'.
   '   <obj:consultaContrato>'.
   '      <!--Optional:-->'.
   '      <cpfCnpj>'.$cpf.'</cpfCnpj>'.
   '      <!--Optional:-->'.
   '      <telefone></telefone>'.
   '   </obj:consultaContrato>'.
   '</soapenv:Body>'.
   '</soapenv:Envelope>';
   
   $time_start = microtime(true);
   $msg = "INICIO;".date("d/m/Y G:i:s").";".$NomeAppServer.";".$NumPorta.";".$time_start.";";
   GravarLog($msg);

   $wsdl = "http://".$NomeAppServer.":".$NumPorta."/webservices-ura/UraWs";

	$client = new nusoap_client($wsdl,true);
	$err = $client->getError();
	if ($err) {
		echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		exit();
	}

	$client->soap_defencoding = 'utf-8';
	$client->useHTTPPersistentConnection();
	$client->setUseCurl($useCURL);
	$bsoapaction = "consultaContrato";
	$result = $client->send($bodyxml, $bsoapaction);
	// Check for a fault
	if ($client->fault) {
		echo '<h2>Fault</h2><pre>';
 		print_r($result);
	 	echo '</pre>';
	 	$msg = "ERRO;";
	 	GravarLog($msg);
	} else {
		// Check for errors
	 	$err = $client->getError();
 		if ($err) {
	 		// Display the error
	 		$time_end = microtime(true);
	 		$time = $time_end - $time_start;
	 		$time = number_format($time,3,",",".");
	 		$msg = "TIMEOUT;".date("d/m/Y G:i:s").";".$NomeAppServer.";".$NumPorta.";".$time_start.";".$time."\n";
	 		GravarLog($msg);
	 		//mail("3188010701@sms.oi.com.br", "Notificacao de Alarme", "Servico: URA de Atendimento: ".$NomeAppServer.";".$NumPorta." Data: ".date("d/m/Y G:i:s"), "From: OiTV Monitoramento Ativo\n\n");
  			return '<h2>Error</h2><pre>' . $err . '</pre>';
 		}
	}
	
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	$time = number_format($time,3,",",".");
	$msg = "TERMINO;".date("d/m/Y G:i:s").";".$NomeAppServer.";".$NumPorta.";".$time_start.";".$time."\n";
	GravarLog($msg);
	
	return $result['return']['numero'];
	
	//return $cliente;
}

function GravarLog($msg){
	// Abre ou cria o arquivo bloco1.txt
	// "a" representa que o arquivo é aberto para ser escrito
	$fp = fopen("log_consulta_contrato_ura_".date("Y-m-d").".txt", "a+");

	// Escreve "exemplo de escrita" no bloco1.txt
	$escreve = fwrite($fp, $msg);

	// Fecha o arquivo
	fclose($fp);

}
?>