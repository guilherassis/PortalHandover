<?php

class CadastrarView {

    
    function imprimeSelectBase($resultado) {


        while ($base = mysql_fetch_array($resultado)) {
            echo" <option value='" . $base['id']."'>".$base['base']."</option>";


         
        }
        
    }
    
    
    function imprimePopover($resultado) {
    $emandamento='';
    $finalizado = '';
    $emcriacao='';
    $cancelado='';
    $suspenso='';
    $i=0;
    $a=0;
    $t=0;
    $p=0;
    $c=0;
    $s=0;
        while ($popover = mysql_fetch_array($resultado)) {



            
    if($popover['status']==1 ){
        $emcriacao.= $popover['total']." - ".$popover['nome']."<br/>";
        $a=$a+$popover['total'];
    }
        
    if($popover['status']==2 ){
        $emandamento.= $popover['total']." - ".$popover['nome']."<br/>";
        $t=$t+$popover['total'];
    }
        
    
    if($popover['status']==4){
        $cancelado.= $popover['total']." - ".$popover['nome']."<br/>";
        $c= $c+$popover['total'];
    }

    if($popover['status']==5){
        $suspenso.= $popover['total']." - ".$popover['nome']."<br/>";
        $s= $s+$popover['total'];
    }

    if($popover['status']==3){
        $finalizado.= $popover['total']." - ".$popover['nome']."<br/>";
        $p= $p+$popover['total'];
    }
        }
        
        $i=$a+$t+$p+$c+$s;
        
        echo "
                <div class='lg-cancelado' data-toggle='popover' title='Cancelado' data-placement='left' data-content='".$cancelado."'>$c</div> 
                
                <div class='lg-suspenso' data-toggle='popover' title='Suspenso' data-placement='left' data-content='".$suspenso."'>$s</div>

                <div class='lg-parada' data-toggle='popover' title='Finalizado' data-placement='left' data-content='".$finalizado."'>$p</div>
                
                <div class='lg-aguarda' data-toggle='popover' title='Em Criação' data-placement='left' data-content='".$emcriacao."'>$a</div>
              
                <div class='lg-trabalha' data-toggle='popover' title='Em Andamento' data-placement='left' data-content='".$emandamento."'>$t</div>
                
                <div class='lg-total' data-toggle='popover' title='Total de Projetos' data-placement='left' data-content='".$i." - Total de Projetos'>".$i."</div>

                
            
                    ";
    
    }
    
    
    
    function impremeHoraMinutoSegundo($seconds){
        
        
        
        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;
        if($hours<10){
            $hours="0".$hours;
        }
        if($minutes<10){
            $minutes="0".$minutes;
            }
            if($seconds<10){
                
                $seconds="0".$seconds;
            }
            $segundo = explode(".", $seconds);
        $tempo = "$hours:$minutes:".$segundo[0];
        return $tempo;
        
    }
    
    
    function imprimeResultadoAlterarResponsavel($resultado){
        
        if ($resultado) {
            echo 'Responsável Alterado! <button type="button" class="close" data-dismiss="alert">×</button>';
        } else {
            echo 'Erro ao efetuar o login. Dados incorretos!';
        }
    }
    
    function imprimeResultadoAlterarBase($resultado){
         
        if ($resultado) {
            echo 'Base alterada! <button type="button" class="close" data-dismiss="alert">×</button>';
        } else {
            echo 'Erro ao alterar a base. Dados incorretos!';
        }
    }
    
    
    function imprimeResultadoAlterarStatus($resultado){
         
        if ($resultado) {
            echo 'Status Alterado com sucesso! <button type="button" class="close" data-dismiss="alert">×</button>';
        } else {
            echo 'Erro ao efetuar o login. Dados incorretos!';
        }
    }

    

    function painel($resultado){
        
        $cadastrarDAO = new CadastrarDAO();
        
        
    echo "<script src='js/functions_cadastrar.js'></script>
            <br>
            
            <p class = 'label label-info'>Filtros de pesquisa</p>
 <form id='search' name='search' class='navbar-search pull-left'>
 <input type='hidden' name='acao' value='pesquisar'/>
     <input type='text' class='search-query span3' placeholder='Pesquisar Nome ou Código do Projeto' name='pesquisa_demanda'> <span style='margin-left:10px; margin-right:10px'><b>Finalizada/Suspenso/Cancelado</b>
            <input type='radio' checked name='finalizada' value='1,2'/> <span>Não</span>
            <input type='radio'  name='finalizada' value='3,4,5'/> <span>Sim</span>
            </span>
            <span>
            <select name='responsavel'>
            <option value='0'>Selecione...</option>";
    
        $responsavel = $cadastrarDAO->preencheSelectResponsavelPesquisa();
        while ($cliente = mysql_fetch_array($responsavel)) {
            echo" <option value='" . $cliente['id']."'>".$cliente['nome']."</option>";}
    echo"       </select>
            </span>
            <button class='btn' type='submit'><i class='icon-search'></i></button>
            <!--<button class='btn' type='reset'><i class='icon-trash'></i></button>-->
            &nbsp           
            <a  class='btn'  title='Extrair Demandas' href='extracaoDados.php'><i class='icon-download'></i></a>
            &nbsp           
            <a  class='btn'  title='Extrair Requisitos' href='extracaoRequisitos.php'><i class='icon-download-alt'></i></a>
       

           

            
</form>
            
            
            ";
            
    $this->imprimePopover($cadastrarDAO->buscaPopover());
    
    
    
        echo"   
                
            <br>
                <br><br>
            <br>
            <p class='label label-info'>Painel de Demandas</p>
            <br>
            <br>
            <div id = 'tabela'>
        <table class='table table-bordered'>
        <thead>
        <tr>
        <th>Projeto</th>
        <th>Responsável Handover</th>
        <th>Status</th>
                <th>Data Status</th>
            <th>Data Release</th>
            <th>Tipo</th>
            <th>Ação</th>
        
        </tr>
        </thead>
        <tbody >";
    
   
        while ($demandas = mysql_fetch_array($resultado)) {
        if ($demandas['tipo'] == '1') {
                $tipo = 'Cascata';
        }elseif ($demandas['tipo'] == '2') {
                $tipo = 'Ágil';
        }elseif ($demandas['tipo'] == '3') {
                $tipo = 'Internalização';
        }else {
                $tipo = 'RFP';
        }
        
          if($demandas['status_gerencial']!=''){
        //$prioridade ="<i class='icon-exclamation-sign'></i>";
        $prioridade ="<div title='Status Gerencial'class='lg-parada'>!</div>";
        }else{$prioridade='';}

                echo"<tr>
                <td title='" . $demandas['nome_prj'] . "'>
                " . $demandas['codigo_prj'] . "".$prioridade."
        
                        </td>
                        <td>";
                if($demandas['responsavel']!=0){
                echo $cadastrarDAO->buscaNomeResponsavel($demandas['responsavel']);
                }
                        echo "</td>
                        <td>" .$cadastrarDAO->buscaNomeStatus( $demandas['status'] ). "</td>
                         <td>" .$this->converterData($demandas['data_status']). "</td>
                                        
                        <td>" .$this->converterData($demandas['data_release']). "</td>

                               
                        <td>
                        " . $tipo. "
        
                        </td>
                        <td>
                         <button class='btn detalhar' id='detalhar' title='Detalhar'  value='" . $demandas['id'] . "' href='#'> <i class='icon-tasks'></i></button>
                        <button class='btn editar' id='editar' title='Editar'  value='" . $demandas['id'] . "' href='#'> <i class='icon-pencil'></i></button>

                        <button class='btn frenteRequisito' id='frenteRequisito' title='Cadastrar Frentes e Requisitos'  value='" . $demandas['id'] . "' href='#'> <i class='icon-plus'></i></button>
                        <button class='btn frenteRequisito_editar' id='frenteRequisito_alterar_Visualizar' title='Editar Frentes e Requisitos'  value='" . $demandas['id'] . "' href='#'> <i class='icon-edit'></i></button>
                        
        
                        </td>
                        </tr>
                         
                        ";
        }
        echo"  </tbody>
                        </table>
                
                ";
        
    
      
     
    }
    
    
    
    
    function paginaInicial() {

        $cadastrarDAO = new CadastrarDAO();



        echo"


<div class='square_white'>
    <p class='label label-info fonte20'>Cadastrar Projetos</p>
    <div class='cadastro' >

        <form action='#' method='post' name='form_cliente' id='form_cliente'>

            <table class='table'>
                <tr>
                    <td>Responsavel Handover:</td>

                    <td> 

                        <span>
                        <select name='responsavel' required>
                        <option value=''>Responsável Handover...</option>";

                       $responsavel = $cadastrarDAO->preencheSelectResponsavelPesquisa();
                             while ($cliente = mysql_fetch_array($responsavel)) {
                             echo" <option value='" . $cliente['id']."'>".$cliente['nome']."</option>";}
                             echo" </select>
                                </span>
                                        
                   </td>
                </tr>
                
                <tr>
                    <td>Tipo:</td>
                    <td>
                        <input type='radio'  name='tipo' checked value='1'  />
                        <span> Cascata</span>&nbsp &nbsp

                        <input type='radio' name='tipo'  value='2' />
                        <span>Ágil</span>&nbsp &nbsp
                        
                        <input type='radio' name='tipo'  value='3' />
                        <span>Internalização</span>&nbsp &nbsp
                        
                        <input type='radio' name='tipo'  value='4' />
                        <span>RFP</span>
                    </td>
                </tr>
                <tr>
                    <td>Projeto:</td>
                    <td><input type='text' required name='codigo_prj' placeholder='Código Projeto' id='codigo_prj' value='' class='input-xxlarge'/>
                                        
                    </td>
                </tr>
                <tr>
                    <td>Nome Projeto:</td>
                    <td><input type='text' required name='nome_prj' id='nome_prj' value='' class='input-xxlarge'/>
                                        
                    </td>
                </tr>

                <tr>
                    <td>Status:</td>
                    <td>
                        <input type='radio'  name='status' checked value='1'  />
                        <span> Em Criação</span>&nbsp &nbsp

                        <input type='radio' name='status'  value='2' />
                        <span>Em Andamento</span>&nbsp &nbsp
                        
                        <input type='radio' name='status'  value='3' />
                        <span>Finalizado</span>&nbsp &nbsp

                        <input type='radio' name='status'  value='4' />
                        <span>Cancelado</span>&nbsp &nbsp

                        <input type='radio' name='status'  value='5' />
                        <span>Suspenso</span>&nbsp &nbsp
         
                    </td>
                </tr>

               
                <tr><td>Data do Status:</td>
                    <td><input type='date' name='data_status' id='data_status' value='' />
                                        
                    </td>

                    
                </tr>
                    
                <tr>
                    <td>Data Próxima Release:</td>
                    <td><input type='date' name='data_release' value=''  id='data_release' />

                    </td>
                </tr>

                <tr>
                    <td>Objetivo:</td>
                    <td><textarea name='objetivo' id='objetivo' value=''  class='textarea-large'/></textarea>
                                        
                    </td>
                </tr>
                <tr>
                    <td>Proximos Passos:</td>
                    <td><textarea  name='proximos_passos'  id='proximos_passos' value='' class='textarea-large'/></textarea>
                                                           
                    </td>
                </tr>
                <tr>
                    <td>Progresso:</td>
                    <td><textarea  name='progresso' id='progresso' value='' class='textarea-large'/></textarea>

                    </td>
                </tr>
                
                <tr>
                    <td>Pontos de Atenção:</td>
                    <td><textarea  name='pts_atencao' id='pts_atencao' value='' class='textarea-large'/></textarea>

                    </td>
                </tr> 

                <tr>
                    <td>Operação:</td>
                    <td><input type='text' name='operacao' id='operacao' value='' class='input-xxlarge'/>

                    </td>
                </tr>   
                
                <tr>
                    <td>Desenvolvimento:</td>
                    <td><textarea  name='desenvolvimento' id='desenvolvimento' value='' class='textarea-large'/></textarea>

                    </td>
                </tr> 

                <tr>
                    <td>Status dos Entregáveis:</td>
                    <td><textarea  name='status_entregaveis' id='status_entregaveis' value='' class='textarea-large'/></textarea>
                    
                    </td>
                </tr>

                <tr>
                    <td>Status dos Entregáveis 2:</td>
                    <td><textarea  name='status_entregaveis_v2' id='status_entregaveis_v2' value='' class='textarea-large'/></textarea>
                   
                    </td>
                </tr>

                <tr>
                    <td>Sistemas Críticos Envolvidos:</td>
                    <td>
                    <textarea  name='sistemas_criticos' id='sistemas_criticos' value='' class='textarea-large'/></textarea>

                    </td>
                </tr>  

                <tr>
                    <td>Status Gerencial:</td>
                    <td>
                    <textarea  name='status_gerencial' id='status_gerencial' value='' class='textarea-large'/></textarea>

                    </td>
                </tr>   

                                    
                            </table>

                            <div align = 'center'>

                            <table>
                            <tr>
                            <td>
                            <input type = 'hidden' name = 'acao' value = 'cadastrar'/>
                            <button type = 'submit' class = 'btn btn-success' >Cadastrar</button>
                            <input type = 'reset' class = 'btn ' value = 'Limpar'/>
                            </td>
                            </tr>
                            </table>


                            </div>


                            </form>
                <br>
                            <div id = 'resultado'></div>
                            </div>
                            </div>

                           
                         ";
        /*
                            <p class = 'label label-info'>Lista de clientes cadastrados</p>
 <form id='search' name='search' class='navbar-search pull-left'>
 <input type='hidden' name='acao' value='pesquisar'/>
     <input type='text' class='search-query span8' placeholder='Buscar Cliente' name='pesquisa_cliente'> <button class='btn' type='submit'><i class='icon-search'></i></button>
</form>
                            <div id = 'tabela'>
  
<table class='table table-bordered'>
    <thead>
    <tr>
        <th>Cliente</th>
        <th>Ativo</th>
        <th>Ação</th>
      
    </tr>
    </thead>
    <tbody id='clientes'>";
        while ($clientes = mysql_fetch_array($resultado)) {
            if ($clientes['ativo'] == '1') {
                $ativo = 'Ativo';
            } else {
                $ativo = 'Inativo';
            }
            echo"<tr>        
            <td>
               " . $clientes['nome_cliente'] . " 
                
            </td>
            <td>
               " . $ativo . " 
                
            </td>
            <td>
                <button class='btn editar' id='editar' title='Editar'  value='" . $clientes['id_cliente'] . "' href='#'> <i class='icon-pencil'></i></button>
             
               
                    
            </td>
        </tr>         
         
";
        }*/
        echo"  </tbody>
    </table>
 </div> 

<div class='holder'></div>

                            </div>
                             ";
    }

 
    function frenteRequisitos_Visualizar($resultado) {

        
        $cadastrarDAO = new CadastrarDAO();
        $demanda = mysql_fetch_array($resultado);




        echo"
              <script src='js/functions_cadastrar.js'></script>      



<div class='square_white'>
    <p class='label label-info fonte20'>Cadastrar Frente de Trabalho e Requisitos Não Funcionais</p>
    <div class='cadastro' >

        <form action='#' method='post' name='form_frenteRequisitos' id='form_frenteRequisitos'>

        
<table id='listas' border='0'>
        <tr style='border-bottom:1pt solid black;'>
                <th>Frente de Trabalho</th>
                <th>&nbsp;</th>
                <th>Requisitos Não Funcionais</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
        </tr>
        <tr style='border-bottom:1pt solid black;'>

                <br>
                <br>
            

                <td>

                    <span>
                        <select name='frenteTrabalho' id='frenteTrabalho'>
                        <option value='0'>Frente de Trabalho...</option>";

                           $frenteTrabalho = $cadastrarDAO->preencheSelectFrentePesquisa();
                                 while ($cliente = mysql_fetch_array($frenteTrabalho)) {
                                 echo" <option value='" . $cliente['id']."'>".$cliente['nome']."</option>";}
                                 echo" </select>
                                </span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                </td>

                <td>";
                        
                        

                           $requisitos = $cadastrarDAO->preencheSelectRequisitosPesquisa();
                            $cont=1;
                                 while ($cliente = mysql_fetch_array($requisitos)) {
                                   

                                   echo "<input type='checkbox' value='" . $cliente['id']."' name='requisitosFuncionais[]' id='requisitosFuncionais'>&nbsp&nbsp " . $cliente['nome']."<br>";


                                    if ($cont==7){ 
                                       echo "  </td><td>";

                                    }elseif($cont==14){
                                     echo" </td><td> ";

                                    } $cont++; 

                                                            


                                }
                                
                                echo"
                                
                                
                            

                                
                <td></td>
                

        </tr>
</table><br><br>
                            
                         <div align = 'center'>

                            <table>
                            <tr>
                            <td><br><input type='hidden' name='acao' value= 'cadastrar_frenteRequisitos'/>   
                            <input type='hidden' name='id' value='" . $demanda['id'] . "'/>   
                            <button type='submit' class='btn btn-success' >Cadastrar</button>   
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            <input type = 'reset' class = 'btn ' value = 'Limpar e Cadastrar Nova Frente'/>

                            </td>
                            </tr>
                            </table>

                                                                             

                            

                            </form>


                <br>
                            <div id = 'resultado'></div>
                            </div>
                            </div>

                           
                         ";
        /*
                            <p class = 'label label-info'>Lista de clientes cadastrados</p>
 <form id='search' name='search' class='navbar-search pull-left'>
 <input type='hidden' name='acao' value='pesquisar'/>
     <input type='text' class='search-query span8' placeholder='Buscar Cliente' name='pesquisa_cliente'> <button class='btn' type='submit'><i class='icon-search'></i></button>
</form>
                            <div id = 'tabela'>
  
<table class='table table-bordered'>
    <thead>
    <tr>
        <th>Cliente</th>
        <th>Ativo</th>
        <th>Ação</th>
      
    </tr>
    </thead>
    <tbody id='clientes'>";
        while ($clientes = mysql_fetch_array($resultado)) {
            if ($clientes['ativo'] == '1') {
                $ativo = 'Ativo';
            } else {
                $ativo = 'Inativo';
            }
            echo"<tr>        
            <td>
               " . $clientes['nome_cliente'] . " 
                
            </td>
            <td>
               " . $ativo . " 
                
            </td>
            <td>
                <button class='btn editar' id='editar' title='Editar'  value='" . $clientes['id_cliente'] . "' href='#'> <i class='icon-pencil'></i></button>
             
               
                    
            </td>
        </tr>         
         
";
        }*/
        echo"  </tbody>
    </table>
 </div> 

<div class='holder'></div>

                            </div>
                             ";
    }

    function frenteRequisitos_alterar($resultado,$resultadoFrentes) {

        
        $cadastrarDAO = new CadastrarDAO();
        $demanda = mysql_fetch_array($resultado);
       
       

        echo"
            <script src='js/functions_cadastrar.js'></script>
  <div class='square_grey'>
<p class='label label-info fonte20'>Editar Frente e Requisitos</p>  

  <div id='resultado'>
 
 
      <table border='0'>
        <tr style='border-bottom:1pt solid black;'>
                <th>Frente de Trabalho</th>
                
                <th>Requisitos Não Funcionais</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
        </tr>
        

                <br>
                <br>";

                
                 $frenAntiga=0;

            while ($demandaFrente = mysql_fetch_array($resultadoFrentes)) {
                    
                    
                    
                    
                        if ($demandaFrente['id_frentes'] != $frenAntiga) {

                           $frenAntiga= $demandaFrente['id_frentes'];

                           

                            echo"<tr style='border-bottom:1pt solid black;'>
                            <td>";
                                  
                                                                         
                                echo" <input type='text' readonly name='nome_frente' id='nome_frente' value='" . $demandaFrente['nome_frente'] .
                                 "'class='input-xxlarge limit'/><br>
                                 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp


                            <td>";


                                    $cont=1;

                                               
                                    $buscaRequisitos = $cadastrarDAO->buscaRequisitos($demanda['id'],$demandaFrente['id_frentes']);                      
                                     
                                    while ($demandaRequisitos = mysql_fetch_array($buscaRequisitos)) {
                                      
                                        if ($demandaRequisitos['id_frentes'] == $demandaFrente['id_frentes']) {
                                           
                                           echo "<input type='checkbox' checked readonly value='" . $demandaRequisitos['id_requisitos']."' id='requisitosFuncionais'>&nbsp&nbsp".$demandaRequisitos['nome_requisito']." <br>";


                                            if ($cont==7){ 
                                               echo "  </td><td>";

                                            }elseif($cont==14){
                                             echo" </td><td> ";

                                            } 
                                              $cont++;

                                                                    
                                         }
                                   }

                                    
                                    
                           echo "</td> <td>

                           

                        <button class='btn frenteRequisito_editar_Visualizar' id='frenteRequisito_editar_Visualizar' title='frenteRequisito_editar_Visualizar'  value='" . $demanda['id'] . "-" . $demandaFrente['id_frentes'] . "' href='#'> Editar</button>


                           </td>      </tr>";
                        }   
                 
            }
            
                
                                
               echo "<td></td> 
                

      
</table>
                           

                            

                            
                                 
    </table><br>
 <button class='btn' id='voltar'>Voltar</button>  
</div>
<div id='voltar'></div>
</div>";



       
    }



    function frenteRequisitos_editar($resultado,$resultadoFrentes) {

        
        $cadastrarDAO = new CadastrarDAO();
        $demanda = mysql_fetch_array($resultado);
       
       

        echo"
            <script src='js/functions_cadastrar.js'></script>
  <div class='square_grey'>
<p class='label label-info fonte20'>Editar Frente e Requisitos</p>  
<form action='#' method='post' name='form_frenteRequisitos_editar' id='form_frenteRequisitos_editar'>

  <div id='resultado'>
 
 
    <table border='0'>
        <tr style='border-bottom:1pt solid black;'>
                <th>Frente de Trabalho</th>
                
                <th>Requisitos Não Funcionais Cadastrados</th>
                <th>&nbsp;</th>
                <th>Novos Requisitos a Serem Cadastrados</th>
                <td></td>
        </tr>      <br>
                <br>";




        $frenAntiga=0;
                 
            $demandaFrente = mysql_fetch_array($resultadoFrentes);
                    
                    

                            echo"

                            <tr style='border-bottom:1pt solid black;'>
                            <td>
                                      <input type='text' readonly name='frenteTrabalho_marcados' id='frenteTrabalho_marcados' value='" . $demandaFrente['nome_frente'] .
                                      "'/><br>
                                        
                                                                                                                 
                                 <span>
                                            <select name='frenteTrabalho[]' id='frenteTrabalho'>
                                            <option value='0'>Selecione a Nova Frente...</option>";

                                               $frenteTrabalho = $cadastrarDAO->preencheSelectFrentePesquisa();

                                                 while ($cliente = mysql_fetch_array($frenteTrabalho)) {
                                                 echo" 
                                                 
                                                 <option value='" . $cliente['id']."'>".$cliente['nome']."</option>

                                                 ";}

                                      echo" </select>
                                </span>

                            <td>";

                                    $cont=1;
                                    $cont2=1;

                                               
                                    $buscaRequisitos = $cadastrarDAO->buscaRequisitos($demanda['id'],$demandaFrente['id_frentes']);                      
                                     
                                    while ($demandaRequisitos = mysql_fetch_array($buscaRequisitos)) {
                                                    
                                        if ($demandaRequisitos['id_frentes'] == $demandaFrente['id_frentes']) {
                                           
                                           echo "<input type='checkbox' checked  value='" . $demandaRequisitos['id_requisitos']."' id='requisitosFuncionais_marcados'>&nbsp&nbsp".$demandaRequisitos['nome_requisito']." <br>";

                                            if ($cont==7){ 
                                                 echo "  </td><td>";

                                            }elseif($cont==14){
                                                echo" </td><td> ";

                                             } $cont++; 


                                           
                                                                    
                                         }

                                   }echo "<br><td border='1'>";


                                    $requisitos = $cadastrarDAO->preencheSelectRequisitosPesquisa();
                                             
                                                 while ($cliente = mysql_fetch_array($requisitos)) {
                                   

                                                  echo "<input type='checkbox' value='" . $cliente['id']."' name='requisitosFuncionais[]' id='requisitosFuncionais'>&nbsp&nbsp " . $cliente['nome']."<br>";


                                                  if ($cont2==7){ 
                                                    echo "  </td><td>";

                                                  }elseif($cont2==14){
                                                    echo" </td><td> ";

                                                    } 
                                                    $cont2++;
                                                     }

                                    echo "</td>";

                                  
                                    
                           echo "</td> 

                           <td></td>
                           
                           </tr>";


            
            
                
                                
               echo "<td></td> 
             
            

                             

                   





    </table><br>
 </form>
 
                           <div align = 'center'>
                            <input type='hidden' name='acao' value='alterar_RequisitosFrentes'/> 
                            <input type='hidden' name='id' value='" . $demanda['id'] . "-" . $demandaFrente['id_frentes'] . "'/>   
                            <button type='submit' class='btn btn-success'>Editar</button>&nbsp&nbsp
                            <button type='submit' class='btn btn-success'>Excluir</button>&nbsp&nbsp
                            

                            
                            <div  id='resultado_status'></div>
                            </div>


 
</div>
<div id='voltar'></div>
</div>";



       
    }


    function resultadoInserir($resultado) {

        if ($resultado) {
            
            echo 'Cadastro realizado com sucesso! <button type="button" class="close" data-dismiss="alert">×</button>';
        } else {
            echo 'Erro ao efetuar o login. Dados incorretos!';
        }
    }

    function resultadoEditar($resultado) {

        if ($resultado) {
            echo 'Cadastro alterado com sucesso!';
        } else {
            echo 'Erro ao efetuar o cadastro!';
        }
    }

     function resultadoCadastrarFrenteRequisitos($resultado) {

        if ($resultado) {
            echo 'Cadastro realizado com sucesso!';
        } else {
            echo 'Erro ao efetuar o cadastro!';
        }
    }

    function resultadoRemoverCadastrarFrenteRequisitos($resultado) {

        if ($resultado) {
            echo 'Realizado com sucesso!';
        } else {
            echo 'Erro ao efetuar comando!';
        }
    }

    function imprimeSubStatus($resultado){
        
        echo"<select name='substatus' id='sub' disabled>";
                while($sub = mysql_fetch_array($resultado)){
            echo" <option value='". $sub['id'] ."'>" . $sub['sub_status'] . "</option>";
                    
                    
    }   
    echo "</select>
                    
                    ";
    /*<button id='enviar_sub_status' class=' btn btn btn-info' disabled><i class=' icon-ok'></i></button>
                    <br>
                    <div  id='resultado_sub_status'></div>*/
    }

    function retornoPesquisar($resultado) {
        $cadastrarDAO = new CadastrarDAO();
        
echo" 
<script src='js/functions_cadastrar.js'></script>    

        <table class='table table-bordered'>
        <thead>
        <tr>
        <th>Projeto</th>
        <th>Responsável Handover</th>
        <th>Status</th>
            <th>Data Status</th>
                <th>Data Release</th>
            <th>Tipo</th>
            <th>Ação</th>
        
        </tr>
        </thead>
        <tbody id='clientes'>";


        while ($demandas = mysql_fetch_array($resultado)) {
        if ($demandas['tipo'] == '1') {
                $tipo = 'Cascata';
        }elseif ($demandas['tipo'] == '2') {
                $tipo = 'Ágil';
        }elseif ($demandas['tipo'] == '3') {
                $tipo = 'Internalização';
        }else {
                $tipo = 'RFP';
        }
        
         if($demandas['status_gerencial']!=''){
        //$prioridade ="<i class='icon-exclamation-sign'></i>";
        $prioridade ="<div title='Status Gerencial'class='lg-parada'>!</div>";
        }else{$prioridade='';}

                echo"<tr>
                <td title='" . $demandas['nome_prj'] . "'>
                " . $demandas['codigo_prj'] . "".$prioridade."
        
                        </td>
                        <td>";
                if($demandas['responsavel']!=0){
                echo $cadastrarDAO->buscaNomeResponsavel( $demandas['responsavel']);
                }
                        echo "</td>
                        <td>" .$cadastrarDAO->buscaNomeStatus( $demandas['status'] ). "</td>
                         <td>" .$this->converterData($demandas['data_status']). "</td>
                                        
                        <td>" .$this->converterData($demandas['data_release']). "</td>

                               
                        <td>
                        " . $tipo. "
        
                        </td>
                        <td>
                         <button class='btn detalhar' id='detalhar' title='Detalhar'  value='" . $demandas['id'] . "' href='#'> <i class='icon-tasks'></i></button>
                        <button class='btn editar' id='editar' title='Editar'  value='" . $demandas['id'] . "' href='#'> <i class='icon-pencil'></i></button>

                        <button class='btn frenteRequisito' id='frenteRequisito' title='Cadastrar Frentes e Requisitos'  value='" . $demandas['id'] . "' href='#'> <i class='icon-plus'></i></button>
                        <button class='btn frenteRequisito_editar' id='frenteRequisito_editar' title='Editar Frentes e Requisitos'  value='" . $demandas['id'] . "' href='#'> <i class='icon-edit'></i></button>
                        
        
                        </td>
                        </tr>
                         
                        ";
        }
        echo"  </tbody>
                        </table>
                
                ";
        
    
    
    }
    
    function  converterData($data){
        
        $convertida = implode("/",array_reverse(explode("-",$data)));
        return $convertida;
    }
    
    function  converterDataHora($data){
        date_default_timezone_set('America/Sao_Paulo');
        $convertida = date('d/m/Y H:i:s', strtotime($data));
        return $convertida;
    }
    

    function editarVisualizar($resultado) {
       
        $cadastrarDAO = new CadastrarDAO();
        $demanda = mysql_fetch_array($resultado);
       
        $cascata = '';
        $agil = '';
        $internalização='';
        $rfp='';
        $emcriacao='';
        $emandamento='';
        $finalizada='';
        $cancelado='';
        $suspenso='';
        
        if ($demanda['tipo'] == '1') {
            $cascata = 'checked';
        }elseif ($demanda['tipo'] == '2') {
            $agil = 'checked';
        }
        elseif ($demanda['tipo'] == '3') {
            $internalização = 'checked';
        } else {
            $rfp = 'checked';
        }

        if ($demanda['status'] == '1') {
            $emcriacao = 'checked';
        }elseif ($demanda['status'] == '2') {
            $emandamento = 'checked';
        }elseif ($demanda['status'] == '3'){
            $finalizada = 'checked';
        }elseif ($demanda['status'] == '4') {
            $cancelado = 'checked';
        }else{
            $suspenso = 'checked';            
        }

        echo"
            <script src='js/functions_cadastrar.js'></script>
  <div class='square_grey'>
<p class='label label-info fonte20'>Editar Projeto</p>  

  <div id='resultado'>
 <form action='#' method='post' name='form_cliente_editar' id='form_cliente_editar'>
 
    <table class='table' border='0'>
       <tr>
            <td>Responsavel:</td>
            <td><input type='text' name='responsavel_editar' id='responsavel_editar' readonly value='" . $demanda['nome'] . "'class='input-xxlarge limit'/>
             
        </td>
                
                
                <tr>
            
            <td>Tipo:</td>
            <td>
            <input type='radio'  name='tipo_editar' value='1' " . $cascata. " />
            <span> Cascata </span>

            <input type='radio' name='tipo_editar' value='2' " . $agil. " />
            <span>Ágil</span>

            <input type='radio' name='tipo_editar' value='3' " . $internalização. " />
            <span>Internalização</span>

            <input type='radio' name='tipo_editar' value='4' " . $rfp. " />
            <span>RFP</span>
            </td>
        </tr>

        <tr>
            <td>Projeto:</td>
            <td><input type='text' name='codigo_prj_editar' id='codigo_prj_editar' value='" . $demanda['codigo_prj'] . "'class='input-xxlarge limit'/>
             
            </td>
        </tr>
                   
        <tr>
            <td>Nome Projeto:</td>
            <td><input type='text' name='nome_prj_editar' id='nome_prj_editar' value='" . $demanda['nome_prj'] . "'class='input-xxlarge limit'/>
                                        
        </tr> 

        <tr>

            <td>Status:</td>
            <td>
            <input type='radio'  name='status_editar' value='1' " . $emcriacao. " />
            <span> Em Criação </span>

            <input type='radio' name='status_editar' value='2' " . $emandamento. " />
            <span>Em Andamento</span>

            <input type='radio' name='status_editar' value='3' " . $finalizada. " />
            <span>Finalizada</span>

            <input type='radio' name='status_editar' value='4' " . $cancelado. " />
            <span>Cancelado</span>

            <input type='radio' name='status_editar' value='5' " . $suspenso. " />
            <span>Suspenso</span>



                    
                                        
        </tr> 

        <tr>
            <td>Data Status:</td>
            <td><input type='date' name='data_status_editar' id='data_status_editar' value='" . $demanda['data_status'] . "'/>
                                        
        </tr> 

        <tr>
            <td>Data Release:</td>
            <td><input type='date' name='data_release_editar' id='data_release_editar' value='" . $demanda['data_release'] . "'/>
                                        
        </tr> 

        <tr>
            <td>Objetivo:</td>
            <td><textarea rows='3' cols='400' style='margin: 0px; width: 541px; height: 80px;'  name='objetivo_editar' id='objetivo_editar'>"; echo $demanda['objetivo'];
            echo"</textarea>
                                        
        </tr> 

        <tr>
            <td>Próximos Passos:</td>
            <td><textarea rows='3' cols='400' style='margin: 0px; width: 541px; height: 80px;'    name='proximos_passos_editar' id='proximos_passos_editar'>";echo $demanda['proximos_passos'];
            echo"</textarea>
                                        
        </tr> 

        <tr>
            <td>Progresso:</td>
            <td><textarea rows='3' cols='400' style='margin: 0px; width: 541px; height: 80px;'   name='progresso_editar' id='progresso_editar'>"; echo $demanda['progresso'];
            echo"</textarea>
                                       
        </tr> 

        <tr>
            <td>Pontos de Atenção:</td>
            <td><textarea rows='3' cols='400' style='margin: 0px; width: 541px; height: 80px;'    name='pts_atencao_editar' id='pts_atencao_editar'>"; echo $demanda['pts_atencao'];
            echo"</textarea>

        </tr> 

        <tr>
            <td>Operação:</td>
            <td><textarea rows='3' cols='400' style='margin: 0px; width: 541px; height: 80px;'   name='operacao_editar' id='operacao_editar'>";echo $demanda['operacao'];
            echo"</textarea>

        </tr> 

        <tr>
            <td>Desenvolvimento:</td>
            <td><textarea rows='3' cols='400' style='margin: 0px; width: 541px; height: 80px;'   name='desenvolvimento_editar' id='desenvolvimento_editar'>";echo $demanda['desenvolvimento'];echo"</textarea>

        </tr> 

       
        <tr>
            <td>Status Entregáveis:</td>
            <td><textarea rows='3' cols='400' style='margin: 0px; width: 541px; height: 80px;'    name='status_entregaveis_editar' id='status_entregaveis_editar'>";echo $demanda['status_entregaveis'];
            echo"</textarea>

        </tr> 

        <tr>
            <td>Status Entregáveis V2:</td>
            <td><textarea rows='3' cols='400' style='margin: 0px; width: 541px; height: 80px;'   name='status_entregaveis_v2_editar' id='status_entregaveis_v2_editar'>"; echo $demanda['status_entregaveis_v2'];
            echo"</textarea>
                                        
        </tr> 

        <tr>
            <td>Sistemas Críticos:</td>
            
            <td><textarea rows='3' cols='400' style='margin: 0px; width: 541px; height: 80px;'   name='sistemas_criticos_editar' id='sistemas_criticos_editar'>";echo $demanda['sistemas_criticos'];
            echo"</textarea>
        </tr>

        <tr>
            <td>Status Gerencial:</td>
            
            <td><textarea rows='3' cols='400' style='margin: 0px; width: 541px; height: 80px;'   name='status_gerencial_editar' id='status_gerencial_editar'>";echo $demanda['status_gerencial'];
            echo"</textarea>
        </tr>



        </table>

        
  
 <input type='hidden' name='acao' value='editar_demanda'/>   
 <input type='hidden' name='id' value='" . $demanda['id'] . "'/>   
        <button type='submit' class='btn btn-success' id='teste'>Enviar</button>    
       <button class='btn' id='cancelar'>Cancelar</button>  
</form>
</div>
<div id='voltar'></div>
</div>";
    }


        
    
    function detalharVisualizar($resultado,$resultadoFrentes) {
         
        $cadastrarDAO = new CadastrarDAO();
        $demanda = mysql_fetch_array($resultado);
            
        
        
        $des_usuario='';

       //if($demanda['status']==9){$des_usuario='disabled';}
        
        $cascata = '';
        $agil = '';
        $internalização='';
        $rfp='';
        $emcriacao='';
        $emandamento='';
        $finalizada='';
        $cancelado='';
        $suspenso='';
        
        if ($demanda['tipo'] == '1') {
            $cascata = 'checked';
        }elseif ($demanda['tipo'] == '2') {
            $agil = 'checked';
        }
        elseif ($demanda['tipo'] == '3') {
            $internalização = 'checked';
        } else {
            $rfp = 'checked';
        }

        if ($demanda['status'] == '1') {
            $emcriacao = 'checked';
        }elseif ($demanda['status'] == '2') {
            $emandamento = 'checked';
        }elseif ($demanda['status'] == '3'){
            $finalizada = 'checked';
        }elseif ($demanda['status'] == '4') {
            $cancelado = 'checked';
        }else{
            $suspenso = 'checked';            
        }



        if($demanda['data_status']!='0000-00-00'){
$data_status=  $this->converterData($demanda['data_status']);}

        if($demanda['data_release']!='0000-00-00'){
$data_release=  $this->converterData($demanda['data_release']);}
        
        echo"
            <script src='js/functions_cadastrar.js'></script>
                
  <div class='square_white'>
    
  <div id='resultado'></div>

        <p class='label label-warning'>Projeto Detalhado</p>
        <br>
        
        <table class='table table-condensed'>
        <tr>
            <td>Responsavel:</td>
            <td><input type='text' name='responsavel' id='responsavel' readonly value='" . $demanda['nome'] . "'class='input-xxlarge limit'/>
             
        </td>
                
                
                <tr>
            
            <td>Tipo:</td>
            <td>
            <input type='radio' readonly name='tipo' value='1' " . $cascata. " />
            <span> Cascata </span>

            <input type='radio' readonly name='tipo' value='2' " . $agil. " />
            <span>Ágil</span>

            <input type='radio' readonly name='tipo' value='3' " . $internalização. " />
            <span>Internalização</span>

            <input type='radio' readonly name='tipo' value='4' " . $rfp. " />
            <span>RFP</span>
            </td>
        </tr>

        <tr>
            <td>Projeto:</td>
            <td><input type='text' readonly name='codigo_prj' id='codigo_prj' value='" . $demanda['codigo_prj'] . "'class='input-xxlarge limit'/>
             
            </td>
        </tr>
                   
        <tr>
            <td>Nome Projeto:</td>
            <td><input type='text' readonly name='nome_prj' id='nome_prj' value='" . $demanda['nome_prj'] . "'class='input-xxlarge limit'/>
                                        
        </tr> 

        <tr>

         <td>Status:</td>
            <td>
            <input type='radio'  name='status_editar' value='1' " . $emcriacao. " />
            <span> Em Criação </span>

            <input type='radio' name='status_editar' value='2' " . $emandamento. " />
            <span>Em Andamento</span>

            <input type='radio' name='status_editar' value='3' " . $finalizada. " />
            <span>Finalizada</span>

            <input type='radio' name='status_editar' value='4' " . $cancelado. " />
            <span>Cancelado</span>

            <input type='radio' name='status_editar' value='5' " . $suspenso. " />
            <span>Suspenso</span>
                    
                                        
        </tr> 

        <tr>
            <td>Data Status:</td>
            <td><input type='date' readonly name='data_status' id='data_status' value='" . $demanda['data_status'] . "'/>
                                        
        </tr> 

        <tr>
            <td>Data Release:</td>
            <td><input type='date' name='data_release' readonly id='data_release' value='" . $demanda['data_release'] . "'/>
                                        
        </tr> 

        <tr>
            <td>Objetivo:</td>
            <td><textarea rows='3' cols='400' readonly style='margin: 0px; width: 541px; height: 80px;'  name='objetivo' id='objetivo'>";echo $demanda['objetivo'];
            echo"</textarea>
                                        
        </tr> 

        <tr>
            <td>Próximos Passos:</td>
            <td><textarea rows='3' readonly cols='400' style='margin: 0px; width: 541px; height: 80px;'    name='proximos_passos' id='proximos_passos'>";echo $demanda['proximos_passos'];
            echo"</textarea>
                                        
        </tr> 

        <tr>
            <td>Progresso:</td>
            <td><textarea rows='3' readonly  cols='400' style='margin: 0px; width: 541px; height: 80px;'   name='progresso' id='progresso'>"; echo $demanda['progresso'];
            echo"</textarea>
                                       
        </tr> 

        <tr>
            <td>Pontos de Atenção:</td>
            <td><textarea rows='3' readonly cols='400' style='margin: 0px; width: 541px; height: 80px;'    name='pts_atencao' id='pts_atencao'>"; echo $demanda['pts_atencao'];
            echo"</textarea>

        </tr> 

        <tr>
            <td>Operação:</td>
            <td><textarea rows='3' readonly cols='400' style='margin: 0px; width: 541px; height: 80px;'   name='operacao' id='operacao'>"; echo $demanda['operacao'];
            echo"</textarea>

        </tr> 

        <tr>
            <td>Desenvolvimento:</td>
            <td><textarea rows='3' readonly cols='400' style='margin: 0px; width: 541px; height: 80px;'   name='desenvolvimento' id='desenvolvimento'>"; echo $demanda['desenvolvimento'];
            echo"</textarea>

        </tr> 

        
        <tr>
            <td>Status Entregáveis:</td>
            <td><textarea rows='3' cols='400' readonly style='margin: 0px; width: 541px; height: 80px;'    name='status_entregaveis' id='status_entregaveis'>"; echo $demanda['status_entregaveis'];
            echo"</textarea>

        </tr> 

        <tr>
            <td>Status Entregáveis V2:</td>
            <td><textarea rows='3' readonly cols='400' style='margin: 0px; width: 541px; height: 80px;'   name='status_entregaveis_v2' id='status_entregaveis_v2'>"; echo $demanda['status_entregaveis_v2'];  
            echo"</textarea>
                                        
        </tr> 

        <tr>
            <td>Sistemas Críticos:</td>
            
            <td><textarea rows='3' cols='400' style='margin: 0px; width: 541px; height: 80px;' readonly name='sistemas_criticos' id='sistemas_criticos_'>";echo $demanda['sistemas_criticos'];
            echo"</textarea>
        </tr> 

        <tr>
            <td>Status Gerencial:</td>
            
            <td><textarea rows='3' cols='400' style='margin: 0px; width: 541px; height: 80px;' readonly name='status_gerencial' id='status_gerencial'>";echo $demanda['status_gerencial'];
            echo"</textarea>
        </tr> 

        </table>



        <table border='0'>
        <tr style='border-bottom:1pt solid black;'>
                <th>Frente de Trabalho</th>
                
                <th>Requisitos Não Funcionais</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
        </tr>
        

                <br>
                <br>";

                $frenAntiga=0;
                 
            while ($demandaFrente = mysql_fetch_array($resultadoFrentes)) {
                    
                    
                    for ($f=0; $f < 999 ; $f++) { 

         
                        if ($demandaFrente['id_frentes'] == $f && $f != $frenAntiga) {

                           

                            echo"<tr style='border-bottom:1pt solid black;'>
                            <td>";
                                  
                                                                         
                                echo" <input type='text' readonly name='nome_frente' id='nome_frente' value='" . $demandaFrente['nome_frente'] .
                                 "'class='input-xxlarge limit'/><br>
                                 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp


                            <td>";


                                    $cont=1;

                                               
                                    $buscaRequisitos = $cadastrarDAO->buscaRequisitos($demanda['id'],$demandaFrente['id_frentes']);                      
                                     
                                    while ($demandaRequisitos = mysql_fetch_array($buscaRequisitos)) {
                                      
                                        if ($demandaRequisitos['id_frentes'] == $demandaFrente['id_frentes']) {
                                           
                                           echo "<input type='checkbox' checked readonly value='" . $demandaRequisitos['id_requisitos']."' id='requisitosFuncionais'>&nbsp&nbsp".$demandaRequisitos['nome_requisito']." <br>";


                                            if ($cont==7){ 
                                               echo "  </td><td>";

                                            }elseif($cont==14){
                                             echo" </td><td> ";

                                            } 
                                              $cont++;

                                                                    
                                         }
                                   }

                                    $frenAntiga= $f;
                                    
                           echo "</td>"; 
                           echo "</tr>";
                        }   
                 }
            }
            
                
                                
               echo "<td></td> 
                

      
</table>

                    
       <button class='btn btn-primary' id='voltar'>Voltar</button>
                

        <br><br>
        <br>
        
</div>
<div id='voltar'></div>
        
</div>";
        echo '<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title">Escolha a base</h4>
        </div>
        <div class="modal-body">
         <select name"base" id="base">
        <option>Selecione...</option>';
            $this->imprimeSelectBase($cadastrarDAO->preencheSelectBases())  ;
                
        echo'</select>
                <p id="resultado_base"></p>
        </div>
        
      </div>
    </div>
  </div>
</div> ';    
       
        echo'<!-- Modal -->
  <div class="modal fade" id="aguardaModal" role="dialog">
    <div class="modal-dialog">
        
      <!-- Modal content-->
      <div class="modal-content">
        <img src="img/ajax-loader.gif"/>
      </div>
        
    </div>
  </div>
    ';
        
    }

}

?>