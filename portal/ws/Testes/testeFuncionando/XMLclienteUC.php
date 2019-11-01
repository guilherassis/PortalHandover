<?php
include "lib/nusoap.php";

require_once("lib/nusoap.php");


$client = new SoapClient('http://operacaotv.telemar/ws/XMLserverUC.php');

/*$codusu = $client->call('hello', array('admcallback','88411'));

print_r($codusu);*/

$xml = $client->call('get_depto', array('helio','helio.filho@gmail.com','02/05/1978'));

echo $xml;
 	
?>