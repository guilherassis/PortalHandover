<?php

class CadastrarDAO {
	
	function calcularValidacao($consulta){
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
		
		/*$sq_historico = mysql_query("SET @inicio = (SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=1);
		SET @fim = (SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=2);
		
		SET @total = @fim - @inicio;
		SELECT @total;");
		
		$t=mysql_result($sq_historico,0);*/
		
		$sq_inicio = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=1" );
		$sq_fim = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=2" );
		
		$sq_inicio_parada = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=13" );
		$sq_fim_parada = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=14" );
		
		$inicio = mysql_fetch_row($sq_inicio);
		$fim = mysql_fetch_row($sq_fim);
		$inicio_parada = mysql_fetch_row($sq_inicio_parada);
		$fim_parada = mysql_fetch_row($sq_fim_parada);
		
		if($inicio[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$inicio[0] = time();
		}
		
		
		if($fim[0]==0){
			if($inicio_parada[0]<0){
				$fim[0] = $inicio_parada[0];
				
			}else{
				date_default_timezone_set('America/Sao_Paulo');
				$fim [0]= time();
			}
		}
		
		if($inicio_parada[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$inicio_parada[0]= time();
		}
		
		if($fim_parada[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$fim_parada[0]= time();
		}
		//echo "(".$fim_parada." - ".$inicio_parada.") - (".$fim."-".$inicio.")";
		$total = ($fim_parada[0]-$inicio_parada[0]) - ($fim[0] - $inicio[0]);
		
		
	
		
	return abs($total);
		$conn->FechaConexao();;
	}
	
	function calcularConstrucao($consulta){
		
		
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
	
	
		$sq_inicio = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=3" );
		$sq_fim = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=4" );
	
		$sq_inicio_parada = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=15" );
		$sq_fim_parada = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=16" );
	
		$inicio = mysql_fetch_row($sq_inicio);
		$fim = mysql_fetch_row($sq_fim);
		$inicio_parada = mysql_fetch_row($sq_inicio_parada);
		$fim_parada = mysql_fetch_row($sq_fim_parada);
		
		if($inicio[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$inicio[0] = time();
		}
		
		
		if($fim[0]==0){
			if($inicio_parada[0]<0){
				$fim[0] = $inicio_parada[0];
				
			}else{
				date_default_timezone_set('America/Sao_Paulo');
				$fim [0]= time();
			}
		}
		
		if($inicio_parada[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$inicio_parada[0]= time();
		}
		
		if($fim_parada[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$fim_parada[0]= time();
		}
		//echo "(".$fim_parada." - ".$inicio_parada.") - (".$fim."-".$inicio.")";
		$total = ($fim_parada[0]-$inicio_parada[0]) - ($fim[0] - $inicio[0]);
	
	
		return abs($total);
		$conn->FechaConexao();
	}
	
	function calcularTeste($consulta){
	
		
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
	
	
		$sq_inicio = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=5" );
		$sq_fim = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=6" );
	
		$sq_inicio_parada = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=17" );
		$sq_fim_parada = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=18" );
	
		$inicio = mysql_fetch_row($sq_inicio);
		$fim = mysql_fetch_row($sq_fim);
		$inicio_parada = mysql_fetch_row($sq_inicio_parada);
		$fim_parada = mysql_fetch_row($sq_fim_parada);
		
		if($inicio[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$inicio[0] = time();
		}
		
		
		if($fim[0]==0){
			if($inicio_parada[0]<0){
				$fim[0] = $inicio_parada[0];
				
			}else{
				date_default_timezone_set('America/Sao_Paulo');
				$fim [0]= time();
			}
		}
		
		if($inicio_parada[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$inicio_parada[0]= time();
		}
		
		if($fim_parada[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$fim_parada[0]= time();
		}
		//echo "(".$fim_parada." - ".$inicio_parada.") - (".$fim."-".$inicio.")";
		$total = ($fim_parada[0]-$inicio_parada[0]) - ($fim[0] - $inicio[0]);
	
	
	
		return abs($total);
		$conn->FechaConexao();
	}
	
	
	function calcularImplatacao($consulta){
	
		
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
	
	
		$sq_inicio = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=7" );
		$sq_fim = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=8" );
	
		$sq_inicio_parada = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=19" );
		$sq_fim_parada = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=20" );
	
		$inicio = mysql_fetch_row($sq_inicio);
		$fim = mysql_fetch_row($sq_fim);
		$inicio_parada = mysql_fetch_row($sq_inicio_parada);
		$fim_parada = mysql_fetch_row($sq_fim_parada);
		
		if($inicio[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$inicio[0] = time();
		}
		
		
		if($fim[0]==0){
			if($inicio_parada[0]<0){
				$fim[0] = $inicio_parada[0];
				
			}else{
				date_default_timezone_set('America/Sao_Paulo');
				$fim [0]= time();
			}
		}
		
		if($inicio_parada[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$inicio_parada[0]= time();
		}
		
		if($fim_parada[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$fim_parada[0]= time();
		}
		//echo "(".$fim_parada." - ".$inicio_parada.") - (".$fim."-".$inicio.")";
		$total = ($fim_parada[0]-$inicio_parada[0]) - ($fim[0] - $inicio[0]);
	
	
		return abs($total);
		$conn->FechaConexao();
	}
	
	function calcularValidacaoProducao($consulta){
	
		
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
	
	
		$sq_inicio = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=9" );
		$sq_fim = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=10" );
	
		$sq_inicio_parada = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=21" );
		$sq_fim_parada = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=22" );
	
		$inicio = mysql_fetch_row($sq_inicio);
		$fim = mysql_fetch_row($sq_fim);
		$inicio_parada = mysql_fetch_row($sq_inicio_parada);
		$fim_parada = mysql_fetch_row($sq_fim_parada);
		
		if($inicio[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$inicio[0] = time();
		}
		
		
		if($fim[0]==0){
			if($inicio_parada[0]<0){
				$fim[0] = $inicio_parada[0];
				
			}else{
				date_default_timezone_set('America/Sao_Paulo');
				$fim [0]= time();
			}
		}
		
		if($inicio_parada[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$inicio_parada[0]= time();
		}
		
		if($fim_parada[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$fim_parada[0]= time();
		}
		//echo "(".$fim_parada." - ".$inicio_parada.") - (".$fim."-".$inicio.")";
		$total = ($fim_parada[0]-$inicio_parada[0]) - ($fim[0] - $inicio[0]);
		return abs($total);
		$conn->FechaConexao();
	}
	
	function calcularReteste($consulta){
	
		
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
	
	
		$sq_inicio = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=11" );
		$sq_fim = mysql_query("SELECT SUM(data) from controle_tempo where id_demanda=".$consulta." and codigo=12" );
	
		
		$inicio = mysql_fetch_row($sq_inicio);
		$fim = mysql_fetch_row($sq_fim);
		
	
		if($inicio[0]==0){
			date_default_timezone_set('America/Sao_Paulo');
			$inicio[0] = time();
		}
	
	
		if($fim[0]==0){
			
				date_default_timezone_set('America/Sao_Paulo');
				$fim[0] = time();
			}
		
	
		
		//echo "(".$fim_parada." - ".$inicio_parada.") - (".$fim."-".$inicio.")";
		$total = ($fim[0] - $inicio[0]);
	
	
	
	
		return abs($total);
		$conn->FechaConexao();
	}
	
	function finalizarDemanda($consulta){
		
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
        
		date_default_timezone_set('America/Sao_Paulo');
		$data = date("Y-m-d");
		$sq_historico = mysql_query("UPDATE handover_demandas SET finalizada=1, data_fim='".$data."' where id=".$consulta->getId());
	//echo "UPDATE demanda SET finalizada=1, data_fim='".$data."' where id=".$consulta->getId();
		$conn->FechaConexao();
	}
	
	function registraHistoricoResponsavel($consulta){
		
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
		
		$sq_historico = mysql_query("INSERT INTO historico (responsavel, executante, id_demanda, acao, data, status, sub_status)
				Values (".$consulta->getResponsavel().",".$consulta->getExecutante().",".$consulta->getId().", 'Alterar Responsável','".$consulta->getDataInicio()."',".$consulta->getStatus().",".$consulta->getSubStatus().")");
				
		$conn->FechaConexao();
		}
		
		function registraHistoricoStatus($consulta){
			
			$conn = new Conection(); $conn->AbreConexao();
			
			$sq_historico = mysql_query("INSERT INTO historico (responsavel, executante, id_demanda, acao, data, status, sub_status)
				Values (".$consulta->getResponsavel().",".$consulta->getExecutante().",".$consulta->getId().", 'Alterar Status','".$consulta->getDataFim()."',".$consulta->getStatus().",".$consulta->getSubStatus().")");
		
			$conn->FechaConexao();
		}
	
	function alterarResponsavel($consulta) {
		
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
	
		$sq_Demanda = mysql_query("UPDATE handover_demandas set responsavel=".$consulta->getResponsavel()." where id=".$consulta->getId());
		//echo "SELECT id, nome FROM usuario where ativo=1 and id!=".$id." ORDER BY nome";
		
		if($sq_Demanda){
			return TRUE;
		}else{
			//echo"INSERT INTO Demanda (nome_Demanda, ativo, segmento_mercado, descricao, ultima_alteracao) VALUES ('".$Demanda->getNome()."',".$Demanda->getAtivo().", '".$Demanda->getSegmento()."', '".$Demanda->getDescricao()."', ".$Demanda->getUltimaModicacao().")";
			return FALSE;
		}
		
	
		$conn->FechaConexao();
	
	}
	
	
	function alterarBasel($consulta) {
	
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
	
		$sq_Demanda = mysql_query("UPDATE handover_demandas set base=".$consulta->getBase()." where id=".$consulta->getId());
		//echo "UPDATE demanda set base=".$consulta->getBase()." where id=".$consulta->getId();
	
		if($sq_Demanda){
			return TRUE;
		}else{
			//echo"INSERT INTO Demanda (nome_Demanda, ativo, segmento_mercado, descricao, ultima_alteracao) VALUES ('".$Demanda->getNome()."',".$Demanda->getAtivo().", '".$Demanda->getSegmento()."', '".$Demanda->getDescricao()."', ".$Demanda->getUltimaModicacao().")";
			return FALSE;
		}
	
	
		$conn->FechaConexao();
	
	}
	
	function inserirTempo($consulta) {
		
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
	
		$sq_Demanda = mysql_query("INSERT INTO controle_tempo (id_demanda, data, codigo)
				VALUES (".$consulta->getId().",".$consulta->getDataInicio().",".$consulta->getTempo().")");
/*echo "INSERT INTO controle_tempo (id_demanda, data, codigo)
			VALUES (".$consulta->getId().",".$consulta->getDataInicio().",".$consulta->getTempo().")";		
		*/
		if($sq_Demanda){
			return TRUE;
		}else{
			//echo"INSERT INTO Demanda (nome_Demanda, ativo, segmento_mercado, descricao, ultima_alteracao) VALUES ('".$Demanda->getNome()."',".$Demanda->getAtivo().", '".$Demanda->getSegmento()."', '".$Demanda->getDescricao()."', ".$Demanda->getUltimaModicacao().")";
			return FALSE;
		}
	
	
		$conn->FechaConexao();
	
	}
	
	
	function retirarResponsavel($consulta) {
	
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
	
		$sq_Demanda = mysql_query("UPDATE handover_demandas set responsavel=0 where id=".$consulta->getId());
		
		if($sq_Demanda){
			return TRUE;
		}else{
			//echo"INSERT INTO Demanda (nome_Demanda, ativo, segmento_mercado, descricao, ultima_alteracao) VALUES ('".$Demanda->getNome()."',".$Demanda->getAtivo().", '".$Demanda->getSegmento()."', '".$Demanda->getDescricao()."', ".$Demanda->getUltimaModicacao().")";
			return FALSE;
		}
	
	
		$conn->FechaConexao();
	
	}
	
	
	
	
	function alterarStatus($consulta) {
		
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
        
		$sq_Demanda = mysql_query("UPDATE handover_demandas set status=".$consulta->getStatus().", sub_status=".$consulta->getSubStatus()." where id=".$consulta->getId());
		//echo "UPDATE demanda set status=".$consulta->getStatus().", sub_status=".$consulta->getSubStatus()." where id=".$consulta->getId();
	
		if($sq_Demanda){
			return TRUE;
		}else{
			//echo"INSERT INTO Demanda (nome_Demanda, ativo, segmento_mercado, descricao, ultima_alteracao) VALUES ('".$Demanda->getNome()."',".$Demanda->getAtivo().", '".$Demanda->getSegmento()."', '".$Demanda->getDescricao()."', ".$Demanda->getUltimaModicacao().")";
			return FALSE;
		}
	
	
		$conn->FechaConexao();
	
	}
	
     function preencheSelectResponsavel($id) {
        
      require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();

        $sq_Demanda = mysql_query("SELECT id, nome FROM handover_usuario where ativo=1 and perfil = 1 and id!=".$id." ORDER BY nome");
		//echo "SELECT id, nome FROM usuario where ativo=1 and id!=".$id." ORDER BY nome";
        return $sq_Demanda;
        $conn->FechaConexao();
        
    }
    
    function preencheSelectResponsavelPesquisa() {
    
    	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
    
    	$sq_Demanda = mysql_query("SELECT id, nome FROM handover_usuario where ativo=1 and perfil = 1 ORDER BY nome");
    	//echo "SELECT id, nome FROM usuario where ativo=1 and id!=".$id." ORDER BY nome";
    	return $sq_Demanda;
    	$conn->FechaConexao();
    
    }

    function preencheSelectFrentePesquisa() {
    
    	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
    
    	$sq_Demanda = mysql_query("SELECT id, nome FROM handover_frentes WHERE 1");
    	//echo "SELECT id, nome FROM usuario where ativo=1 and id!=".$id." ORDER BY nome";
    	return $sq_Demanda;
    	$conn->FechaConexao();
    
    }

    

    function preencheSelectRequisitosPesquisa() {
    
    	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
    
    	$sq_Demanda = mysql_query("SELECT id, nome FROM handover_requisitos WHERE 1");
    	//echo "SELECT id, nome FROM usuario where ativo=1 and id!=".$id." ORDER BY nome";
    	return $sq_Demanda;
    	$conn->FechaConexao();
    
    }
    
    
    function preencheSelectStatus($id,$tipo) {
    	
    require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
    
    	$sq_Demanda = mysql_query("SELECT s.id, s.status FROM status s, status_grupo g where g.grupo =".$id." and s.id=g.id_status and g.tipo=".$tipo." ORDER BY s.id");
    	//echo "SELECT s.id, s.status FROM status s, status_grupo g where g.grupo =".$id." and id=id_status ORDER BY s.id";
    	return $sq_Demanda;
    	$conn->FechaConexao();
    
    }
    
    function preencheSelectBases() {
    	 
    	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
    
    	$sq_Demanda = mysql_query("SELECT * FROM bases ORDER BY base");
    	//echo "SELECT s.id, s.status FROM status s, status_grupo g where g.grupo =".$id." and id=id_status ORDER BY s.id";
    	return $sq_Demanda;
    	$conn->FechaConexao();
    
    }
    
    
    function preencheSelectSubStatus($id) {
    	
    	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
    
    	$sq_Demanda = mysql_query("SELECT id, sub_status FROM sub_status where id_status =".$id->getId()." ORDER BY id");
    	//echo "SELECT id, sub_status FROM sub_status where id_status =".$id->getId()." ORDER BY id";
    	return $sq_Demanda;
    	$conn->FechaConexao();
    
    }
    
    function buscaHistorico($id){
    
    	
    	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
    
    	$sq_nome = mysql_query("SELECT * FROM historico where id_demanda=".$id." order by id desc");
    	
    	//echo $nome_segmento;
    	return $sq_nome;
    	$conn->FechaConexao();
    
    }
    
    
    function buscaPopover(){
    
    	 
    	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
    
    	$sq_nome = mysql_query("SELECT count(d.id) as total, s.status as nome, d.status  FROM  handover_demandas d, status s where s.id=d.status group by d.status");
    	 
    	//echo $nome_segmento;
    	return $sq_nome;
    	$conn->FechaConexao();
    
    }
    
    
    function buscaNomeResponsavel($id){
        
      
       require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();

        $sq_nome = mysql_query("SELECT nome FROM handover_usuario where id=".$id);
$nome=  mysql_fetch_row($sq_nome);
//echo $nome_segmento;
        return $nome[0];
        $conn->FechaConexao();  
        
    }
    
    function buscaNomeBase($id){
    
    
    	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
    
    	$sq_nome = mysql_query("SELECT base FROM bases where id=".$id);
    	$nome=  mysql_fetch_row($sq_nome);
    	//echo $nome_segmento;
    	return $nome[0];
    	$conn->FechaConexao();
    
    }
    
function buscaStatusDemanda($cliente){
	
	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
	
	$sq_status = mysql_query("SELECT status FROM handover_demandas where id=".$cliente->getId());
	$status=  mysql_fetch_row($sq_status);
	//echo $nome_segmento;
	return $status[0];
	$conn->FechaConexao();
	
}


function buscaCodigoDemanda($id){
	
	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();

	$sq_codigo = mysql_query("SELECT codigo_prj FROM handover_demandas where id=".$id);
	$codigo = mysql_fetch_row($sq_codigo);
	return $codigo[0];
	$conn->FechaConexao();

}

    function buscaNomeStatus($id){
    
    	
    	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
    
    	$sq_status = mysql_query("SELECT s.status FROM handover_demandas d, status s where d.status = s.id and s.id=".$id);
    	$status=  mysql_fetch_row($sq_status);
    	//echo $nome_segmento;
    	return $status[0];
    	$conn->FechaConexao();
    
    }
    
    function buscaNomeSubStatus($id){
    
    	
    require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
    
    	$sq_sub = mysql_query("SELECT sub_status FROM sub_status where id=".$id);
    	$sub=  mysql_fetch_row($sq_sub);
    	//echo $nome_segmento;
    	return $sub[0];
    	$conn->FechaConexao();
    
    }
    
    function buscaSubStatusAjax($id){
    
    	
    	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
    
    	$sq_sub = mysql_query("SELECT id, sub_status FROM sub_status where grupo=".$id->getId());
    	
    	//echo "SELECT id, sub_status FROM sub_status where grupo='".$id."'";
    	
    	return $sq_sub;
    	$conn->FechaConexao();
    
    }
    
    function pesquisarDemanda($Demanda) {
        require_once("../model/bean/Cadastrar.class.php");
        $responsavel ="";
        require_once 'Conection.class.php';
        $conn = new Conection(); $conn->AbreConexao();

                
		if($Demanda->getResponsavel()!=0){
			
			$responsavel="and responsavel='".$Demanda->getResponsavel()."'";


		}
        $sq_Demanda = mysql_query("SELECT * FROM handover_demandas where status in (".$Demanda->getFinalizada().") and (responsavel like '".$Demanda->getResponsavel()."%' or codigo_prj like '".$Demanda->getCodigo_prj()."%') ".$responsavel." ORDER BY id");
        
      // echo "SELECT * FROM demanda where finalizada = ".$Demanda->getFinalizada()." and (nome like '".$Demanda->getNome()."%' or codigo like '".$Demanda->getNome()."%')  ORDER BY codigo";
        
        return $sq_Demanda;
        $conn->FechaConexao();
        
    }


   
    
    
    function listaDemanda() {
    	require_once 'includes/model/dao/Conection.class.php';
    
    	
    	$conn = new Conection();
        $conn->AbreConexao();

        $sq_Demanda = mysql_query("SELECT d.* FROM handover_demandas d WHERE status !=3 and status !=4 and status !=5 ORDER BY responsavel");
        
        return $sq_Demanda;
        
        
        $conn->FechaConexao();
        
    }


    function listaDemandaResponsavel() {
    	require_once 'includes/model/dao/Conection.class.php';
    
    	
    	$conn = new Conection();
        $conn->AbreConexao();

        $usuario = $_SESSION['username'];

       
        $sq_Demanda = mysql_query("SELECT d.* FROM handover_demandas d , handover_usuario u WHERE d.status not in (3,4,5) and d.responsavel = u.id and u.login ='".$usuario."' ORDER BY d.responsavel");
        
        
        return $sq_Demanda;
        
        
        $conn->FechaConexao();
        
    }

      function extrairTodos() {
    	require_once 'includes/model/dao/Conection.class.php';


    	
    	$conn = new Conection();
        $conn->AbreConexao();

       $sq_Demanda = mysql_query("SELECT user.nome as nome_responsavel,tipo.nome as nome_tipo,status.status as nome_status, demanda.* FROM handover_demandas demanda,handover_usuario user,handover_tipo tipo,status status WHERE demanda.responsavel=user.id AND demanda.tipo=tipo.id_tipo AND demanda.status=status.id");

   

    	$conn->FechaConexao();
    
    while ($row = mysql_fetch_array($sq_Demanda)) {
        $grupo[] = $row;
    }
    return $grupo;
      
        
    }

    function extrairFrentes() {
    	require_once 'includes/model/dao/Conection.class.php';


    	
    	$conn = new Conection();
        $conn->AbreConexao();

       $sq_Demanda = mysql_query("SELECT distinct de.codigo_prj as 'codigo_prj', de.nome_prj as 'nome_prj', user.nome as 'nome_responsavel', fre.nome as 'frente', re.id_demandas, re.id_frentes from handover_demandas de, handover_relacionamento re, handover_frentes fre, handover_usuario user where de.id = re.id_demandas and fre.id = re.id_frentes and user.id = de.responsavel");

   

    	$conn->FechaConexao();
    
    while ($row = mysql_fetch_array($sq_Demanda)) {
        
        $frentes[] = $row;
    }
    return $frentes;
      
        
    }

    function extrairRequisitos($id_demandas,$id_frentes) {
    	require_once 'includes/model/dao/Conection.class.php';


    	
    	$conn = new Conection();
        $conn->AbreConexao();

         $sq_Demanda = mysql_query("SELECT de.codigo_prj as 'codigo_prj', de.nome_prj as 'nome_prj', us.nome as 'nome_responsavel', fre.nome as 'frente', re.id_demandas, re.id_frentes, req.nome as 'requisitos', 'SIM' CADASTRADO from handover_demandas de, handover_relacionamento re, handover_requisitos req, handover_frentes fre, handover_usuario us where re.id_demandas = de.id and re.id_frentes = fre.id and de.responsavel = us.id and re.id_requisitos = req.id and de.id = ".$id_demandas." and fre.id = ".$id_frentes." UNION select distinct de.codigo_prj as 'codigo_prj', de.nome_prj as 'nome_prj', us.nome as 'nome_responsavel', fre.nome as 'frente', re.id_demandas, re.id_frentes, req.nome as 'requisitos', 'NAO' CADASTRADO from handover_demandas de, handover_relacionamento re, handover_requisitos req, handover_frentes fre, handover_usuario us where re.id_demandas = de.id and re.id_frentes = fre.id and de.responsavel = us.id and req.id not in (select rei.id_requisitos from handover_relacionamento rei where rei.id_demandas = de.id and rei.id_frentes = fre.id) and de.id = ".$id_demandas." and fre.id = ".$id_frentes." order by 1, 7");

       

   

    	$conn->FechaConexao();
 
     while ($row = mysql_fetch_array($sq_Demanda)) {
        
        $gruposRequisitos[] = $row;
    }
    return $gruposRequisitos;
      
      
        
    }

    function formatoData($data){
            $array = explode("-", $data);
            // $data = 2016-04-14
            // $array[0]= 2016, $array[1] = 04 e $array[2]= 14;
            $novaData = $array[2]."/".$array["1"]."/".$array[0];
            return $novaData;
        }
    
    
    function listaDemanda_cancelar() {
    	//require_once 'includes/model/dao/Conection.class.php';
    	require_once 'Conection.class.php';
    	 
    	$conn = new Conection();
    	$conn->AbreConexao();
    
    	$sq_Demanda = mysql_query("SELECT * FROM handover_demandas where finalizada =0 ORDER BY prioridade desc, codigo");
    
    	return $sq_Demanda;
    
    
    	$conn->FechaConexao();
    
    }
    

    function cadastraDemanda($Demanda) {
    	
//require_once "../bean/Cadastrar.class.php";
        
 require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();



        $sq_inserir = mysql_query("INSERT INTO handover_demandas (id, responsavel, tipo, codigo_prj, nome_prj, objetivo, proximos_passos, progresso, data_status, data_release, status, pts_atencao, operacao, desenvolvimento, status_entregaveis, status_entregaveis_v2, sistemas_criticos,status_gerencial,ultima_alteracao) VALUES (NULL, '".$Demanda->getResponsavel()."','".$Demanda->getTipo()."','".$Demanda->getCodigo_prj()."','".$Demanda->getNome_prj()."','".$Demanda->getObjetivo()."','".$Demanda->getProximos_passos()."','".$Demanda->getProgresso()."','".$Demanda->getData_status()."','".$Demanda->getData_release()."','".$Demanda->getStatus()."','".$Demanda->getPts_atencao()."','".$Demanda->getOperacao()."','".$Demanda->getDesenvolvimento()."','".$Demanda->getStatus_entregaveis ()."','".$Demanda->getStatus_entregaveis_v2()."','".$Demanda->getSistemas_criticos()."','".$Demanda->getStatus_Gerencial()."','".$Demanda->getUltima_alteracao()."')");
//echo"INSERT INTO `sicoof`.`demanda` (id,nome, codigo, tipo, data_inicio, status, sub_status, finalizada, cenarios) VALUES (NULL, '".$Demanda->getNome()."', '".$Demanda->getCodigo()."','".$Demanda->getTipo()."' , '".$Demanda->getDataInicio()."', '1','1','0'".$Demanda->getCenarios().")";
if($sq_inserir){
		return TRUE;
}else{
    //echo"INSERT INTO Demanda (nome_Demanda, ativo, segmento_mercado, descricao, ultima_alteracao) VALUES ('".$Demanda->getNome()."',".$Demanda->getAtivo().", '".$Demanda->getSegmento()."', '".$Demanda->getDescricao()."', ".$Demanda->getUltimaModicacao().")";
    return FALSE;
}
     $conn->FechaConexao();  
    }
    
    
    function editaDemanda($Demanda) {
require_once("../model/bean/Cadastrar.class.php");
        
 require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();


 $sq_inserir = mysql_query("UPDATE handover_demandas SET tipo='".$Demanda->getTipo()."',codigo_prj='".$Demanda->getCodigo_prj()."', nome_prj='".$Demanda->getNome_prj()."', objetivo='".$Demanda->getObjetivo()."', proximos_passos='".$Demanda->getProximos_passos()."', progresso='".$Demanda->getProgresso()."', data_status='".$Demanda->getData_status()."', data_release='".$Demanda->getData_release()."' , status='".$Demanda->getStatus()."' , pts_atencao='".$Demanda->getPts_atencao()."' , operacao='".$Demanda->getOperacao()."' , desenvolvimento='".$Demanda->getDesenvolvimento()."' , status_entregaveis='".$Demanda->getStatus_entregaveis()."' , status_entregaveis_v2='".$Demanda->getStatus_entregaveis_v2()."' , sistemas_criticos='".$Demanda->getSistemas_criticos()."', status_gerencial='".$Demanda->getStatus_Gerencial()."', ultima_alteracao='".$Demanda->getUltima_alteracao()."'  WHERE id=".$Demanda->getId());

if($sq_inserir){
	
	//echo "UPDATE demanda SET nome='".$Demanda->getNome()."', codigo='".$Demanda->getCodigo()."', cenarios='".$Demanda->getCenarios()."', tipo='".$Demanda->getTipo()."' WHERE id=".$Demanda->getId();
	
	
        return TRUE;
}else{
  
	//echo "UPDATE demanda SET nome='".$Demanda->getNome()."', codigo='".$Demanda->getCodigo()."', cenarios='".$Demanda->getCenarios()."', tipo='".$Demanda->getTipo()."' WHERE id=".$Demanda->getId();
    return FALSE;
}
     $conn->FechaConexao();  
    }


    function cadastrarFrenteRequisitos($Demanda) {
		require_once("../model/bean/Cadastrar.class.php");
        
 		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();

      //echo "INSERT into handover_relacionamento (id_demandas,id_frentes,id_requisitos) values ('".$Demanda->getId()."','".$Demanda->getFrenteTrabalho()."','".$Demanda->getRequisitosFuncionais()."')";

 	$sq_inserir = mysql_query("INSERT into handover_relacionamento (id_demandas,id_frentes,id_requisitos) values ('".$Demanda->getId()."','".$Demanda->getFrenteTrabalho()."','".$Demanda->getRequisitosFuncionais()."')");



if($sq_inserir){

		
	  return TRUE;

}else{

  		//echo "INSERT into handover_relacionamento (id_demandas,id_frentes,id_requisitos) values ('".$Demanda->getId()."','".$Demanda->getFrenteTrabalho()."','".$Demanda->getRequisitosFuncionais()."')";
	    return FALSE;
}
     $conn->FechaConexao();  
    }




    function excluirFrenteRequisitos($Demanda) {
		require_once("../model/bean/Cadastrar.class.php");
        
 		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();

       //echo "DELETE FROM handover_relacionamento WHERE id_demandas='".$Demanda->getId()."' AND id_frentes='".$Demanda->getFrenteTrabalho()."'";

 	$sq_excluir = mysql_query("DELETE FROM handover_relacionamento WHERE id_demandas='".$Demanda->getId()."' AND id_frentes='".$Demanda->getFrenteTrabalho()."'");




if($sq_excluir){

		
	  return TRUE;

}else{

  		//echo "INSERT into handover_relacionamento (id_demandas,id_frentes,id_requisitos) values ('".$Demanda->getId()."','".$Demanda->getFrenteTrabalho()."','".$Demanda->getRequisitosFuncionais()."')";
	    return FALSE;
}
     $conn->FechaConexao();  
    }

    
    function buscaDemanda($id){
        //require_once("../model/bean/Demanda.class.php");
    require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();

      
       $sq_Demanda = mysql_query("SELECT s.nome, d.* FROM handover_demandas d, handover_usuario s WHERE s.id = d.responsavel and d.id=".$id->getId());

       return $sq_Demanda;
       
       $conn->FechaConexao();   
        
    }


    function buscaFrenteRequisitos($id){
        //require_once("../model/bean/Demanda.class.php");
    require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();



      
       $sq_Demanda = mysql_query("SELECT rel.id_frentes, fre.nome AS nome_frente, rel.id_requisitos, req.nome AS nome_requisito FROM handover_relacionamento rel, handover_frentes fre, handover_requisitos req WHERE rel.id_frentes = fre.id AND rel.id_requisitos = req.id AND rel.id_demandas =".$id->getId()." ORDER by rel.id_frentes") ;

       return $sq_Demanda;

        //echo "SELECT rel.id_frentes, fre.nome AS nome_frente, rel.id_requisitos, req.nome AS nome_requisito FROM handover_relacionamento rel, handover_frentes fre, handover_requisitos req WHERE rel.id_frentes = fre.id AND rel.id_requisitos = req.id AND rel.id_demandas =".$id->getId();
       
       $conn->FechaConexao();   
        
    }


function buscaRequisitos($id,$id_frentes){
        //require_once("../model/bean/Demanda.class.php");
    require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();



      
       $sq_Demanda = mysql_query("SELECT rel.id_frentes, fre.nome AS nome_frente, rel.id_requisitos, req.nome AS nome_requisito FROM handover_relacionamento rel, handover_frentes fre, handover_requisitos req WHERE rel.id_frentes = fre.id AND rel.id_requisitos = req.id AND rel.id_demandas =".$id." AND fre.id =".$id_frentes);

       return $sq_Demanda;

        //echo "SELECT rel.id_frentes, fre.nome AS nome_frente, rel.id_requisitos, req.nome AS nome_requisito FROM handover_relacionamento rel, handover_frentes fre, handover_requisitos req WHERE rel.id_frentes = fre.id AND rel.id_requisitos = req.id AND rel.id_demandas =".$id->getId();
       
       $conn->FechaConexao();   
        
    }
          

}

?>
