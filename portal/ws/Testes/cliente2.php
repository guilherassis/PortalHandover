<?php
include "lib/nusoap.php";

require_once("lib/nusoap.php");

$client = new SoapClient('http://operacaotv.telemar/ws/server2.php');

$result = $client->call('hello', array('helio','abcdef'));

print_r($result);


?>