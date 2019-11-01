<?php
session_start();
//Aqui importamos todas as classes que poder�o ser usadas baseado nas solicita��es que forem feitas.
require_once("../model/bean/Relatorio.class.php"); // Classe Bean
require_once("../model/dao/RelatoriosDAO.class.php"); // Classe DAO
require_once("../view/RelatoriosView.class.php"); //Classe View

//Armazena na vari�vel $acao o que o sistema esta requisitando (cadastrar, autenticar, excluir, etc)
if(isset($_POST['acao'])){
$acao = $_POST["acao"];
}else{
    $acao=$_GET["acao"];
}
//Baseado no que foi solicitado, chama na classe DAO o m�todo respons�vel por tal tarefa, e depois manda pra View a resposta, para ser exibida de alguma forma ao usu�rio
switch($acao){

	
	case 'relatorio_grafico':{
	$relatorioDAO = new RelatoriosDAO();
  
    $array_ofertas = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $array_mailling = array(0,0,0,0,0,0,0,0,0,0,0,0);
  	
    $busca_oferta= $relatorioDAO->buscaTotalOfertaMes($_POST['ano']);
   
    while($ofertas=mysql_fetch_array($busca_oferta)){
    	$result=$ofertas['contagem'];
    $array_ofertas[$ofertas['mes']-1]=intval($result);
    
    }
  
    
    $busca_mailling= $relatorioDAO->buscaTotalMaillingMes($_POST['ano']);
     
    while($mailling=mysql_fetch_array($busca_mailling)){
    	$result=$mailling['contagem'];
    	$array_mailling[$mailling['mes']-1]=intval($result);
    
    }
    
    
	
    $categories = array('Jan', 'Feb', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez');
    
    
    
    $graph_data = array('categories'=>$categories, 'impression'=>$array_ofertas, 'clicks'=>$array_mailling);
   echo json_encode($graph_data);
		
	}
	break;
	
	case 'relatorio_execucao':{
		$relatorioDAO = new RelatoriosDAO();
		$relatorioView = new RelatoriosView();
		date_default_timezone_set('America/Sao_Paulo');
		$d1 = explode("/", $_POST['dpd1']);
		$d2 = explode("/", $_POST['dpd2']);
		$data_inicio = $d1[2]."-".$d1[1]."-".$d1[0];
		$data_fim = $d2[2]."-".$d2[1]."-".$d2[0];
		
		$i=0;
		$validacao=0;
		$construcao=0;
		$teste=0;
		$implantacao=0;
		$valprod=0;
		$reteste=0;
		$resultado= array();
		$json="";
		$busca_responsavel = $relatorioDAO->buscaResponsavelHistorico();
		while ($responsavel=mysql_fetch_array($busca_responsavel)){
			$id_responsavel= $responsavel['responsavel'];
			$busca_status=$relatorioDAO->buscaStatusResponsavel($data_inicio, $data_fim,$id_responsavel);
			while ($status=mysql_fetch_array($busca_status)){
				if($status['status']==2 ){
					$validacao++;
				}
				
				if($status['status']==4 ){
					$construcao++;
				}
				
				if($status['status']==6 ){
					$teste++;
				}
				
				if($status['status']==8 ){
					$implantacao++;
				}
				
				if($status['status']==10 ){
					$valprod++;
				}
				if ($status['status']==12){
					$reteste++;
				}
			}
			$resultado[$i][0]=$responsavel['nome'];
			$resultado[$i][1]=$validacao;
			$resultado[$i][2]=$construcao;
			$resultado[$i][3]=$teste;
			$resultado[$i][4]=$implantacao;
			$resultado[$i][5]=$valprod;
			$resultado[$i][6]=$reteste;
			
			$json.= "{name:'".$responsavel['nome']."', data:[".$validacao.",".$construcao.",".$teste.",".$implantacao.",".$valprod.",".$reteste."]},";
					
			
			$i++;
			$validacao=0;
		$construcao=0;
		$teste=0;
		$implantacao=0;
		$valprod=0;
		$reteste=0;
			
		}
		

$relatorioView->imprimeTabelaExecucao($resultado,$json);




		
		
	}
	break;
	
         
		case 'relatorio_demanda':{
              $relatorio = new Relatorio();	
		$relatorio->setDataInicio(implode("-",array_reverse(explode("/",$_POST['dpd1']))));
		$relatorio->setDataFim(implode("-",array_reverse(explode("/",$_POST['dpd2']))));
            $relatorioDAO = new RelatoriosDAO();
		$relatorioView = new RelatoriosView();
	
		$perido = "De: ".$_POST['dpd1']." até: ".$_POST['dpd2'];
		//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
		$resultado = $relatorioDAO->gerarRelatorioDemanda($relatorio);	
		//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
		$relatorioView->imprimeRelatorioDemanda($resultado,$perido);
        }
        break;
        
        case 'relatorio_projeto':{
        	$relatorio = new Relatorio();
        	$relatorio->setDataInicio(implode("-",array_reverse(explode("/",$_POST['dpd1']))));
        	$relatorio->setDataFim(implode("-",array_reverse(explode("/",$_POST['dpd2']))));
        	$relatorioDAO = new RelatoriosDAO();
        	$relatorioView = new RelatoriosView();
        
        	$perido = "De: ".$_POST['dpd1']." até: ".$_POST['dpd2'];
        	//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.
        	$resultado = $relatorioDAO->buscaProjetos($relatorio);
        	//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
        	$relatorioView->imprimeRelatorioProjeto($resultado,$perido);
        }
        break;
        
        
        
        case 'relatorio_sla':{
        	$relatorio = new Relatorio();
        	$relatorio->setDataInicio(implode("-",array_reverse(explode("/",$_POST['dpd1']))));
        	$relatorio->setDataFim(implode("-",array_reverse(explode("/",$_POST['dpd2']))));
        	$relatorioDAO = new RelatoriosDAO();
        	$relatorioView = new RelatoriosView();
        
        	$perido = "De: ".$_POST['dpd1']." até: ".$_POST['dpd2'];
        	//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.
        	$resultado = $relatorioDAO->gerarRelatorioSLA($relatorio);
        	//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
        	$relatorioView->imprimeRelatorioSLA($resultado,$perido);
        	
        }
        break;
        
        
}


?>