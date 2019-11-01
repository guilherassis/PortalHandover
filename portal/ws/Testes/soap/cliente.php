<? 
// WebServices - iMasters.com.br
// Autor: Mauricio Reckziegel
// http://www.mauricioreckziegel.com
// Arquivo : cliente.php
// Observações:
// Adicionar a extensão php_soap

// passando o endereço do servidor
$client = new SoapClient(null, array(
	'location' => 'http://caminho/server.php',  // ex.: http://localhost/imasters/soap/server.php
	'uri' => 'http:/caminho/',  				// ex.: http://localhost/imasters/soap/
	'trace' => 1));
// chamada do serviço SOAP
$result = $client->hello('Mauricio Reckziegel'); 			 
// verifica erros na execução do serviço e exibe o resultado
if (is_soap_fault($result)){
	trigger_error("SOAP Fault: (faultcode: {$result->faultcode},
	faultstring: {$result->faulstring})", E_ERROR);
}else{
	echo "Resultado Encontrado : <br><br>";
	print_r($result);
}
?>

