<?php

require_once("../lib/nusoap.php");


$clienteSoap = new SoapClient('http://operacaotv.telemar/ws/UserControl/GetAcessoUC.php');

/*$resultado = $clienteSoap->call('hello', array('admcallback','CALLBACK'));

if($clienteSoap->fault) {
   echo "Erro ao acessar o WEBSERVICE<br />Erro: ".$clienteSoap->faultstring;
}
else {
   echo "Nome Usuario: ".$resultado;
}

//print_r($resultado);


echo "<br>";*/

$codusu = $clienteSoap->call('GetLoginAuthenticate', array('daraujo','teste','CALLBACK'));

print_R($codusu);

echo "<br>";

$depto  = $clienteSoap->call('get_depto', array($codusu));

if (isset($codusu))
  if ($codusu <> '')
 	echo "<BR>Codigo Usuário: " . $codusu[0];
 	echo "<BR>Nome Usuário: " . $codusu[1];
 	echo "<BR>Nome Usuário: " . $codusu[2];
 	echo "<BR>Depto: " . $codusu[3];
 	echo "<BR>Regra: " . $codusu[4];
 	
$var = strpos($_SERVER["HTTP_USER_AGENT"],"MSIE")?"<br>achou":"<br>nao achou";
$var = strpos($_SERVER["HTTP_USER_AGENT"],"MSIE")?1:0;

echo $var;
?>