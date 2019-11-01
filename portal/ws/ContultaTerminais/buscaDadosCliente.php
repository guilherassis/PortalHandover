<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Consulta Terminais Fixa - SAC/STC</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<?php
require_once('../lib/nusoap.php');

if(isset($_POST['numTel'])){
		if(strlen($_POST['numTel'])==10){
			$ddd = substr($_POST['numTel'],-10, 2);
			$num = substr($_POST['numTel'],-8);
		
			$numtel = $_POST['numTel'];
		}else{
			echo "<br>Deve-se informar o número do telefone";exit();
		}
}else
	if(isset($_GET['numtel'])){
		if(strlen($_GET['numtel'])==10){
			$ddd = substr($_GET['numtel'],-10, 2);
			$num = substr($_GET['numtel'],-8);
		
			$numtel = $_GET['numtel'];
		}else{
			echo "<br>Deve-se informar o número do telefone";exit();
		}
}

$regiao = buscaRegiaoDDD($ddd);

if($regiao == 2){
	
	$xml = buscaDadosR2($ddd, $num);

}else{
	
	$xml = buscaDadosR1($ddd, $num);
}
?>

<form method="post">
<br>
<div align="CENTER"><font class="Titulo">Consulta Dados de Terminal</font></div>
Número do Terminal: <input type="text" name="numTel" value="<?=$numtel?>"> <em>3132222233</em>
<br><br>
<div align="left">
<!--
<tr><td class="Titulo">Assinante</td><td><?=$xml[0];?>&nbsp;</td></tr>
<tr><td class="Titulo">CPF</td><td><?=$xml[1];?>&nbsp;</td></tr>
<tr><td class="Titulo">Status</td><td><?=$xml[2];?>&nbsp;</td></tr>
<tr><td class="Titulo">Tipo Logradouro</td><td><?=$xml[3];?>&nbsp;</td></tr>
<tr><td class="Titulo">Logradouro</td><td><?=$xml[4];?>&nbsp;</td></tr>
<tr><td class="Titulo">Número</td><td><?=$xml[5];?>&nbsp;</td></tr>
<tr><td class="Titulo">Bairro</td><td><?=$xml[6];?>&nbsp;</td></tr>
<tr><td class="Titulo">Cidade</td><td><?=$xml[7];?>&nbsp;</td></tr>
<tr><td class="Titulo">Estado</td><td><?=$xml[8];?>&nbsp;</td></tr>
<tr><td class="Titulo">CEP</td><td><?=$xml[9];?>&nbsp;</td></tr>
<tr><td class="Titulo">Dias em Atraso/Bloqueio</td><td><?=$xml[10];?>&nbsp;</td></tr>
<tr><td class="Titulo">Tipo de Cliente</td><td><?=$xml[11];?>&nbsp;</td></tr>
<tr><td class="Titulo">Data Contratação</td><td><?=$xml[12];?>&nbsp;</td></tr>
<tr><td class="Titulo">Plano</td><td><?=$xml[13];?>&nbsp;</td></tr>
<tr><td class="Titulo">Data Ativação</td><td><?=$xml[14];?>&nbsp;</td></tr>
</table>

-->


<table border="1" cellpadding="0" cellspacing="0">
<tr class="Titulo">
  <td>Assinante</td>
  <td>CPF</td>
  <td>Status</td>
  <td>Tipo Logradouro</td>
  <td>Logradouro</td>
  <td>Número</td>
  <td>Bairro</td>
  <td>Cidade</td>
  <td>Estado</td>
  <td>CEP</td>
  <td>Dias em Atraso/Bloqueio</td>
  <td>Tipo de Cliente</td>
  <td>Data Contratação</td>
  <td>Plano</td>
  <td>Data Ativação</td>
</tr>
<tr>
  <?for($i = 0; $i <= 14; $i++){?>
	<td><?=$xml[$i];?>&nbsp;</td>
  <?}?>
</tr>
</table>
</div>
</form>

<html>

<?php
function buscaRegiaoDDD($ddd){
	
	$xml = simplexml_load_file("estadosporregiao.xml");
	foreach($xml->estado as $estado){
		if($ddd == $estado->ddd){
			return $estado->regiao;
		}
	}
}

function buscaDadosR1($ddd, $terminal){
	$bodyxml = '<?xml version="1.0" encoding="utf-8"?>'.
	'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:con="http://alsb.telemar/xsd/ConsultarInformacoesTerminal" xmlns:esb="http://alsb.telemar/soap/esbUser">'.
	'   <soapenv:Header/>'.
	'   <soapenv:Body>'.
	'      <con:ConsultarInformacoesTerminalRequest>'.
	'         <esb:Ator>'.
	'            <!--Optional:-->'.
	'            <esb:nomeSolicitante></esb:nomeSolicitante>'.
	'            <esb:sistema></esb:sistema>'.
	'            <!--Optional:-->'.
	'            <esb:senha></esb:senha>'.
	'         </esb:Ator>'.
	'         <con:DDD>'.$ddd.'</con:DDD>'.
	'         <con:numTerminal>'.$terminal.'</con:numTerminal>'.
	'      </con:ConsultarInformacoesTerminalRequest>'.
	'   </soapenv:Body>'.
	'</soapenv:Envelope>';


	$client = new nusoap_client("http://osbprd.telemar:7200/RecargaAutomatica/ConsultarInfoTerminalClienteProxySoap?WSDL",true);
	$err = $client->getError();
	if ($err) {
		echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		exit();
	}

	$client->soap_defencoding = 'utf-8';
	$client->useHTTPPersistentConnection();
	$client->setUseCurl($useCURL);
	$bsoapaction = "ConsultarInformacoesTerminal";
	$result = $client->send($bodyxml, $bsoapaction);
	// Check for a fault
	if ($client->fault) {
		echo '<h2>Fault</h2><pre>';
 		print_r($result);
	 	echo '</pre>';
	} else {
		// Check for errors
	 	$err = $client->getError();
 		if ($err) {
	 		// Display the error
  			echo '<h2>Error</h2><pre>' . $err . '</pre>';
 		}
	}
	
	$cliente = array($result['nome'], 
					 $result['CPFCNPJ'], 
					 $result['statusLinha'], 
					 "", 
					 $result['endereco'] ." - ". $result['enderecoComplemento'], 
					 "", 
					 $result['bairro'], 
					 $result['cidade'], 
					 $result['estado'], 
					 $result['CEP'], 
					 $result['numDia'], 
					 $result['tipoConta'], 
					 $result['dtContratacao'], 
					 $result['codPlano'], 
					 $result['dtInstalacao']);
					 
	return $cliente;
	/*echo $result['nome']."<br>";
	echo $result['CPFCNPJ']."<br>";
	echo $result['statusLinha']."<br>";
	echo ""."<br>";
	echo $result['endereco']."<br>";
	echo $result['enderecoComplemento']."<br>";
	echo ""."<br>";
	echo $result['bairro']."<br>";
	echo $result['cidade']."<br>";
	echo $result['estado']."<br>";
	echo $result['CEP']."<br>";
	echo $result['numDia']."<br>";
	echo $result['tipoConta']."<br>";
	echo $result['dtContratacao']."<br>";
	echo $result['codPlano']."<br>";
	echo $result['dtInstalacao']."<br>";*/
	
	
	/*echo $result['dtNasc']."<br>";
	echo $result['statusConta']."<br>";
	echo $result['codDebito']."<br>";
	echo $result['tipoPlano']."<br>";*/
	
}

function buscaDadosR2($ddd, $terminal){
	$bodyxml = '<?xml version="1.0" encoding="utf-8"?>'.
	'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:con="http://alsb.telemar/xsd/RecargaAutomatica/ConsultarValidacaoPlanoRecarga">'.
    '<soapenv:Header/>'.
    '<soapenv:Body>'.
    '  <con:ConsultarPlanoRequest>'.
    '     <con:DDD_Fixo>'.$ddd.'</con:DDD_Fixo>'.
    '     <con:num_Fixo>'.$terminal.'</con:num_Fixo>'.
    '  </con:ConsultarPlanoRequest>'.
    '</soapenv:Body>'.
'</soapenv:Envelope>';


	$client = new nusoap_client("http://alsbprd.telemar:7200/RecargaAutomatica/ConsultarValidacaoPlanoRecargaProxySoap?wsdl",true);
	$err = $client->getError();
	if ($err) {
		echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		exit();
	}

	$client->soap_defencoding = 'utf-8';
	$client->useHTTPPersistentConnection();
	$client->setUseCurl($useCURL);
	$bsoapaction = "consultarPlano";
	$result = $client->send($bodyxml, $bsoapaction);
	// Check for a fault
	if ($client->fault) {
		echo '<h2>Fault</h2><pre>';
 		print_r($result);
	 	echo '</pre>';
	} else {
		// Check for errors
	 	$err = $client->getError();
 		if ($err) {
	 		// Display the error
  			echo '<h2>Error</h2><pre>' . $err . '</pre>';
 		}
	}
	
	$cliente = array($result['nome'],
					 $result['CPF_CNPJ'],
					 $result['status'],
					 $result['Endereco']['tipoLogr'],
					 $result['Endereco']['logradouro'],
					 $result['Endereco']['numero'],
					 $result['Endereco']['bairro'],
					 $result['Endereco']['cidade'],
					 $result['Endereco']['UF'],
					 $result['Endereco']['CEP'],
					 $result['Endereco']['qauntBloq'],
					 $result['Endereco']['tipoCliente'],
					 $result['Endereco']['dt_Contratacao'],
					 $result['Endereco']['plano'],
					 $result['Endereco']['dt_Ativacao']);
	
	return $cliente;
}

?>