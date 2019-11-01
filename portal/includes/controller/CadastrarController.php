<?php
session_start();
//Aqui importamos todas as classes que poder�o ser usadas baseado nas solicita��es que forem feitas.
require_once("../model/bean/Cadastrar.class.php"); // Classe Bean
require_once("../model/dao/CadastrarDAO.class.php"); // Classe DAO
require_once("../view/CadastrarView.class.php"); //Classe View

//Armazena na vari�vel $acao o que o sistema esta requisitando (cadastrar, autenticar, excluir, etc)
if(isset($_POST['acao'])){
$acao = $_POST["acao"];
}else{
    $acao=$_GET["acao"];
}
//Baseado no que foi solicitado, chama na classe DAO o m�todo respons�vel por tal tarefa, e depois manda pra View a resposta, para ser exibida de alguma forma ao usu�rio
switch($acao){

	
	case 'cadastrar':{
		
         $cadastrar = new Cadastrar();  
         
      //$data_status=$_POST['data_status'];
      //$data_status_convertida = implode("-",array_reverse(explode("/",$data_status)));
      date_default_timezone_set('America/Sao_Paulo');
      $data_status_convertida = date('Y-m-d');
      

        
      $data_release=$_POST['data_release'];
      $data_release_convertida = implode("-",array_reverse(explode("/",$data_release)));

     
        $cadastrar->setResponsavel(addslashes($_POST['responsavel']));
        $cadastrar->setTipo(addslashes($_POST['tipo']));
        $cadastrar->setCodigo_prj(addslashes($_POST['codigo_prj']));
        $cadastrar->setNome_prj(addslashes($_POST['nome_prj']));
        $cadastrar->setStatus(addslashes($_POST['status']));
        $cadastrar->setData_status($data_status_convertida);
        $cadastrar->setData_release($data_release_convertida);
        $cadastrar->setObjetivo(addslashes($_POST['objetivo']));
        $cadastrar->setProximos_passos(addslashes($_POST['proximos_passos']));
        $cadastrar->setProgresso(addslashes($_POST['progresso']));
        $cadastrar->setPts_atencao(addslashes($_POST['pts_atencao']));
        $cadastrar->setOperacao(addslashes($_POST['operacao']));
        $cadastrar->setDesenvolvimento(addslashes($_POST['desenvolvimento']));
        $cadastrar->setStatus_entregaveis(addslashes($_POST['status_entregaveis']));
        $cadastrar->setStatus_entregaveis_v2(addslashes($_POST['status_entregaveis_v2']));
        $cadastrar->setSistemas_criticos(addslashes($_POST['sistemas_criticos']));
        $cadastrar->setStatus_Gerencial(addslashes($_POST['status_gerencial']));
        $cadastrar->setUltima_alteracao($_SESSION['username']);

                /* Agora vamos instanciar um objeto da classe DAO e um da View, e passaremos para a View o que for retornado pela DAO */		
		$cadastrarDAO = new CadastrarDAO();
		$cadastrarView = new CadastrarView();
		
		//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
		$resultado = $cadastrarDAO->cadastraDemanda($cadastrar);
		
		//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
		$cadastrarView->resultadoInserir($resultado);
            
       
	}
             break;
	case 'editar_demanda':{
    
      //$data_status=$_POST['data_status_editar'];
      //$data_status_convertida = implode("-",array_reverse(explode("/",$data_status)));
      date_default_timezone_set('America/Sao_Paulo');
      $data_status_convertida = date('Y-m-d');

        
      $data_release=$_POST['data_release_editar'];
      $data_release_convertida = implode("-",array_reverse(explode("/",$data_release)));


    	$demanda = new Cadastrar();
		$demanda->setId($_POST['id']);
        //$demanda->setResponsavel($_POST['responsavel_editar']);
        $demanda->setTipo($_POST['tipo_editar']);
        $demanda->setCodigo_prj($_POST['codigo_prj_editar']);
        $demanda->setNome_prj(addslashes($_POST['nome_prj_editar']));
        $demanda->setStatus(addslashes($_POST['status_editar']));
        $demanda->setData_status($data_status_convertida);
        $demanda->setData_release($data_release_convertida);
        $demanda->setObjetivo(addslashes($_POST['objetivo_editar']));
        $demanda->setProximos_passos(addslashes($_POST['proximos_passos_editar']));
        $demanda->setProgresso(addslashes($_POST['progresso_editar']));
        $demanda->setPts_atencao(addslashes($_POST['pts_atencao_editar']));
        $demanda->setOperacao(addslashes($_POST['operacao_editar']));
        $demanda->setDesenvolvimento(addslashes($_POST['desenvolvimento_editar']));
        $demanda->setStatus_entregaveis(addslashes($_POST['status_entregaveis_editar']));
        $demanda->setStatus_entregaveis_v2(addslashes($_POST['status_entregaveis_v2_editar']));
        $demanda->setSistemas_criticos(addslashes($_POST['sistemas_criticos_editar']));
        $demanda->setStatus_Gerencial(addslashes($_POST['status_gerencial_editar']));
        $demanda->setUltima_alteracao($_SESSION['username']);

           
                
                /* Agora vamos instanciar um objeto da classe DAO e um da View, e passaremos para a View o que for retornado pela DAO */	
        
        	
		
		$demandaDAO = new CadastrarDAO();	
		$demandaView = new CadastrarView();
		
		//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
		$resultado = $demandaDAO->editaDemanda($demanda);
        
		
		//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
		$demandaView->resultadoEditar($resultado);
            
       
	}
             break;
         case 'cadastrar_frenteRequisitos':{
    
        $demanda = new Cadastrar();
        
      
               $demanda->setId($_POST['id']);
               

               if(!empty($_POST['frenteTrabalho'])) {



                        $demanda->setFrenteTrabalho($_POST['frenteTrabalho']);
                        

                             if(!empty($_POST['requisitosFuncionais'])) {
                                    foreach($_POST['requisitosFuncionais'] as $requisitosFuncionais) {

                                        $demanda->setRequisitosFuncionais($requisitosFuncionais);
                                        $demandaDAO = new CadastrarDAO();
                                        $resultado = $demandaDAO->cadastrarFrenteRequisitos($demanda);

                                        
                                    }  
                            }
  
                } 





               //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.               
               //$demandaDAO = new CadastrarDAO();
         

                 $demandaView = new CadastrarView();
                 // $resultado = $demandaDAO->cadastrarFrenteRequisitos($demanda);
               $demandaView->resultadoCadastrarFrenteRequisitos($resultado);
               
         
              
            
       
    }
             break;       
		case 'atualiza_tabela':{
             
            $painelDAO = new CadastrarDAO();
		$painelView = new CadastrarView();
		
		//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
		$resultado = $painelDAO->listaDemandaResponsavel();
		//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
		$painelView->painel($resultado);
        }
        break;
        
        case 'editar':{
        	$editar = new Cadastrar();
        	$editar->setId($_POST['id']);
        	$editarDAO = new CadastrarDAO();
        	$editarView = new CadastrarView();
        
        	//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.
        	$resultado = $editarDAO->buscaDemanda($editar);
            

        	//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
        	$editarView->editarVisualizar($resultado);
        }
        break;
        
        case 'frenteRequisito':{
            $editar = new Cadastrar();
            $editar->setId($_POST['id']);
            $editarDAO = new CadastrarDAO();
            $editarView = new CadastrarView();
        
            //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.
            $resultado = $editarDAO->buscaDemanda($editar);
            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
            $editarView->frenteRequisitos_Visualizar($resultado);
        }
        
        
        
        break;

        case 'frenteRequisito_alterar_Visualizar':{

            $editar = new Cadastrar();
            $editar->setId($_POST['id']);
            $editarDAO = new CadastrarDAO();
            $editarView = new CadastrarView();
        
            //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.
            $resultadoFrentes = $editarDAO->buscaFrenteRequisitos($editar);
            $resultado = $editarDAO->buscaDemanda($editar);

            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
            $editarView->frenteRequisitos_alterar($resultado,$resultadoFrentes);
        }
        
        break;

        case 'frenteRequisito_editar_Visualizar':{

            $editar = new Cadastrar();
            $separando = ($_POST['id']);
            $arquivo = explode('-', $separando);
            $id= $arquivo[0];
            $id_frentes = $arquivo[1];

           

            $editar->setId($id);
            $editar->setFrenteTrabalho($id_frentes);


            
            
            $editarDAO = new CadastrarDAO();
            $editarView = new CadastrarView();
        
            //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.
            $resultadoFrentes = $editarDAO->buscaRequisitos($id,$id_frentes);
            $resultado = $editarDAO->buscaDemanda($editar);

            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
            $editarView->frenteRequisitos_editar($resultado,$resultadoFrentes);
        }
        
        break;


        case 'gerar_hash':{
        	
        	$contrato = $_POST['contrato'].$_POST['hash'];
        	$md5 = md5($contrato);
        	echo "Hash do Cartão: ".strtoupper($md5);
        }
        
        
        
        break;
        
        
        
        case 'detalhar':{
        	$detalhar = new Cadastrar();
        	$detalhar->setId($_POST['id']);
        	$detalharDAO = new CadastrarDAO();
        	$detalharView = new CadastrarView();
        
        	//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.
        	$resultadoFrentes = $detalharDAO->buscaFrenteRequisitos($detalhar);
            $resultado = $detalharDAO->buscaDemanda($detalhar);
            
        	//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
        	$detalharView->detalharVisualizar($resultado,$resultadoFrentes);
        }
        break;
        
        
               
		case 'inicio':{
			
              $painelDAO = new CadastrarDAO();
                            $painelView = new CadastrarView();

                            //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
                            $resultado = $painelDAO->listaDemandaResponsavel();

                            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
                            $painelView->painel($resultado);
        }
        break;
        
        
        case 'cancelar':{
        		
        	$painelDAO = new CadastrarDAO();
        	$painelView = new CadastrarView();
        
        	//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.
        	$resultado = $painelDAO->listaDemanda_cancelar();
        
        	//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
        	$painelView->painel($resultado);
        }
        break;
        
		case 'pesquisar':{
                $demanda = new Cadastrar();	
                
                
		$demanda->setCodigo_prj($_POST['pesquisa_demanda']);
		$demanda->setResponsavel($_POST['responsavel']);
		$demanda->setFinalizada($_POST['finalizada']);
            $demandaDAO = new CadastrarDAO();
		$demandaView = new CadastrarView();
		
		//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
		$resultado = $demandaDAO->pesquisarDemanda($demanda);
		
		//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
		$demandaView->retornoPesquisar($resultado);
        }
        break;
    
        case 'alterar_base':{
        	 
        	
        	$cliente = new Cadastrar();
        	$cliente->setId($_POST['id_demanda']);
        	$cliente->setBase($_POST['id_base']);
        	
        	 
        	$clientesDAO = new CadastrarDAO();
        	$clienteView = new CadastrarView();
        
        	//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.
        	$resultado = $clientesDAO->alterarBasel($cliente);
        	
        	 
        	//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
        	$clienteView->imprimeResultadoAlterarBase($resultado);
        }
        break;
        
        
        case 'alterar_responsavel':{
        	
        	date_default_timezone_set('America/Sao_Paulo');
        	$date = date("Y-m-d H:i:s");
        	$cliente = new Cadastrar();
        	$cliente->setId($_POST['id_demanda']);
        	$cliente->setResponsavel($_POST['id_responsavel']);
        	$cliente->setStatus($_POST['status']);
        	$cliente->setSubStatus($_POST['sub_status']);
        	$cliente->setExecutante($_SESSION['login']['id']);
        	$cliente->setDataInicio($date);
        	
        	$clientesDAO = new CadastrarDAO();
        	$clienteView = new CadastrarView();
        
        	//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.
        	$resultado = $clientesDAO->alterarResponsavel($cliente);
        	$clientesDAO->registraHistoricoResponsavel($cliente);
        	
        	//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
        	$clienteView->imprimeResultadoAlterarResponsavel($resultado);
        }
        break;


        case 'alterar_RequisitosFrentes':{
               $demanda = new Cadastrar();
               $remover = new Cadastrar();
                

                //Deletar a frente antiga associada ao projeto, para que depois a gente adicione uma nova.
                $separando = ($_POST['id']);
                $arquivo = explode('-', $separando);
                $id= $arquivo[0];
                $id_frentes_deletada = $arquivo[1];

                $deletar = new CadastrarDAO();  



                $remover->setFrenteTrabalho($id_frentes_deletada);
                $remover->setId($id);     
                $resultadoDeletar = $deletar->excluirFrenteRequisitos($remover);


                //Adicionar a frente associada aos requisitos
               $demanda->setId($id);



               if(!empty($_POST['frenteTrabalho'])) {

                    foreach($_POST['frenteTrabalho'] as $frenteTrabalho) {

                        $demanda->setFrenteTrabalho($frenteTrabalho);
                        

                             if(!empty($_POST['requisitosFuncionais'])) {
                                    foreach($_POST['requisitosFuncionais'] as $requisitosFuncionais) {

                                        $demanda->setRequisitosFuncionais($requisitosFuncionais);

                                        

                                        $demandaDAO = new CadastrarDAO();
                                        $resultado = $demandaDAO->cadastrarFrenteRequisitos($demanda);

                                                                                  
                                    }  
                            }

                         
                    }   

                } 





               //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.               
               //$demandaDAO = new CadastrarDAO();
         

                 $demandaViewCadastrarDeletar = new CadastrarView();
                 // $resultado = $demandaDAO->cadastrarFrenteRequisitos($demanda);
               $demandaViewCadastrarDeletar->resultadoRemoverCadastrarFrenteRequisitos($resultadoDeletar);
               
         
         
        }

        break;
     

        case 'alterar_status':{
        	
        	$status =$_POST['id_status'];
        	
        	$cliente = new Cadastrar();
        	$cliente->setId($_POST['id_demanda']);
        	$cliente->setStatus($_POST['id_status']);
        	$cliente->setSubStatus($_POST['id_sub']);
        	$cliente->setResponsavel($_POST['id_responsavel']);
        	$cliente->setExecutante($_SESSION['login']['id']);
        	$clientesDAO = new CadastrarDAO();
        	$clienteView = new CadastrarView();
        	
        	date_default_timezone_set('America/Sao_Paulo');
        	$cliente->setDataFim(date("Y-m-d H:i:s"));
        	$cliente->setDataInicio(time());
        /*C�digos de tempo
         1 - inicio Valida��o - status = 2
         2 - fim valida��o  - status =3
         3 - inicio contru��o - status = 4 
         4 - fim constru��o - status = 5 
         5 - ini testes - status = 6
         6 - fim testes - status = 7
         7 - inicio implata��o - status = 8
         8 - fim implata��o -  status = 17
         9 - inicio val prod -  status = 10
         10 - fim val prod -  status = 9
		 11 - inicio reteste -  status = 16
		 12 - fim reteste - -  saindo de 16 para status = 7
   
       		Paradas
        	
        	13 - Inicio parada valida��o - status = 11
        	14 - fim parada de valida��o saindo de 11 pra 2
        	15 - Inicio parada Constru��o - status = 12
        	16 - Fim parada Constru��o - saindo de 12 para 4
        	17 - Inicio parada teste - status 13
        	18 - fim parada teste - Saindo de 13 para 6
        	19 - inicio para implanta��o - Status 14
        	20 - fim parada implanta��o - Saindo de 14 para 8
        	21 - inicio parada valida��o em produ��o - Status = 15
        	22 - fim parada valida��o em produ��o saindo 15 para 10
        	
        	*/
        	
        	if($status==18){
        		
        		//    15 - 16  
        		
        		$status_atual = $clientesDAO->buscaStatusDemanda($cliente);
        		if($status_atual==2){
        			$cliente->setTempo(2);
        		$clientesDAO->inserirTempo($cliente);
        		}
        		if($status_atual==4){
        			$cliente->setTempo(4);
        			$clientesDAO->inserirTempo($cliente);
        		}
        		if($status_atual==6){
        			$cliente->setTempo(6);
        			$clientesDAO->inserirTempo($cliente);
        		}
        		if($status_atual==8){
        			$cliente->setTempo(8);
        			$clientesDAO->inserirTempo($cliente);
        		}
        		if($status_atual==10){
        			$cliente->setTempo(10);
        			$clientesDAO->inserirTempo($cliente);
        		}
        		
        		if($status_atual==11){
        			$cliente->setTempo(14);
        			$clientesDAO->inserirTempo($cliente);
        		}
        		if($status_atual==12){
        			$cliente->setTempo(16);
        			$clientesDAO->inserirTempo($cliente);
        		}
        		if($status_atual==13){
        			$cliente->setTempo(18);
        			$clientesDAO->inserirTempo($cliente);
        		}
        		if($status_atual==14){
        			$cliente->setTempo(20);
        			$clientesDAO->inserirTempo($cliente);
        		}
        		if($status_atual==15){
        			$cliente->setTempo(22);
        			$clientesDAO->inserirTempo($cliente);
        		}
        		if($status_atual==16){
        			$cliente->setTempo(12);
        			$clientesDAO->inserirTempo($cliente);
        		}
        		
        		
        		$clientesDAO->finalizarDemanda($cliente);
        	}
        	
        	
        	
        	
        	if($status==2){
        	$status_atual = $clientesDAO->buscaStatusDemanda($cliente);
        	if($status_atual==11){
        		$cliente->setTempo(14);
        		$clientesDAO->inserirTempo($cliente);
        	}else{	
        		$cliente->setTempo(1);
        		$clientesDAO->inserirTempo($cliente);
        	}
        	}
        	
        	if($status==3){
        		$cliente->setTempo(2);
        		$clientesDAO->inserirTempo($cliente);
        		$clientesDAO->retirarResponsavel($cliente);
        		//echo $status;
        	}
        	if($status==4){
        		$status_atual = $clientesDAO->buscaStatusDemanda($cliente);
        		//echo $status_atual;
        		if($status_atual==12){
        			$cliente->setTempo(16);
        			$clientesDAO->inserirTempo($cliente);
        			
        		}else{
        		
        	
        		$cliente->setTempo(3);
        		$clientesDAO->inserirTempo($cliente);
        		}
        	}
        	
        	if($status==5){
        		$cliente->setTempo(4);
        		$clientesDAO->inserirTempo($cliente);
        		$clientesDAO->retirarResponsavel($cliente);
        	}
        	
        	if($status==6){
        		
        		$status_atual = $clientesDAO->buscaStatusDemanda($cliente);
        		if($status_atual==13){
        			
        			$cliente->setTempo(18);
        			$clientesDAO->inserirTempo($cliente);
        			
        		}else{
        			
        		$cliente->setTempo(5);
        		$clientesDAO->inserirTempo($cliente);
        		} 
        	}
        	
        	
        	if($status==7){
        		$status_atual = $clientesDAO->buscaStatusDemanda($cliente);
        		if($status_atual==16){
        		
        			$cliente->setTempo(12);
        			$clientesDAO->inserirTempo($cliente);
        			$clientesDAO->retirarResponsavel($cliente);
        			 
        		}else{
        		$cliente->setTempo(6);
        		$clientesDAO->inserirTempo($cliente);
        		$clientesDAO->retirarResponsavel($cliente);
        		}
        	}
        	
        	if($status==8){
        		
        		$status_atual = $clientesDAO->buscaStatusDemanda($cliente);
        		if($status_atual==14){
        		
        			$cliente->setTempo(20);
        			$clientesDAO->inserirTempo($cliente);
        			
        		}else{
        			
        		$cliente->setTempo(7);
        		$clientesDAO->inserirTempo($cliente);
        		
        		}
        	}
        	
        	if($status==9){
        		$cliente->setTempo(10);
        		$clientesDAO->inserirTempo($cliente);
        		$clientesDAO->finalizarDemanda($cliente);
        		 
        	}
        	
        	if($status==10){
        		
        		$status_atual = $clientesDAO->buscaStatusDemanda($cliente);
        		if($status_atual==15){
        		
        			$cliente->setTempo(22);
        			$clientesDAO->inserirTempo($cliente);
        			 
        		}else{
        		$cliente->setTempo(9);
        		$clientesDAO->inserirTempo($cliente);
        		}	 
        	}
        	
        	if($status==11){
        		$cliente->setTempo(13);
        		$clientesDAO->inserirTempo($cliente);
        		 
        	}
        	
        	if($status==12){
        		$cliente->setTempo(15);
        		$clientesDAO->inserirTempo($cliente);
        		 
        	}
        	
        	
        	if($status==13){
        		$cliente->setTempo(17);
        		$clientesDAO->inserirTempo($cliente);
        		 
        	}
        	
        	if($status==14){
        		
        		$cliente->setTempo(19);
        		$clientesDAO->inserirTempo($cliente);
        		 
        	}
        	
        	
        	if($status==15){
        		$cliente->setTempo(21);
        		$clientesDAO->inserirTempo($cliente);
        		 
        	}
        	
        	if($status==16){
        		$cliente->setTempo(11);
        		$clientesDAO->inserirTempo($cliente);
        		 
        	}
        	
        	if($status==17){
        		$cliente->setTempo(8);
        		$clientesDAO->inserirTempo($cliente);
        		$clientesDAO->retirarResponsavel($cliente);
        		
        		 
        	}
        	
        	//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.
        	$resultado = $clientesDAO->alterarStatus($cliente);
        $clientesDAO->registraHistoricoStatus($cliente);
        	//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
        	$clienteView->imprimeResultadoAlterarStatus($resultado);
        }
        break;
     
        
        case 'buscar_sub':{
        	$cliente = new Cadastrar();
        	$cliente->setId($_POST['id']);
        	$clientesDAO = new CadastrarDAO();
        	$clienteView = new CadastrarView();
        
        	//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.
        	$resultado = $clientesDAO->preencheSelectSubStatus($cliente);
        	
        	
        	//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
        	$clienteView->imprimeSubStatus($resultado);
        }
        break;
        
	case 'excluir':{
		//Aqui faz as valida��es necess�rias e requisita o m�todo da classe DAO respons�vel por excluir o usu�rio.
	}
	
	default: return null; //Por padr�o, esse switch n�o retorna nada.
		
}


?>