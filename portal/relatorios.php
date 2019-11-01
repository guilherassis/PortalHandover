<?php
require_once 'includes/view/html_body.php';
require_once 'includes/controller/ValidaLogin.class.php';
$html = new HtmlBody();
$html->htmlHeaderAdmin();
$validar = new ValidaLogin();
$validar->ValdidarLogin();

?>
 


<div id='corpo'>
                            <?php
                            require_once("includes/model/dao/RelatoriosDAO.class.php"); // Classe DAO
                            require_once("includes/view/RelatoriosView.class.php"); //Classe View
                            $relatorioDAO = new RelatoriosDAO();
                            $relatorioView = new RelatoriosView();
								
                            if(isset($_GET['tipo']) && $_GET['tipo']=="SLA"){
                            	$relatorioView->relatorioSLA();
                            	
                            }
                            
                            if(isset($_GET['tipo']) && $_GET['tipo']=="demandas"){
                            	$relatorioView->relatorioDemanda();
                            	 
                            }
                            
                            
                            if(isset($_GET['tipo']) && $_GET['tipo']=="Projeto"){
                            	$relatorioView->relatorioProjeto();
                            
                            }
                            
                            
                            if(isset($_GET['tipo']) && $_GET['tipo']=="graficos"){
                            	$relatorioView->relatorioGrafico();
                            
                            }
                            
                            if(isset($_GET['tipo']) && $_GET['tipo']=="execucao"){
                            	$relatorioView->relatorioExecucao();
                            
                            }
                      
                            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
                           
                            ?>

                </div>            


<?php
$html->htmlFooter();
?>