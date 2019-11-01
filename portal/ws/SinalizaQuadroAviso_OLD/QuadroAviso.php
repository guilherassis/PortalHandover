<?php
require_once("../lib/nusoap.php");

$wsdl = 'http://operacaotv.telemar/ws/SinalizaQuadroAviso/SetQuadroAvisos.php?wsdl';
// criação de uma instância do cliente
$client = new nusoap_client($wsdl, true);
// verifica se ocorreu erro na criação do objeto
$err = $client->getError();
if ($err){
	echo "Erro no construtor<pre>".$err."</pre>";
}
// chamada do método SOAP
// Chamada de abertura de um chamado
$codusu = $client->call('SetAtualizaQuadro', array('RX47AMA','50','20:09','A','30'));
// verifica se ocorreu falha na chamada do método
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

// Chamada de fechamento de um chamado
$codusu = $client->call('SetAtualizaQuadro', array('RX47AMA','50','20:09','E','30'));
?>