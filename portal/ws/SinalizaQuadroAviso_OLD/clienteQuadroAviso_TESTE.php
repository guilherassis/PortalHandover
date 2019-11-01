<?php
include "../lib/nusoap.php";

require_once("../lib/nusoap.php");


$client = new SoapClient('http://operacaotv.telemar/ws/QuadroAviso/SetQuadroAvisos.php');


$codusu = $client->call('SetAtualizaQuadro', array('RX47AMA','50','20:09','E','30'));

print_R($codusu);

if (isset($codusu))
  if ($codusu <> '')
 	echo "<BR>Codigo Usuário: " . $codusu[0];
 	echo "<BR>Login Usuário: " . $codusu[1];
 	echo "<BR>Nome Usuário: " . $codusu[2];
 	echo "<BR>Depto: " . $codusu[3];
 	echo "<BR>Regra: " . $codusu[4];
 	
$var = strpos($_SERVER["HTTP_USER_AGENT"],"MSIE")?"<br>achou":"<br>nao achou";
$var = strpos($_SERVER["HTTP_USER_AGENT"],"MSIE")?1:0;
?>