<?php
include "../lib/nusoap.php";

require_once("../lib/nusoap.php");

$wsdl = 'http://operacaotv.telemar/ws/SinalizaQuadroAviso/SetQuadroAvisos.php?wsdl';
// cria��o de uma inst�ncia do cliente
$client = new nusoap_client($wsdl, true);
// verifica se ocorreu erro na cria��o do objeto
$err = $client->getError();
if ($err){
	echo "Erro no construtor<pre>".$err."</pre>";
}
// chamada do m�todo SOAP
$codigo = $client->call('hello',array('helio','hfilhoway')); 
// verifica se ocorreu falha na chamada do m�todo
if ($client->fault){
	echo "Falha<pre>".print_r($codigo)."</pre>";
}else{
	// verifica se ocorreu erro
	$err = $client->getError();
	if ($err){
		echo "Erro<pre>".$err."</pre>";
	} else{
			print_r($codigo);
	}//end_else
}//end_else
echo "<br>";
$codusu = $client->call('SetAtualizaQuadro', array('RX47AMA','50','22:09','A','30'));

print_r($codusu);
?>