<?php
require_once 'includes/view/html_body.php';
require_once 'includes/controller/ValidaLogin.class.php';
$html = new HtmlBody();
$html->htmlHeaderAdmin();
$validar = new ValidaLogin();
$validar->ValdidarLogin();

?>
 
<script src="js/functions_cadastrar.js"></script>

<div id='corpo'>
                            <?php
                            require_once("includes/model/dao/CadastrarDAO.class.php"); // Classe DAO
                            require_once("includes/view/CadastrarView.class.php"); //Classe View
                            $cadastrarDAO = new CadastrarDAO();
                            $cadastrarView = new CadastrarView();

                            //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
                           // $resultado = $clientesDAO->listaCliente();
 $resultado = $cadastrarDAO->listaDemanda();
                            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
                            $cadastrarView->paginaInicial();
                            ?>

                </div>            


<?php
$html->htmlFooter();
?>