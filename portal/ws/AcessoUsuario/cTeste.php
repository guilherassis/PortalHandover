<?php

require_once("lib/nusoap.php");

$client = new soapclient('http://operacaotv.telemar/ws/sTeste.php');

$result = $client->call('teste',array('Vinicius'));
print_r($result);

echo '<h2>Requisigco</h2>';
echo '<pre>'.htmlspecialchars($client->request).'</pre>';
echo '<h2>Resposta</h2>';
echo '<pre>'.htmlspecialchars($client->response).'</pre>';
echo '<h2>Debug</h2>';
echo '<pre>'.htmlspecialchars($client->debug_str).'</pre>';

?>