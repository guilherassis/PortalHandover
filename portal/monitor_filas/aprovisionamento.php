<?php 
require("funcoes.php");
$funcoes = new funcoes();
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="monitor.css">
<title><?=TITULO;?></title>
<meta http-equiv="refresh" content="60">
</head>
<body class="novo">
<form method="POST" name="frmMonitor" <!--action="http://blgprd04:9580/monitor"-->
<table align=center border="0" cellpadding="0" cellspacing="0" width="100%" class="tbl1">
<?include("cabecalho_.php");?>
</table>
<br>
<div align='center'><font>Aprovisionamento</font></div>

<em>&nbsp;Última Atualização: <?=date("d/m/Y H:i:s");?> </em>

<br>

<?php
//echo "<BR><P>" . $funcoes->FilaComandosAprovisionamento();

//$last_line = system('ping -c 2 10.203.235.23', $retval);

$host = "10.203.235.23";

$pin = "ping -c 10 " . $host;

echo '<pre>';

// Mostra todo o resultado do comando do shell "ls", e retorna
// a última linha da saída em $last_line. Guarda o valor de retorno
// do comando shell em $retval.
$last_line = system($pin, $retval);

?>
</font>
</body>
</html>