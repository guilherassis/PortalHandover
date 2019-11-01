<?php
require_once('../lib/nusoap.php');

$wsdl = 'http://alsbprd.telemar:7200/RecargaAutomatica/ConsultarValidacaoPlanoRecargaProxySoap?wsdl';

$soapclient = new nusoap_client($wsdl, true);
// verifica se ocorreu erro na criação do objeto
$err = $soapclient->getError();
if ($err){
	echo "Erro no construtor<pre>".$err."</pre>";
}

//$dados = $client->call('consultarPlano',array('61','33545028')); 
//$dados = $client->call('consultarPlano',array('ConsultarPlanoRequest'=>array('DDD_Fixo'=>61,'num_Fixo'=>'33545028'))); 


$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:con="http://alsb.telemar/xsd/RecargaAutomatica/ConsultarValidacaoPlanoRecarga">'.
'   <soapenv:Header/>'.
'   <soapenv:Body>'.
'      <con:ConsultarPlanoRequest>'.
'         <con:DDD_Fixo>62</con:DDD_Fixo>'.
'         <con:num_Fixo>35882238</con:num_Fixo>'.
'      </con:ConsultarPlanoRequest>'.
'   </soapenv:Body>'.
'</soapenv:Envelope>';

//echo $xml; exit();

$soapclient = new nusoap_client('http://alsbprd.telemar:7200/RecargaAutomatica/ConsultarValidacaoPlanoRecargaProxySoap?wsdl');


$soapclient->send($xml, "http://alsbprd.telemar:7200/RecargaAutomatica/ConsultarValidacaoPlanoRecargaProxySoap");
$response = $soapclient->response;



/*
echo '<h2>Requisição</h2>';
echo '<pre>'.htmlspecialchars($soapclient->request).'</pre>';
echo '<h2>Resposta</h2>';
echo '<pre>'.htmlspecialchars($soapclient->response).'</pre>';
// Exibe mensagens para debug
echo '<h2>Debug</h2>';
echo '<pre>'.htmlspecialchars($soapclient->debug_str).'</pre>';
*/


echo $response;
?>