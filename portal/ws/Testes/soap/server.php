<?php
// WebServices - iMasters.com.br
// Autor: Mauricio Reckziegel
// http://www.mauricioreckziegel.com
// Arquivo : server.php
// Observações:
// Adicionar a extensão php_soap

//criação de uma instância do servidor (coloque o endereço na sua máquina local)
$server = new SoapServer(null, array('uri' => "http://caminho"));  // ex.: http://localhost/imasters/soap/
//definição do serviço ( vai retornar apenas a frase Hello + parâmetro que receber )
	  function hello($name) {
			return 'Hello '.$name;
	  }	
//registro do serviço
$server->addFunction("hello");
// chamada do método para atender as requisição do serviço 
// se a chamada for um POST executa, senão apenas mostra as funções “cadastradas”
if ($_SERVER["REQUEST_METHOD"]== "POST") {
		$server->handle();
} else {
	$functions = $server->getFunctions();
	foreach ($functions as $func) {
		print $func. "<br>";
	}
}
?>
