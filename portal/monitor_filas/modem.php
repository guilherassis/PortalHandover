<?php 
require("funcoes.php");
$funcoes = new funcoes();
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
<div align='center'><font>Instalações de Cable Modem</font></div>

<?
echo "<BR><P>" . $funcoes->InstalacoesModem();
?>
</font>
</body>
</html>