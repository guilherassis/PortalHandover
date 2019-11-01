<?php
	
	include "lib/nusoap.php";

	require_once("lib/nusoap.php");
	$server = new soap_server;
	$server->register('get_depto');
	$server->register('hello');
	
	function hello($name,$senha){
		return 'Hello ' . $name . ', sua senha é: ' . $senha;
	}
	
	function get_depto($nome,$email,$dataniver){
		
		//return $nome;
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?><!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">";
		
		$xml .="<aniversariante><nomePessoa>'".$nome."'</nomePessoa><emailPessoa>'".$email."'</emailPessoa><dataAniversario>'".$dataniver."'</dataAniversario></aniversariante>";
		
		$xml .="</dadosAniversariantes>";

		return $xml;
	}
	
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>