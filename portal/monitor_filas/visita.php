<?php 
require("funcoes.php");
$funcoes = new funcoes();

if(isset($_GET["dias"]))
  	$dias = $_GET["dias"];
else
	$dias = 30;

$dias = $dias > 60?60:$dias;	

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="monitor.css">
<title><?=TITULO;?></title>
</head>
<body class="novo">
<form method="POST" name="frmMonitor" <!--action="http://blgprd04:9580/monitor"-->
<table align=center border="0" cellpadding="0" cellspacing="0" width="100%" class="tbl1">
<?include("cabecalho_.php");?>
</table>
<br>
<div align='center'><font>OS's Reincidentes</font></div>

<?
echo "<BR><P>" . $funcoes->FilaOSsReincidentes($dias);
?>
</font>
</body>
</html>