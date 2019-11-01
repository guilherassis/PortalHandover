<?php
include "lib/nusoap.php";

require_once("lib/nusoap.php");
$server = new soap_server;
$server->register('hello');

	function hello($name,$senha){
		return 'Hello ' . $name . ', sua senha é: ' . $senha;
	}
	
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>