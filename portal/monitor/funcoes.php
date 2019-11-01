<?php
//require_once('../ws/lib/nusoap.php');

ini_set("display_errors",1);
ini_set("display_startup_erros",1);
error_reporting(E_ALL);


class funcoes{
	
	var $conn = "";
	var $operacao = "";
	var $cor = "#ADACC0";
	var $informa = "";
	//var $listaServidores = array("blgpx01", "blgpx02", "blgpx03", "blgpx04");
	var $listaServidores = array("blgpx05", "blgpx06", "blgpx07", "blgpx04");
	var $listaPortas = array("9180", "9380", "9080", "9580");
		
	function funcoes(){
		require("informa_dados.php");
	    $this->informa = new informa_dados();
		
		if(isset($_GET["ope"]))
			$this->operacao = $_GET["ope"];
			
		if($this->operacao == "dth"){
			define("DBUSER","DBMDTH");
		}else{
			define("DBUSER","DBMCABO");
		}
//  		define("DBCID","sinnprod");
  		define("TITULO","Monitores SINN OiTV");
  		define("NOMECABECALHO","Monitores SINN OiTV");
  		define("MONITOR","Monitor de Processos");
  		define("REMESSA","Monitor de Remessa");
  		define("DETALHAREMESSA","Detalhe da Remessa");
  		define("MONITORA","Monitoramento");
  		define("DTH","Monitores SINN DTH");
  		define("CABO","Monitores SINN CABO");
  		
  		define("PROCESSOS","Monitor de Processos");
  		define("MATERIALIZADAS","Views Materializadas");
//  		define("MATERIALIZADAS","Views Materializadas");
  		define("STATUS","Processos");
  		define("PARADOS","Parados");
  		define("EXECUCAO","Em Execução");
  		define("ESPERA","em Espera");
  		define("SUSPENSO","Suspensos");
  		define("GERARQ","Gera Arquivo de BackLog");
  		
  		define("LBLSEMAFORO","Alarme");
  		define("LBLPROCESSO","Processo");
  		define("LBLSTATUS","Status");
  		define("LBLINICIO","Início");
  		define("LBLULTIMA","Última Atualização");
  		define("LBLULTIMAMAQUINA","Máquina");
  		define("LBLFIM","Término");
  		
  		define("LBLPERINI","Período de Início");
  		define("LBLCICLO","Ciclo de Faturamento");
  		define("LBLPERFIM","Período de Término");
  		define("LBLAGENREMESSA","Agenda Remessa");
  		define("LBLPREREMESSA","Agenda Pré-Remessa");
  		define("LBLEMISSAONF","Agenda Emissão NF");
  		define("LBLIMPRESSAONF","Agenda Impressão NF");
  		
  		define("LBLNUMEXEC","Número de Execuções");
  		define("LBLINIPROC","Início do Processo");
  		define("LBLFIMPROC","Término do Processo");
  		
  		//CRONOGRAMA FATURAMENTO
  		define("CRONOGRAMA","Cronograma de Faturamento");
  		define("LBLDATACRONOGRAMA","Mês de Referência");
  		define("LBLSISTEMA","Sistema");
  		define("LBLAREA","Área Responsável");
  		define("LBLDURACAO","Duração");
  		
  		//ALERTAS
  		define("SERVIDORES","Servidores de Aplicação");
  		define("SERVICOS","Web Services");
  		define("LBLAPPSERVER","Application Server");
  		define("LBLWEBSERVER","Web Service");
  		define("LBLACAO","Ação");
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
  		define("LBLAC_INTERFACE","Interface");
  		define("LBLAC_QTDE","Qtde Erros");
  		
  		//$this->ConectaBanco("","");
  		$this->NovaConexaoBanco(DBUSER,"PRODUCAO");
  		set_time_limit(120);
  		
	}
	
	function NovaConexaoBanco($user, $base){
	    
		$dbpas = $this->informa->InformaSenha($user,"",$base);
		$dbcid = $this->informa->InformaBase($user,$base);
		
		
		//$this->conn = ocilogon($user,$dbpas,$dbcid) or die ($user . " " . $dbcid . " " . $base);
		$this->conn = oci_connect($user,$dbpas,$dbcid); // or die ($user . " " . $dbcid . " " . $base);
		
		if (!$this->conn) {
    		$e = oci_error();
    		var_dump($e);
  		    echo htmlentities($e['message']);
  		    echo "aqui";
			print "<br>Error code = "     . $e['code'];
			print "<br>Error message = "  . $e['message'];
			print "<br>Error position = " . $e['offset'];
			print "<br>SQL Statement = "  . $e['sqltext'];
			print "<br>SQL User = "  . $user;
			print "<br>SQL Pass = "  . $dbpas;
			

			trigger_error(htmlentities($e['message']), E_USER_ERROR);

    		/*trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);*/
    		echo("error");
	    }  
	}
	
	function ConectaBancoBcvLock($user,$pass,$cid,$codigo){
		if($user == ""){
			$this->conn = oci_connect(DBUSER,DBPASS,DBCID);
		}else{
			$this->conn = @oci_connect($user,$pass,$cid);
			
			if(!$this->conn){
				$e = oci_error();
				$codigo++;
				$this->DesbloqueiaBCV($codigo);
				
				die(date("d/m/Y H:i:s") . " - ERRO: " . $e['message']);
			}
			
		}
	}
	
	function DesbloqueiaBCV($codigo){
		
		switch ($codigo){
			case 1:
			    echo $codigo;
				$this->ConectaBancoBcvLock("DBMCABO","cabo11bcv","sinnbcv",$codigo);
				break;
			case 2:
				echo $codigo;
			    $this->ConectaBancoBcvLock("DBMDTH","dth11bcv","sinnbcv",$codigo);
				break;
			case 3:
				echo $codigo;
				$this->ConectaBancoBcvLock("BCVCABO","bcv\$10cabooi","sinnbcv",$codigo);
				break;
			case 4:
				echo $codigo;
				$this->ConectaBancoBcvLock("BCVDTH","bcv\$10oidth","sinnbcv",$codigo);
				break;
			case 5:
				echo $codigo;
				die("Não foi possível realizar o desbloqueio");
				break;
		}
		
		$sql = "alter user BCVCABO ACCOUNT UNLOCK";
		
  		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		@ociexecute($sql,OCI_DEFAULT);
  		
		$sql = "alter user BCVDTH ACCOUNT UNLOCK";
  		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		@ociexecute($sql,OCI_DEFAULT);

		$sql = "alter user DBMCABO ACCOUNT UNLOCK";
		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		@ociexecute($sql,OCI_DEFAULT);

		$sql = "alter user DBMDTH ACCOUNT UNLOCK";
  		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		@ociexecute($sql,OCI_DEFAULT);
  		
		
	}
		
	function FechaBanco(){
		@oci_close($this->conn);
	}
	
	function busca_processos_parados($tipo){
		$sql = "select vmp.processo, to_char(vmp.INICIO,'dd/mm/yyyy hh24:mi:ss') inicio, ".
       "to_char(vmp.ultima_atualizacao,'dd/mm/yyyy hh24:mi:ss') ultima_atualizacao, ".
       "to_char(vmp.finalizacao,'dd/mm/yyyy hh24:mi:ss') finalizacao, vmp.status, ".
	   "calc_tempo(vmp.ultima_atualizacao, sysdate) tempo_exe, (sysdate - vmp.ultima_atualizacao)*1440 tempo, ultima_maquina " .
	   "from vw_monitor_processos vmp where vmp.status = :status";
	   
	   switch($tipo){
		   	
			case 1:
		    	$status = "PARADO";
		     	break;
			case 2:
		     	$status = "EM EXECUÇÃO";
		     	break;
			case 3:
		     	$status = "ESPERANDO";
		     	break;
			case 4:
		     	$status = "SUSPENSO";
		     	break;
	    }
	    
	    //echo  $sql . "<br>Status " . $status . "<br>"; 
		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL! ");	   
	
		OCIBindByName ($sql, ":status", $status);
	
		ociexecute($sql,OCI_DEFAULT);
	
		$ret = "";
		//$cor = "#ADACC0";
		while(Ocifetch($sql)) {
		
			$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
			
			if (ociresult($sql,'TEMPO') < 120 && ociresult($sql,'STATUS') == "EM EXECUÇÃO"){
				$img = "<img src='imagens/bullet-green-2.gif'border='0'>";
			}else{
				if(ociresult($sql,'TEMPO') < 120 && ociresult($sql,'STATUS') == "ESPERANDO"){
					$img = "<img src='imagens/bullet-orange-2.gif'border='0' alt='Último update ocorreu a ".ociresult($sql,'TEMPO_EXE')."'>";
				}else{
					$img = "<img src='imagens/bullet-red-2.gif'border='0' alt='Último update ocorreu a ".ociresult($sql,'TEMPO_EXE')."'>";
				}
			}
			
			$ret .= "<tr class='Exibe' bgcolor='".$this->cor."'><td align='center'>$img</td><td>".ociresult($sql,'PROCESSO')."</td><td>&nbsp;".ociresult($sql,'STATUS')."</td>".
			"<td>".ociresult($sql,'INICIO')."&nbsp;</td><td>".ociresult($sql,'ULTIMA_ATUALIZACAO')."&nbsp;</td><td>".ociresult($sql,'ULTIMA_MAQUINA')."&nbsp;</td></tr>";
		}
	
		return $ret;
	}
	
	
	function monitora_views(){
		$sql = "select o.object_name objeto, TO_CHAR(o.last_ddl_time,'DD/MM/YYYY HH24:MI:SS') ultima_atualizacao " .
		"from all_objects o where o.object_type = 'MATERIALIZED VIEW' and trunc(o.last_ddl_time) < trunc(sysdate)";
		
		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");	   
		ociexecute($sql,OCI_DEFAULT);
		
		$ret = "";
		$cor = "#ADACC0";
		while(Ocifetch($sql)) {
		
			$cor = ($cor == "#ADACC0")?"#FFFFFF":$cor = "#ADACC0";
			
			$ret .= "<tr class='Exibe' bgcolor='$cor'><td>".ociresult($sql,'OBJETO')."</td><td>&nbsp;".ociresult($sql,'ULTIMA_ATUALIZACAO')."</td></tr>";
		}
	
		return $ret;
	}
	
	function busca_backlog_dth(){
		$sql = "select count(*) qtde, motivo_os, trunc(dt_baixa) baixa ".
		   	"from Vw_Os_Externa_Base o " .
		   	"where trunc(o.dt_despacho) = trunc(sysdate) and motivo_os = 'Habilitação' group by motivo_os,trunc(dt_baixa)";
		   
		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");	   
		ociexecute($sql,OCI_DEFAULT);
	
		$ret  = "";
		$cont = 0;
		$soma = 0;
		$i	  = 0;
		$dados_motivo = array();
		$dados_qtde   = array();
		$dados_baixa  = array();
	
		while(Ocifetch($sql)) {
			$dados_motivo[$cont] = ociresult($sql,'MOTIVO_OS');
			$dados_qtde[$cont]   =	ociresult($sql,'QTDE');
			$dados_baixa[$cont]  =	ociresult($sql,'BAIXA');
		
			$soma += $dados_qtde[$cont];
		
			$cont++;
		}
		
		while ($i < $cont){
			$ret .= "<tr class='Exibe' bgcolor='#FFFFFF'><td>$dados_motivo[$i]</td><td align='right'>$dados_qtde[$i]&nbsp;</td>".
			"<td align='right'>$dados_baixa[$i]&nbsp;</td><td align='right'>&nbsp;". number_format(100 * ($dados_qtde[$i]/$soma),1)."</td></tr>";
		
			$i++;
		}

   
    	$ret .= "<tr class='Exibe' bgcolor='#E6FDFF'><td><em>TOTAL DE OS</em></td><td align='right'><em>$soma&nbsp;</em></td><td>&nbsp;</td>".
			    "<td>&nbsp</td></tr>";
	
    	return $ret;
	
	}
	
	function CriaMonitoramento($tipo){
		
		$ret = "";
		
		switch($tipo){
		   	
			case 1:
		    	$ret .= "<br><font class='Titulo'>".STATUS." ".PARADOS."</font><br>";
		     	break;
			case 2:
		     	$ret .= "<br><font class='Titulo'>".STATUS." ".EXECUCAO."</font><br>";
		     	break;
			case 3:
		     	$ret .= "<br><font class='Titulo'>".STATUS." ".ESPERA."</font><br>";
		     	break;
			case 4:
		     	$ret .= "<br><font class='Titulo'>".STATUS." ".SUSPENSO."</font><br>";
		     	break;
	    }
		
		
		$ret .= "<table width='100%' border='1' cellspacing='0' cellpadding='0'><tr class='Titulo'><td>".LBLSEMAFORO."</td><td>".LBLPROCESSO."</td><td>".LBLSTATUS."</td><td>".LBLINICIO."</td><td>".LBLULTIMA."</td><td>".LBLULTIMAMAQUINA."</td></tr>";
		$ret .= $this->busca_processos_parados($tipo);
		$ret .= "</table>";
		
		return $ret;
	}
	
	function GeraArquivoBacklog(){
		/*$sql = "select p.cgc_cpf cnpj_cpf, os.contrato, os.data_agendamento, os.periodo_agendamento turno_do_agendamento ".
		"from vm_dbm_os os, contrato_assinante ca, pessoa p where os.cod_status_os in ('AG','AA') ".
		"and (os.data_agendamento >= trunc(sysdate) + 1 or os.data_agendamento is null) and os.contrato = ca.numero ".
		"and ca.id_pessoa = p.id and length(p.cgc_cpf) = 11 order by os.data_agendamento, os.periodo_agendamento";*/
		
		$sql = "select * from VM_URA_AGENDA_OSE os order by os.data_agendamento";
		
		$file = "lote/".date("Ymd") .".txt";
		
		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");	   
		ociexecute($sql,OCI_DEFAULT);
		
		$fp = fopen($file, "w");
				
		while(Ocifetch($sql)) {
		
			$msg = ociresult($sql,'CNPJ_CPF').";".ociresult($sql,'CONTRATO').";".ociresult($sql,'DATA_AGENDAMENTO').";".ociresult($sql,'TURNO_DO_AGENDAMENTO').";\n";
			fwrite($fp, $msg);
		}
		fclose($fp);
		
		$this->FechaBanco();
	}
	
	function BuscaArquivos(){
		
		$ret = "<table align=center border='0' cellpadding='0' cellspacing='0' class='tbl1' width='100%'>";
		$ret .= "<tr class='Titulo'><td>Nome do Arquivo</td></tr>";
		
		$dir = "./lote";
		$cor = "#ADACC0";
		$dh = opendir($dir);

		while (false !== ($filename = readdir($dh))) {
			if (substr($filename,-4) == ".txt") {
				$cor = ($cor == "#ADACC0")?"#FFFFFF":$cor = "#ADACC0";
				$ret .= "<tr class='Exibe' bgcolor='$cor'><td><a href='lote/$filename'>$filename</a></td></tr>";
			}
		}
		$ret .= "</table>";
		
		$this->FechaBanco();
		
		return $ret;
	
	}
	
	function BuscaRemessa(){
		$ret = "";
		
		$ret .= "<table width='100%' border='1' cellspacing='0' cellpadding='0'><tr class='Titulo'><td>".LBLCICLO."</td><td>".LBLPREREMESSA."</td><td>".LBLAGENREMESSA."</td><td>".LBLEMISSAONF."</td><td>".LBLIMPRESSAONF."</td><td>".LBLINIPROC."</td><td>".LBLFIMPROC."</td></tr>";
		//$ret .= "<table width='100%' border='1' cellspacing='0' cellpadding='0'><tr class='Titulo'><td>".LBLPERINI."</td><td>".LBLPERFIM."</td><td>".LBLAGENREMESSA."</td><td>".LBLPREREMESSA."</td><td>".LBLEMISSAONF."</td><td>".LBLIMPRESSAONF."</td><td>Ação</td></tr>";
				
		$sql = "select to_char(af.periodo_inicio,'dd/mm/yyyy') periodo_inicio,to_char(af.periodo_inicio,'mm/yyyy') ciclo, to_char(af.periodo_fim,'dd/mm/yyyy') periodo_fim, to_char(af.data_agendamento_remessa, 'dd/mm/yyyy hh24:mi:ss') data_agendamento_remessa, to_char(af.data_emissao_nf, 'dd/mm/yyyy hh24:mi:ss') data_emissao_nf, to_char(af.data_agendamento_pre_remessa,'dd/mm/yyyy hh24:mi:ss') data_agendamento_pre_remessa, to_char(af.data_impressao_remessa,'dd/mm/yyyy hh24:mi:ss') data_impressao_remessa, af.finalizou_processos_remessa, af.id ";
		$sql .= ", (select to_char(min(pr.inicio),'dd/mm/yyyy hh24:mi:ss') inicio from processo_remessa pr where pr.id_agendamento_faturamento = af.id and pr.classe <> 1820) inicio_processo, ".
		"(select to_char(max(pr.finalizacao),'dd/mm/yyyy hh24:mi:ss') inicio from processo_remessa pr where pr.id_agendamento_faturamento = af.id and pr.classe <> 1820) fim_processo from agendamento_faturamento af order by af.data_agendamento_remessa";
		
		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");	   
		ociexecute($sql,OCI_DEFAULT);
		
		$cor = "#ADACC0";
		while(Ocifetch($sql)) {
		
			$cor = ($cor == "#ADACC0")?"#FFFFFF":$cor = "#ADACC0";
			
			$ret .= "<tr class='Exibe' bgcolor='$cor'><td><a href='DetalhaRemessa.php?ope=$this->operacao&id=".ociresult($sql,'ID')."'>".ociresult($sql,'CICLO')."</a></td>";
			$ret .= "<td>".ociresult($sql,'DATA_AGENDAMENTO_PRE_REMESSA')."</td><td>&nbsp;".ociresult($sql,'DATA_AGENDAMENTO_REMESSA')."</td>";
			$ret .= "<td>".ociresult($sql,'DATA_EMISSAO_NF')."</td><td>&nbsp;".ociresult($sql,'DATA_IMPRESSAO_REMESSA')."</td>";
			$ret .= "<td>".ociresult($sql,'INICIO_PROCESSO')."</td><td>&nbsp;".ociresult($sql,'FIM_PROCESSO')."</td></TR>";
		}
		
		$ret .= "</table>";
		
		$this->FechaBanco();
		
		return $ret;
	}
	
	function BuscaDetalheRemessa($id_remessa){
		$ret = "";
		
		$ret .= "<table width='100%' border='1' cellspacing='0' cellpadding='0'><tr class='Titulo'><td>".LBLPROCESSO."</td><td>".LBLINICIO."</td><td>".LBLULTIMA."</td><td>".LBLFIM."</td><td>".LBLSTATUS."</td><td>".LBLNUMEXEC."</td></tr>";
				
		$sql = "select decode(pb.classe,845, 'REMESSA REAL CC', 849, 'REMESSA UNIBANCO CC', 848, 'REMESSA ITAU CC', 846, 'REMESSA HSBC CC', 844, 'REMESSA BRASIL CC', 847, 'REMESSA BRADESCO CC', 9873265365, 'REMESSA BOLETO REGISTRADO BANCO DO BRASIL', 102334, 'REMESSA TERCEIROS TELEMAR', 1820, 'REMESSA PRE-EXTRATO', 102434, 'REMESSA TERCEIROS BRTEL' ,pb.classe) processo, ".
		"to_char(pb.inicio, 'dd/mm/yyyy hh24:mi:ss') inicio,to_char(pb.ultima_atualizacao, 'dd/mm/yyyy hh24:mi:ss') ultima_atualizacao,to_char(pb.finalizacao, 'dd/mm/yyyy hh24:mi:ss') finalizacao,decode(pb.status,'F', 'FINALIZADO', 'E', 'EM EXECUÇÃO', pb.status) status,pb.numero_execucoes,pb.total_execucoes,pb.arquivo,pb.resumo_execucao " .
		"from processo_remessa pb where pb.id_agendamento_faturamento = :id_remessa order by pb.inicio, pb.finalizacao";
		
		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");	   
		OCIBindByName ($sql, ":id_remessa", $id_remessa);
		ociexecute($sql,OCI_DEFAULT);
		
		$cor = "#ADACC0";
		while(Ocifetch($sql)) {
		
			$cor = ($cor == "#ADACC0")?"#FFFFFF":$cor = "#ADACC0";
			
			$ret .= "<tr class='Exibe' bgcolor='$cor'><td>".ociresult($sql,'PROCESSO')."</td><td>&nbsp;".ociresult($sql,'INICIO')."</td>";
			$ret .= "<td>".ociresult($sql,'ULTIMA_ATUALIZACAO')."</td><td>&nbsp;".ociresult($sql,'FINALIZACAO')."</td>";
			$ret .= "<td>".ociresult($sql,'STATUS')."</td><td>&nbsp;".ociresult($sql,'NUMERO_EXECUCOES')."</td></TR>";
		}
		
		$ret .= "</table>";
		
		$this->FechaBanco();
		
		return $ret;
	}
	
	function BuscaCronogramaFaturamento(){
		
		$ret = "";
		$ret .= "<table width='100%' border='1' cellspacing='0' cellpadding='0'><tr class='Titulo'><td>".LBLDATACRONOGRAMA."</td><td>".LBLSISTEMA."</td></tr>";
		
		$sql = "select oi.mes_referencia, oi.sistema from oitv_cronograma_faturamento oi group by oi.mes_referencia, oi.sistema";
		
		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");	   
		ociexecute($sql,OCI_DEFAULT);
		
		$cor = "#ADACC0";
		while(Ocifetch($sql)) {
		
			$cor = ($cor == "#ADACC0")?"#FFFFFF":$cor = "#ADACC0";
			$ret .= "<tr class='Exibe' bgcolor='$cor'><td><a href='?sistema=".strtolower(ociresult($sql,'SISTEMA'))."&mes=".ociresult($sql,'MES_REFERENCIA')."'>".ociresult($sql,'MES_REFERENCIA')."</a></td><td>".ociresult($sql,'SISTEMA')."</td></tr>";
		}
		$ret .= "</table>";
		
		return $ret;
	}
	
	function BuscaDetalheCronogramaFaturamento($mes_ref,$sistema){
		
		$ret = "";
		$ret .= "<table width='100%' border='1' cellspacing='0' cellpadding='0'><tr class='Titulo'><td>".CRONOGRAMA."</td><td>".LBLAREA."</td><td>".LBLINICIO."</td><td>".LBLFIM."</td><td>".LBLDURACAO."</td></tr>";
		
		$sql = "select oi.tarefa, oi.area, to_char(oi.inicio,'dd/mm/yyyy hh24:mi:ss') inicio, to_char(oi.termino,'dd/mm/yyyy hh24:mi:ss') termino, oi.mes_referencia, oi.sistema, calc_tempo(oi.inicio, oi.termino) tempo from oitv_cronograma_faturamento oi ".
		"where oi.mes_referencia = :mes_ref and oi.sistema = :sistema order by oi.id";
		
		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL! $sql");

		OCIBindByName ($sql, ":mes_ref", $mes_ref);
		OCIBindByName ($sql, ":sistema", strtoupper($sistema));
		
		ociexecute($sql,OCI_DEFAULT);   
		
		$cor = "#ADACC0";
		while(Ocifetch($sql)) {
		
			$cor = ($cor == "#ADACC0")?"#FFFFFF":$cor = "#ADACC0";
			$ret .= "<tr class='Exibe' bgcolor='$cor'><td>".ociresult($sql,'TAREFA')."</td><td>".ociresult($sql,'AREA')."</td><td>".ociresult($sql,'INICIO')."</td><td>".ociresult($sql,'TERMINO')."</td><td>".ociresult($sql,'TEMPO')."</td></tr>";
		}
		$ret .= "</table>";
		
		$this->FechaBanco();
		return $ret;
	}	
	
	function CriaMonitor($tipo){
		
		$ret = "";
		
		switch($tipo){
		   	
			case 1:
		    	//$ret .= "<br><font class='Titulo'>".STATUS."</font><br>";
		    	//$ret .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td align='left'><img src='imagens/IMAGENS/Titulo_1_.JPG'border='0' width='10'></td><td width='10%'>".LBLSEMAFORO."</td><td width='60%'>".LBLPROCESSO."</td><td>".LBLACAO."</td><td align='right'><img src='imagens/IMAGENS/Titulo_3_.JPG'border='0' width='10'></td></tr>";
		    	$ret .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td width='10%'>".LBLSEMAFORO."</td><td width='60%'>".LBLPROCESSO."</td><td>".LBLACAO."</td></tr>";
		    	$ret .= $this->BuscaProcessosAlerta($tipo,"CABO");
		    	
		    	$this->NovaConexaoBanco("DBMDTH","PRODUCAO");
		    	
		    	$ret .= $this->BuscaProcessosAlerta($tipo,"DTH");
		    	$this->FechaBanco();
		    	$ret .= "</table>";
		
		    	$this->FechaBanco();
		    	break;
			case 2:
		    	//$ret .= "<br><font class='Titulo'>".SERVIDORES."</font><br>";
		    	//$ret .= "<p><br></p>";
		    	//$ret .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td align='left'><img src='imagens/IMAGENS/Titulo_1_.JPG' border='0' width='10'></td><td width='10%'>".LBLSEMAFORO."</td><td width='60%'>".LBLAPPSERVER."</td><td>".LBLACAO."</td><td align='right'><img src='imagens/IMAGENS/Titulo_3_.JPG' border='0' width='10'></td></tr>";
		    	$ret .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td width='10%'>".LBLSEMAFORO."</td><td width='60%'>".LBLAPPSERVER."</td><td>".LBLACAO."</td></tr>";

/* PORTAS
8080 - OK
8980 - OK
9080 - OK
9480 - OK
9580 - OK

SINNWEB
9180 - OK
9380 - OK
*/		    	
		    	
		    			    			    	
		    	for($indice = 1; $indice < 7; $indice ++){
		    		$porta = "8080";

		    		while($porta != "9580"){
			    		ini_set('default_socket_timeout', 10);
			    		$appserver = $this->BuscaServidorAplicacaoIsAlive($indice,$porta);
			    		
			    		//echo $appserver;
			    		//$file = "http://blgpx04:9580/healthcheck/alive.jsp";

			    		$data = "";
			    		$data = @file_get_contents($appserver);
			    		
			    		//echo $appserver . " - " . $data;
			    		
			    		if (!strpos($data, "lgpx")){
			    			$conectado = false;
			    		}
						else{
						    $conectado = true;
						}
			    		
						/*if ($porta == "9180"){
						   $data = "blgpx01 - 9180";	
						   echo strpos($data, "blg");
						   if (!strpos($data, "blg"))
			    			  echo $data ." - " . $conectado . "<br>";
		    			  }*/

						
			    		if($indice < 3){
				    		if (!strpos($data, "SINN")){
					    		$conectado = false;
					    	}else{
						    	$conectado = true;
					    	}
				    		$porta = "9380";
			    		}

			    		//$conectado = @fsockopen($appserver, $porta, $numeroDoErro, $stringDoErro, 5); // Este último é o timeout, em segundos
	    			
			    		if (!$conectado) {
				    		$img = "<img src='imagens/bullet-red-2.gif'border='0' alt='Servidor de aplicação não responde'>";
				    		$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
				    		$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
				    		//$seg = ($seg == "DTH")?"CABO":$seg = "DTH";
				    		
						    //$msg = "DTH: ABRIR ARS";
						    $SevARS = $this->informa->InformaSeveridadeARS();
						    //$this->gravaLog($appserver.":".$porta);
						    //$this->gravaLog($appserver);//Removido em 19/11/2013
						    switch($porta){
					    		case "8080":
									$msg = "START_DTH_ARS";
					    			break;
					    		case "8980":
					    		    break;
					    		case "9080":
					    			$msg = "URA_CABO_ARS";
					    		    break;
					    		case "9480":
					    			$msg = "SL_CABO_ARS";
					    		    break;
					    		case "9180":
					    		    $msg = "SW_CABO_ARS";
					    			break;
					    		case "9380":
					    			$msg = "SW_DTH_ARS";
					    		    break;
					    		case "9580":
					    		    $msg = "AO_DTH_ARS";
					    			break;
					    		default:
					    			$porta = "9580";
					    		    break;    
				    		}
						    
						    
						    /*if(($porta == "9180") || ($porta == "9380")){
							    if($porta == "9180"){
								    $segmento = "CABO";
							    }else{
								    $segmento = "DTH";
							    }
							    
							    $msg = "SW_".$segmento."_".$SevARS;
						    }else{
							    if($porta == "9080"){
								    $segmento = "CABO";
							    }else{
								    $segmento = "DTH";
							    }
							    $msg = "APPSERVER_".$segmento."_".$SevARS;
						    }*/
						    //$porta = "9580";
				
				    		$ret .= "<tr class='".$classe."'><td align='center'>$img</td><td>".$appserver."</td><td align='left'>$msg</td></tr>";
			    		}
			    		//fclose($conectado);			    		
			    		
			    		//echo $porta . " - ";
			    					    		
			    		switch($porta){
				    		case "8080":
				    		    $porta = "8980";
				    		    break;
				    		case "8980":
				    		    $porta = "9080";
				    		    break;
				    		case "9080":
				    		    $porta = "9480";
				    		    break;
				    		case "9480":
				    		    $porta = "9180";
				    		    break;
				    		case "9180":
				    			$porta = "9380";
				    		    break;
				    		case "9380":
				    			$porta = "9580";
				    		    break;
				    		default:
				    			$porta = "9580";
				    		    break;    
			    		}
		    		}  
	    		}
		    	
		    	$ret .= "</table>";
		     		
		    	break;
			case 3:
				$ret .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td width='20%'>Serviço</td><td width='60%'>WebService</td><td>".LBLACAO."</td></tr>";
	    		for($i = 0; $i < 4; $i++){
		    		
		    		for($j = 1; $j < 4; $j++){
			    		if($j < 2){//Serviços SINN Web
			    			$retorno = $this->verificaStatusServicoLoginSINN($this->listaServidores[$i], $this->listaPortas[$j]);
			    			$pos = strpos($retorno, "sucesso");
			    			
			    			if($pos == false){
				    			$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
								$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
				    			
								$wsdl = "http://".$this->listaServidores[$i].":".$this->listaPortas[$j]."/webservices-sinnweb/SinnWebWs?wsdl";
				    			$segmento = $this->listaPortas[$j] == "9180"?"CABO":"DTH";
				    			$msg = "SW_".$segmento."_ARS";
				    			
				    			$ret .= "<tr class=".$classe."><td>realizaLoginUsuarioESenha</td><td>".$wsdl."</td><td>".$msg."</td></tr>";
			    			}
			    				
		    			}else{//Serviços URA
			    			$retorno = $this->verificaStatusServicoLoginSinnUra($this->listaServidores[$i], $this->listaPortas[$j]);
			    			
			    			if (!($retorno > 0))
			    				$pos = false;
			    			else
			    				$pos = true;	
			    			
			    			if($pos == false){
				    			$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
								$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
				    			
								$wsdl = "http://".$this->listaServidores[$i].":".$this->listaPortas[$j]."/webservices-ura/UraWs?wsdl";
								$segmento = $this->listaPortas[$j] == "9080"?"CABO":"DTH";
				    			$msg = "URA_".$segmento."_ARS";
				    			
				    			$ret .= "<tr class=".$classe."><td>consultaContrato</td><td>".$wsdl."</td><td>".$msg."</td></tr>";
			    			}
		    			}
		    		}
		    		
		    		
	    		}
	    		
	    		for($serv = 4; $serv < 8; $serv++){
		    		for($porta = 1; $porta < 8; $porta++){
			    		$url = "http://blgpx0".$serv.":8".$porta."80/healthcheck/alive.jsp";
			    		
			    		$data = "";
			    		$data = @file_get_contents($url);
			    		
			    		/*echo $url . " - " . $data;
			    		exit();*/
			    		
			    		if (!strpos($data, "lgpx")){
			    			$conectado = false;
			    		}
						else{
						    $conectado = true;
						} 
						
						if (!$conectado) {
							$img = "<img src='imagens/bullet-red-2.gif'border='0' alt='Servidor de aplicação não responde'>";
				    		$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
				    		$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
				    		//$seg = ($seg == "DTH")?"CABO":$seg = "DTH";
				    		
						    //$msg = "DTH: ABRIR ARS";
						    $SevARS = $this->informa->InformaSeveridadeARS();
						    $segmento = "DTH";
						    $msg = "URA_".$segmento."_ARS";
						    $ret .= "<tr class='".$classe."'><td align='center'>$img</td><td>".$url."</td><td align='left'>$msg</td></tr>";
							set_time_limit(1000);
						}
			    		
		    		}
	    		}
	    		
				
		    	$ret .= "</table>";

			
				//$ret .= "<br><font class='Titulo'>".SERVICOS."</font><br>";
		    	//$ret .= "<p><br></p>";
		    	//$ret .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td align='left'><img src='imagens/IMAGENS/Titulo_1_.JPG'border='0' width='10'></td><td width='10%'>".LBLSEMAFORO."</td><td width='60%'>".LBLWEBSERVER."</td><td>".LBLACAO."</td><td align='right'><img src='imagens/IMAGENS/Titulo_3_.JPG'border='0' width='10'></td></tr>";
		    	//$ret .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td width='10%'>".LBLSEMAFORO."</td><td width='60%'>".LBLWEBSERVER."</td><td>".LBLACAO."</td></tr>";
		     	//$ret .= "</table>";
		     	
		     	//mail("helio.filho@oi.net.br", "Verifique esta mensagem!", "O PHP é o melhor!", "From: Monitoramento SINN OiTV <helio.filho@oi.net.br>\n\n");
		     	//mail("03188833055@sms.oi.com.br,03188010701@sms.oi.com.br", "Notificacao de Alarme", "Processo: REFRESH STATUS", "From: Monitoramento SINN OiTV\n\n");
		     	//mail("03188010701@sms.oi.com.br", "Verifique esta mensagem!", "Teste de envio de SMS", "From: Monitoramento SINN OiTV <helio.filho@oi.net.br>\n\n");
		     	//mail("03188845055@sms.oi.com.br,03188010701@sms.oi.com.br", "Notificacao de Alarme", "Processo: REFRESH STATUS", "From: Monitoramento SINN OiTV\n\n");
		    	
		    	break;
	    }
	    
		return $ret;
	}

	function BuscaProcessosAlerta($tipo,$seg){
		if($tipo == 1){
			/*$sql = "select vmp.processo, to_char(vmp.INICIO,'dd/mm/yyyy hh24:mi:ss') inicio, ".
       		"to_char(vmp.ultima_atualizacao,'dd/mm/yyyy hh24:mi:ss') ultima_atualizacao, ".
       		"to_char(vmp.finalizacao,'dd/mm/yyyy hh24:mi:ss') finalizacao, vmp.status, ".
	   		"calc_tempo(vmp.ultima_atualizacao, sysdate) tempo_exe, (sysdate - vmp.ultima_atualizacao)*1440 tempo " .
	   		"from vw_monitor_processos vmp where vmp.status in (:parado, :esperando, :suspenso)and vmp.ordem = :ordem " .
	   		"and (sysdate - vmp.ultima_atualizacao)*24 > 1 and to_number(to_char(sysdate, 'HH24')) - 5 > 0";*/
	   		
	   		$sql = "select vmp.processo, to_char(vmp.INICIO,'dd/mm/yyyy hh24:mi:ss') inicio, ".
       		"to_char(vmp.ultima_atualizacao,'dd/mm/yyyy hh24:mi:ss') ultima_atualizacao, ".
       		"to_char(vmp.finalizacao,'dd/mm/yyyy hh24:mi:ss') finalizacao, vmp.status, ".
	   		"calc_tempo(vmp.ultima_atualizacao, sysdate) tempo_exe, (sysdate - vmp.ultima_atualizacao)*1440 tempo, vmp.grupo " .
	   		"from vw_monitor_processos vmp where vmp.status in (:parado)and vmp.ordem = :ordem " .
	   		"/*and (sysdate - vmp.ultima_atualizacao)*24 > 1 and to_number(to_char(sysdate, 'HH24')) - 5 > 0*/";
	   		
	   		
	   		//echo $sql;
	   		
	   		$parado = "PARADO";
	   		$esperando = "ESPERANDO";
	   		$suspenso = "SUSPENSO";
	   		$ordem = 1;
	   		$msg = "";
	   
	   		//echo $sql;
	   		
			//$con = $this->ConectaBanco();
			$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");	   
			
			OCIBindByName ($sql, ":parado", $parado);
/*			OCIBindByName ($sql, ":esperando", $esperando);
			OCIBindByName ($sql, ":suspenso", $suspenso);*/
			OCIBindByName ($sql, ":ordem", $ordem);
	
			ociexecute($sql,OCI_DEFAULT) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
	
			$ret = "";
			$classe = "";
			//$cor = "#ADACC0";
			while(Ocifetch($sql)) {
				$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
				$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
				$msg = "";
			
				if ((ociresult($sql,'TEMPO') < 120 && ociresult($sql,'STATUS') == "EM EXECUÇÃO") || ociresult($sql,'STATUS') == "SUSPENSO"){
					$img = "<img src='imagens/bullet-green-2.gif'border='0'>";
				}else{
					if(ociresult($sql,'STATUS') == "ESPERANDO"){
						$img = "<img src='imagens/bullet-orange-2.gif'border='0' alt='Último update ocorreu a ".ociresult($sql,'TEMPO_EXE')."'>";
						$msg = $seg .": ATENÇÃO";
					}else{
						$img = "<img src='imagens/bullet-red-2.gif'border='0' alt='Último update ocorreu a ".ociresult($sql,'TEMPO_EXE')."'>";
						$SevARS = $this->informa->InformaSeveridadeARS();
						$msg =  "PROC_". $seg ."_". ociresult($sql,'GRUPO') ."_". $SevARS;
						
						//$this->gravaLog(ociresult($sql,'PROCESSO').";".$seg);//Removido em 19/11/2013
					}
				}
				
			
/*				if ($classe == "ExibeGrande"){
					$ldesquerdo = "<img src='imagens/IMAGENS/linha_1_1_.JPG' border='0' width='22%'>";
					$lddireito = "<img src='imagens/IMAGENS/linha_1_3_.JPG' border='0' width='22%'>";
				}else{
					$ldesquerdo = "<img src='imagens/IMAGENS/linha_2_3_.JPG' border='0' width='22%'>";
					$lddireito = "<img src='imagens/IMAGENS/linha_2_1_.JPG' border='0' width='22%'>";
				}*/
//				if(ociresult($sql,'STATUS') == "PARADO"){
					//$ret .= "<tr class='".$classe."'><td align='left'>".$ldesquerdo."</td><td align='center'>$img</td><td>".ociresult($sql,'PROCESSO')."</td><td align='left'>$msg</td><td align='right'>".$lddireito."</td></tr>";
					$ret .= "<tr class='".$classe."'><td align='center'>$img</td><td>".ociresult($sql,'PROCESSO')."</td><td align='left'>$msg</td></tr>";
//				}
			}
		}
	
		return $ret;
	}
	
	function BuscaServidorAplicacaoIsAlive($indice,$porta){
		switch($indice){
			case 1:
				$appserver[$indice] = "http://sinncluster01.telemar:8080/sinndth_producao/";
				//echo $indice . " " .$appserver[$indice] . "<br>";
				return $appserver[$indice];
				break;
			case 2:
				$appserver[$indice] = "http://sinncluster01.telemar:8080/sinntv_producao/";
				//echo $indice . " " .$appserver[$indice] . "<br>";
				return $appserver[$indice];
				break;
			case 3:
				$appserver[$indice] = "http://blgpx05:$porta/healthcheck/alive.jsp";
				//echo $indice . " " .$appserver[$indice] . "<br>";
				return $appserver[$indice];
				break;
			//case 4:
				//$appserver[$indice] = "http://blgpx01:$porta/healthcheck/alive.jsp";
				//echo $indice . " " .$appserver[$indice] . "<br>";
				//return $appserver[$indice];
				//break;
			case 4:
				$appserver[$indice] = "http://blgpx06:$porta/healthcheck/alive.jsp";
				//echo $indice . " " .$appserver[$indice] . "<br>";
				return $appserver[$indice];
				break;
			case 5:
				$appserver[$indice] = "http://blgpx07:$porta/healthcheck/alive.jsp";
				//echo $indice . " " .$appserver[$indice] . "<br>";
				return $appserver[$indice];
				break;
			case 6:
				$appserver[$indice] = "http://blgpx04:$porta/healthcheck/alive.jsp";
				//echo $indice . " " .$appserver[$indice] . "<br>";
				return $appserver[$indice];
				break;
			/*case 8:
				$appserver[$indice] = "http://blgpx01:$porta/healthcheck/alive.jsp";
				//echo $indice . " " .$appserver[$indice] . "<br>";
				return $appserver[$indice];
				break;
			case 9:
				$appserver[$indice] = "http://blgpx02:$porta/healthcheck/alive.jsp";
				//echo $indice . " " .$appserver[$indice] . "<br>";
				return $appserver[$indice];
				break;
			case 10:
				$appserver[$indice] = "http://blgpx02:$porta/healthcheck/alive.jsp";
				//echo $indice . " " .$appserver[$indice] . "<br>";
				return $appserver[$indice];
				break;
			case 11:
				$appserver[$indice] = "http://blgpx03:$porta/healthcheck/alive.jsp";
				//echo $indice . " " .$appserver[$indice] . "<br>";
				return $appserver[$indice];
				break;				
			case 12:
				$appserver[$indice] = "http://blgpx03:$porta/healthcheck/alive.jsp";
				//echo $indice . " " .$appserver[$indice] . "<br>";
				return $appserver[$indice];
				break;
			case 13:
				$appserver[$indice] = "http://blgpx04:$porta/healthcheck/alive.jsp";
				//echo $indice . " " .$appserver[$indice] . "<br>";
				return $appserver[$indice];
				break;
			case 14:
				$appserver[$indice] = "http://blgpx04:$porta/healthcheck/alive.jsp";
				//echo $indice . " " .$appserver[$indice] . "<br>";
				return $appserver[$indice];
				break;*/
		}
	}	
	
	function BuscaServidorAplicacao($indice,$porta){
		switch($indice){
			case 1:
				$appserver[$indice] = "sinncluster01.telemar";
				return $appserver[$indice];
				break;
			case 2:
				$appserver[$indice] = "blgpx05.telemar";
				return $appserver[$indice];
				break;
			case 3:
				$appserver[$indice] = "blgpx06.telemar";
				return $appserver[$indice];
				break;
			case 4:
				$appserver[$indice] = "blgpx07.telemar";
				return $appserver[$indice];
				break;
			case 5:
				$appserver[$indice] = "blgpx04.telemar";
				return $appserver[$indice];
				break;
/*			case 6:
				$appserver[$indice] = "blgprd03.telemar";
				return $appserver[$indice];
				break;*/
		}
	}
	
	/*NÃO ESTÁ EM PRODUÇÃO*/
	function ProcessosSemExecutar(){
		  		
  		$sql = "select pc.processo, to_char(pc.inicio, 'dd/mm/yyyy hh24:mi:ss') inicio, pc.ultima_atualizacao, to_char(pc.finalizacao, 'dd/mm/yyyy hh24:mi:ss') termino, 'DTH' segmento from vw_processos_criticos pc where to_number(to_char(sysdate, 'HH24')) > 15 union all " .
  			   "select pc.processo, to_char(pc.inicio, 'dd/mm/yyyy hh24:mi:ss') inicio, pc.ultima_atualizacao, to_char(pc.finalizacao, 'dd/mm/yyyy hh24:mi:ss') termino, 'CABO' segmento from dbmcabo.vw_processos_criticos pc where to_number(to_char(sysdate, 'HH24')) > 15 ";
  		
  		//echo $sql;	   
  		//$this->ConectaBanco("DBMDTH","dth11dbm");
  		
		$this->NovaConexaoBanco("DBMDTH","PRODUCAO");
		
  		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		ociexecute($sql,OCI_DEFAULT) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td width='40%'>".LBLPROCESSO."</td><td>".LBLINIPROC."</td><td>".LBLFIMPROC."</td><td align='center'>".LBLACAO."</td></tr>";
  		
  		while(Ocifetch($sql)) {
	  		$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
	  		$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
	  		
			$msg = ociresult($sql,'SEGMENTO') . ": ABRIR ARS";
			
			$ret .= "<tr class='".$classe."'><td>".ociresult($sql,'PROCESSO')."</td><td align='left'>".ociresult($sql,'INICIO')."</td><td align='left'>".ociresult($sql,'TERMINO')."</td><td align='center'>".$msg."</td></tr>";

  		}
  		$this->FechaBanco();
  		
  		$ret .= "</table>";
  			   
  		return $ret;
	}
	
	function ProcessosCriticos(){
		  		
  		$sql = "select processo, p.categoria_processo, to_char(max(trunc(p.finalizacao)), 'dd/mm/yyyy') ultima_execucao, 'DTH' segmento " .
  			   "from vw_dth_analise_processos p where greatest(p.inicio, p.ultima_atualizacao) < sysdate - (15/24) and greatest(trunc(p.inicio), trunc(p.ultima_atualizacao)) = trunc(sysdate) and not exists (select 1 from vw_dth_analise_processos pp " .
               "where pp.processo = p.processo and (trunc(pp.inicio) = trunc(sysdate) or trunc(pp.ultima_atualizacao) = trunc(sysdate))) and exists (select 1 from processos_criticos pc where pc.processo = p.processo and pc.dias_execucao like '%'||to_char(sysdate,'d')||'%') " .
   			   "and trunc(p.finalizacao) < trunc(sysdate) group by processo, p.categoria_processo UNION ALL ".
   			   "select processo, p.categoria_processo, to_char(max(trunc(p.finalizacao)), 'dd/mm/yyyy') ultima_execucao, 'CABO' segmento " .
  			   "from dbmcabo.vw_cabo_analise_processos p where greatest(p.inicio, p.ultima_atualizacao) < sysdate - (15/24) and greatest(trunc(p.inicio), trunc(p.ultima_atualizacao)) = trunc(sysdate) and not exists (select 1 from dbmcabo.vw_cabo_analise_processos pp " .
               "where pp.processo = p.processo and (trunc(pp.inicio) = trunc(sysdate) or trunc(pp.ultima_atualizacao) = trunc(sysdate))) and exists (select 1 from dbmcabo.processos_criticos pc where pc.processo = p.processo and pc.dias_execucao like '%'||to_char(sysdate,'d')||'%') " .
   			   "and trunc(p.finalizacao) < trunc(sysdate) group by processo, p.categoria_processo ";
   			   
   		//echo $sql;	   
  		  		
  		$this->NovaConexaoBanco("DBMDTH","PRODUCAO");
  		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		ociexecute($sql,OCI_DEFAULT) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		//$ret = "<table width='100%' border='1' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td align='left'><img src='imagens/IMAGENS/Titulo_1_.JPG'border='0' width='10'></td><td width='40%'>".LBLPROCESSO."</td><td>".LBLINIPROC."</td><td align='right'>".LBLFIMPROC."</td><td align='right'><img src='imagens/IMAGENS/Titulo_3_.JPG'border='0' width='10'></td></tr>";	   	   
  		//$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td align='left'><img src='imagens/IMAGENS/Titulo_1_.JPG'border='0' width='10'></td><td width='40%'>".LBLPROCESSO."</td><td>".LBLCATEGORIA."</td><td>".LBLEXECUCAO."</td><td align='center'>".LBLACAO."</td><td align='right'><img src='imagens/IMAGENS/Titulo_3_.JPG'border='0' width='10'></td></tr>";
  		$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'></td><td width='40%'>".LBLPROCESSO."</td><td>".LBLCATEGORIA."</td><td>".LBLEXECUCAO."</td><td align='center'>".LBLACAO."</td></tr>";
  		
  		while(Ocifetch($sql)) {
	  		
	  		if((ociresult($sql,'PROCESSO') <> "NOTIFICAÇÃO INADIMPLÊNCIA ENVIO")|| ((ociresult($sql,'PROCESSO') == "NOTIFICAÇÃO INADIMPLÊNCIA ENVIO") and (date("H") > 14))){
		  		$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
		  		$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
	  		
			  	$SevARS = $this->informa->InformaSeveridadeARS();
				$msg = "PC_".ociresult($sql,'SEGMENTO')."_".$SevARS;
				
				//$this->gravaLog(ociresult($sql,'PROCESSO').";".ociresult($sql,'SEGMENTO'));//Removido em 19/11/2013
			
		  		//$ret .= "<tr class='".$classe."'><td align='left'>".$ldesquerdo."</td><td>".ociresult($sql,'PROCESSO')."</td><td align='left'>".ociresult($sql,'CATEGORIA_PROCESSO')."</td><td align='left'>".ociresult($sql,'ULTIMA_EXECUCAO')."</td><td align='center'>".$msg."</td><td align='right'>".$lddireito."</td></tr>";
		  		$ret .= "<tr class='".$classe."'><td>&nbsp;".ociresult($sql,'PROCESSO')."</td><td align='left'>".ociresult($sql,'CATEGORIA_PROCESSO')."</td><td align='left'>".ociresult($sql,'ULTIMA_EXECUCAO')."</td><td align='center'>".$msg."</td></tr>";
	  		}	

  		}
  		$this->FechaBanco();
  		
  		$ret .= "</table>";
  		
  			   
  		return $ret;
	}
	
	function FilaComandosAprovisionamento(){
		
		/*$sql = "select 'INTRAWAYQUEUE' fila, 'DTH' segmento, 'DTH' tipo, count(*) qtde from intrawayqueue union all " .
			   "select 'ACC4000QUEUETB' fila, 'CABO' segmento, 'Analógico' tipo, count(*) qtde from sinntv.acc4000queuetb union all ".
			   "select 'SCIATLANTABOSSQUEUE' fila, 'CABO' segmento, 'Digital' tipo, count(*) qtde from sinntv.sciatlantabossqueue union all ".
			   "select 'CSMQUEUETB' fila, 'CABO' segmento, 'Velox' tipo, count(*) qtde from sinntv.csmqueuetb union all " .
			   "select 'SGFTQUEUE' fila, 'CABO' segmento, 'SGFT' tipo, count(*) qtde from sinntv.Sgftqueue union all " .
			   "select 'SGFTQUEUE' fila, 'DTH' segmento, 'SGFT' tipo, count(*) qtde from sinndth.Sgftqueue";*/
			   
		/*$sql = "SELECT 'INTRAWAYQUEUE' fila,'DTH' segmento,' ' tipo,  to_char(min(i.data_hora_geracao), 'DD/MM/YYYY HH24:MI:SS') hr_executa, COUNT(*) qtde, COUNT(DISTINCT contrato_numero) contratos FROM INTRAWAY_COMANDO I WHERE I.DATA_HORA_GERACAO BETWEEN SYSDATE - 1 AND SYSDATE AND I.DATA_HORA_PROCESSAMENTO IS NULL UNION ALL " .
			   "SELECT 'ACC4000QUEUETB' fila, 'CABO' segmento, 'Analógico' tipo, to_char(min(i.data_hora_geracao), 'DD/MM/YYYY HH24:MI:SS') hr_executa, COUNT(*) qtde, COUNT(DISTINCT contrato_numero) contratos FROM sinntv.acc_comando I WHERE I.DATA_HORA_GERACAO BETWEEN SYSDATE - 1 AND SYSDATE AND I.DATA_HORA_PROCESSAMENTO IS NULL UNION ALL " .
			   "SELECT 'SCIATLANTABOSSQUEUE' fila, 'CABO' segmento, 'Digital' tipo, to_char(min(i.data_hora_geracao), 'DD/MM/YYYY HH24:MI:SS') hr_executa, COUNT(*) qtde, COUNT(DISTINCT contrato_numero) contratos FROM sinntv.sciatlanta_boss_comando I WHERE I.DATA_HORA_GERACAO BETWEEN SYSDATE - 1 AND SYSDATE AND I.DATA_HORA_PROCESSAMENTO IS NULL UNION ALL " .
			   "SELECT 'CSMQUEUETB' fila, 'CABO' segmento, 'Velox' tipo, to_char(min(i.data_hora_geracao), 'DD/MM/YYYY HH24:MI:SS') hr_executa, COUNT(*) qtde, COUNT(DISTINCT contrato_numero) contratos FROM sinntv.csm_comando I WHERE I.DATA_HORA_GERACAO BETWEEN SYSDATE - 1 AND SYSDATE AND I.DATA_HORA_PROCESSAMENTO IS NULL UNION ALL " .
			   "select 'SGFTQUEUE' fila, 'DTH' segmento, 'SGFT' tipo, to_char(min(enq_time), 'DD/MM/YYYY HH24:MI:SS') hr_executa, count(*) qtde, 0 contratos from sinndth.Sgftqueue union ALL " .
			   "select 'SGFTQUEUE' fila, 'CABO' segmento, 'SGFT' tipo, to_char(min(enq_time), 'DD/MM/YYYY HH24:MI:SS') hr_executa, count(*) qtde, 0 contratos from sinntv.Sgftqueue ";*/
			   
		$sql = "select * from vw_monitor_filas_comando";	   
		
		$this->NovaConexaoBanco("DBMDTH","PRODUCAO");
  		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		ociexecute($sql,OCI_DEFAULT) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
		
  		//$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td align='left'><img src='imagens/IMAGENS/Titulo_1_.JPG'border='0' width='10'></td><td width='40%'>".LBLSERVICO."</td><td>".LBLSERVICOSEG."</td><td>".LBLSERVICOTIPO."</td><td align='center'>".LBLSERVICOQTDE."</td><td align='center'>".LBLACAO."</td><td align='right'><img src='imagens/IMAGENS/Titulo_3_.JPG'border='0' width='10'></td></tr>";  		
  		//$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td width='40%'>".LBLSERVICO."</td><td>".LBLSERVICOSEG."</td><td>".LBLSERVICOTIPO."</td><td align='center'>".LBLSERVICOQTDE." Comandos</td><td align='center'>".LBLSERVICOQTDE." Contratos</td><td align='center'>Em Execução</td><td align='center'>".LBLACAO."</td></tr>";  		
  		$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td width='40%'>".LBLSERVICO."</td><td>".LBLSERVICOSEG."</td><td>".LBLSERVICOTIPO."</td><td align='center'>".LBLSERVICOQTDE." Comandos</td><td align='center'>".LBLSERVICOQTDE." Contratos</td><td align='center'>Em Execução</td><td align='center'>".LBLACAO."</td></tr>";  		
  		
  		while(Ocifetch($sql)) {
	  		$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
	  		$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
	  		$qtde = ociresult($sql,'QTDE');
	  		$msg = "&nbsp;";
	  		if ($qtde >= 400){
		  		
		  		if ($qtde <= 800){
			  		$SevARS = $this->informa->InformaSeveridadeARS();
		  		}else{
			  		$SevARS = "ARS";
		  		}

		  		switch (ociresult($sql,'FILA')){
			  		case "INTRAWAYQUEUE":
			  			$msg = "APRO_" . ociresult($sql,'SEGMENTO') . "_" . $SevARS;
			  			break;
			  		case "ACC4000QUEUE":
			  			$msg = "APRO_" . ociresult($sql,'SEGMENTO') . "_ANALOGICO_" . $SevARS;
			  			break;
			  		case "SCIATLANTABOSSQUEUE":
			  			$msg = "APRO_" . ociresult($sql,'SEGMENTO') . "_DIGITAL_" . $SevARS;
			  			break;
			  		case "CSMQUEUETB":
			  			$msg = "APRO_" . ociresult($sql,'SEGMENTO') . "_VELOX_" . $SevARS;
			  			break;
		  		}
		  		//$this->gravaLog(ociresult($sql,'FILA').";".ociresult($sql,'SEGMENTO'));//Removido em 19/11/2013
	  		}
	  		
	  		//$ret .= "<tr class='".$classe."'><td align='left'>".$ldesquerdo."</td><td>".ociresult($sql,'FILA')."</td><td align='left'>".ociresult($sql,'SEGMENTO')."</td><td align='left'>".ociresult($sql,'TIPO')."</td><td align='center'>".ociresult($sql,'QTDE')."</td><td align='center'>".$msg."</td><td align='right'>".$lddireito."</td></tr>";
	  		//$ret .= "<tr class='".$classe."'><td>&nbsp;".ociresult($sql,'FILA')."</td><td align='left'>".ociresult($sql,'SEGMENTO')."</td><td align='left'>".ociresult($sql,'TIPO')."</td><td align='center'>".ociresult($sql,'QTDE')."</td><td align='center'>".$msg."</td></tr>";
	  		if(ociresult($sql,'FILA') == "SGFTQUEUE") {
		  		$ret .= "<tr class='".$classe."'><td>".ociresult($sql,'FILA')."</td><td align='left'>".ociresult($sql,'SEGMENTO')."</td><td align='left'>".ociresult($sql,'TIPO')."</td><td align='center'>".ociresult($sql,'QTDE')."</td><td align='center'>-</td><td align='center'>".ociresult($sql,'HR_EXECUTA')."</td><td align='center'>".$msg."</td></tr>";
	  		}else{
		  		$ret .= "<tr class='".$classe."'><td>".ociresult($sql,'FILA')."</td><td align='left'>".ociresult($sql,'SEGMENTO')."</td><td align='left'>".ociresult($sql,'TIPO')."</td><td align='center'>".ociresult($sql,'QTDE')."</td><td align='center'>".ociresult($sql,'QTDE')."</td><td align='center'>".ociresult($sql,'HR_EXECUTA')."</td><td align='center'>".$msg."</td></tr>";
	  		}
  		}
		
	    $ret .= "</table>";
		
	    $this->FechaBanco();
  		return $ret;
	}
	
	function ViewsReguaCobrana(){
		
		$sql = "select ao.owner dono, ao.object_name objeto, to_char(trunc(ao.last_ddl_time),'DD/MM/YYYY') atualizacao, ao.object_type tipo_objeto from all_objects ao where ao.owner = 'DBMDTH' and ao.object_name in ('VM_DTH_ANALISE_INADIMPLENCIA') and trunc(ao.last_ddl_time) != trunc(sysdate) and ao.Object_Type <> 'TABLE' and to_number(to_char(sysdate,'HH24')) > 5 union all ".
			   "select ao.owner dono, ao.object_name objeto, to_char(trunc(ao.last_ddl_time),'DD/MM/YYYY') atualizacao, ao.object_type tipo_objeto from all_objects ao where ao.owner = 'DBMDTH' and ao.object_name in ('VM_DTH_AUDITA_REGUA_BASE','VM_DTH_ANALISE_REGUACOB','VM_DTH_ANALISE_REGUACOB_ACOES') and trunc(ao.last_ddl_time) != trunc(sysdate) and ao.Object_Type <> 'TABLE' and to_number(to_char(sysdate,'HH24')) > 10 union all ".
			   "select ao.owner dono, ao.object_name objeto, to_char(trunc(ao.last_ddl_time),'DD/MM/YYYY') atualizacao, ao.object_type tipo_objeto from all_objects ao where ao.owner = 'DBMDTH' and ao.object_name in ('VM_DTH_ANALISE_REGUACOB_CP','VM_DTH_REGUA_BACKLOG','VM_DTH_REGUA_EXECUCAO','VM_DTH_REGUA_EXECUCAO_TOTAL ','VM_DTH_REGUA_PREVISAO_BLOQ','VM_DTH_REGUA_BACKLOG_DET') and trunc(ao.last_ddl_time) != trunc(sysdate) and ao.Object_Type <> 'TABLE' and to_number(to_char(sysdate,'HH24')) > 11 union all ".
			   "select ao.owner dono, ao.object_name objeto, to_char(trunc(ao.last_ddl_time),'DD/MM/YYYY') atualizacao, ao.object_type tipo_objeto from all_objects ao where ao.owner = 'DBMCABO' and ao.object_name in ('VM_CABO_ANALISE_INADIMPLENCIA') and trunc(ao.last_ddl_time) != trunc(sysdate) and ao.Object_Type <> 'TABLE' and to_number(to_char(sysdate,'HH24')) > 5 union all ".
			   "select ao.owner dono, ao.object_name objeto, to_char(trunc(ao.last_ddl_time),'DD/MM/YYYY') atualizacao, ao.object_type tipo_objeto from all_objects ao where ao.owner = 'DBMCABO' and ao.object_name in ('VM_CABO_AUDITA_REGUA_BASE','VM_CABO_ANALISE_REGUACOB','VM_CABO_ANALISE_REGUACOB_ACOES') and trunc(ao.last_ddl_time) != trunc(sysdate) and ao.Object_Type <> 'TABLE' and to_number(to_char(sysdate,'HH24')) > 10 union all ".
			   "select ao.owner dono, ao.object_name objeto, to_char(trunc(ao.last_ddl_time),'DD/MM/YYYY') atualizacao, ao.object_type tipo_objeto from all_objects ao where ao.owner = 'DBMCABO' and ao.object_name in ('VM_CABO_ANALISE_REGUACOB_CP','VM_CABO_REGUA_BACKLOG','VM_CABO_REGUA_EXECUCAO','VM_CABO_REGUA_EXECUCAO_TOTAL ','VM_CABO_REGUA_PREVISAO_BLOQ','VM_CABO_REGUA_BACKLOG_DET') and trunc(ao.last_ddl_time) != trunc(sysdate) and ao.Object_Type <> 'TABLE' and to_number(to_char(sysdate,'HH24')) > 11 ";
			   
		//echo $sql;
		$this->NovaConexaoBanco("DBMDTH","BCV");
  		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		ociexecute($sql,OCI_DEFAULT) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
		
  		//$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td align='left'><img src='imagens/IMAGENS/Titulo_1_.JPG'border='0' width='10'></td><td width='20%'>".LBLSERVICOSEG."</td><td>".LBLOBJETO."</td><td>".LBLATUALIZACAO."</td><td align='center'>".LBLTIPO."</td><td align='center'>".LBLACAO."</td><td align='right'><img src='imagens/IMAGENS/Titulo_3_.JPG'border='0' width='10'></td></tr>";
  		$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td width='20%'>".LBLSERVICOSEG."</td><td>".LBLOBJETO."</td><td>".LBLATUALIZACAO."</td><td align='center'>".LBLTIPO."</td><td align='center'>".LBLACAO."</td></tr>";
  		
  		while(Ocifetch($sql)) {
	  		$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
	  		$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
	  		$segmento = (ociresult($sql,'DONO') == "DBMDTH")?"DTH":"CABO";
	  		
	  		$SevARS = $this->informa->InformaSeveridadeARS();
	  		$msg = "VM_RC_".$segmento."_".$SevARS;
	  		
	  		//$this->gravaLog(ociresult($sql,'OBJETO').";".$segmento);//Removido em 19/11/2013
	  		
	  		//$ret .= "<tr class='".$classe."'><td align='left'>".$ldesquerdo."</td><td>".$segmento."</td><td align='left'>&nbsp;".ociresult($sql,'OBJETO')."</td><td align='left'>".ociresult($sql,'ATUALIZACAO')."</td><td align='center'>".ociresult($sql,'TIPO_OBJETO')."</td><td align='center'>".$msg."</td><td align='right'>".$lddireito."</td></tr>";
	  		$ret .= "<tr class='".$classe."'><td>".$segmento."</td><td align='left'>&nbsp;".ociresult($sql,'OBJETO')."</td><td align='left'>".ociresult($sql,'ATUALIZACAO')."</td><td align='center'>".ociresult($sql,'TIPO_OBJETO')."</td><td align='center'>".$msg."</td></tr>";
  		}
		
	    $ret .= "</table>";
  		
  		$this->FechaBanco();
  		return $ret;
	}
	
	
	function ErroAnaliseCredito(){
		$sql = "select 'DBMDTH' dono, 'Transact' interface, count(*) qtde from vw_dth_analise_credito_diario acd where acd.descricao like 'Erro%' ".
  			   "and calc_tempo(acd.hora_criacao, sysdate) < '01:00:00' having count(*) >= 10";
			   
		$this->NovaConexaoBanco("DBMDTH","PRODUCAO");
  		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		ociexecute($sql,OCI_DEFAULT) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
		
  		//$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td align='left'><img src='imagens/IMAGENS/Titulo_1_.JPG'border='0' width='10'></td><td width='20%'>".LBLSERVICOSEG."</td><td>".LBLOBJETO."</td><td>".LBLATUALIZACAO."</td><td align='center'>".LBLTIPO."</td><td align='center'>".LBLACAO."</td><td align='right'><img src='imagens/IMAGENS/Titulo_3_.JPG'border='0' width='10'></td></tr>";
  		$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td>".LBLAC_INTERFACE."</td><td>".LBLAC_QTDE."</td><td align='center'>".LBLACAO."</td></tr>";
  		
  		while(Ocifetch($sql)) {
	  		$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
	  		$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
	  		$segmento = (ociresult($sql,'DONO') == "DBMDTH")?"DTH":"CABO";
	  		
	  		$SevARS = $this->informa->InformaSeveridadeARS();
	  		$msg = "AC_".$segmento."_".$SevARS;
	  		$ret .= "<tr class='".$classe."'><td align='left'>&nbsp;".ociresult($sql,'INTERFACE')."</td><td align='center'>".ociresult($sql,'QTDE')."</td><td align='center'>".$msg."</td></tr>";
	  		
	  		//$this->gravaLog(ociresult($sql,'INTERFACE'));//Removido em 19/11/2013
  		}
		
	    $ret .= "</table>";
  		
  		$this->FechaBanco();
  		return $ret;
	}
	
	function ViewsInformacionais(){
		
		$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td width='20%'>".LBLSERVICOSEG."</td><td>".LBLOBJETO."</td><td align='center'>".LBLTIPO."</td><td align='center'>".LBLACAO."</td></tr>";
		for($i = 0; $i < 2; $i++){
			/*$sql = "select va.object_name, va.tipo_objeto, va.owner from VW_DTH_ANALISE_VIEWS_TABELAS va where to_number(to_char(sysdate, 'D')) between 2 and 6 ".
  			   "and to_number(to_char(sysdate, 'HH24')) between 11 and 23 and va.dias_sem_atualizacao > 0 union all select va.object_name, va.tipo_objeto, va.owner ".
  			   "from dbmcabo.VW_CABO_ANALISE_VIEWS_TABELAS va where to_number(to_char(sysdate, 'D')) between 2 and 6 and to_number(to_char(sysdate, 'HH24')) between 11 and 23 ".
  			   "and va.dias_sem_atualizacao > 0";*/
  			   
  		
  			   
			//echo $sql;	   
			
			if($i == 0){
				$this->NovaConexaoBanco("DBMDTH","BCV");
				$sql = "select va.nome_objeto, va.tipo_objeto, va.owner from VW_DTH_ANALISE_VIEWS_TABELAS va where to_number(to_char(sysdate, 'D')) between 2 and 6 ".
				"and to_number(to_char(sysdate, 'HH24')) between 11 and 23 and va.dias_sem_atualizacao > 0";
			}else{
				$this->NovaConexaoBanco("DBMCABO","BCV");
				$sql = "select va.nome_objeto, va.tipo_objeto, va.owner from dbmcabo.VW_CABO_ANALISE_VIEWS_TABELAS va where to_number(to_char(sysdate, 'D')) between 2 and 6 ".
				"and to_number(to_char(sysdate, 'HH24')) between 11 and 23 and va.dias_sem_atualizacao > 0";
			}
  		
  			$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  			ociexecute($sql,OCI_DEFAULT) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
	  		while(Ocifetch($sql)) {
		  		$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
		  		$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
		  		$segmento = (ociresult($sql,'OWNER') == "DBMDTH")?"DTH":"CABO";
		  		
		  		$SevARS = $this->informa->InformaSeveridadeARS();
		  		$msg = "VM_RC_".$segmento."_".$SevARS;
		  		$ret .= "<tr class='".$classe."'><td>".$segmento."</td><td align='left'>&nbsp;".ociresult($sql,'NOME_OBJETO')."<td align='center'>".ociresult($sql,'TIPO_OBJETO')."</td><td align='center'>".$msg."</td></tr>";
		  		
		  		//$this->gravaLog(ociresult($sql,'NOME_OBJETO').";".$segmento);//Removido em 19/11/2013
	  		}
	  		$this->FechaBanco();
  		}
  		
  		$ret .= "</table>";
  		
  		return $ret;

	}
	
	function ServidorDeTravas(){
		$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td width='20%'>".LBLSEMAFORO."</td><td align='center'>".LBLTIPO."</td><td align='center'>".LBLACAO."</td></tr>";
		
		$sql = "select * FROM dbmcabo.vw_cabo_check_svrtrava WHERE teste_servidor = 'Servidor de Trafas DOWN'";
		$this->NovaConexaoBanco("DBMDTH","PRODUCAO");
		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		ociexecute($sql,OCI_DEFAULT) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		while(Ocifetch($sql)) {
	  		
	  		$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
		  	$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
		  	$segmento = "DTH";//(ociresult($sql,'OWNER') == "DBMDTH")?"DTH":"CABO";
		  	
		  	$img = "<img src='imagens/bullet-red-2.gif'border='0'>";
		  	$SevARS = $this->informa->InformaSeveridadeARS();
		  	$msg = "ST_".$segmento."_".$SevARS;
		  	$ret .= "<tr class='".$classe."'><td align='center'>".$img."</td><td align='left'>&nbsp;SERVIDOR DE TRAVAS (TRAVALOCKDIGINET)</td><td align='center'>".$msg."</td></tr>";

  		}
		
		$ret .= "</table>";
		$this->FechaBanco();
		return $ret;
	}
	
	function gravaLog($alarme){
		
		$fp = fopen("Analisar/logExecucao_".date("Y-m-d").".txt", "a+");
		
		$msg = date("Y/m/d H:i:s") .";";
		
		fwrite($fp, $msg . $alarme ."\n");
		
		fclose($fp);
		
	}
	
	function verificaStatusServicoLoginSINN($appserver, $porta){
		$bodyxml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:obj="objectiveng.sinnweb">'.
	   '<soapenv:Header/>'.
	   '<soapenv:Body>'.
	   '   <obj:realizaLoginUsuarioESenha>'.
	   '      <!--Optional:-->'.
	   '      <login>w1025139</login>'.
	   '      <!--Optional:-->'.
	   '      <senha>w1025139</senha>'.
	   '      <!--Optional:-->'.
	   '      <canal>web</canal>'.
	   '   </obj:realizaLoginUsuarioESenha>'.
	   '</soapenv:Body>'.
	   '</soapenv:Envelope>';
	
	   
	   $wsdl = "http://".$appserver.":".$porta."/webservices-sinnweb/SinnWebWs?wsdl";
	   
		$client = new nusoap_client($wsdl,true);
		$err = $client->getError();
		if ($err) {
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
			exit();
		}
		$useCURL = 0;
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
	  			return '<h2>Error</h2><pre>' . $err . '</pre>';
	 		}
		}
		
		
		return $result['return']['mensagem'];
		
		//return $cliente;
	}
	
	function verificaStatusServicoLoginSinnUra($NomeAppServer, $NumPorta){
	
		$cpf = $NumPorta=="9580"?"31360017453":"03144722669";
		
		$bodyxml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:obj="objectiveng.ura">'.
	   '<soapenv:Header/>'.
	   '<soapenv:Body>'.
	   '   <obj:consultaContrato>'.
	   '      <!--Optional:-->'.
	   '      <cpfCnpj>'.$cpf.'</cpfCnpj>'.
	   '      <!--Optional:-->'.
	   '      <telefone></telefone>'.
	   '   </obj:consultaContrato>'.
	   '</soapenv:Body>'.
	   '</soapenv:Envelope>';
	   
	   $wsdl = "http://".$NomeAppServer.":".$NumPorta."/webservices-ura/UraWs";
	
		$client = new nusoap_client($wsdl,true);
		$err = $client->getError();
		if ($err) {
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
			exit();
		}
		$useCURL = 0;
		$client->soap_defencoding = 'utf-8';
		$client->useHTTPPersistentConnection();
		$client->setUseCurl($useCURL);
		$bsoapaction = "consultaContrato";
		$result = $client->send($bodyxml, $bsoapaction);
		// Check for a fault
		if ($client->fault) {
			echo '<h2>Fault</h2><pre>';
	 		print_r($result);
		 	echo '</pre>';
		 	$msg = "ERRO;";
		 	//GravaLog($msg);//Removido em 19/11/2013
		} else {
			// Check for errors
		 	$err = $client->getError();
	 		if ($err) {
		 		// Display the error
		 		//mail("3188010701@sms.oi.com.br", "Notificacao de Alarme", "Servico: URA de Atendimento: ".$NomeAppServer.";".$NumPorta." Data: ".date("d/m/Y G:i:s"), "From: OiTV Monitoramento Ativo\n\n");
	  			return '<h2>Error</h2><pre>' . $err . '</pre>';
	 		}
		}
		
		return $result['return']['numero'];
	}
	
	function ExecucaoBcv(){
		$ret = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='TituloGrande'><td width='50%'>Etapas</td><td align='center'>Horário</td><td align='center'>Alerta</td></tr>";
		
		$sql = "SELECT * FROM vw_monitoria_bcv where alerta is not null ORDER BY horario";
		$this->NovaConexaoBanco("DBMDTH","BCV");
		//$this->NovaConexaoBanco("DBMDTH","PRODUCAO");
		$sql = ociparse($this->conn,$sql) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		ociexecute($sql,OCI_DEFAULT) or die("ERRO NA ANÁLISE DA CLÁUSULA SQL!");
  		
  		while(Ocifetch($sql)) {
	  		$hora = date("H") . ":00"; 
	  		
	  		if($hora == ociresult($sql,'HORARIO')){
		  			  		
		  		$this->cor = ($this->cor == "#ADACC0")?"#FFFFFF":$this->cor = "#ADACC0";
			  	$classe = ($this->cor == "#ADACC0")?"ExibeGrande":"ExibeGrandeBranco";
			  	$segmento = "DTH";//(ociresult($sql,'OWNER') == "DBMDTH")?"DTH":"CABO";
			  	
			  	$img = "<img src='imagens/bullet-red-2.gif'border='0'>";
			  	$SevARS = $this->informa->InformaSeveridadeARS();
			  	//$msg = "ST_".$segmento."_".$SevARS;
			  	$msg = ociresult($sql,'ALERTA');
			  	switch(ociresult($sql,'ALERTA')){
				  	case "ALTERTA BCV CABO-F1":
				  		$msg = "BCV_CABO_F1_ARS";
				  		break;
				  	case "ALTERTA BCV CABO-F2":
				  		$msg = "BCV_CABO_F2_ARS";
				  		break;
				  	case "ALTERTA BCV CABO-F3":
				  		$msg = "BCV_CABO_F3_ARS";
				  		break;
				  	case "ALTERTA BCV CABO-F4":
				  		$msg = "BCV_CABO_F4_ARS";
				  		break;
				  	case "ALTERTA BCV DTH-F1":
				  		$msg = "BCV_DTH_F1_ARS";
				  		break;
				  	case "ALTERTA BCV DTH-F2":
				  		$msg = "BCV_DTH_F2_ARS";
				  		break;
				  	case "ALTERTA BCV DTH-F3":
				  		$msg = "BCV_DTH_F3_ARS";
				  		break;
				  	case "ALTERTA BCV DTH-F4":
				  		$msg = "BCV_DTH_F4_ARS";
				  		break;
			  	}	
			  	$ret .= "<tr class='".$classe."'><td align='left'>&nbsp;".ociresult($sql,'IMPACTO')."</td><td align='left'>&nbsp;".ociresult($sql,'HORARIO')."</td><td align='center'>&nbsp;".$msg."</td></tr>";
	  		}

  		}
		
		$ret .= "</table>";
		$this->FechaBanco();
		
		$ret .= "</table>";
		return $ret;
	}
}
?>
