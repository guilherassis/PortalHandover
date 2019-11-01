<?php 

include ("Conection.class.php");
require_once "includes/model/dao/CadastrarDAO.class.php";

$cadastrarDAO = new CadastrarDAO();

$grupo = $cadastrarDAO->extrairTodos();

//var_dump($grupo);

$arqexcel= "<meta charset='UTF-8'>";


$arqexcel .="<table class='table'>
		<thead>
                <tr>
                    <th>Responsavel Handover:</th>

                    <th>Tipo:</th>
                   
                    <th>Projeto:</th>
               
                    <th>Nome Projeto:</th>
                 
                    <th>Status:</th>
                 
                    <th>Data do Status:</th>
               
                    <th>Data Próxima Release:</th>
                
                    <th>Objetivo:</th>
                
                    <th>Proximos Passos:</th>
               
                    <th>Progresso:</th>
              
                    <th>Pontos de Atenção:</th>
              
                    <th>Operação:</th>
              
                    <th>Desenvolvimento:</th>
                
                    <th>Status dos Entregáveis:</th>
                 
                    <th>Status dos Entregáveis 2:</th>
              
                    <th>Sistemas Críticos Envolvidos:</th>

                    <th>Status Gerencial:</th>

                </tr>  

            </thead>                        
            <tbody>";


           	

           			foreach ($grupo as $demanda ) {
           				
           	//$demandaResponsavel = mysql_fetch_array($resultadoResponsavel);		
           $arqexcel .="<tr>

           				<td>{$demanda["nome_responsavel"]}</td>
           				<td>{$demanda["nome_tipo"]}</td>
           				<td>{$demanda["codigo_prj"]}</td>
           				<td>{$demanda["nome_prj"]}</td>
                  <td>{$demanda["nome_status"]}</td>
           				<td>".$cadastrarDAO->formatoData($demanda["data_status"])."</td>
           				<td>".$cadastrarDAO->formatoData($demanda["data_release"])."</td>
           				<td>{$demanda["objetivo"]}</td>
           				<td>{$demanda["proximos_passos"]}</td>
           				<td>{$demanda["progresso"]}</td>
           				<td>{$demanda["pts_atencao"]}</td>
           				<td>{$demanda["operacao"]}</td>
           				<td>{$demanda["desenvolvimento"]}</td>
           				<td>{$demanda["status_entregaveis"]}</td>
           				<td>{$demanda["status_entregaveis_v2"]}</td>
           				<td>{$demanda["sistemas_criticos"]}</td>
                  <td>{$demanda["status_gerencial"]}</td>




						</tr>
           ";



           }

            $arqexcel .="  </tbody>
        </table>";
          
          header("Content-Type: application/xls");
          header("Content-Disposition:attachment; filename = relatorioProjetos.xls");
          echo $arqexcel;







 ?>