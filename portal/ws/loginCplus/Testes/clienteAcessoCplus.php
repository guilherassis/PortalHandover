<?php
require_once('../lib/nusoap.php');
// Definição da localização do arquivo WSDL
$wsdl = 'http://operacaotv.telemar/ws/logincplus/GetAcessoUsuario.php?wsdl';
// criação de uma instância do cliente
$client = new nusoap_client($wsdl, true);
// verifica se ocorreu erro na criação do objeto
$err = $client->getError();
if ($err){
	echo "Erro no construtor<pre>".$err."</pre>";
}
// chamada do método SOAP
$codigo = $client->call('AutenticaUsuario',array('helio','hfilhoway')); 
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

echo "<br>";

$nome = $client->call('BuscaNomeUsuario',array(17084)); 
// verifica se ocorreu falha na chamada do método
if ($client->fault){
	echo "Falha<pre>".print_r($nome)."</pre>";
}else{
	// verifica se ocorreu erro
	$err = $client->getError();
	if ($err){
		echo "Erro<pre>".$err."</pre>";
	} else{
			print_r($nome);
	}//end_else
}//end_else

echo "<br>";

$depto = $client->call('BuscaDepartamentoUsuario',array(17084)); 
// verifica se ocorreu falha na chamada do método
if ($client->fault){
	echo "Falha<pre>".print_r($depto)."</pre>";
}else{
	// verifica se ocorreu erro
	$err = $client->getError();
	if ($err){
		echo "Erro<pre>".$err."</pre>";
	} else{
			print_r($depto);
	}//end_else
}//end_else


?>