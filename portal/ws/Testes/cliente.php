<?php

$client = new SoapClient(null, array('location' => 'http://operacaotv.telemar/ws/server.php',
									'uri' => 'http://operacaotv.telemar/ws/',
									'trace' => 1));

$result = $client->hello('Hélio Filho');

if (is_soap_fault($result)){
	//trigger_error("SOAP FAULT: (Faultcode: {$result->faultcode}, Faultstring: {$result-faultstring})",E_ERROR);
	echo "erro";
}else{
	echo "Resultado Encontrado: " . print_r($result);
}
?>