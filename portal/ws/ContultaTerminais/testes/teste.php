<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Consulta Terminais Região II</title>
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
	$wsdl = 'http://alsbprd.telemar:7200/RecargaAutomatica/ConsultarValidacaoPlanoRecargaProxySoap?wsdl';


	// Criando o cliente SOAP
	$cliente = new nusoap_client($wsdl, true);

	// Checando os erros
	if($cliente->getError())
   		echo "ERRO: ".$cliente->getError();
  	// Chamando o serviço cadastro no webservice com um argumento
	$xml = $cliente->call("consultarPlano", array(DDD_Fixo=>$ddd,num_Fixo=>$num));
}else{
	$wsdl = "http://osbprd.telemar:7200/RecargaAutomatica/ConsultarInfoTerminalClienteProxySoap?WSDL";
	$nada="?";
	// Criando o cliente SOAP
	$cliente = new nusoap_client($wsdl, true);

	// Checando os erros
	if($cliente->getError())
   		echo "ERRO: ".$cliente->getError();
  	// Chamando o serviço cadastro no webservice com um argumento
	$xml = $cliente->call("ConsultarInformacoesTerminal", array(ator->nomeSolicitante->"",ator->senha->"",DDD=>$ddd,numTerminal=>$num));
	
	print_r($xml);
}
?>

<form method="post">
Número Telefone: <input type="text" name="numTel" value="<?=$numtel?>"> <em>3132222233</em>
<br><br>
<div align="left">
<table border="1" cellpadding="0" cellspacing="0">
<tr><td class="Titulo">Assinante</td><td><?=$xml['nome'];?>&nbsp;</td></tr>
<tr><td class="Titulo">CPF</td><td><?=$xml['CPF_CNPJ'];?>&nbsp;</td></tr>
<tr><td class="Titulo">Status</td><td><?=$xml['status'];?>&nbsp;</td></tr>
<tr><td class="Titulo">Tipo Logradouro</td><td><?=$xml['Endereco']['tipoLogr'];?>&nbsp;</td></tr>
<tr><td class="Titulo">Logradouro</td><td><?=$xml['Endereco']['logradouro'];?>&nbsp;</td></tr>
<tr><td class="Titulo">Número</td><td><?=$xml['Endereco']['numero'];?>&nbsp;</td></tr>
<tr><td class="Titulo">Bairro</td><td><?=$xml['Endereco']['bairro'];?>&nbsp;</td></tr>
<tr><td class="Titulo">Cidade</td><td><?=$xml['Endereco']['cidade'];?>&nbsp;</td></tr>
<tr><td class="Titulo">Estado</td><td><?=$xml['Endereco']['UF'];?>&nbsp;</td></tr>
<tr><td class="Titulo">CEP</td><td><?=$xml['Endereco']['CEP'];?>&nbsp;</td></tr>
<tr><td class="Titulo">Dias em Bloqueio</td><td><?=$xml['Endereco']['qauntBloq'];?>&nbsp;</td></tr>
<tr><td class="Titulo">Tipo de Cliente</td><td><?=$xml['Endereco']['tipoCliente'];?>&nbsp;</td></tr>
<tr><td class="Titulo">Data Contratação</td><td><?=$xml['Endereco']['dt_Contratacao'];?>&nbsp;</td></tr>
<tr><td class="Titulo">Plano</td><td><?=$xml['Endereco']['plano'];?>&nbsp;</td></tr>
<tr><td class="Titulo">Data Ativação</td><td><?=$xml['Endereco']['dt_Ativacao'];?>&nbsp;</td></tr>
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

?>