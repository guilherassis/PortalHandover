<?php 
if(isset($_GET["ope"]))
  	$operacao = $_GET["ope"];

$ope = $operacao == "cabo"?"dth":"cabo";
  	
require("funcoes.php");
$funcoes = new funcoes();
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilos.css">
<title><?=MONITOR;?> do SINN</title>
<meta http-equiv="refresh" content="60">
</head>
<body>
<form method="POST" name="frmMonitor" action="monitor.php?ope=<?=$ope;?>">

<table align=center border="0" cellpadding="0" cellspacing="0" class="tbl1" width="100%">
<?include("cabecalho.php");?>
</table>

<?PHP

 for($tipo = 1; $tipo <= 3; $tipo++){
	 echo $funcoes->CriaMonitoramento($tipo);
 }
 $funcoes->FechaBanco();
?>

<br>
<a href="index.php">&nbsp;Voltar</a>
</font>
</body>
</html>