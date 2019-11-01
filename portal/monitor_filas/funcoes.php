<?php

class funcoes{
	
	var $conn = "";
	var $operacao = "";
	var $cor = "#ADACC0";
	var $informa = "";
	
	function funcoes(){
		require("../monitor/informa_dados.php");
	    $this->informa = new informa_dados();
		
		
		if(isset($_GET["ope"]))
			$this->operacao = $_GET["ope"];
			
		if($this->operacao == "dth"){
			define("DBUSER","DBMDTH");
		}else{
			define("DBUSER","DBMCABO");
		}
  		define("DBCID","sinnprod");
  		define("TITULO","Monitores SINN OiTV");
  		define("NOMECABECALHO","Monitores SINN OiTV");
  		define("MONITORA","Monitoramento ");
 		
  		//ALERTAS
  		define("SERVIDORES","Servidores de Aplicação");
  		define("SERVICOS","Web Services");
  		define("LBLAPPSERVER","Application Server");
  		define("LBLWEBSERVER","Web Service");
  		define("LBLACAO","Em Execução");
  		define("LBLCATEGORIA","Categoria");
  		define("LBLEXECUCAO","Última Execução");
  		define("LBLSERVICO","Fila");
  		define("LBLSERVICOSEG","Segmento");
  		define("LBLSERVICOTIPO","Tipo");
  		define("LBLSERVICOQTDE","Qtde");
  		//define("LBLDONO","Owner");
  		define("LBLOBJETO","Objeto");
  		define("LBLATUALIZACAO","Atualização");
  		define("LBLTIPO","Tipo Objeto");
  		
  		$this->ConectaBanco(DBUSER,"PRODUCAO");
  		
	}
	
	function ConectaBanco($user,$base){
		$dbpas = $this->informa->InformaSenha($user,"",$base);
		$dbcid = $this->informa->InformaBase($user,$base);
		
		//echo $dbpas . " " . $dbcid;exit();
		
		//echo $user."aaa ".$dbpas;
		
		$this->conn = ocilogon($user,$dbpas,$dbcid);
		
/*		if($cid == ""){
			if($user == ""){
				$this->conn = ocilogon(DBUSER,DBPASS,DBCID);
			}else{
				$this->conn = @ocilogon($user,$pass,DBCID);
			}
		}else{
			$this->conn = @ocilogon($user,$pass,$cid);
		}*/
	}

	function FechaBanco(){
		@oci_close($this->conn);
	}
	
	
	function InstalacoesModem(){
		$sql = "select NUM_OS_EXTERNA, CODIGO_EQUIPAMENTO_NOVO, to_char(DATA_HORA_BAIXA,'DD/MM/YYYY HH24:MI:SS') data_baixa, SERVICO_TECNICO_RETORNO, MOTIVO_TAREFA ".
			   "from vm_cabo_tarefa WHERE COD_STATUS_TAREFA_TECNICA = 'BE' AND SERVICO_TECNICO = 'Instalar Modem' ".
			   "AND TRUNC(DATA_HORA_BAIXA) between trunc(sysdate) - 7 and trunc(sysdate) order by data_hora_baixa";
		
		$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='Titulo'><td align='left'><img src='imagens/IMAGENS/Titulo_1_.JPG'border='0' width='10'></td><td>OS Externa</td><td>Equipamento Novo</td><td>Data da Baixa</td><td>Serviço Técnico</td><td>Motivo da Tarefa</td><td align='right'><img src='imagens/IMAGENS/Titulo_3_.JPG'border='0' width='10'></td></tr>"; 
		
		$this->ConectaBanco("DBMCABO","BCV");
		
		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		ociexecute($sql,OCI_DEFAULT) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		while(ocifetch($sql)){
	  		$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
	  		
	  		$classe = ($this->cor == "#ADACC0")?"ExibeG":"ExibeGB";
	  		
	  		$ret .= "<tr class='".$classe."'><td align='left'>".$ldesquerdo."</td><td>".ociresult($sql,'NUM_OS_EXTERNA')."</td><td>".ociresult($sql,'CODIGO_EQUIPAMENTO_NOVO').
	  		"</td><td>".ociresult($sql,'DATA_BAIXA')."</td><td>".ociresult($sql,'SERVICO_TECNICO_RETORNO')."</td><td>".ociresult($sql,'MOTIVO_TAREFA')."</td><td align='right'>".$lddireito."</td></tr>";
	  		
  		}
		
		return $ret;
		
	}
	
	function FilaOSsReincidentes($dias){
		
		/*$sql = "select count(*) as qtde, contrato from dbmcabo.vm_cabo_os os where trunc(os.data_criacao_os) between trunc(sysdate) - 15 and trunc(sysdate) ".
		"  and os.tipo_os = 'Assistência Técnica'  and cod_status_os = 'BT' group by contrato having count(*) > 2";*/
		$sql = "select os2.CONTRATO, os2.NUMERO_OS, os2.EQUIPE_DESPACHADA, to_char(os2.DATA_FIM_EXECUCAO, 'DD/MM/YYYY HH24:MI:SS') DATA_FIM_EXECUCAO FROM vm_cabo_os os2, (select count(*), contrato ".
             "from vm_cabo_os os where trunc(os.data_criacao_os) between trunc(sysdate) - 30 and trunc(sysdate) and os.tipo_os = 'Assistência Técnica' ".
             "    and cod_status_os = 'BT' group by contrato  having count(*) > 3) os where trunc(os2.data_criacao_os) between trunc(sysdate) - :qtde_dias and trunc(sysdate) ".
			"and os2.contrato=os.contrato and os2.tipo_os = 'Assistência Técnica' and cod_status_os = 'BT' order by contrato";
		
		$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td align='left'><img src='imagens/IMAGENS/Titulo_1_.JPG'border='0' width='10'></td><td>Número Contrato</td><td>Número da OS</td><td>Equipe</td><td>Data Execução</td><td align='right'><img src='imagens/IMAGENS/Titulo_3_.JPG'border='0' width='10'></td></tr>"; 
		
		$this->ConectaBanco("DBMCABO","BCV");
		
		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
		OCIBindByName ($sql, ":qtde_dias", $dias);
  		
  		ociexecute($sql,OCI_DEFAULT) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		while(ocifetch($sql)){
	  		$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
	  		
	  		$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
	  		
	  		$ret .= "<tr class='".$classe."'><td align='left'>".$ldesquerdo."</td><td>".ociresult($sql,'CONTRATO')."</td><td align='CENTER'>".ociresult($sql,'NUMERO_OS').
	  		"</td><td>".ociresult($sql,'EQUIPE_DESPACHADA')."</td><td>".ociresult($sql,'DATA_FIM_EXECUCAO')."</td><td align='right'>".$lddireito."</td></tr>";
	  		
  		}
		
		return $ret;
		
	}
	
	function FilaComandosAprovisionamento(){
		
		$this->ConectaBanco("DBMDTH","PRODUCAO");
		
		/*$sql = "select fila, segmento, tipo, min(dataHora) hr_executa, count(*) qtde from ".
			   "(select 'INTRAWAYQUEUE' fila,'DTH' segmento,'DTH' tipo, to_char(enq_time+ 1/24, 'DD/MM/YYYY HH24:MI:SS') dataHora from intrawayqueue union all ".
			   "select 'ACC4000QUEUE' fila, 'CABO' segmento, 'Analógico' tipo, to_char(enq_time+ 1/24, 'DD/MM/YYYY HH24:MI:SS') dataHora from sinntv.acc4000queue a union all ".
			   "select 'SCIATLANTABOSSQUEUE' fila, 'CABO' segmento, 'Digital' tipo, to_char(enq_time+ 1/24, 'DD/MM/YYYY HH24:MI:SS') dataHora from sinntv.sciatlantabossqueue union all ".
			   "select 'CSMQUEUETB' fila, 'CABO' segmento, 'Velox' tipo, to_char(enq_time+ 1/24, 'DD/MM/YYYY HH24:MI:SS') dataHora from sinntv.csmqueuetb) group by fila, segmento, tipo";*/
		
		
		/*$sql = "select 'INTRAWAYQUEUE' fila,'DTH' segmento,'DTH' tipo, to_char(min(enq_time) + 1 / 24, 'DD/MM/YYYY HH24:MI:SS') hr_executa, count(*) qtde from intrawayqueue union all ".
			   "select 'ACC4000QUEUE' fila, 'CABO' segmento, 'Analógico' tipo, to_char(min(enq_time) + 1 / 24, 'DD/MM/YYYY HH24:MI:SS') hr_executa, count(*) qtde from sinntv.acc4000queue a union all ".
			   "select 'SCIATLANTABOSSQUEUE' fila, 'CABO' segmento, 'Digital' tipo, to_char(min(enq_time) + 1 / 24, 'DD/MM/YYYY HH24:MI:SS') hr_executa, count(*) qtde from sinntv.sciatlantabossqueue union all ".
			   "select 'CSMQUEUETB' fila, 'CABO' segmento, 'Velox' tipo, to_char(min(enq_time) + 1 / 24, 'DD/MM/YYYY HH24:MI:SS') hr_executa, count(*) qtde from sinntv.csmqueuetb";*/
			   
		/*$sql = "select 'INTRAWAYQUEUE' fila,'DTH' segmento,'DTH' tipo, to_char(min(enq_time), 'DD/MM/YYYY HH24:MI:SS') hr_executa, count(*) qtde from intrawayqueue union all ".
			   "select 'ACC4000QUEUETB' fila, 'CABO' segmento, 'Analógico' tipo, to_char(min(enq_time), 'DD/MM/YYYY HH24:MI:SS') hr_executa, count(*) qtde from sinntv.acc4000queuetb a union all ".
			   "select 'SCIATLANTABOSSQUEUE' fila, 'CABO' segmento, 'Digital' tipo, to_char(min(enq_time), 'DD/MM/YYYY HH24:MI:SS') hr_executa, count(*) qtde from sinntv.sciatlantabossqueue union all ".
			   "select 'CSMQUEUETB' fila, 'CABO' segmento, 'Velox' tipo, to_char(min(enq_time), 'DD/MM/YYYY HH24:MI:SS') hr_executa, count(*) qtde from sinntv.csmqueuetb union all ".
			   "select 'SGFTQUEUE' fila, 'DTH' segmento, 'SGFT' tipo, to_char(min(enq_time), 'DD/MM/YYYY HH24:MI:SS') hr_executa, count(*) qtde from sinndth.Sgftqueue union all ".
			   "select 'SGFTQUEUE' fila, 'CABO' segmento, 'SGFT' tipo, to_char(min(enq_time), 'DD/MM/YYYY HH24:MI:SS') hr_executa, count(*) qtde from sinntv.Sgftqueue ";			   */
			   
		$sql = "select * from vw_monitor_filas_comando";
		$this->ConectaBanco("DBMDTH","PRODUCAO");
  		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		ociexecute($sql,OCI_DEFAULT) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
		
  		$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td align='left'><img src='imagens/IMAGENS/Titulo_1_.JPG'border='0' width='10'></td><td>".LBLSERVICO."</td><td>".LBLSERVICOSEG."</td><td>".LBLSERVICOTIPO."</td><td align='center'>".LBLSERVICOQTDE."</td><td align='center'>".LBLACAO."</td><td align='right'><img src='imagens/IMAGENS/Titulo_3_.JPG'border='0' width='10'></td></tr>";  		
  		
  		while(Ocifetch($sql)) {
	  		$alarmar = ociresult($sql,'ALARMAR');
	  		$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
	  		$qtde = ociresult($sql,'QTDE');

	  		$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
	  		$ldesquerdo = $lddireito  = "&nbsp;";
	  		//$classe = ($qtde >= 800)?"ExibeGrandeVermelho":$classe;
		  	$classe = ($qtde >= $alarmar)?"ExibeGrandeVermelho":$classe;	
	  		$ret .= "<tr class='".$classe."'><td align='left'>".$ldesquerdo."</td><td>".ociresult($sql,'FILA')."</td><td align='left'>".ociresult($sql,'SEGMENTO')."</td><td align='left'>".ociresult($sql,'TIPO')."</td><td align='center'>".ociresult($sql,'QTDE')."</td><td align='center'>".ociresult($sql,'HR_EXECUTA')."</td><td align='right'>".$lddireito."</td></tr>";
  		}
		
	    $ret .= "</table>";
		
	    $this->FechaBanco();
  		return $ret;
	}
}
?>
