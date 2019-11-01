<?php
require_once('../lib/nusoap.php');

$bodyxml = '<?xml version="1.0" encoding="utf-8"?>'.
'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:con="http://alsb.telemar/xsd/ConsultarInformacoesTerminal" xmlns:esb="http://alsb.telemar/soap/esbUser">'.
'   <soapenv:Header/>'.
'   <soapenv:Body>'.
'      <con:ConsultarInformacoesTerminalRequest>'.
'         <esb:Ator>'.
'            <!--Optional:-->'.
'            <esb:nomeSolicitante></esb:nomeSolicitante>'.
'            <esb:sistema></esb:sistema>'.
'            <!--Optional:-->'.
'            <esb:senha></esb:senha>'.
'         </esb:Ator>'.
'         <con:DDD>21</con:DDD>'.
'         <con:numTerminal>25802211</con:numTerminal>'.
'      </con:ConsultarInformacoesTerminalRequest>'.
'   </soapenv:Body>'.
'</soapenv:Envelope>';


$client = new nusoap_client("http://osbprd.telemar:7200/RecargaAutomatica/ConsultarInfoTerminalClienteProxySoap?WSDL",true);
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
	exit();
}

$client->soap_defencoding = 'utf-8';
$client->useHTTPPersistentConnection();
$client->setUseCurl($useCURL);
$bsoapaction = "ConsultarInformacoesTerminal";
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
  		echo '<h2>Error</h2><pre>' . $err . '</pre>';
 	}
}

echo $result['nome'];

/*echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
echo '<h2>Client Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
echo '<h2>Proxy Debug</h2><pre>' . htmlspecialchars($proxy->debug_str, ENT_QUOTES) . '</pre>';*/
?>
