<?php 

require('../ws/lib/nusoap.php');

require("funcoes.php");
$funcoes = new funcoes();

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="monitor_sinn.css">
<title><?=TITULO;?></title>
<meta http-equiv="refresh" content="300"><!--content="60;URL=http://blgprd04:9580/monitor"-->

<SCRIPT language="JavaScript">
<!--
var g_iCount = new Number();

// de 30 a 0 //
var g_iCount = 295;

function startCountdown(){
       if((g_iCount - 1) >= 0){
               g_iCount = g_iCount - 1;
               numberCountdown.innerText = g_iCount;
               setTimeout('startCountdown()',1000);
       }
}
-->
</SCRIPT>
</head>
<body class="novo" <!--onload=startCountdown()-->
<form method="POST" name="frmRelGerencial" <!--action="http://blgprd04:9580/monitor"-->
<table align=center border="0" cellpadding="0" cellspacing="0" width="100%" class="tbl1">
<?php
include("cabecalho_.php");?>
</table>
<br>

<FONT face="verdana" color="#1e90ff" size="8"><B>
<DIV id="numberCountdown" align="center"></DIV></FONT>

<?php

for($tipo = 1; $tipo <= 3; $tipo++){
	echo $funcoes->CriaMonitor($tipo);
	echo "<br>";
}

/*echo "<BR><P><div align='center'><font>Processos Sem Executar</font></div>";

echo "<BR><P>" . $funcoes->ProcessosSemExecutar();

echo "<BR><P><div align='center'><font class='Titulo'>Processos Críticos</font></div>";

echo "<BR><P>" . $funcoes->ProcessosCriticos();*/

echo "<BR><div align='center'><font class='Titulo'>Servidor de Travas</font></div>";

echo "<BR><P>" . $funcoes->ServidorDeTravas();

echo "<BR><div align='center'><font class='Titulo'>Aprovisionamento</font></div>";

echo "<BR><P>" . $funcoes->FilaComandosAprovisionamento();

echo "<BR><div align='center'><font class='Titulo'>Régua de Cobrança</font></div>";

echo "<BR><P>" . $funcoes->ViewsReguaCobrana();

echo "<BR><div align='center'><font class='Titulo'>Análise de Crédito</font></div>";

echo "<BR><P>" . $funcoes->ErroAnaliseCredito();

echo "<BR><div align='center'><font class='Titulo'>Cadeia de Execução BCV</font></div>";

echo "<BR><P>" . $funcoes->ExecucaoBcv();

/*
echo "<BR><div align='center'><font class='Titulo'>Views Informacionais</font></div>";

echo "<BR><P>" . $funcoes->ViewsInformacionais();
*/
?>
</font>
</body>
</html>