<?php
$server = new SoapServer(null, array('uri' => "http://operacaotv.telemar/ws"));

	function hello($name){
		return "Hello $name";
	}
	
	$server->addFunction("hello");
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$server->handle();
	}else{
		$functions = $server->getFunctions();
		foreach($functions as $func) {
			print $func . "<br>";
		}
	}
?>