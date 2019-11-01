<?php
require_once 'includes/view/html_body.php';
require_once 'includes/controller/ValidaLogin.class.php';
$html = new HtmlBody();
$html->htmlHeaderAdmin();
$validar = new ValidaLogin();
$validar->ValdidarLogin();
$id = $_GET['id'];
?>
 


<div id='corpo'>
                            <?php
                            require_once("includes/model/dao/CadastrarDAO.class.php"); // Classe DAO
                            require_once("includes/view/CadastrarView.class.php"); //Classe View
                            require_once ("includes/model/bean/Cadastrar.class.php");
                            $cadastrarDAO = new CadastrarDAO();
                            $cadastrarView = new CadastrarView();

                            //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
                         $detalhar = new Cadastrar();
        				$detalhar->setId($id);
        				$detalharDAO = new CadastrarDAO();
        				$detalharView = new CadastrarView();
        
        	//Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar.
        			$resultado = $detalharDAO->buscaDemanda($detalhar);
        	//Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
        			$detalharView->detalharVisualizar($resultado);
                            ?>

                </div>            


<?php
$html->htmlFooter();
?>