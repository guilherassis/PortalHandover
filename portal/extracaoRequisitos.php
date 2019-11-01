<?php 

include ("Conection.class.php");
require_once "includes/model/dao/CadastrarDAO.class.php";

$cadastrarDAO = new CadastrarDAO();

$frentes = $cadastrarDAO->extrairFrentes();

//var_dump($grupo);

$arqexcel= "<meta charset='UTF-8'>";


$arqexcel .="<table class='table'>
    <thead>
                <tr>
                    <th>ID Projeto</th>
                    
                    <th>Nome Projeto</th>

                    <th>Nome Responsavel</th>
                                      
                    <th>Frente de Trabalho</th>
               
                    <th>Administração Centralizada</th>
               
                    <th>Atendimento Nivel 1 / Healthcheck</th>
               
                    <th>Auditoria</th>
               
                    <th>BKP Infraestrutura</th>
               
                    <th>Cadastro</th>
               
                    <th>Capacidade</th>
               
                    <th>Conectividade</th>
               
                    <th>Contrato</th>
               
                    <th>Dashboard Negócio</th>
               
                    <th>Dashboard Operacional</th>
               
                    <th>Governança ITIL</th>
               
                    <th>Monitoração Aplicacional</th>

                    <th>Monitoração Exp. do cliente (Robô)</th>

                    <th>MOP/POP</th>

                    <th>Operação assistida / 1ª. Execuo / BSIM</th>

                    <th>Passagem de conhecimento</th>

                    <th>Política de Expurgo</th>

                    <th>Release CRQ</th>

                    <th>Runbook</th>

                    <th>Segurança</th>

                    <th>Tecnologia</th>
               
                </tr>  

            </thead>                        
            <tbody>";


            

                foreach ($frentes as $demanda ) {
                  
            //$demandaResponsavel = mysql_fetch_array($resultadoResponsavel);   
           $arqexcel .="<tr>

                  <td>{$demanda["codigo_prj"]}</td>
                  <td>{$demanda["nome_prj"]}</td>
                  <td>{$demanda["nome_responsavel"]}</td>
                  <td>{$demanda["frente"]}</td>";
                    
                 $gruposRequisitos = $cadastrarDAO->extrairRequisitos($demanda['id_demandas'],$demanda['id_frentes']);

                    foreach($gruposRequisitos as $requisitos ){
                      

                          if ($requisitos["CADASTRADO"] == 'SIM' ) {

                            $arqexcel .="<td>Aplicavel</td>";
                            
                          }else{
                            
                             $arqexcel .="<td>Não Aplicavel</td>";
                            
                          }

                }

                


                  

           $arqexcel .= "</tr>";



           }

            $arqexcel .="  </tbody>
        </table>";
          
          header("Content-Type: application/xls");
          header("Content-Disposition:attachment; filename = relatorioRequisitos.xls");
          echo $arqexcel;







 ?>